<?php
    class CookieController{
        public function __construct() {
        }
        public function checkCookies(){
            if(!isset($_COOKIE["username"]) or !isset($_COOKIE["password"])) {
                return false;
            } elseif (!Db::getinstance()->validLogin($_COOKIE["username"],$_COOKIE["password"]) ) {
                return false;
            }
            return true;
        }
        
    }
?>