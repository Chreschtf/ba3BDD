<?php
    class EstablishmentProfileController{
        private function __construct(){
        }
        public static function displayGenericInfo($data, $uid){
            
            // temporary :
            echo "<td> <a href='?action=createComment&eid=".$data['eid']."&uid=".$uid."'>Write a new Comment</a> </td>";
            echo "<td> <a href='?action=createTag&eid=".$data['eid']."&uid=".$uid."'>Tag this establishment</a> </td>";
            echo "<a href='?action=search'>Click here to go back to search.</a>";
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
                echo "<td><b>Name : </b> </td>";
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
                        
        }
        public static function displayComments($id){
            $comments = Db::getInstance()->getCommentsOnEstablishment($id);
            echo "<h2>Comments</h2>";
            if (count($comments) == 0){
                echo "No comments available";
            }else{
                echo "<b>Average Score : </b>".round($comments[0]['average'],2)."<br><br>";
                for ($i=0;$i<count($comments);$i++){
                    echo "<b>Date : </b>".$comments[$i]['entry_date'].'<br>';
                    echo "<b>From :</b> ".$comments[$i]["nickname"]."<br>";
                    echo "<b>Score : </b>".$comments[$i]['score'].'<br>';
                    echo '"'.$comments[$i]['text'].'"<br><br>';
                }
            }
        }
        
        public static function displayTags($id){
            $tags = Db::getInstance()->getTagsOnEstablishment($id);
            echo "<h2>Tags</h2>";
            if (count($tags)==0){
                echo "No tags available";
            }
            else{
                for ($i=0;$i<count($tags);$i++){
                    echo $tags[$i]['tname'].' ; ';
                }
            }
        } 
    }
?>