<?php

/**
*   設計模式的原則最終要達到的目的: 低耦合、高內聚、易維護、可擴展
*
*
*   Liskov Substitution Principle
*   里式替換原則
*   若對型態 S 的每一個物件 o1，都存在一個型態為 T 的物件 o2，使得在所有針對 T 編寫的程式 P 中，用 o1 替換 o2後，程式 P 的行為功能不變，則 S 是 T 的子型態
*
* 通俗的講就是，子類繼承父類的時候盡量不要對父類的方法進行重寫
*/

class Product 
{
    public function getPrice(){
        echo '返回產品的價格';
    }
}

class SubProduct extends  Product
{
    public function getPrice(){
        echo '返回訂單的價格';
    }
}


//違反里式替換原則，因為子類修改父類後的方法跟原本父類差異太大
$obj=new  Product();
echo $obj->getPrice();
echo '<br>';
$obj=new  SubProduct();
echo $obj->getPrice();

?>