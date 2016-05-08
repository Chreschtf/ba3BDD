<?php
    class ModifyEstabController{
        
        private $_eid;
        private $_uid;
        private $horeca_type;
        
        public function __contruct(){
            
        }
        
        private function getEstabType($horeca_type){
            $type = "";
            if ( $horeca_type == 'Bar' ) {
                $type = "barProfile";
            } else if ( $horeca_type == 'Restaurant' ) {
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
                $this->_eid = (int)$_POST['eid'];
                $this->_uid = (int)$_POST['uid'];
                $data = Db::getInstance()->getEstablishment($this->_eid);
                $this->horeca_type = $data['horeca_type'];
                
                if(isset($_POST['ename'])){ // modify request fullfilled
                    $this->applyModifications();
                } else {                    // modify request to fullfill
                    $this->showInputs($data);
                }
                
            }
        }
        
        public function applyModifications(){
            $type =  $this->getEstabType($_POST['horeca_type']);
            
            $this->applyEstablishmentModifs();
            
            if($_POST['horeca_type'] == 'Restaurant'){
                $this->applyRestaurantModifs();
            } elseif ($_POST['horeca_type'] == 'Bar') {
                $this->applyBarModifs();
            } else { // Hotel
                $this->applyHotelModifs();
            }
            
            header('Location: ?action=' . $type . '&eid=' . $this->_eid);
            die();
        }
        
        public function applyEstablishmentModifs(){
            $ename = $_POST["ename"];
            $street = $_POST["street"];
            $house_num = $_POST["house_num"];
            $zip = $_POST["zip"];
            $city = $_POST["city"];
            $longitude = floatval($_POST["longitude"]);
            $latitude = floatval($_POST["latitude"]);
            $tel = $_POST["tel"];
            $site = $_POST["site"];
            $data = array($ename, $street, $house_num, $zip, $city, 
                        $longitude, $latitude, $tel, $site);
            Db::getInstance()->updateEstablishment($this->_eid, $data);
        }
        
        public function applyRestaurantModifs() {
            $price_range = (int)$_POST["price_range"];
            $banquet_capacity = (int)$_POST["banquet_capacity"];
            $takeaway = ($_POST["hasTakeaway"] == 'Y') ? 1 : 0;
            $delivery = ($_POST["hasDelivery"] == 'Y') ? 1 : 0;
            $data = array($price_range, $banquet_capacity, $takeaway, $delivery);
            Db::getInstance()->updateRestaurant($this->_eid, $data);
            
            Db::getInstance()->deleteRestaurantClosingDays($this->_eid);
            $days = array("MON", "TUE", "WED", "THU", "FRI", "SAT", "SUN");
            foreach($days as $day){
                $hour = $_POST[$day];
                if ($hour != "open")
                    Db::getInstance()->insertRestaurantClosingDays( array($this->_eid, $day, $hour) );
            }
        }
        
        public function applyBarModifs() {
            $smoking = ($_POST["hasSmoking"] == 'Y') ? 1 : 0;
            $snack = ($_POST["hasSnack"] == 'Y') ? 1 : 0;
            $data = array($smoking, $snack);
            Db::getInstance()->updateBar($this->_eid, $data);
        }
        
        public function applyHotelModifs() {
            $stars = (int)$_POST["stars"];
            $rooms = (int)$_POST["rooms"];
            $standard_price = (int)$_POST["standard_price"];
            $data = array($stars, $rooms, $standard_price);
            Db::getInstance()->updateHotel($this->_eid, $data);
        }
        
        public function showInputs($data){
            
            $this->displayEstabInputs($data);
            
            if($data['horeca_type'] == 'Restaurant'){
                $this->displayRestaurantInputs($data);
            } elseif ($data['horeca_type'] == 'Bar'){
                $this->displayBarInputs($data);
            } else { // Hotel
                $this->displayHotelInputs($data);
            }
            
            $this->displaySubmit();
            die();
        }
        
        public function displayEstabInputs($data){
            echo "           <div class='container'>";
            echo " <div class='row'>";
            echo " 	<div class='col-md-6'>";

                 if (isset($notification) && $notification != '')
                     echo "<div style='color:#FF0000'>" . $notification . "</div>';";
                     
            echo "       ";
            echo "         <form class='form-horizontal' action='?action=modifyEstablishment' method='post'>";
            echo "         <fieldset>";
            echo "           <div id='legend'>";
            echo "              <p></p><p></p><p></p><p></p>";
            echo "             <legend class=''></legend>";
            echo "           </div>";
            echo "           <div class='control-group'>";
            echo "             <label class='control-label' for='ename'>Establishment's name</label>";
            echo "             <div class='controls'>";
            echo "               <input type='text' pattern='{3,40}' id='ename' name='ename' value=" . $data["ename"] . " required class='form-control input-lg'>";
            echo "             </div>";
            echo "           </div>";
            echo "        ";
            echo "           <div class='control-group'>";
            echo "             <label class='control-label' for='street'>Street</label>";
            echo "             <div class='controls'>";
            echo "               <input type='text' pattern='.{0}|.{3,40}' id='street' name='street'  value=" . $data["street"] . " required class='form-control input-lg'>";
            echo "             </div>";
            echo "           </div>";
            echo "        ";
            echo "           <div class='control-group'>";
            echo "             <label class='control-label' for='house_num'>House number </label>";
            echo "             <div class='controls'>";
            echo "               <input type='text' pattern='.{0}|.{1,7}' id='house_num' name='house_num'  value=" . $data["house_num"] . " class='form-control input-lg'>";
            echo "             </div>";
            echo "           </div>";
            echo "                    ";
            echo "           <div class='control-group'>";
            echo "             <label class='control-label' for='zip'>Zip</label>";
            echo "             <div class='controls'>";
            echo "               <input type='text' pattern='.{0}|.{4,4}' id='zip' name='zip'  value=" . $data["zip"] . " required class='form-control input-lg'>";
            echo "             </div>";
            echo "           </div>";
            echo "           ";
            echo "           <div class='control-group'>";
            echo "             <label class='control-label' for='city'>City</label>";
            echo "             <div class='controls'>";
            echo "               <input type='text' pattern='.{0}|.{3,20}' id='city' name='city'  value=" . $data["city"] . " required class='form-control input-lg'>";
            echo "             </div>";
            echo "           </div>";
            echo "           ";
            echo "           <div class='control-group'>";
            echo "             <label class='control-label' for='longitude'>Longitude</label>";
            echo "             <div class='controls'>";
            echo "               <input type='text' pattern='.{0}|.{1,23}' id='longitude' name='longitude'  value=" . $data["longitude"] . " required class='form-control input-lg'>";
            echo "             </div>";
            echo "           </div>";
            echo "           ";
            echo "           <div class='control-group'>";
            echo "             <label class='control-label' for='latitude'>Latitude</label>";
            echo "             <div class='controls'>";
            echo "               <input type='text' pattern='.{0}|.{1,23}' id='latitude' name='latitude'  value=" . $data["latitude"] . " required class='form-control input-lg'>";
            echo "             </div>";
            echo "           </div>";
            echo "           ";
            echo "           <div class='control-group'>";
            echo "             <label class='control-label' for='tel'>Telephone</label>";
            echo "             <div class='controls'>";
            echo "               <input type='text' pattern='.{0}|.{8,20}' id='tel' name='tel'  value=" . $data["tel"] . " required class='form-control input-lg'>";
            echo "             </div>";
            echo "           </div>";
            echo "           ";
            $site = ( $data["site"] != NULL) ? $data["site"]."/" : "http://";
            echo "           <div class='control-group'>";
            echo "             <label class='control-label' for='site'>Site</label>";
            echo "             <div class='controls'>";
            echo "               <input type='text' pattern='.{0}|.{5,60}' id='site' name='site'  value=".$site." class='form-control input-lg'>";
            echo "             </div>";
            echo "           </div>";
            echo "           <input type='hidden' name='eid' value=" . $this->_eid . ">";
            echo "           <input type='hidden' name='uid' value=" . $this->_uid . ">";
            echo "           <input type='hidden' name='horeca_type' value=" . $this->horeca_type . ">";
        }
        
        public function displayRestaurantInputs($data){
            $restData = Db::getInstance()->getRestaurantData($this->_eid);
            $closingDays = Db::getInstance()->getClosingDays($this->_eid);
            
           echo "<h3>Opening hours :</h3>";
           echo "<div class='control-group'>";
              
              echo "<div class='controls'>";
                echo "<label class='control-label' for='MON'>Monday : </label><p>";
                echo "<input type='radio' value='open' name='MON'  " . $this->checkClosingDay("MON", "open", $closingDays) . " >Open all day</input>";
                echo "<input type='radio' value='AM' name='MON' " . $this->checkClosingDay("MON", "AM", $closingDays) . " >Closed AM</input>";
                echo "<input type='radio' value='PM' name='MON' " . $this->checkClosingDay("MON", "PM", $closingDays) . ">Closed PM</input>";
                echo "<input type='radio' value='COMPLETE' name='MON'  " . $this->checkClosingDay("MON", "COMPLETE", $closingDays) . ">Closed all day</input>";
                echo "<br>";
                echo "<label class='control-label' for='TUE'>Tuesday : </label><p>";
                echo "<input type='radio' value='open' name='TUE'  " . $this->checkClosingDay("TUE", "open", $closingDays) . " >Open all day</input>";
                echo "<input type='radio' value='AM' name='TUE' " . $this->checkClosingDay("TUE", "AM", $closingDays) . " >Closed AM</input>";
                echo "<input type='radio' value='PM' name='TUE' " . $this->checkClosingDay("TUE", "PM", $closingDays) . ">Closed PM</input>";
                echo "<input type='radio' value='COMPLETE' name='TUE' " . $this->checkClosingDay("TUE", "COMPLETE", $closingDays) . " >Closed all day</input>";
                echo "<br>";
                echo "<label class='control-label' for='WED'>Wednesday : </label><p>";
                echo "<input type='radio' value='open' name='WED'  " . $this->checkClosingDay("WED", "open", $closingDays) . " >Open all day</input>";
                echo "<input type='radio' value='AM' name='WED' " . $this->checkClosingDay("WED", "AM", $closingDays) . " >Closed AM</input>";
                echo "<input type='radio' value='PM' name='WED' " . $this->checkClosingDay("WED", "PM", $closingDays) . ">Closed PM</input>";
                echo "<input type='radio' value='COMPLETE' name='WED' " . $this->checkClosingDay("WED", "COMPLETE", $closingDays) . " >Closed all day</input>";
                echo "<br>";
                echo "<label class='control-label' for='THU'>Thursday : </label><p>";
                echo "<input type='radio' value='open' name='THU'  " . $this->checkClosingDay("THU", "open", $closingDays) . " >Open all day</input>";
                echo "<input type='radio' value='AM' name='THU' " . $this->checkClosingDay("THU", "AM", $closingDays) . " >Closed AM</input>";
                echo "<input type='radio' value='PM' name='THU' " . $this->checkClosingDay("THU", "PM", $closingDays) . " >Closed PM</input>";
                echo "<input type='radio' value='COMPLETE' name='THU' " . $this->checkClosingDay("THU", "COMPLETE", $closingDays) . "  >Closed all day</input>";
                echo "<br>";
                echo "<label class='control-label' for='FRI'>Friday : </label><p>";
                echo "<input type='radio' value='open' name='FRI'  " . $this->checkClosingDay("FRI", "open", $closingDays) . "  >Open all day</input>";
                echo "<input type='radio' value='AM' name='FRI' " . $this->checkClosingDay("FRI", "AM", $closingDays) . ">Closed AM</input>";
                echo "<input type='radio' value='PM' name='FRI' " . $this->checkClosingDay("FRI", "PM", $closingDays) . ">Closed PM</input>";
                echo "<input type='radio' value='COMPLETE' name='FRI' " . $this->checkClosingDay("FRI", "COMPLETE", $closingDays) . " >Closed all day</input>";
                echo "<br>";
                echo "<label class='control-label' for='SAT'>Saturday : </label><p>";
                echo "<input type='radio' value='open' name='SAT'  " . $this->checkClosingDay("SAT", "open", $closingDays) . " >Open all day</input>";
                echo "<input type='radio' value='AM' name='SAT' " . $this->checkClosingDay("SAT", "AM", $closingDays) . ">Closed AM</input>";
                echo "<input type='radio' value='PM' name='SAT' " . $this->checkClosingDay("SAT", "PM", $closingDays) . ">Closed PM</input>";
                echo "<input type='radio' value='COMPLETE' name='SAT' " . $this->checkClosingDay("SAT", "COMPLETE", $closingDays) . " >Closed all day</input>";
                echo "<br>";
                echo "<label class='control-label' for='SUN'>Sunday : </label><p>";
                echo "<input type='radio' value='open' name='SUN'  " . $this->checkClosingDay("SUN", "open", $closingDays) . " >Open all day</input>";
                echo "<input type='radio' value='AM' name='SUN' " . $this->checkClosingDay("SUN", "AM", $closingDays) . ">Closed AM</input>";
                echo "<input type='radio' value='PM' name='SUN' " . $this->checkClosingDay("SUN", "PM", $closingDays) . ">Closed PM</input>";
                echo "<input type='radio' value='COMPLETE' name='SUN' " . $this->checkClosingDay("SUN", "COMPLETE", $closingDays) . " >Closed all day</input>";
                echo "<br>";
                
                $takeawayYes = ($restData["takeaway"]) ? 'checked'  : "";
                $takeawayNo = ( ! $restData["takeaway"]) ? 'checked'  : "";
                echo "<label class='control-label' for='Takeaway'>Takeaway  : </label><p>";
                echo "<input type='radio' value='Y' name='hasTakeaway' " . $takeawayYes . " >Yes</input>";
                echo "<input type='radio' value='N' name='hasTakeaway' " . $takeawayNo . " >No</input>";
                echo "<br>";
                
                $deliveryYes = ($restData["delivery"]) ? 'checked'  : "";
                $deliveryNo = ( ! $restData["delivery"]) ? 'checked'  : "";
                echo "<label class='control-label' for='Delivery'>Delivery : </label><p>";
                echo "<input type='radio' value='Y' name='hasDelivery'  " . $deliveryYes . " >Yes</input>";
                echo "<input type='radio' value='N' name='hasDelivery' " . $deliveryNo . " >No</input>";
                
              echo "</div>";
            echo "</div>";
            
            echo "<div class='control-group'>";
            echo "  <label class='control-label' for='banquet_capacity'>Banquet capacity  : </label>";
            echo "  <div class='controls'>";
            echo "    <input type='number' id='banquet_capacity' name='banquet_capacity' min='0' max='400' value=" . $restData["banquet_capacity"] . " required>";
            echo "  </div>";
            echo "</div>";
            
            echo "<div class='control-group'>";
            echo "  <label class='control-label' for='price_range'>Price range  : </label>";
            echo "  <div class='controls'>";
            echo "    <input type='number' id='price_range' name='price_range' min='0' max='200' value=" . $restData["price_range"] . " required>";
            echo "  </div>";
            echo "</div>";
        }
        
        public function checkClosingDay($day, $hour, $closingDays){
            
            for ($i=0; $i<count($closingDays); $i++) {
                if ($closingDays[$i]["closing_day"] == $day && $closingDays[$i]["hour"] == $hour)
                    return "checked";
            }
            
            if($hour == "open")
                return "checked";
            else
                return "";
        }
        
        public function displayBarInputs($data){
            $barData = Db::getInstance()->getBarData($this->_eid);
            
            $smokingYes = ($barData["smoking"]) ? 'checked'  : "";
            $smokingNo = ( ! $barData["smoking"]) ? 'checked'  : "";
            
            $snackYes = ($barData["snack"]) ? 'checked'  : "";
            $snackNo = ( ! $barData["snack"]) ? 'checked'  : "";
            
            echo "<div class='control-group'>";
                echo "<div class='controls'>";
                    echo "<label class='control-label' for='Smoking'>Smoking allowed  : </label><p>";
                    echo "<input type='radio' value='Y' name='hasSmoking'  " . $smokingYes . " >Yes</input>";
                    echo "<input type='radio' value='N' name='hasSmoking' " . $smokingNo . ">No</input>";
                    
                    echo "<br>";
                    echo "<label class='control-label' for='Snack'>Snack's : </label><p>";
                    echo "<input type='radio' value='Y' name='hasSnack'  " . $snackYes . " >Yes</input>";
                    echo "<input type='radio' value='N' name='hasSnack' " . $snackNo . ">No</input>";
              echo "</div>";
            echo "</div>";
        }
        
        public function displayHotelInputs($data){
            $hotelData = Db::getInstance()->getHotelData($this->_eid);
            
            $_0 = ($hotelData['stars'] == 0) ? "checked" : "";
            $_1 = ($hotelData['stars'] == 1) ? "checked" : "";
            $_2 = ($hotelData['stars'] == 2) ? "checked" : "";
            $_3 = ($hotelData['stars'] == 3) ? "checked" : "";
            $_4 = ($hotelData['stars'] == 4) ? "checked" : "";
            $_5 = ($hotelData['stars'] == 5) ? "checked" : "";
            echo "<div class='control-group'>";
                echo "<div class='controls'>";
                    echo "<label class='control-label' for='Stars'>Stars  : </label><p>";
                    echo "<input type='radio' value='0' name='stars'  " . $_0 . " >0</input>";
                    echo "<input type='radio' value='1' name='stars'  " . $_1 . ">1</input>";
                    echo "<input type='radio' value='2' name='stars'  " . $_2 . ">2</input>";
                    echo "<input type='radio' value='3' name='stars'  " . $_3 . ">3</input>";
                    echo "<input type='radio' value='4' name='stars'  " . $_4 . ">4</input>";
                    echo "<input type='radio' value='5' name='stars'  " . $_5 . ">5</input>";
                echo "</div>";
            echo "</div>";
                        
            echo "<div class='control-group'>";
            echo "  <label class='control-label' for='rooms'>Rooms  : </label>";
            echo "  <div class='controls'>";
            echo "    <input type='number' id='rooms' name='rooms' min='1' max='100' value=" . $hotelData["rooms"] . " required>";
            echo "  </div>";
            echo "</div>";
                        
            echo "<div class='control-group'>";
            echo "  <label class='control-label' for='standard_price'>Standard price  : </label>";
            echo "  <div class='controls'>";
            echo "    <input type='number' id='standard_price' name='standard_price' min='1' max='1000' value=" . $hotelData["standard_price"] . " required>";
            echo "  </div>";
            echo "</div>";
        }
        
        private function displaySubmit(){
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