<?php
    class HotelProfileController{
        
        private $_eid;
        private $_uid;
        
        public function __contruct(){}
        
        public function setEID($eid){
            $this->_eid=$id;
        }
        
        public function run(){
            require_once('Controllers/CookieController.php');
            $controller = new CookieController();
            
            if (!$controller->checkCookies()) {
                header("Location:?action=login");
                die();
                
            }else{
                echo "<h1>Hotel Profile</h1>";
                require_once("EstablishmentProfileController.php");
                $this->_uid = Db::getInstance()->getUIDof($_COOKIE["username"]);
                $hotelData = Db::getInstance()->getHotelData($this->_eid);
                
                EstablishmentProfileController::displayGenericInfo($hotelData, Db::getinstance()->getUIDof($_COOKIE['username']));
                $this->displayHotelSpecificInfo($hotelData);
                
                EstablishmentProfileController::displayTags($hotelData['eid']);
                EstablishmentProfileController::displayComments($hotelData['eid'], $this->_uid);
            }
        }
        
        public function displayHotelSpecificInfo($data){
            
            echo "<tr>";
            echo "<td><b>Stars :</b></td>";          
            echo "<td>" . $data['stars'] . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><b>Rooms :</b></td>";
            echo "<td>" . $data['rooms'] . "</td>";
            echo "<tr>";
            echo "<td><b>Standard price :</b></td>";
            echo "<td>" . $data['standard_price'] . "</td>";
            echo "<tr>";
            
            echo "</table>";
        }
        
    }
?>