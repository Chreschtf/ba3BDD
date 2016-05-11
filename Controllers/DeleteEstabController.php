<?php
    class DeleteEstabController {
        
        public function __construct() {}
        
        public function run() {
            require_once('Controllers/CookieController.php');
            $controller = new CookieController();
            if (!$controller->checkCookies()) {
                header("Location:?action=login");
                die();
            }else{
                
                $estabData = Db::getInstance()->getEstablishment((int)$_POST['eid']);
                
                if($estabData['horeca_type'] == 'Restaurant'){
                    Db::getInstance()->deleteRestaurantWithEID((int)$_POST['eid']);
                } elseif ($estabData['horeca_type'] == 'Bar') {
                    Db::getInstance()->deleteBarWithEID((int)$_POST['eid']);
                } else {        // Hotel
                    Db::getInstance()->deleteHotelWithEID((int)$_POST['eid']);
                }
                
                Db::getInstance()->deleteEstablishmentWithEID((int)$_POST['eid']);
                
                header('Location: ?action=userProfile&user='.$_COOKIE['username']);
                die();
            }
        }
    }  
?>