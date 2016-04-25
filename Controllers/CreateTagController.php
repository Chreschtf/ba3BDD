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
                
                if ($this->_uid == '' || $this->_eid == ''){
                    
                    header('Location: ?action=userProfile&user='.$_POST[$_COOKIE["username"]]);
                    die();
                    
                } elseif ( isset($_POST['createTag']) ) { // create new tag
                    if( strlen($_POST['tag_name']) >= 3 ){
                        $tid = Db::getInstance()->insertTag( array($_POST['tag_name']) ):
                        Db::getInstance()->insertEstablishmentTag( array( $tid, $this->_eid, $this->_uid ) );
                        
                        header('Location: ?action=estabProfile&estab='. $this->_eid);
                        die();
                    } else {
                        $notification = "You didn't select a tag";
                    }
                    
                } elseif (  isset($_POST['useTag']) ) { // use existing tag
                    if( Db::getInstance()->isValidTID( (int)$_POST['tag'] ) ){
                        Db::getInstance()->insertEstablishmentTag( array( (int)$_POST['tag'], $this->_eid, $this->_uid ) );
                        
                        header('Location: ?action=estabProfile&estab='. $this->_eid);
                        die();
                    } else {
                        $notification = "The tagname was not long enough";
                    }
                }
                
                echo "<div class='wrapper'>";
                echo "    <h2>Tag " . $estab_name . "</h2>";
                echo "    <div>" . $notification . "</div> "
                echo "    <form action='?action=createTag' method='post' class='form-control'>";
                echo "        <p> ";
                echo "            Choose from the existing tags : ";
                echo "            <select name='tag' >";
                echo "                <option value='' selected='selected'></option>";
                foreach (Db::getinstance()->getAllTagnames() as $tag) {
                       echo "<option value=" . $tag['tid'] . ">" . $tag['tid'] . "</option>";
                }
                echo "            </select>";
                
                require_once (VIEWSPATH . 'createTag.php');
                   
            }
        }
    }  
?>


                