<?php
    class BarProfileController{
        private $_id;
        public function __contruct($id){
            echo $id;
            $this->_id=$id;
        }
        public function run(){
            require_once(VIEWSPATH."barProfile.php");
            require_once("EstablishmentProfileController.php");
            echo $this->_id;
            $barData=Db::getInstance()->getBarData($this->_id);
            echo empty($barData);
            EstablishmentProfileController::displayGenericInfo($barData);
            
        }
     
        
    }
?>