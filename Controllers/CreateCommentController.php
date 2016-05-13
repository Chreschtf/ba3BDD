<?php
    class CreateCommentController {
        
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
                
                if ( ! empty ( $_POST ) && isset($_POST['comment_text']) ) {
                    $this->_uid = (int)$_POST['uid'];
                    $this->_eid = (int)$_POST['eid'];
                    if ( strlen($_POST['comment_text']) > 5 ){
                        Db::getInstance()->insertCommentNow( array( (int)$_POST['uid'], (int)$_POST['eid'], (int)$_POST['score'], $_POST['comment_text'] ) );
                        
                        $type =  $this->getEstabType( Db::getInstance()->getEstablishmentWihtEID($this->_eid) );
                        
                        header('Location: ?action=' . $type . '&eid=' . $this->_eid);
                        die();
                    } else {
                        $notification = "Your comment was too short !";
                        
                    }

                } elseif ($this->_uid == '' || $this->_eid == ''){
                    header('Location: ?action=userProfile&user='.$_COOKIE["username"]);
                    die();
                }
                        
            }
            $uid = $this->_uid;
            $eid = $this->_eid;
            require_once (VIEWSPATH . 'createComment.php');
                  
        }
    }  
?>