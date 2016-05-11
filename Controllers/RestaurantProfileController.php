<?php
    class RestaurantProfileController{
        
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
                echo "<h1>Restaurant Profile </h1>";
                require_once("EstablishmentProfileController.php");
                $restaurantData=Db::getInstance()->getRestaurantData($this->_id);
                EstablishmentProfileController::displayGenericInfo($restaurantData, Db::getinstance()->getUIDof($_COOKIE['username']));
                
                $this->displayRestaurantSpecificInfo($restaurantData);
                $this->displayClosingDays($restaurantData['eid']);
                
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
        
        public function displayClosingDays($eid){
            $closingDays = Db::getInstance()->getClosingDays($eid);
            if (count($closingDays)>0){
                echo "<h2>Closing hours</h2>";
                echo "<p></p>";
                echo "<table>";
                echo "<div class='col-md-6'>";
                echo '<table class="table table-striped" style="width:*%">';
                
                for ($i =0;$i<count($closingDays);$i++){
                    if ($closingDays[$i]['closing_day']=='MON'){   
                        echo "<tr>";
                            echo "<td><b>Mondays : </b></td>";
                            echo "<td>".$closingDays[$i]['hour']."</td>";
                        echo "</tr>";               
                    }
                }
                
                for ($i =0;$i<count($closingDays);$i++){
                    if ($closingDays[$i]['closing_day']=='TUE'){   
                        echo "<tr>";
                            echo "<td><b>Tuesdays : </b></td>";
                            echo "<td>".$closingDays[$i]['hour']."</td>";
                        echo "</tr>";               
                    }
                }
                
                for ($i =0;$i<count($closingDays);$i++){
                    if ($closingDays[$i]['closing_day']=='WED'){   
                        echo "<tr>";
                            echo "<td><b>Wednesdays : </b></td>";
                            echo "<td>".$closingDays[$i]['hour']."</td>";
                        echo "</tr>";               
                    }
                }
                
                for ($i =0;$i<count($closingDays);$i++){
                    if ($closingDays[$i]['closing_day']=='THU'){   
                        echo "<tr>";
                            echo "<td><b>Thursdays : </b></td>";
                            echo "<td>".$closingDays[$i]['hour']."</td>";
                        echo "</tr>";               
                    }
                }
                
                for ($i =0;$i<count($closingDays);$i++){
                    if ($closingDays[$i]['closing_day']=='FRI'){   
                        echo "<tr>";
                            echo "<td><b>Fridays : </b></td>";
                            echo "<td>".$closingDays[$i]['hour']."</td>";
                        echo "</tr>";               
                    }
                }
                
                for ($i =0;$i<count($closingDays);$i++){
                    if ($closingDays[$i]['closing_day']=='SAT'){   
                        echo "<tr>";
                            echo "<td><b>Saturdays : </b></td>";
                            echo "<td>".$closingDays[$i]['hour']."</td>";
                        echo "</tr>";               
                    }
                }
                
                for ($i =0;$i<count($closingDays);$i++){
                    if ($closingDays[$i]['closing_day']=='SUN'){   
                        echo "<tr>";
                            echo "<td><b>Sundays : </b></td>";
                            echo "<td>".$closingDays[$i]['hour']."</td>";
                        echo "</tr>";               
                    }
                }
                
                echo "</div>";
                echo "</table>";
            }
        }
    }
?>