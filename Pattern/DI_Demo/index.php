<?php



require_once __DIR__.'/vendor/autoload.php';

$shop1=new \Shop\Shop1;
$shop2=new \Shop\Shop2;

$factory=new \Factory\ProductFactory;
$factory->instance('shoes',$factory->make('\Product\Shoes'));
//var_dump($factory->getInstances());
$factory->instance('clothes',$factory->make('\Product\Clothes'));

$factory->bind('shoes',function  () use ($factory) {
    return $factory->make('\Product\Shoes');
});

//var_dump($factory->getBind());
var_dump($factory->make('shoes'));
exit;

$shop1->setProduct($factory->make('shoes'));
// $shop2->setProduct($factory->make('\Product\Clothes'));
// $shop1->setProduct($factory->make('\Product\Clothes'));
$shop2->setProduct($factory->make('clothes'));
$shop2->setProduct($factory->make('shoes'));

var_dump($shop1);
var_dump($shop2);

?>