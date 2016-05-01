<?php
    class LoginController {
        public function __construct() {
        }

        public function run() {
            
            $notification = "";
            require_once (VIEWSPATH . 'login.php');
            
            if (empty ( $_POST ) || !isset($_POST['username']) || !isset($_POST['password']) ) {#if no connexion is attempted
                $notification = "Not sucessful";
                die();
            }
            elseif (DB::getInstance()->validLogin((htmlentities ( $_POST ['username'] )), (htmlentities ( $_POST ['password'] )))) {
                if (isset($_POST['rememberme'])) {
                /* Set cookie to last 1 year */
                    setcookie('username', $_POST['username'], time()+60*60*24*365);#, '/account', 'www.example.com');
                    setcookie('password', $_POST['password'], time()+60*60*24*365);#, '/account', 'www.example.com');
                } else {
                /* Cookie expires when browser closes */
                    setcookie('username', $_POST['username'], false);#, '/account', 'www.example.com');
                    setcookie('password', $_POST['password'], false);#, '/account', 'www.example.com');
                }
                header('Location: ?action=userProfile&user='.$_POST['username']);
                die();
            }
        }
    }
?>