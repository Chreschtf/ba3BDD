<?php
    class UserProfileController {
        
        private $_user ;
        private $_uid ;
        
        public function __construct($user) {
            $this->_user = $user;
            $this->_uid = Db::getInstance()->getUIDof($user);
        }
        
        public function run() {
            require_once('Controllers/CookieController.php');
            $controller = new CookieController();
            
            if (!$controller->checkCookies()) {
                header("Location:?action=login");
                die();
                
            }else{
                echo "<h2>User Info</h2>";
                
                if ($this->_user==""){
                    $this->_user = $_COOKIE["username"];
                }
                
                if ($this->_uid != "NULL"){
                    $userdata = Db::getInstance()->getUserData($this->_uid);
                    echo "<b>Nickname :</b> ".$userdata['nickname']."<br>";
                    if ($userdata['email']==NULL)
                        echo "<b> Email :</b> unknown<br>";
                    else
                        echo "<b>Email</b> : ".$userdata['email']."<br>";
                    echo "<b>Member since :</b> ".$userdata['entry_date'];
                    
                    echo "<div class='row'>";
                    echo "    <div class='col-md-6'>";
                    
                    $this->displayComments();
                    
                    echo "    </div>";
                    echo "    <div class='col-md-6'>";
                    
                    $this->displayTags();
                    
                    echo "    </div>";
                    echo "</div>";
                }
            }
        }
        
        public function displayComments(){

            $comments = Db::getInstance()->getCommentsOfUser($this->_uid);
            echo "<h2>Comments</h2>";
            if (empty($comments)){
                echo "No comments available";
            }else{
                for ($i=0;$i<count($comments);$i++){
                    if($comments[$i]['horeca_type'] == "Restaurant"){
                        echo "          <b> <a href='?action=restaurantProfile&eid=".$comments[$i]["eid"]."'></b>".$comments[$i]['ename']."</a>  <br>";
                    } else if ($comments[$i]['horeca_type'] == "Bar"){
                        echo "          <b> <a href='?action=barProfile&eid=".$comments[$i]["eid"]."'></b>".$comments[$i]['ename']."</a>  <br>";
                    } else if ($comments[$i]['horeca_type'] == "Hotel"){
                        echo "          <b> <a href='?action=hotelProfile&eid=".$comments[$i]["eid"]."'></b>".$comments[$i]['ename']."</a>  <br>";
                    }
                    echo "<b>Date : </b>".$comments[$i]['entry_date'].'<br>';
                    echo "<b>Score : </b>".$comments[$i]['score'].'<br>';
                    echo '"'.$comments[$i]['text'].'"<br><br>';
                }
            }
        }
        
        public function displayTags(){
            $tags = Db::getInstance()->getTagsUsedByUser($this->_uid);
            echo "<h2>Tags</h2>";
            if (count($tags)==0){
                echo "No tags available";
            }
            else{
                for ($i=0;$i<count($tags);$i++){
                    if($tags[$i]['horeca_type'] == "Restaurant"){
                        echo "          <p>Tagged <a href='?action=restaurantProfile&eid=".$tags[$i]["eid"]."'>".$tags[$i]['ename']."</a>";
                    } else if ($tags[$i]['horeca_type'] == "Bar"){
                        echo "          <p>Tagged <a href='?action=barProfile&eid=".$tags[$i]["eid"]."'>".$tags[$i]['ename']."</a>";
                    } else if ($tags[$i]['horeca_type'] == "Hotel"){
                        echo "          <p>Tagged <a href='?action=hotelProfile&eid=".$tags[$i]["eid"]."'>".$tags[$i]['ename']."</a>";
                    }
                    echo "  with  <a href='?action=tagProfile&tid=".$tags[$i]["tid"]."'>".$tags[$i]['tname']."</a> </p>";
                }
            }
        }
    }  
?>