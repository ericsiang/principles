<?php

namespace Shop;

use Product;

class Shop1
{
    private $product=[];

    public function setProduct(Product $product){
        $this->product[]=$product;
    }

    public function getProduct(){
        return $this->product;
    }
}




?>