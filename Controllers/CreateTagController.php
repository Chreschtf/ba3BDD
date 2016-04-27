<?php
    class CreateTagController {
        
    private $_uid ;
    private $_eid ;
    
        public function __construct($uid, $eid) {
            $this->_uid = $uid;
            $this->_eid = $eid;
        }
    
        public function run() {
            require_once('Controllers/CookieController.php');
            $controller = new CookieController();
            if (!$controller->checkCookies()) {
                
                header("Location:?action=login");
                die();
                
            }else{
                $notification = "";
                
                if ( ! empty ( $_POST )) {
                    if ( isset($_POST['createTag']) ) { // create new tag
                        if( strlen($_POST['tag_name']) >= 3 && ! Db::getInstance()->checkIftagExists($_POST['tag_name']) ){
                            $tid = Db::getInstance()->insertTag( array($_POST['tag_name']) );
                            Db::getInstance()->insertEstablishmentTag( array( $tid,  (int)$_POST['eid'], (int)$_POST['uid'] ) );
                            
                            header('Location: ?action=userProfile&user='.$_COOKIE["username"]);
                            die();
                        } else {
                            if (Db::getInstance()->checkIftagExists($_POST['tag_name']))
                                $notification = "This tagname exists already";
                            else
                                $notification = "The tagname was not long enough";
                            $this->_uid = (int)$_POST['uid'];
                            $this->_eid = (int)$_POST['eid'];
                        }
                        
                    } elseif (  isset($_POST['useTag']) ) { // use existing tag
                        if( Db::getInstance()->checkIftagExistsTID( (int)$_POST['tag'] ) ){
                            Db::getInstance()->insertEstablishmentTag( array( (int)$_POST['tag'], (int)$_POST['eid'], (int)$_POST['uid'] ) );

                            header('Location: ?action=userProfile&user='.$_COOKIE["username"]);
                            die();
                        } else {
                            $this->_uid = (int)$_POST['uid'];
                            $this->_eid = (int)$_POST['eid'];
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
                foreach (Db::getinstance()->getAllTagnames() as $tag) {
                       echo "<option value=" . $tag['tid'] . ">" . $tag['tname'] . "</option>";
                }
                echo "            </select>";
                
                $uid = $this->_uid;
                $eid = $this->_eid;
                require_once (VIEWSPATH . 'createTag.php');
                   
            }
        }
    }  
?>


                