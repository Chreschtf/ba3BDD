<?php
    class RestaurantProfileController{
        private $_id;
        public function __contruct(){
            
        }
        
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
                require_once(VIEWSPATH."restaurantProfile.php");
                require_once("EstablishmentProfileController.php");
                $restaurantData=Db::getInstance()->getRestaurantData($this->_id);
                EstablishmentProfileController::displayGenericInfo($restaurantData, Db::getinstance()->getUIDof($_COOKIE['username']));
                $this->displayRestaurantSpecificInfo($restaurantData);
                EstablishmentProfileController::displayClosingDays($restaurantData['eid']);
                EstablishmentProfileController::displayTags($restaurantData['eid']);
                EstablishmentProfileController::displayComments($restaurantData['eid']);
            }
        }
        
        public function displayRestaurantSpecificInfo($data){
            echo "<tr>";
            echo "<td><b>Price range : </b></td>";
            echo "<td>".$data['price_range'].' € </td>';
            echo "</tr>";
            echo "<tr>";
            echo "<td><b>Banquet capacity : </b> </td>";
            echo "<td>".$data['banquet_capacity'].'</td>';
            echo "</tr>";
            echo "<td><b>Smoking allowed :</b></td>";
            if ($data['takeaway']){
                echo "<td> Yes  </td>";
            }else{
                echo "<td> No  </td>";
            }
            echo "</tr>";
            echo "<tr>";
            echo "<td><b>Serves snacks :</b></td>";
            if ($data['delivery']){
                echo "<td> Yes  </td>";
            }else{
                echo "<td> No  </td>";
            }
            echo "<tr>";
            
            echo "</table>";
        }
    }
?>