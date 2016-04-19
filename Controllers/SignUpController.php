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
        }else{
            #$nickname  = test!
        }
        

        require_once(VIEWSPATH . 'signUp.php');

    }
}    
 ?>