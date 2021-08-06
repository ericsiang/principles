<?php


/**
*   設計模式的原則最終要達到的目的: 低耦合、高內聚、易維護、可擴展
*
*
*   Single Responsibility Principle
*   單一職責原則 (SRP) : 每一個類都應該有其自己單一的職責
*
*/

//EX:  下方的類範例，違反單一職責原則
//因為getAccount，這個用來方法是獲取某個訂單的價格，這個類應該只是單一處理產品
//應該要將此拆到另一個單一處理訂單的類

class Product
{
    public function getName(){
        //to do
    }

    public function getPrice(){
         //to do
    }

    //用來獲取某個訂單的價格(違反單一職責原則)
    // public function getAccount(){
    //     //to do
    // }

}


class Order
{
    //用來獲取某個訂單的價格
    public function getAccount(){
        //to do
    }

}





?>