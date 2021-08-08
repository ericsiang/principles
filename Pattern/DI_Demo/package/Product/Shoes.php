<?php

namespace Product;

use Product;

class Shoes implements Product
{
    protected $attribute;

    public function __construct(Attribute $attribute){
        $this->attribute=$attribute;
    }

    public function getName(){
        return 'Shoes';
    }

    public function getAttribute(){
        return $this->attribute->get();
    }

}



?>