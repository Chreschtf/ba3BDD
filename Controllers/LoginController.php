<?php
    class LoginController {
        public function __construct() {
        }

        public function run() {
            
            $notification = "";
            
            if (empty ( $_POST ) || !isset($_POST['username']) || !isset($_POST['password']) ) {#if no connexion is attempted
                require_once (VIEWSPATH . 'login.php');
                $notification = "Not sucessful";
                die();
            }
            
            elseif (DB::getInstance()->validLogin((htmlentities ( $_POST ['username'] )), (htmlentities ( $_POST ['password'] )))) {
                header('Location: ?action=userProfile&user='.$_POST['username']);
                
                if (isset($_POST['rememberme'])) {
                /* Set cookie to last 1 year */
                    setcookie('username', $_POST['username'], time()+60*60*24*365);#, '/account', 'www.example.com');
                    setcookie('password', $_POST['password'], time()+60*60*24*365);#, '/account', 'www.example.com');
                } else {
                /* Cookie expires when browser closes */
                    setcookie('username', $_POST['username'], false);#, '/account', 'www.example.com');
                    setcookie('password', $_POST['password'], false);#, '/account', 'www.example.com');
                }
                die();
                
            } else { // password or username false
                if( ! DB::getInstance()->checkIfUserExists($_POST ['username']) )
                    $notification = "Username does not exist";
                else
                    $notification = "Password incorrect";
                    
                require_once (VIEWSPATH . 'login.php');
                die(); 
            }
            
        }
    }
?>