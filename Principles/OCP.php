<?php

/**
*   設計模式的原則最終要達到的目的: 低耦合、高內聚、易維護、可擴展
*
*
*   Open Closed Principle
*   開閉原則(OCP) :  開閉原則規定 "軟件中的對象(類、模塊、函數等等)應該對於擴展是開放的，但對於修改是封閉的"，這意味著一個實體是允許在不改變它的源代碼的前提下變更它的行為
*   
*
*/


interface Mail
{
    public function sendMail();
}



class Qq implements Mail
{

    public function sendMail(){
        //to do
        return 'Qq';
    }

}


class Foxmail implements Mail
{

    public function sendMail(){
        //to do
        return 'Foxmail';
    }

}



//行為
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


/*
* 當people類的行為，發生變更時(切換為Qq或Foxmail)並不會要修改people類的源代碼，因此就符合開閉原則
*   
*/
$people=new People;
$people->send(new Qq);
$people->send(new Foxmail);





?>