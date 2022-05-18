<?php
namespace Elements;
//this class defines a user db object

class Validator{
    private static function forbidden($string){
        $forbidden = array(";",":","\"","'","`","(",")","[","]","{","}");
        foreach(str_split($string) as $char){
            if(in_array($char,$forbidden)) return true;
        }
        return false;
    }
    public static function validatePassword($pass){
        if(strlen($pass)<4) return false;
        if(Validator::forbidden($pass)) return false;
        return true;
    }
    public static function validateUsername($name){
        if(strlen($name)<3) return false;
        if(Validator::forbidden($name)) return false;
        return true;
    }
}