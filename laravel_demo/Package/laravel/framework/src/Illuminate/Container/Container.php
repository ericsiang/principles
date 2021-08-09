<?php
namespace Illuminate\Container;

use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Container\BindingResolutionException;

class Container
{
    protected $buildStack   = [];//構建棧(優化3)
    protected $with = []; //with參數，存放未做約定的參數(優化5)
    protected $aliases = [];
    protected $contextual   = [];//綁定上下文映射關係

    //生成實例
    public function make($abstract,$parameter=[]){
        return $this->resolve($abstract,$parameter);
    }

    //解析抽象
    protected function resolve($abstract,$parameter=[]){
        $abstract=$this->getAlias($abstract);
        //var_dump($abstract);
        $concrere =$abstract;
        $this->with[]=$parameter;
        return $this->build($concrere);
    }

    //構建實例 
    protected function build($concrete){
        try{
            $reflector=new ReflectionClass($concrete);
        }catch(ReflectionException $exception){
            //第三個參數用來顯示stack trace : 傳入上一個異常(優化1)
            throw new BindingResolutionException('沒有找到實例["'.$concrete.'"]',0,$exception);
        }

        //判斷實例是否能被實例化，拋出異常(優化2)
        if(!$reflector->isInstantiable()){
            return $this->notInstantiable($concrete);
        }

        //將可以實例化的實例放入構建棧(優化3)
        $this->build[]=$concrete;

        $constructor    =$reflector->getConstructor();
       
        if(is_null($constructor)){
            array_pop($this->buildStack); //移出構建棧(優化3)
            return new $concrete;
        }

        $dependencies   =$constructor->getParameters();

        //捕捉依賴解析拋出的異常(優化4)
        try{
            $instances  =$this->resolveDependencies($dependencies);
        }catch(BindingResolutionException $exception){ //(優化1)
            array_pop($this->buildStack);//移出構建棧(優化3)
            throw $exception; 
        }
        
        
        array_pop($this->buildStack); //移出構建棧(優化3)
        return  $reflector->newInstanceArgs($instances);
    }


    //解析依賴
    protected function resolveDependencies($dependencies){
        $results=[];

        foreach($dependencies as $dependency){
            //判斷依賴是否做了參數覆蓋
            if($this->hasParameterOverride($dependency)){
                $results[]=$this->getParameterOverride($dependency);
                continue;
            }
            
            //判斷依賴是否能取到class(優化6)
            if(!$dependency->getClass()){
                //否，則執行resolvePrimitive方法(優化6)
                $results[]=$this->resolvePrimitive($dependency);
               
            }

            $results[]=$this->make($dependency->getName());
        }

        return $results;
    }

     /*
    *   如果參數是一個字符或者其他基元類型時，不是我們想要依賴，需要判斷其是否有默認值，如果有默認值返回默認值，沒有的話不是我們想要依賴，容器拋出異常(優化6)
    *   
    */
    protected function resolvePrimitive(ReflectionParameter $dependency){
        
        //判斷是否有默認值(優化6)
        if($dependency->isDefaultValueAvailable()){
            //有，則回傳默認值(優化6)
            return $dependency->getDefaultValue();
        }

        //否，則執行unresolvablePrimitive方法拋出異常(優化6)
        $this->unresolvablePrimitive($dependency);

    }


    /*
    *
    *   拋出依賴不能被解析的異常(優化6)
    *
    */ 
    protected function unresolvablePrimitive(ReflectionParameter $parameter){
        //getDeclaringClass(返回所反映方法的已聲明類的名稱)
        $message='Unresolvable dependency resolving ['.$parameter.'] in class '.$parameter->getDeclaringClass()->getName();

        throw new BindingResolutionException($message);
    }



    /*
    *   如果類不能被實例化，拋出異常(優化2)
    *   不能被實例化的類(interface/abstract/private __construct/protected __construct/trait)
    */
    protected function notInstantiable($concrete){
        if(!empty($this->buildStack)){
            $concrete=implode(',',$this->buildStack);
        }

        $message='目標實例'.$concrete.'不能被實例化';
        //(優化1)
        throw new BindingResolutionException($message);
    }


    //判斷依賴是否做了參數覆蓋(優化5)
    protected function hasParameterOverride($dependency){
        return array_key_exists(
            $dependency->name,$this->getLastParameterOverride()
        );
    }

    //獲取依賴的覆蓋參數(優化5)
    protected function getParameterOverride($dependency){
        return $this->getLastParameterOverride()[$dependency->name];
    }

    //獲取最後覆蓋的參數(優化5)
    protected function getLastParameterOverride(){
        return count($this->with) ?  end($this->with) : [];
    }


    //給實例設置別名
    public function alias($abstract,$alias){
        if($abstract==$alias){
            throw new LogicException("{$abstract} is aliased to itself");
        }

        return $this->aliases[$alias]=$abstract;

    }

    public function getAlias($abstract){
     
        if(!isset($this->aliases[$abstract])){
            return $abstract; 
        }

        return $this->getAlias($this->aliases[$abstract]);
    }

    public function when($concrete){
        $aliases=[];

        foreach(Arr::wrap($concrete) as $c){
            $aliases=$this->getAlias($c);
        }
        return new ContextualBindingBuilder($this,$aliases);
    }

    /*
    *   綁定上下文映射關係
    *
    */
    public function addContextualBinding($concrete, $abstract, $implementation){
        $this->contextual[$concrete][$this->getAlias($abstract)]=$implementation;
    }


}

/*
*   實例化類遇到的問題 => 優化
*   1.如果容器傳入不存在的實例的時候，我們引入BindingResolutionException來自定義我們返回的異常訊息
*   2.如果容器傳入不能被實例化的實例的類時，我們是用反射類的isInstantiable方法判斷實例是否能被實例化，否則拋出異常
*   3.引入構建棧，來查看未實例化的實例
*   4.捕捉依賴解析拋出的異常
*
*   解析依賴遇到的問題 => 優化
*   5.如果傳入的依賴沒有做約定，那麼此時在使用反射類獲取構造參數時，會把參數變量名作為類的名稱去實例化並拋出異常，在此時我們引入with參數，用來覆蓋未做約定的參數
*   6.如果傳入的的依賴是字符或者其他不能被實例化的基元類型，我們引入resolvePrimitive方法來判斷依賴是否有默認值，如果有的話，返回默認值，沒有則拋出異常
*   7.引入別名，映射關係保存在$aliases中
*
*   8.上下文綁定
*/ 




?>