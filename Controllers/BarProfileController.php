<?php
    class BarProfileController{
        
        private $_eid;
        private $_uid;
        
        public function __contruct(){}
        
        public function setEID($eid){
            $this->_eid = $eid;
        }
        
        public function run(){
            require_once('Controllers/CookieController.php');
            $controller = new CookieController();
            
            if (!$controller->checkCookies()) {
                header("Location:?action=login");
                die();
                
            }else{
                echo "<h1>Bar Profile</h1>";
                require_once("EstablishmentProfileController.php");
                $this->_uid = Db::getInstance()->getUIDof($_COOKIE["username"]);
                $barData=Db::getInstance()->getBarData($this->_eid);
                
                EstablishmentProfileController::displayGenericInfo($barData, Db::getinstance()->getUIDof($_COOKIE['username']));
                $this->displayBarSpecificInfo($barData);
                
                EstablishmentProfileController::displayTags($barData['eid']);
                EstablishmentProfileController::displayComments($barData['eid'], $this->_uid);
            }
            
        }
        public function displayBarSpecificInfo($data){
            
            echo "<tr>";
            echo "<td><b>Smoking allowed :</b></td>";
            if ($data['smoking']){
                echo "<td> Yes  </td>";
            }else{
                echo "<td> No  </td>";
            }
            echo "</tr>";
            echo "<tr>";
            echo "<td><b>Serves snacks :</b></td>";
            if ($data['snack']){
                echo "<td> Yes  </td>";
            }else{
                echo "<td> No  </td>";
            }
            echo "<tr>";
            
            echo "</table>";
        }
        
    }
?>