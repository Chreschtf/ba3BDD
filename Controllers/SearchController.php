<?php
    class SearchController {
        public function __construct() {
        }
        public function run() {
            require_once('Controllers/CookieController.php');
            $controller = new CookieController();
            if (!$controller->checkCookies()) {
                header("Location:?action=login");
                die();
            }else{
                
                require_once(VIEWSPATH.'search.php');
                
            }
        }
    }
?>