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
            
            elseif (Db::getInstance()->validLogin((htmlentities ( $_POST ['username'] )), (htmlentities ( $_POST ['password'] )))) {
                header('Location: ?action=userProfile&user='.$_POST['username']);
                
                if (isset($_POST['rememberme'])) {
                /* Set cookie to last 1 hour */
                    setcookie('username', $_POST['username'], time()+60*60);
                    setcookie('uid', Db::getInstance()->getUIDof($_POST['username']), time()+60*60);
                } else {
                /* Cookie expires when browser closes */
                    setcookie('username', $_POST['username'], false);
                    setcookie('uid',Db::getInstance()->getUIDof($_POST['username']), false);
                }
                die();
                
            } else { // password or username false
                if( ! Db::getInstance()->checkIfUserExists($_POST ['username']) )
                    $notification = "Username does not exist";
                else
                    $notification = "Password incorrect";
                    
                require_once (VIEWSPATH . 'login.php');
                die(); 
            }
            
        }
    }
?>