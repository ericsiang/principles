<?php

/**
*   設計模式的原則最終要達到的目的: 低耦合、高內聚、易維護、可擴展
*
*
*   Interface Segregation Principle
*   接口隔離原則 (ISP) : 客戶端不應該依賴它不需要的接口，一個類對另一個類的依賴應該建立在最小的接口上
*
*/


//因為接口需實現底下的所有方法，但getOrderAccount不應該在Pro接口，
interface Pro
{
    public function getProductName();

    public function getProductAmount();

    public function getProductPrice();

    //不應該用在此接口
    //public function getOrderAccount();

}

//因此應該是要，新增新的接口來實現
interface Ord
{
    public function getOrderAccount();
}

class Product implements Pro
{
    public function getProductName(){
        //to do
    }

    public function getProductAmount(){
        //to do
    }

    public function getProductPrice(){
        //to do
    }

    //不應該實現此方法，但因為如果接口有宣告，只能照樣實現，因此在設計接口時就需架構好
    // public function getOrderAccount(){
    //     //to do
    // }

}

class Order implements Ord
{
    public function getOrderAccount(){
        //to do
    }
}


?>