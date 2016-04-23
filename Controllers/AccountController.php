<?php
    class AccountController {
    public function __construct() {
    }
    public function run() {
        if(!isset($_COOKIE["username"]) or !isset($_COOKIE["password"])) {
            #header('Location: index.php?action=login');
            #die();
        } elseif (!Db::getinstance()->validLogin($_COOKIE["username"],$_COOKIE["password"]) ) {
            #header('Location: index.php?action=login');
            #die();
        } else{
            
        }
    
    
        require_once (VIEWSPATH . 'account.php');
    }
    
    
    
    }  
?>