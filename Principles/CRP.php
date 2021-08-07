<?php

/**
*   設計模式的原則最終要達到的目的: 低耦合、高內聚、易維護、可擴展
*
*
*   Composite Reuse Principle
*   合成復用原則(CRP) :  在軟件復用時，要盡量先使用組合或聚合等關聯關係來實現，如果要使用繼承關係，則必須遵守里式替換原則
*   
*   
*/


class A 
{
    public function get(){
        
    }
}


//盡量少用繼承
// class B extends A
// {
//     public function get(){
        
//     }
// }

//組合或聚合的意思
class B
{
    protected $A;

    public function __construct(A $A){
        $this->A=$A;
    }
}


?>