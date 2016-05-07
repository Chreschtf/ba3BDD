<?php
    class EstablishmentProfileController{
        private function __construct(){
        }
        
        public static function displayGenericInfo($data, $uid){
            
            // temporary :
            
            echo "<div class = 'row'>";
            echo "      <div class='col-xs-8 col-sm-2'>";
            echo "<form action='?action=createComment' method='post' >\n";
            echo "    <input type='hidden' name='eid' value='".$data['eid']."'>\n";
            echo "    <input type='hidden' name='uid' value='".$uid."'>\n";
            echo "    <button type='submit' class='btn btn-success'>Write a new Comment</button>\n";
            echo "</form>\n";
            echo "      </div>";
                        
            echo "      <div class='col-xs-8 col-sm-2'>";
            echo "<form action='?action=createTag' method='post' >\n";
            echo "    <input type='hidden' name='eid' value='".$data['eid']."'>\n";
            echo "    <input type='hidden' name='uid' value='".$uid."'>\n";
            echo "    <button type='submit' class='btn btn-warning'>Tag this establishment</button>\n";
            echo "</form>\n";
            echo "      </div>";
            echo "</div>";
            
            if(Db::getInstance()->isAdmin($uid)){
                echo "      <div class='col-xs-8 col-sm-2'>";
                echo "<form action='?action=modifyEstablishment' method='post' >\n";
                echo "    <input type='hidden' name='eid' value='".$data['eid']."'>\n";
                echo "    <input type='hidden' name='uid' value='".$uid."'>\n";
                echo "    <button type='submit' class='btn btn-warning'>Modify information</button>\n";
                echo "</form>\n";
                echo "      </div>";
                echo "</div>";
                
                echo "      <div class='col-xs-8 col-sm-2'>";
                echo "<form action='?action=deleteEstablishment' method='post' >\n";
                echo "    <input type='hidden' name='eid' value='".$data['eid']."'>\n";
                echo "    <input type='hidden' name='uid' value='".$uid."'>\n";
                echo "    <button type='submit' class='btn btn-warning'>Delete</button>\n";
                echo "</form>\n";
                echo "      </div>";
                echo "</div>";
            }
            

            
            // end temporary
            
            echo "<p></p>";
            echo "<div class='col-md-6'>";
            echo '<table class="table table-striped" style="width:*%">';
            echo "<tr>";            
                echo "<td><b>Name : </b> </td>";
                echo "<td> ".$data['ename']."</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td><b>Adress : </b></td>";
                echo "<td>".$data['house_num'].", ".$data['street']."</td>";
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
                    echo "<td> <a href='".trim($data['site'])."'>".$data['site']."</a> </td>";
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
            echo "</div>";
                       
        }
        
        public static function displayClosingDays($eid){
            $closingDays = Db::getInstance()->getClosingDays($eid);
            if (count($closingDays)>0){
                echo "<h2>Closing hours</h2>";
                echo "<p></p>";
                echo "<table>";
                echo "<div class='col-md-6'>";
                echo '<table class="table table-striped" style="width:*%">';
                
                for ($i =0;$i<count($closingDays);$i++){
                    if ($closingDays[$i]['closing_day']=='MON'){   
                        echo "<tr>";
                            echo "<td><b>Mondays : </b></td>";
                            echo "<td>".$closingDays[$i]['hour']."</td>";
                        echo "</tr>";               
                    }
                }
                
                for ($i =0;$i<count($closingDays);$i++){
                    if ($closingDays[$i]['closing_day']=='TUE'){   
                        echo "<tr>";
                            echo "<td><b>Tuesdays : </b></td>";
                            echo "<td>".$closingDays[$i]['hour']."</td>";
                        echo "</tr>";               
                    }
                }
                
                for ($i =0;$i<count($closingDays);$i++){
                    if ($closingDays[$i]['closing_day']=='WED'){   
                        echo "<tr>";
                            echo "<td><b>Wednesdays : </b></td>";
                            echo "<td>".$closingDays[$i]['hour']."</td>";
                        echo "</tr>";               
                    }
                }
                
                for ($i =0;$i<count($closingDays);$i++){
                    if ($closingDays[$i]['closing_day']=='THU'){   
                        echo "<tr>";
                            echo "<td><b>Thursdays : </b></td>";
                            echo "<td>".$closingDays[$i]['hour']."</td>";
                        echo "</tr>";               
                    }
                }
                
                for ($i =0;$i<count($closingDays);$i++){
                    if ($closingDays[$i]['closing_day']=='FRI'){   
                        echo "<tr>";
                            echo "<td><b>Fridays : </b></td>";
                            echo "<td>".$closingDays[$i]['hour']."</td>";
                        echo "</tr>";               
                    }
                }
                
                for ($i =0;$i<count($closingDays);$i++){
                    if ($closingDays[$i]['closing_day']=='SAT'){   
                        echo "<tr>";
                            echo "<td><b>Saturdays : </b></td>";
                            echo "<td>".$closingDays[$i]['hour']."</td>";
                        echo "</tr>";               
                    }
                }
                
                for ($i =0;$i<count($closingDays);$i++){
                    if ($closingDays[$i]['closing_day']=='SUN'){   
                        echo "<tr>";
                            echo "<td><b>Sundays : </b></td>";
                            echo "<td>".$closingDays[$i]['hour']."</td>";
                        echo "</tr>";               
                    }
                }
                
                echo "</div>";
                echo "</table>";
            }
        }
        
        public static function displayComments($id){

            $comments = Db::getInstance()->getCommentsOnEstablishment($id);
            echo "<h2>Comments</h2>";
            if (empty($comments)){
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