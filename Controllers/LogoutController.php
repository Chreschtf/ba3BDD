<?php
    class LogoutController {
        public function __construct() {
        }

        public function run() {
            
            session_destroy();
            
            header('Location: index.php');
            die();
        }
    }
?>