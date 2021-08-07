<?php

/**
*   設計模式的原則最終要達到的目的: 低耦合、高內聚、易維護、可擴展
*
*
*   Dependence Inversion Principle
*   依賴倒置原則(DIP) : 高層模塊不應該依賴低層模塊，兩者應該都於抽象
*   進一步說，抽象不應該依賴於細節，細節依賴於抽象
*
*/

interface Mail
{
    public function sendMail();
}


//低層類 => 依賴Mail接口
class Qq implements Mail
{

    public function sendMail(){
        //to do
        return 'Qq';
    }

}

//低層類 => 依賴Mail接口
class Foxmail implements Mail
{

    public function sendMail(){
        //to do
        return 'Foxmail';
    }

}



//高層類 
class People
{

    /* 當要用不同發信類，會因為類的不同而要切換不易，導致依賴過高

    public function send(Qq $qq){
        $fox->sendMail();
    }  

    public function send(Foxmail $fox){
        
        $fox->sendMail();
    }  
    */

    //因此要改成依賴Mail接口
    public function send(Mail $mail){
        
        echo $mail->sendMail();
        
    } 

}



$people=new People;
$people->send(new Qq);
$people->send(new Foxmail);



?>