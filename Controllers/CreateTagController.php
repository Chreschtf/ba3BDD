<?php
    class CreateTagController {
        
    private $_uid ;
    private $_eid ;
    
        public function __construct($uid, $eid) {
            $this->_uid = $uid;
            $this->_eid = $eid;
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
    
        public function run() {
            require_once('Controllers/CookieController.php');
            $controller = new CookieController();
            if (!$controller->checkCookies()) {
                
                header("Location:?action=login");
                die();
                
            }else{
                $notification = "";
                $this->_uid = Db::getInstance()->getUIDof($_COOKIE["username"]);
                echo $this->_uid;
                if ( ! empty ( $_POST )) {
                    $this->_eid = (int)$_POST['eid'];
                    if ( isset($_POST['createTag']) ) { // create new tag
                        if( strlen($_POST['tag_name']) >= 3 && ! Db::getInstance()->checkIftagExists($_POST['tag_name']) ){
                            $tid = Db::getInstance()->insertTag( array($_POST['tag_name']) );
                            Db::getInstance()->insertEstablishmentTag( array( $tid,  (int)$_POST['eid'], (int)$_POST['uid'] ) );
                            
                            $type =  $this->getEstabType( Db::getInstance()->getEstablishment($this->_eid) );
                        
                            header('Location: ?action=' . $type . '&eid=' . $this->_eid);
                            die();
                        } else {
                            if (Db::getInstance()->checkIftagExists($_POST['tag_name']))
                                $notification = "This tagname exists already";
                            else
                                $notification = "The tagname was not long enough";
                        }
                        
                    } elseif (  isset($_POST['useTag']) ) { // use existing tag
                        if( Db::getInstance()->checkIftagExistsTID( (int)$_POST['tag'] ) ){
                            Db::getInstance()->insertEstablishmentTag( array( (int)$_POST['tag'], (int)$_POST['eid'], (int)$_POST['uid'] ) );

                            $type =  $this->getEstabType( Db::getInstance()->getEstablishment($this->_eid) );
                        
                            header('Location: ?action=' . $type . '&eid=' . $this->_eid);
                            die();
                        } else {
                            $notification = "You didn't select a tag";
                        }
                    }
                    
                } elseif ($this->_uid == '' || $this->_eid == '') {
                    
                    header('Location: ?action=userProfile&user='.$_COOKIE["username"]);
                    die();
                    
                }
                
                echo "<div class='wrapper'>";
                echo "    <h2>Tag " . Db::getInstance()->getEstablishmentWihtEID($this->_eid) . "</h2>";
                //echo "    <div style='color:#FF0000'>" . $notification . "</div> ";

                if(isset($notification) && $notification != ""){
                    //echo "<p>" . $notification . "</p>";
                    echo "      <div class='alert alert-danger' role='alert'>";
                    echo            $notification;
                    echo "      </div> ";
                }
                
                echo "    <form action='?action=createTag' method='post' class='form-control'>";
                //echo "        <p> ";
                echo "            Choose from the existing tags : ";
                echo "            <select name='tag' >";
                echo "                <option value='' selected='selected'></option>";
                foreach (Db::getinstance()->getAllTagnames($this->_uid) as $tag) {
                       echo "<option value='" . $tag['tid'] . "'>" . $tag['tname'] . "</option>";
                }
                echo "            </select>";
                
                $uid = $this->_uid;
                $eid = $this->_eid;
                require_once (VIEWSPATH . 'createTag.php');
                   
            }
        }
    }  
?>


                