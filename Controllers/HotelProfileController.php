<?php
    class HotelProfileController{
        
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
                echo "<h1>Hotel Profile</h1>";
                require_once("EstablishmentProfileController.php");
                $hotelData = Db::getInstance()->getHotelData($this->_id);
                
                EstablishmentProfileController::displayGenericInfo($hotelData, Db::getinstance()->getUIDof($_COOKIE['username']));
                $this->displayHotelSpecificInfo($hotelData);
                
                EstablishmentProfileController::displayTags($hotelData['eid']);
                EstablishmentProfileController::displayComments($hotelData['eid']);
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