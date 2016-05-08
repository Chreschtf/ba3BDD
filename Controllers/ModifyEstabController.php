<?php
    class ModifyEstabController{
        
        private $_eid;
        private $_uid;
        
        
        public function __contruct(){
            
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
                $this->_eid = (int)$_POST['eid'];
                $this->_uid = (int)$_POST['uid'];
                $data = Db::getInstance()->getEstablishment($this->_eid);
                if(isset($_POST['ename'])){ // modify request fullfilled
                    $this->verifyAndApplyModifications($data);
                } else {                    // modify request to fullfill
                    $this->showInputs($data);
                }
                
            }
        }
        
        public function verifyAndApplyModifications($data){
            
            
            
            $type =  $this->getEstabType(  );
            header('Location: ?action=' . $type . '&eid=' . $this->_eid);
            die();
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
            echo "         <form class='form-horizontal' action='?action=createEstablishment' method='post'>";
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
            $restData = Db::getInstance()->getBarData($this->_eid);
            
        }
        
        public function displayHotelInputs($data){
            $restData = Db::getInstance()->getHotelData($this->_eid);
            
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