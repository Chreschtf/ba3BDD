<?php
    class CreateEstablishmentController{
        

        #private _uid;
        
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
                if (!empty($_POST)){
                    if (($_POST['Mon'])=='Mon_open'){
                    }
                    
                }
            require_once(VIEWSPATH.'createEstablishment.php');
            }
        }
        
        public function verifyInputs($data){
            
            
            
            $type =  $this->getEstabType(  );
            header('Location: ?action=' . $type . '&eid=' . $this->_eid);
            die();
        }
        

    }
?>