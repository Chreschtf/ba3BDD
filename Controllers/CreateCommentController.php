<?php
    class CreateCommentController {
        
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
            
            if ($this->_uid == '' || $this->_eid == ''){
                header('Location: ?action=userProfile&user='.$_POST[$_COOKIE["username"]]);
                die();
            }
            
            require_once (VIEWSPATH . 'createComment.php');
            
                
            
        }
    }
    
    
    
    }  
?>