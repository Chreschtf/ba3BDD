<?php
    class EstablishmentProfileController{
        private function __construct(){
        }
        public static function displayGenericInfo($data, $uid){
            
            // temporary :
            echo "<td> <a href='?action=createComment&eid=".$data['eid']."&uid=".$uid."'>Write a new Comment</a> </td>";
            
            //echo "<div class='form-createComment' >";
            //echo "  <form action='?action=createComment' method='get' >";
            //echo "      <input type='hidden' name='eid' value='" . $data['eid'] . "'/>";
            //echo "      <input type='hidden' name='uid' value='" . $uid . "'/>";
            //echo "      <input type='submit' value='Create a Comment'/>";
            //echo "  </form>";
            //echo "</div>";
            
            // end temporary
            
            echo '<table style="width:*%">';
            echo "<tr>";            
                echo "<td><b>Name : </b> </td";
                echo "<td> ".$data['ename']."</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td><b>Adress : </b></td>";
                echo "<td>".$data['house_num'].",".$data['street']."</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td><b>City : </b></td>";
                echo "<td>".$data['city']."</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td><b>Zip Code : </b></td>";
                echo "<td>".$data['zip']."</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td><b>Phone number : </b></td>";
                echo "<td>".$data['tel']."</td>";
            echo "</tr>";
            if ($data['site']!=NULL){
                echo "<tr>";
                    echo "<td><b>Web site : </b></td>";
                    echo "<td> <a href='http://".trim($data['site'])."'>".$data['site']."</a> </td>";
                echo "</tr>";
            }
            echo "<tr>";
                echo "<td><b>Longitude : </b></td>";
                echo "<td>".$data['longitude']."</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td><b>Latitude : </b></td>";
                echo "<td>".$data['latitude']."</td>";
            echo "</tr>";
            #echo "</table>";
            #echo "<b>Name : </b>".$data['ename']."<br>";
            #echo "<b>Adress : </b>".$data['house_num'].", ".$data['street']."<br>";
            #echo "<b>City : </b>".$data['city'].'<br>';
            #echo "<b>Zip Code :</b>".$data["zip"]."<br>";
            
            
            
        }
        public function displayComments($id){
            
        }
    }
?>