<?php

namespace Factory;

use Closure;
use ReflectionClass;
use Contract\Factory;

class ProductFactory implements Factory
{
    protected $instances=[];
    protected $bindings=[];

    public function make($class){
        if(isset($this->instances[$class])){
            return $this->instances[$class];
        }

        if(isset($this->bindings[$class])){
            $concrete= $this->bindings[$class];
            
            if($concrete instanceof Closure){
                return $concrete();
            }
        }

        //return new $class;
        $reflector= new ReflectionClass($class);
        $constructor=   $reflector->getConstructor();

        if(is_null($constructor)){
            return new $class;
        }

        $dependencies=$constructor->getParameters();
        $instances=$this->resolveDependencies($dependencies);
        return $reflector->newInstanceArgs($instances);
        //var_dump($instances);
        //exit;
    }

    //解析依賴
    protected function resolveDependencies($dependencies){
        $result=[];

        foreach($dependencies as $dependency){
            $result[]=$this->make($dependency->getClass()->name);
        }

        return $result;
    }

    //單例 : 將已經實例化的對象，透過抽象名稱綁定到工廠裡面
    public function instance($abstract,$instance){
        $this->instances[$abstract]=$instance; 
    }

    public function getInstances(){
        return $this->instances;
    }

    public function bind($abstract,$concrete){
        unset($this->instances[$abstract]);

        $this->bindings[$abstract]=$concrete;
    }

    public function getBind(){
        return $this->bindings;
    }

}


?>