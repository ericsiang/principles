<?php

namespace Shop;

use Product;

class Shop2
{
    private $product=[];


    public function setProduct(Product $product){
        $this->product[]=$product;
    }
}




?>