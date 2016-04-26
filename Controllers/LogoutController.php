<?php
    class LogoutController {
        public function __construct() {
        }

        public function run() {
            
            if (isset($_COOKIE['username'])) {
                //unset($_COOKIE['username']);
                setcookie('username');
            }
            
            if (isset($_COOKIE['password'])) {
                //unset($_COOKIE['password']);
                setcookie('password');
            }
            
            session_unset();
            session_destroy();
            
            header('Location: index.php');
            die();
        }
    }
?>