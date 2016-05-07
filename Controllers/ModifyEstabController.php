<?php
    class ModifyEstabController{
        
        private _eid;
        private _uid;
        
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
                this->_eid = (int)$_POST['eid'];
                this->_uid = (int)$_POST['uid'];
                $data = Db::getInstance()->getEstablishment($this->_eid);
                if(isset($_POST['ename'])){ // modify request fullfilled
                    $this->verifyAndApplyModifications($data);
                } else { // modify request to fullfill
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
            
            if(Db::getInstance()->getEstablishment(this->_eid) == 'Restaurant'){
                $this->displayRestaurantInputs($data);
            } elseif (Db::getInstance()->getEstablishment(this->_eid) == 'Bar'){
                $this->displayBarInputs($data);
            } else { // Hotel
                $this->displayHotelInputs($data);
            }
            
            $this->displaySubmit($data);
        }
        
        public function displayEstabInputs($data){
            
        }
        
        public function displayRestaurantInputs($data){
            $restData = Db::getInstance()->getRestaurantData($this->_eid);
            
        }
        
        public function displayBarInputs($data){
            $restData = Db::getInstance()->getBarData($this->_eid);
            
        }
        
        public function displayHotelInputs($data){
            $restData = Db::getInstance()->getHotelData($this->_eid);
            
        }
        
        public function displaySubmit($data){
            
        }
    }
?>