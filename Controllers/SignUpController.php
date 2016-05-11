<?php
class SignUpController{
    public function __construct() {

    }
    
    public function run(){
        
        $nicknameErr = $emailErr = $passwordErr = "";
        $nickname = $email = $password = "";

        
       
        if (empty($_POST)) {
            $notification='Sign up!';
        }
        
        // NICKNAME
        if (empty($_POST["nickname"])){
            $nicknameErr="Nickname is required";
        } elseif (strlen($_POST["nickname"])<6 or strlen($_POST["nickname"])>32) {
            $nicknameErr="Invalid nickname length";
        }elseif (Db::getInstance()->nicknameExists($_POST["nickname"])) {
            $nicknameErr="Nickname already taken";
        }else{
            $nickname = $_POST["nickname"];
        }
        
        // PASSWORD
        if (empty($_POST["password"])){
            $passwordErr="Password is required";
        }elseif (strlen($_POST["password"])<6 or strlen($_POST["password"])>32){
            $passwordErr="Invalid password length";
        }elseif ($_POST["password"]!=$_POST["passwordconfirm"]){
            $passwordErr="Passwords don't match";
        }else{
            $password = $_POST["password"];
        }
        
        // EMAIL
        if (empty($_POST["email"])){
            $emailErr = "Email is required";
        }elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format"; 
        }elseif (Db::getInstance()->emailAlreadyInUse($_POST["email"]) ){
            $emailErr = "Email already in use";
        }else{
            $email = $_POST["email"];
        }
        
        
        if ($emailErr == "" and $nicknameErr == "" and $passwordErr == ""){
            $user = [
                    0 => $nickname,
                    1 => $email,
                    2 => $password
                    ];
            Db::getInstance()->insertUserComplete($user);
            
            
            header("Location: ?action=login");
            die();
        }
        
        require_once(VIEWSPATH . 'signUp.php');

    }
}    
 ?>