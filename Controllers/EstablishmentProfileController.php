<?php
    class EstablishmentProfileController{
        private function __construct(){
        }
        
        public static function displayGenericInfo($data, $uid){
            
            EstablishmentProfileController::displayButtons($data, $uid);
            
            // show the establishment data
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
                    if (0 === strpos(trim($data['site']), 'http'))
                        echo "<td> <a href='".trim($data['site'])."'>".$data['site']."</a> </td>";
                    else 
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
            echo "</div>";
                       
        }
        
        public static function displayButtons($data, $uid){
            // show buttons : Tag and Comment :
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
            echo "    <button type='submit' class='btn btn-success'>Tag this establishment</button>\n";
            echo "</form>\n";
            echo "      </div>";
            
            if(Db::getInstance()->isAdmin($uid)){ // show admin buttons : Delete and Modify :
                echo "      <div class='col-xs-8 col-sm-4'>";
                echo "<form action='?action=modifyEstablishment' method='post' >\n";
                echo "    <input type='hidden' name='eid' value='".$data['eid']."'>\n";
                echo "    <input type='hidden' name='uid' value='".$uid."'>\n";
                echo "    <button type='submit' class='btn btn-warning'>Modify information</button>\n";
                echo "</form>\n";
                echo "      </div>";
                
                echo "      <div class='col-xs-8 col-sm-0'>";
                echo "<form action='?action=deleteEstablishment' method='post' >\n";
                echo "    <input type='hidden' name='eid' value='".$data['eid']."'>\n";
                echo "    <input type='hidden' name='uid' value='".$uid."'>\n";
                echo "    <button type='submit' class='btn btn-danger'>Delete</button>\n";
                echo "</form>\n";
                echo "      </div>";
            }
            
            echo "</div>";
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
                    //echo "<b>From :</b> ". Db::getInstance()->getUsersWithSimilarName($comments[$i]["nickname"]) ."<br>";
                    echo "<b>From :</b> <a href='?action=userProfile&user=" . $comments[$i]["nickname"] . "'>" . $comments[$i]["nickname"] . "</a> <br>";
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
                    echo "<a href='?action=tagProfile&tid=".$tags[$i]["tid"]."'>".$tags[$i]['tname']."</a> (". $tags[$i]['_nbrTagged'] .") ; ";
                }
            }
        } 
    }
?>