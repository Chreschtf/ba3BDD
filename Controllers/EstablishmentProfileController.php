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
        
        public static function displayComments($eid, $uid){

            $comments = Db::getInstance()->getCommentsOnEstablishment($eid);
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
                    echo '"'.$comments[$i]['text'].'"';
                    
                    $hasLiked = Db::getInstance()->hasLiked($uid, $comments[$i]['cid']);
                    $downColor = "danger"; $upColor = "success"; $downDisabled = ""; $upDisabled = "";
                    
                    if($uid == $comments[$i]["uid"]){ // writer of the comment can't up/down vote it !!
                        $downColor = $upColor = "default";
                        $downDisabled = "disabled"; $upDisabled = "disabled";
                        
                    } elseif ( $hasLiked["likes"] != NULL ) {
                        if ($hasLiked["likes"]){ // liked the comment
                            $downDisabled = "disabled";
                        } else {// disliked the comment
                            $upDisabled = "disabled";
                        }
                    }
                    
                    echo "<div class = 'row'>";
                    
                    echo "<b>Likes : ". $comments[$i]["likes"] ."</b>";
                    
                    echo "      <div class='col-xs-8 col-sm-2'>";
                    echo "<form action='?action=likeComment' method='post' >";
                    echo "    <input type='hidden' name='cid' value='". $comments[$i]['cid'] ."'>";
                    echo "    <input type='hidden' name='uid' value='". $uid ."'>";
                    echo "    <input type='hidden' name='eid' value='". $eid ."'>";
                    echo "    <input type='hidden' name='likes' value='up'>";
                    echo "    <input type='hidden' name='page' value='". EstablishmentProfileController::getEstabType($comments[$i]['horeca_type']) ."'>";
                    echo "      <button type='submit' class='btn btn-xs btn-". $upColor ."' ". $upDisabled .">Up</button>";
                    echo "</form>\n";
                    echo "      </div>";
                                
                    echo "      <div class='col-xs-8 col-sm-2'>";
                    echo "<form action='?action=likeComment' method='post' >";
                    echo "    <input type='hidden' name='cid' value='". $comments[$i]['cid'] ."'>";
                    echo "    <input type='hidden' name='uid' value='". $uid ."'>";
                    echo "    <input type='hidden' name='eid' value='". $eid ."'>";
                    echo "    <input type='hidden' name='likes' value='down'>";
                    echo "    <input type='hidden' name='page' value='". EstablishmentProfileController::getEstabType($comments[$i]['horeca_type']) ."'>";
                    echo "      <button type='submit' class='btn btn-xs btn-". $downColor ."' ". $downDisabled .">Down</button>";
                    echo "</form>\n";
                    echo "      </div>";
                    
                    echo "</div> <br><br>";
                }
            }
        }
        
        public static function getEstabType($horeca_type){
            if ( $horeca_type == 'Bar' ) {
                 return "barProfile";
            } else if ( $horeca_type == 'Restaurant' ) {
                 return "restaurantProfile";
            } else { // Hotel
                 return "hotelProfile";
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