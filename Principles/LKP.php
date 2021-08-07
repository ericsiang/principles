<?php

/**
*   設計模式的原則最終要達到的目的: 低耦合、高內聚、易維護、可擴展
*
*
*   Least Knowledge Principle
*   最少知道原則(LKP) :  Talk only to your immediate friends and not to stranger
*   
*   這裡的朋友是指當前對象本身、成員變量、成員方法，即一個對象應該對其他對象有最少的了解，也就是減少類裡面沉余的類
*
*   其目的是降低類之間的耦合度，提高模塊的相對獨立性
*
*   EX: 產品與商店是朋友關係，產品與服務員和顧客之間是非朋友關係
*/

class Product
{
    public function getProduct(){
        return 'Apple';
    }
}

class Waiter
{
    public function getWaiter(){
        return 'John';
    }
}

class Customer
{
    public function getCustomer(){
        return 'Eric';
    }
}


class Shop
{
    private $product;
    private $waiter;
    private $customer;

    public function setProduct(Product $Product){
        $this->product=$product;
    }

    public function setWaiter(Waiter $waiter){
        $this->waiter=$waiter;
    }

    public function setCustomer(Customer $customer){
        $this->customer=$customer;
    }

    //商品售賣
    public function shopping(){
        echo $this->waiter->getWaiter().'將產品'.$this->product->getProduct().'賣給了'.$this->customer->getCustomer();
    }

    //商品寄賣
    public function consignment(){
        echo $this->customer->getCustomer().'將產品'.$this->product->getProduct().'通過'.$this->waiter->getWaiter().'進行寄賣';
    }

    //商品暫存
    public function storage(){
        echo $this->customer->getCustomer().'通過'.$this->waiter->getWaiter().'將產品'.$this->product->getProduct().'暫存起來';
    }

}



?>