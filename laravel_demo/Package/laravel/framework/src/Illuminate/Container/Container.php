<?php
namespace Illuminate\Container;

use ReflectionClass;

class Container
{

    //生成實例
    public function make($abstrate){
        return $this->resolve($abstrate);
    }

    //解析抽象
    protected function resolve($abstrate){
        $concrere =$abstrate;
        return $this->build($concrere);
    }

    //構建實例 
    protected function build($concrete){
        $reflector  =new ReflectionClass($concrete);
        $constructor    =$reflector->getConstructor();
       
        if(is_null($constructor)){
            return new $concrete;
        }

        $dependencies   =$constructor->getParameters();
        $instances  =$this->resolveDependencies($dependencies);
        
        return  $reflector->newInstanceArgs($instances);
    }


    //解析依賴
    protected function resolveDependencies($dependencies){
        $results=[];

        foreach($dependencies as $dependency){
            $results[]=$this->make($dependency->getName());
        }

        return $results;
    }

}






?>