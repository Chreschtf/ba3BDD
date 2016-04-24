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
                if (!empty($_POST["searchQuery"])){
                    require_once(VIEWSPATH.'search.php');
                    $searchQuery = $_POST["searchQuery"];
                    if (isset($_POST["all"])){
                        $this->searchUsers($searchQuery);
                        $this->searchBars($searchQuery);
                        $this->seachRestaurants($searchQuery);
                        $this->searchHotels($searchQuery);
                        
                    }elseif (isset($_POST["users"])){
                        $this->searchUsers($searchQuery);
                    }elseif (isset($_POST["establishments"])){
                        $this->searchBars($searchQuery);
                        $this->seachRestaurants($searchQuery);
                        $this->searchHotels($searchQuery);
                    }elseif (isset($_POST["bar"])){
                        $this->searchBars($searchQuery);
                    }elseif (isset($_POST["restaurant"])){
                        $this->seachRestaurants($searchQuery);
                    }elseif (isset($_POST["hotel"])){
                        $this->seachHotels($searchQuery);
                    }
                    
                }else{
                    
                    require_once(VIEWSPATH.'search.php');
                }


            }
        }
        
        private function searchUsers($nickname){
            $users = Db::getInstance()->getUsersWithSimilarName($nickname);
            echo "<h3>Users</h3>";
            echo "<table style='width:100%'>";
            echo "<tr>";
            echo "<td> <b>Nickname</b> </td>";
            echo "<td> <b>Email</b> </td>";
            echo "<td> <b>Entry Date</b> </td>";
            echo "</tr>";
            for ($i=0;$i<count($users);$i++) {       
                echo "<tr>";
                echo "<td> ".$users[$i]['nickname']."  </td>";
                echo "<td> ".$users[$i]['email']."  </td>";
                echo "<td> ".$users[$i]['entry_date']."  </td>";
                echo '</tr>';
            }
            echo "</table>";
        }
        
        private function searchBars($name){
            #$bars = ;
            echo "<h3>Bars</h3>";
            echo "<table style='width:100%'>";
            echo "<tr>";
            echo "<td> <b>Name</b> </td>";
            echo "<td> <b>Street</b> </td>";
            echo "<td> <b>Number</b> </td>";
            echo "<td> <b>City</b> </td>";
            echo "<td> <b>Zip</b> </td>";
            echo "<td> <b>Phone number</b> </td>";
            echo "<td> <b>Website</b> </td>";
            echo "<td> <b>Smoking allowed</b> </td>";
            echo "<td> <b>Serves snacks</b> </td>";
            echo "</tr>";
        }
        
        private function seachRestaurants($name){
            
        }
        
        private function searchHotels($name){
            
        }
    }
?>