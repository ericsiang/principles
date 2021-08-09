<?php



require __DIR__.'/../vendor/autoload.php';


class Log
{
    protected $sys;
    public function __construct(Sys $sys){
        $this->sys=$sys;
    }
}


class File implements Sys
{
    // protected $sys;
    // public function __construct(Sys $sys){
    //     $this->sys=$sys;
    // }
}

interface Sys
{
 
}


$container= new \Illuminate\Container\Container;
$container->when(Log::class)->needs(Sys::class)->give(File::class);
var_dump($container);
// $container->alias(Log::class,'ooo');
// $obj=$container->make('ooo');
//var_dump($obj);



?>