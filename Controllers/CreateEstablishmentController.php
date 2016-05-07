<?php
    class CreateEstablishmentController{
        

        private $horeca_type;
        
        public function __contruct(){
            
        }
        
        public function setType($horeca_type){
            $this->horeca_type = $horeca_type;
        }
        
        private function getEstabType($data){
            $type = "";
            if ( $data['horeca_type'] == 'Bar' ) {
                $type = "barProfile";
            } else if ( $data['horeca_type'] == 'Restaurant' ) {
                $type = "restaurantProfile";
            } else { // Hotel
                $type = "hotelProfile";
            }
            return $type;
        }
        
        public function run(){
            require_once('Controllers/CookieController.php');
            $controller = new CookieController();
            if (!$controller->checkCookies()) {
                header("Location:?action=login");
                die();
            }else{
                $notification = "";
                
                if (isset($_POST['ename'])) {     // create request fullfilled
                
                    $this->horeca_type = $_POST['horeca_type'];
                    $this->verifyAndCreateEstab();
                    
                } elseif ( ! empty($_GET) ) {                        // create request to fullfill
                
                    $this->showInputs();
                    
                } else {
                    
                    header('Location: ?action=userProfile&user='.$_COOKIE["username"]);
                    die();
                    
                }
            }
        }
        
        public function verifyAndCreateEstab(){
            
            // if ($this->verifyEstablishmentInputs()){
                
            $eid = $this->createEstablishment();
            
            $type = "";
            if ($this->horeca_type == 'Restaurant'){
                $this->createRestaurant($eid);
                $type = "restaurantProfile";
            } elseif ($this->horeca_type == 'Bar'){
                $this->createBar($eid);
                $type = "barProfile";
            } else { // Hotel
                $this->createHotel($eid);
                $type = "hotelProfile";
            }
            
            header('Location: ?action=' . $type . '&eid=' . $eid);
            die();
                
            // } else {
            //     $notification = "The submitted data is incorrect";
            //     $this->showInputs(); // TODO : include previous data
            // }
        }
        
        public function createEstablishment(){
            $ename = $_POST["ename"];
            $street = $_POST["street"];
            $house_num = $_POST["house_num"];
            $zip = $_POST["zip"];
            $city = $_POST["city"];
            $longitude = floatval($_POST["longitude"]);
            $latitude = floatval($_POST["latitude"]);
            $tel = $_POST["tel"];
            $site = $_POST["site"];
            $uid = Db::getInstance()->getUIDof($_COOKIE["username"]);
            $data = array($ename, $street, $house_num, $zip, $city, 
                        $longitude, $latitude, $tel, $site, (int)$uid, $this->horeca_type);
            return Db::getInstance()->insertEstablishmentWithoutDate($data);
        }
        
        public function createRestaurant($eid){
            $price_range = (int)$_POST["price_range"];
            $banquet_capacity = (int)$_POST["banquet_capacity"];
            $takeaway = ($_POST["hasTakeaway"] == 'Y') ? 1 : 0;
            $delivery = ($_POST["hasDelivery"] == 'Y') ? 1 : 0;
            $data = array($eid, $price_range, $banquet_capacity, $takeaway, $delivery);
            Db::getInstance()->insertRestaurant($data);
        }
        
        public function createBar($eid){
            $smoking = ($_POST["hasSmoking"] == 'Y') ? 1 : 0;
            $snack = ($_POST["hasSnack"] == 'Y') ? 1 : 0;
            $data = array((int)$eid, $smoking, $snack);
            Db::getInstance()->insertBar($data);
        }
        
        public function createHotel($eid){
            $stars = (int)$_POST["stars"];
            $rooms = (int)$_POST["rooms"];
            $standard_price = (int)$_POST["standard_price"];
            $data = array((int)$eid, $stars, $rooms, $standard_price);
            Db::getInstance()->insertHotel($data);
        }
        
        public function showInputs(){
            
            require_once(VIEWSPATH.'createEstablishment.php');
            
            if ($this->horeca_type == 'Restaurant'){
                $this->showRestaurantSpecificInputs();
            } elseif ($this->horeca_type == 'Bar'){
                $this->showBarSpecificInputs();
            } else { // Hotel
                $this->showHotelSpecificInputs();
            }
            
            $this->displaySubmit();
            die();
        }
        
        private function showRestaurantSpecificInputs(){
           echo "<h3>Opening hours :</h3>";
           echo "<div class='control-group'>";
              
              echo "<div class='controls'>";
                echo "<label class='control-label' for='Mon'>Monday : </label><p>";
                echo "<input type='radio' value='open' name='Mon'  checked >Open all day</input>";
                echo "<input type='radio' value='am' name='Mon' >Closed AM</input>";
                echo "<input type='radio' value='pm' name='Mon' >Closed PM</input>";
                echo "<input type='radio' value='complete' name='Mon'  >Closed all day</input>";
                echo "<br>";
                echo "<label class='control-label' for='Tue'>Tuesday : </label><p>";
                echo "<input type='radio' value='open' name='Tue'  checked >Open all day</input>";
                echo "<input type='radio' value='am' name='Tue' >Closed AM</input>";
                echo "<input type='radio' value='pm' name='Tue' >Closed PM</input>";
                echo "<input type='radio' value='complete' name='Tue'  >Closed all day</input>";
                echo "<br>";
                echo "<label class='control-label' for='Wed'>Wednesday : </label><p>";
                echo "<input type='radio' value='open' name='Wed'  checked >Open all day</input>";
                echo "<input type='radio' value='am' name='Wed' >Closed AM</input>";
                echo "<input type='radio' value='pm' name='Wed' >Closed PM</input>";
                echo "<input type='radio' value='complete' name='Wed'  >Closed all day</input>";
                echo "<br>";
                echo "<label class='control-label' for='Thu'>Thursday : </label><p>";
                echo "<input type='radio' value='open' name='Thu'  checked >Open all day</input>";
                echo "<input type='radio' value='am' name='Thu' >Closed AM</input>";
                echo "<input type='radio' value='pm' name='Thu' >Closed PM</input>";
                echo "<input type='radio' value='complete' name='Thu'  >Closed all day</input>";
                echo "<br>";
                echo "<label class='control-label' for='Fri'>Friday : </label><p>";
                echo "<input type='radio' value='open' name='Fri'  checked >Open all day</input>";
                echo "<input type='radio' value='am' name='Fri' >Closed AM</input>";
                echo "<input type='radio' value='pm' name='Fri' >Closed PM</input>";
                echo "<input type='radio' value='complete' name='Fri'  >Closed all day</input>";
                echo "<br>";
                echo "<label class='control-label' for='Sat'>Saturday : </label><p>";
                echo "<input type='radio' value='open' name='Sat'  checked >Open all day</input>";
                echo "<input type='radio' value='am' name='Sat' >Closed AM</input>";
                echo "<input type='radio' value='pm' name='Sat' >Closed PM</input>";
                echo "<input type='radio' value='complete' name='Sat'  >Closed all day</input>";
                echo "<br>";
                echo "<label class='control-label' for='Sun'>Sunday : </label><p>";
                echo "<input type='radio' value='open' name='Sun'  checked >Open all day</input>";
                echo "<input type='radio' value='am' name='Sun' >Closed AM</input>";
                echo "<input type='radio' value='pm' name='Sun' >Closed PM</input>";
                echo "<input type='radio' value='complete' name='Sun'  >Closed all day</input>";
                echo "<br>";
                
                echo "<label class='control-label' for='Takeaway'>Takeaway  : </label><p>";
                echo "<input type='radio' value='Y' name='hasTakeaway'  checked >Yes</input>";
                echo "<input type='radio' value='N' name='hasTakeaway' >No</input>";
                echo "<br>";
                echo "<label class='control-label' for='Delivery'>Delivery : </label><p>";
                echo "<input type='radio' value='Y' name='hasDelivery'  checked >Yes</input>";
                echo "<input type='radio' value='N' name='hasDelivery' >No</input>";
              echo "</div>";
            echo "</div>";
            
            echo "<div class='control-group'>";
            echo "  <label class='control-label' for='banquet_capacity'>Banquet capacity  : </label>";
            echo "  <div class='controls'>";
            echo "    <input type='number' id='banquet_capacity' name='banquet_capacity' min='0' max='400' value='0' required>";
            echo "  </div>";
            echo "</div>";
            
            echo "<div class='control-group'>";
            echo "  <label class='control-label' for='price_range'>Price range  : </label>";
            echo "  <div class='controls'>";
            echo "    <input type='number' id='price_range' name='price_range' min='0' max='200' value='30' required>";
            echo "  </div>";
            echo "</div>";
        }
        
        private function showBarSpecificInputs(){
              echo "<div class='control-group'>";
                echo "<div class='controls'>";
                    echo "<label class='control-label' for='Smoking'>Smoking allowed  : </label><p>";
                    echo "<input type='radio' value='Y' name='hasSmoking'  checked >Yes</input>";
                    echo "<input type='radio' value='N' name='hasSmoking' >No</input>";
                    
                    echo "<br>";
                    echo "<label class='control-label' for='Snack'>Snack's : </label><p>";
                    echo "<input type='radio' value='Y' name='hasSnack'  checked >Yes</input>";
                    echo "<input type='radio' value='N' name='hasSnack' >No</input>";
              echo "</div>";
            echo "</div>";
        }
        
        private function showHotelSpecificInputs(){
              echo "<div class='control-group'>";
                echo "<div class='controls'>";
                    echo "<label class='control-label' for='Stars'>Stars  : </label><p>";
                    echo "<input type='radio' value='0' name='stars'  checked >0</input>";
                    echo "<input type='radio' value='1' name='stars'  >1</input>";
                    echo "<input type='radio' value='2' name='stars'  >2</input>";
                    echo "<input type='radio' value='3' name='stars'  >3</input>";
                    echo "<input type='radio' value='4' name='stars'  >4</input>";
                    echo "<input type='radio' value='5' name='stars'  >5</input>";
              echo "</div>";
            echo "</div>";
                        
            echo "<div class='control-group'>";
            echo "  <label class='control-label' for='rooms'>Rooms  : </label>";
            echo "  <div class='controls'>";
            echo "    <input type='number' id='rooms' name='rooms' min='1' max='100' value='1' required>";
            echo "  </div>";
            echo "</div>";
                        
            echo "<div class='control-group'>";
            echo "  <label class='control-label' for='standard_price'>Standard price  : </label>";
            echo "  <div class='controls'>";
            echo "    <input type='number' id='standard_price' name='standard_price' min='1' max='1000' value='100' required>";
            echo "  </div>";
            echo "</div>";
        }
        
        private function displaySubmit(){
            echo "            <input type='hidden' name='horeca_type' value=" . $this->horeca_type . ">";
            echo "            <br>";
            echo "            <div class='control-group'>";
            echo "            <!-- Button -->";
            echo "            <div class='controls'>";
            echo "                <button class='btn btn-success' name='form_signup' type='submit'>Submit</button>";
            echo "            </div>";
            echo "            </div>";
            echo "        </fieldset>";      
            echo "        </form>";
            echo "    </div>";
            echo "</div>";
            echo "</div>";
        }
        

    }
?>