<?php
    class CookieController{
        public function __construct() {
        }
        public function checkCookies(){
            if(!isset($_COOKIE["username"]) or !isset($_COOKIE["uid"])) {
                return false;
            } else{ 
                return Db::getinstance()->getUIDof($_COOKIE["username"])==(int)$_COOKIE["uid"];
            }
        }
        
    }
?>