<?php



require __DIR__.'/../vendor/autoload.php';


class Log
{
    protected $file;
    public function __construct(String $file='798879'){
        $this->file=$file;
    }
}


// class File
// {
 
// }

class Sys
{
 
}


$container= new \Illuminate\Container\Container;
$obj=$container->make(Log::class);
var_dump($obj);



?>