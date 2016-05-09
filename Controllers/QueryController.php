<?php
class QueryController
{
    public function __construct() {
    }
    
    public function run() {
        require_once('Controllers/CookieController.php');
        $controller = new CookieController();
        
        if (!$controller->checkCookies()) {
            
            header("Location:?action=login");
            die();
            
        }else{
            
            //$this->showTitle();
            require_once(VIEWSPATH."queryScreen.php");

            $result = Db::getInstance()->R1();
            $this->showUsers($result,
                                       "R1",
                                       "All users that like at least one establishment that
                                        'Brenda' likes.");
            
            $result = Db::getInstance()->R2();
            $this->showEstablishments($result,
                                       "R2",
                                       "All establishments that have been liked by at least one 
                                       user that likes all the establishments that 'Brenda' likes.");
            
            $result = Db::getInstance()->R3();
            $this->showEstablishments($result,
                                       "R3",
                                       "All establishments that have at most one comment.");
             
            $result = Db::getInstance()->R4();
            $this->showUsers($result,
                                       "R4",
                                       "All admins who have not commented every establishment 
                                       they created.");
            
            $result = Db::getInstance()->R5();
            $this->showEstablishments($result,
                                       "R5",
                                       "All establishments that have at least three comments 
                                       sorted by the average score they received in the comments.");
            
            $result = Db::getInstance()->R6();
            $this->showTags($result,
                                       "R6",
                                       "All the tags that have been used on at least 5 different establishments 
                                       sorted by the average score of the establishments being tagged by this tag.");
            
            echo "</div>";
            }
        }
        
        
        public function showTitle(){
            echo "<div class='container theme-showcase' role='main'>";
            echo "<div class='jumbotron'>";
            echo "    <h1>Query Results :</h1>";
            echo "</div>";
        }
        
        public function showEstablishments($results, $title, $description) {
            
            echo "<div class='page-header'>";
            echo "  <h1>" . $title . "</h1>";
            echo "  <p>" . $description . "</p>";
            echo "</div>";
            
            echo "<div>";
            echo "<table class='table table-striped'>";
            echo "    <thead>";
            echo "    <tr>";
            echo "        <th>#</th>";
            echo "        <th>Name</th>";
            echo "        <th>Street</th>";
            echo "        <th>City</th>";
            echo "        <th>Zip Code</th>";
            echo "        <th>Phone number</th>";
            echo "        <th>Web site</th>";
            echo "        <th>Longitude</th>";
            echo "        <th>Latitude</th>";
            echo "        <th>Type</th>";
            //echo "        <th>Average Score</th>";
            echo "    </tr>";
            echo "    </thead>";
            echo "    <tbody>";
            
            $i = 1;
            foreach($results as $Estab){
                echo "    <tr>";
                echo "        <td>" . $i . "</td>";
                //echo "        <td>" . $Estab['ename'] . "</td>";
                if($Estab['horeca_type'] == "Restaurant"){
                    echo "          <td> <a href='?action=restaurantProfile&eid=".$Estab["eid"]."'>".$Estab['ename']."</a>  </td>";
                } else if ($Estab['horeca_type'] == "Bar"){
                    echo "          <td> <a href='?action=barProfile&eid=".$Estab["eid"]."'>".$Estab['ename']."</a>  </td>";
                } else if ($Estab['horeca_type'] == "Hotel"){
                    echo "          <td> <a href='?action=hotelProfile&eid=".$Estab["eid"]."'>".$Estab['ename']."</a>  </td>";
                }
                echo "        <td>" . $Estab['street'] . ", " . $Estab['house_num'] . "</td>";
                echo "        <td>" . $Estab['city'] . "</td>";
                echo "        <td>" . $Estab['zip'] . "</td>";
                echo "        <td>" . $Estab['tel'] . "</td>";
                if( $Estab['site'] != NULL )
                    echo "<td> <a href='".trim($Estab['site'])."'>".$Estab['site']."</a> </td>";
                else
                    echo "        <td> </td>";
                echo "        <td>" . $Estab['longitude'] . "</td>";
                echo "        <td>" . $Estab['latitude'] . "</td>";
                echo "        <td>" . $Estab['horeca_type'] . "</td>";
                //echo "        <td>" . $Estab['average'] . "</td>"
                echo "    </tr>";
                $i = $i +1;
            }
            
            echo "    </tbody>";
            echo "</table>";
            echo "</div>";
            
            
        }
        
        public function showUsers($results, $title, $description) {
            
            echo "<div class='page-header'>";
            echo "  <h1>" . $title . "</h1>";
            echo "  <p>" . $description . "</p>";
            echo "</div>";
            
            echo "<div>";
            echo "<table class='table table-striped'>";
            echo "    <thead>";
            echo "    <tr>";
            echo "        <th>#</th>";
            echo "        <th>Nickname</th>";
            echo "        <th>Email</th>";
            echo "        <th>Entry Date</th>";
            echo "        <th>is Admin</th>";
            echo "    </tr>";
            echo "    </thead>";
            echo "    <tbody>";
            
            $i = 1;
            foreach($results as $User){
                echo "    <tr>";
                echo "        <td>" . $i . "</td>";
                //echo "        <td>" . $User['nickname'] . "</td>";
                echo "        <td> <a href='?action=userProfile&user=".$User['nickname']."'>".$User['nickname']."</a> </td>";
                echo "        <td>" . $User['email'] . "</td>";
                echo "        <td>" . $User['entry_date'] . "</td>";
                if($User['admin'])
                    echo "        <td>yes</td>";
                else
                    echo "        <td>no</td>";
                echo "    </tr>";
                $i = $i +1;
            }
            
            echo "    </tbody>";
            echo "</table>";
            echo "</div>";
            
        }
        
        public function showTags($results, $title, $description) {
            
            echo "<div class='page-header'>";
            echo "  <h1>" . $title . "</h1>";
            echo "  <p>" . $description . "</p>";
            echo "</div>";
            
            echo "<div>";
            echo "<table class='table table-stiped'>";
            echo "    <thead>";
            echo "    <tr>";
            echo "        <th>#</th>";
            echo "        <th>Tag</th>";
            echo "        <th>Average Score</th>";
            echo "    </tr>";
            echo "    </thead>";
            echo "    <tbody>";
            
            $i = 1;
            foreach($results as $Tag){
                echo "    <tr>";
                echo "        <td>" . $i . "</td>";
                echo "        <td>" . $Tag['tname'] . "</td>";
                echo "        <td>" . $Tag['score_avg'] . "</td>";
                echo "    </tr>";
                
                $i = $i +1;
            }
            
            echo "    </tbody>";
            echo "</table>";
            echo "</div>";
            
        }
    }
?>