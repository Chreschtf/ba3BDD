<?php
    class BarProfileController{
        
        private $_id;
        
        public function __contruct(){}
        
        public function setId($id){
            $this->_id=$id;
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
                $barData=Db::getInstance()->getBarData($this->_id);
                
                EstablishmentProfileController::displayGenericInfo($barData, Db::getinstance()->getUIDof($_COOKIE['username']));
                $this->displayBarSpecificInfo($barData);
                
                EstablishmentProfileController::displayTags($barData['eid']);
                EstablishmentProfileController::displayComments($barData['eid']);
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