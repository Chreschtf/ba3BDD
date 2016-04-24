<?php
    class EstablishmentProfileController{
        private function __construct(){
        }
        public static function displayGenericInfo($data){
            echo "<b>Name : </b>".$data['ename']."<br>";
            echo "<b>Adress : </b>".$data['house_num'].", ".$data['street']."<br>";
            echo "<b>City : </b>".$data['city'].'<br>';
            echo "<b>Zip Code :</b>".$data["zip"]."<br>";
        }
    }
?>