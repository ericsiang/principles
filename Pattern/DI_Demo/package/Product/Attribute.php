<?php

namespace Product;

class Attribute
{   

    protected $clothes;

    public function __construct(Clothes $clothes){
        $this->clothes=$clothes;
    }

    public function get(){
        return '屬性';
    }

}


?>