<?php
    class LogoutController {
        public function __construct() {
        }

        public function run() {
            
            if (isset($_COOKIE['username'])) {
                unset($_COOKIE['username']);
                setcookie('username', null, -1, '/');
            }
            if (isset($_COOKIE['password'])) {
                unset($_COOKIE['password']);
                setcookie('password', null, -1, '/');
            }
            
            session_destroy();
            session_unset();
            
            header('Location: index.php');
            die();
        }
    }
?>