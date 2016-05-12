<?php
    class LogoutController {
        public function __construct() {
        }

        public function run() {
            
            if (isset($_COOKIE['username'])) {
                setcookie('username');
            }
            
            if (isset($_COOKIE['uid'])) {
                setcookie('uid');
            }
            
            session_unset();
            session_destroy();
            
            header('Location: index.php');
            die();
        }
    }
?>