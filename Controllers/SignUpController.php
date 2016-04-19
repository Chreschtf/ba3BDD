<?php
class SignUpController{
    public function __construct() {

    }
    
    public function run(){
        
        $nicknameErr = $emailErr = $passwordErr = $websiteErr = "";
        $nickname = $email = $password = $website = "";
        
       
        if (empty($_POST)) {
            $notification='Sign up!';

        }
        if (empty($_POST["nickname"])){
            $nicknameErr="Nickname is required";
        } elseif (strlen($_POST["nickname"])<6 or strlen($_POST["nickname"])>32) {
            $nicknameErr="Invalid nickname length";
        }elseif (!Db::getInstance()->validNickname($_POST["nickname"])) {
            $nicknameErr="Nickname already taken";
        }else{
            $nickname = $_POST["nickname"];
        }
        
        if (empty($_POST["password"])){
            $passwordErr="Password is required";
        }elseif (strlen($_POST["password"])<6 or strlen($_POST["password"])>32){
            $passwordErr="Invalid password length";
        }elseif ($_POST["password"]!=$_POST["passwordconfirm"]){
            $passwordErr="Passwords don't match";
        }else{
            $password=$_POST["password"];
        }
        
        if (empty($_POST["email"])){
            $emailErr = "Email required";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format"; 
        } else{
            $email = $_POST["email"];
        }
        

        require_once(VIEWSPATH . 'signUp.php');

    }
}    
 ?>