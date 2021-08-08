<?php

namespace Product;

use Product;

class Clothes implements Product
{
    public function getName(){
        return 'Clothes';
    }

    public function getAttribute(){
        return 'Clothes Attribute';
    }
    
}



?>