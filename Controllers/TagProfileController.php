<?php
    class TagProfileController {
        
        private $_tid ;
        
        public function __construct() {
             $this->_tid = NULL;
        }
        
        public function setTid($tid){
             $this->_tid = $tid;
        }
        
        public function run() {
            require_once('Controllers/CookieController.php');
            $controller = new CookieController();
            
            if (!$controller->checkCookies()) {
                header("Location:?action=login");
                die();
                
            }else{
                if( $this->_tid == NULL ){
                    header('Location: ?action=userProfile&user='.$_COOKIE["username"]);
                    die();
                }
                
                // title 
                $tag = Db::getInstance()->getTagAndNbrTagged($this->_tid);
                echo "<h1>Tag: '" . $tag["tname"] . "'</h1>";
                echo "<p></p>";
                $nbrTagged = ($tag['_nbrTagged'] != NULL) ? $tag['_nbrTagged'] : 0 ;
                echo "<h2>Total times tagged : ". $nbrTagged ."</h2>";
                
                echo "<div class='container theme-showcase' role='main'>";
                
                // Establishments
                $results = Db::getInstance()->getTagOnEstabs($this->_tid);
                echo "<div class='page-header'>";
                echo "  <h2>Establishments tagged</h2>";
                echo "</div>";

                echo "<div>";
                echo "<table class='table table-striped'>";
                echo "    <thead>";
                echo "    <tr>";
                echo "        <th>#</th>";
                echo "        <th>Name</th>";
                echo "        <th>Times tagged</th>";
                echo "    </tr>";
                echo "    </thead>";
                echo "    <tbody>";
                
                $i = 1;
                foreach($results as $Estab){
                    echo "    <tr>";
                    echo "        <td>" . $i . "</td>";
                    
                    if($Estab['horeca_type'] == "Restaurant"){
                        echo "          <td> <a href='?action=restaurantProfile&eid=".$Estab["eid"]."'>".$Estab['ename']."</a>  </td>";
                    } else if ($Estab['horeca_type'] == "Bar"){
                        echo "          <td> <a href='?action=barProfile&eid=".$Estab["eid"]."'>".$Estab['ename']."</a>  </td>";
                    } else if ($Estab['horeca_type'] == "Hotel"){
                        echo "          <td> <a href='?action=hotelProfile&eid=".$Estab["eid"]."'>".$Estab['ename']."</a>  </td>";
                    }

                    echo "        <td>" . $Estab['_nbrTagged'] . "</td>";
                    echo "    </tr>";
                    $i = $i +1;
                }
                
                echo "    </tbody>";
                echo "</table>";
                echo "</div>";
            
            }
        }
    }  
?>