<?php
namespace  Illuminate\Support;

class Arr
{

    //判斷是否為數組，不是則包裝成數組回傳
    public static function wrap($value){
        if(is_null($value)){
            return [];
        }

        return is_array($value) ? $value : [$value];
    }


}


?>