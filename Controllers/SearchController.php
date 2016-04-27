<?php
    class SearchController {
        public function __construct() {
        }
        public function run() {
            require_once('Controllers/CookieController.php');
            $controller = new CookieController();
            if (!$controller->checkCookies()) {
                header("Location:?action=login");
                die();
            }else{
                require_once(VIEWSPATH.'search.php');
                if (!empty($_POST["searchQuery"]) and isset($_POST["choice"])){
                    $searchQuery = $_POST["searchQuery"];
                    $choice = $_POST["choice"];
                    switch($choice){
                        case 'all':
                            $this->searchUsers($searchQuery);
                            $this->searchBars($searchQuery);
                            $this->seachRestaurants($searchQuery);
                            $this->searchHotels($searchQuery);
                            break;
                        case'users':
                            $this->searchUsers($searchQuery);
                            break;
                        case 'establishments':
                            $this->searchBars($searchQuery);
                            $this->seachRestaurants($searchQuery);
                            $this->searchHotels($searchQuery);
                            break;
                        case 'bar':
                            $this->searchBars($searchQuery);
                            break;
                        case 'restaurant':
                            $this->seachRestaurants($searchQuery);
                            break;
                        case 'hotel':
                            $this->seachHotels($searchQuery);
                            break;  
                    }
                    die();          
                } 
            }
        }
        
        private function searchUsers($searchQuery){
            $users = Db::getInstance()->getUsersWithSimilarName($searchQuery);
            if (count($users)!=0){
                echo "<h3>Users</h3>";
                echo "<table style='width:100%'>";
                echo "<tr>";
                echo "<td> <b>Nickname</b> </td>";
                echo "<td> <b>Email</b> </td>";
                echo "<td> <b>Entry Date</b> </td>";
                echo "</tr>";
                for ($i=0;$i<count($users);$i++) {       
                    echo "<tr>";
                    echo "<td> <a href='?action=userProfile&user=".$users[$i]['nickname']."'>".$users[$i]['nickname']."</a> </td>";
                    echo "<td> ".$users[$i]['email']."  </td>";
                    echo "<td> ".$users[$i]['entry_date']."  </td>";
                    echo '</tr>';
                }
                echo "</table>";
            }
        }
        
        private function searchBars($searchQuery){
            $bars = Db::getInstance()->getBars($searchQuery);
            if (count($bars)!=0){
                echo "<h3>Bars</h3>";
                $this->standardTableEcho();
                echo "<td> <b>Smoking allowed</b> </td>";
                echo "<td> <b>Serves snacks</b> </td>";
                echo "</tr>";
                for ($i=0;$i<count($bars);$i++) {
                    echo "<tr>";
                    echo "<td> <a href='?action=barProfile&eid=".$bars[$i]["eid"]."'>".$bars[$i]['ename']."</a>  </td>";
                    $this->standardEstablishmentInfo($bars[$i]);
                    if ($bars[$i]['smoking']){
                        echo "<td> Yes  </td>";
                    }else{
                        echo "<td> No  </td>";
                    }
                    if ($bars[$i]['snack']){
                        echo "<td> Yes  </td>";
                    }else{
                        echo "<td> No  </td>";
                    }
                    echo '</tr>';
                }
                echo "</table>";
            }
        }
        
        private function seachRestaurants($searchQuery){
            $restaurants = Db::getInstance()->getRestaurants($searchQuery);
            if (count($restaurants)!=0){
                echo "<h3>Restaurants</h3>";
                $this->standardTableEcho();
                echo "<td> <b>Price Range</b> </td>";
                echo "<td> <b>Banquet capacity</b> </td>";
                echo "<td> <b>Takeaway</b> </td>";
                echo "<td> <b>Delivery</b> </td>";
                echo "</tr>";
                for ($i=0;$i<count($restaurants);$i++){
                    echo "<tr>";
                    echo "<td> <a href='?action=restaurantProfile&eid=".$restaurants[$i]["eid"]."'>".$restaurants[$i]['ename']."</a>  </td>";
                    $this->standardEstablishmentInfo($restaurants[$i]);
                    echo "<td>".$restaurants[$i]['price_range']." € </td>";
                    echo "<td>".$restaurants[$i]['banquet_capacity']." </td>";
                    if ($restaurants[$i]['takeaway']){
                        echo "<td> Yes  </td>";
                    }else{
                        echo "<td> No  </td>";
                    }
                    if ($restaurants[$i]['delivery']){
                        echo "<td> Yes  </td>";
                    }else{
                        echo "<td> No  </td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
        }
        
        private function searchHotels($searchQuery){
            
        }
        
        private function standardTableEcho(){
            echo "<table style='width:100%'>";
            echo "<tr>";
            echo "<td> <b>Name</b> </td>";
            echo "<td> <b>Street</b> </td>";
            echo "<td> <b>Number</b> </td>";
            echo "<td> <b>City</b> </td>";
            echo "<td> <b>Zip</b> </td>";
            echo "<td> <b>Phone number</b> </td>";
            echo "<td> <b>Website</b> </td>";
        }
        
        private function standardEstablishmentInfo($info){
            echo "<td> ".$info['street']."  </td>";
            echo "<td> ".$info['house_num']."  </td>";
            echo "<td> ".$info['city']."  </td>";
            echo "<td> ".$info['zip']."  </td>";
            echo "<td> ".$info['tel']."  </td>";
            echo "<td> ".$info['site']."  </td>";
        }
    }
?>