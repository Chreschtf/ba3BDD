<?php
    class UserProfileController {
    private $_user ;
    public function __construct($user) {
        $this->_user = $user;
    }
    
    public function run() {
        require_once('Controllers/CookieController.php');
        $controller = new CookieController();
        if (!$controller->checkCookies()) {
            header("Location:?action=login");
            die();
        }else{
            require_once (VIEWSPATH . 'userProfile.php');
            if ($this->_user==""){
                $this->_user = $_COOKIE["username"];
            }
            $uid = Db::getInstance()->getUIDof($this->_user);
            if ($uid != "NULL"){
                $userdata = Db::getInstance()->getUserData($uid);
                echo "<b>Nickname :</b> ".$userdata['nickname']."<br>";
                if ($userdata['email']==NULL)
                    echo "<b> Email :</b> unknown<br>";
                else
                    echo "<b>Email</b> : ".$userdata['email']."<br>";
                echo "<b>Member since :</b> ".$userdata['entry_date'];
                
                /*
                echo "<table style='width:100%'>";
                echo "<tr>";
                echo "<td> <b>Nickname</b> </td>";
                echo "<td> <b>Email</b> </td>";
                echo "<td> <b>Entry Date</b> </td>";
                echo "</tr>";        
                echo "<tr>";
                echo "<td> ".$userdata['nickname']."  </td>";
                echo "<td> ".$userdata['email']."  </td>";
                echo "<td> ".$userdata['entry_date']."  </td>";
                echo '</tr>';
                echo "</table>";
                */
            }
        }
    }
    
    
    
    }  
?>