<?php



require __DIR__.'/../vendor/autoload.php';


class Log
{
    protected $file;
    public function __construct(File $file){
        $this->file=$file;
    }
}


class File
{
 
}


$container= new \Illuminate\Container\Container;
$obj=$container->make(Log::class);
var_dump($obj);



?>