<?php
    class LikeCommentController {
        
        public function __construct() {}
        
        public function run() {
            require_once('Controllers/CookieController.php');
            $controller = new CookieController();
            
            if (!$controller->checkCookies()) {
                header("Location:?action=login");
                die();
                
            }else{
                $cid = (int)$_POST["cid"];
                $uid = (int)$_POST["uid"];
                $eid = (int)$_POST["eid"];
                $page = $_POST["page"];
                $likes = $_POST["likes"];
                
                $hasLiked = Db::getInstance()->hasLiked($uid, $cid);
                
                if($hasLiked != NULL){ // liked/disliked the comment -> undo the like/dislike
                    
                    Db::getInstance()->deleteLike($uid, $cid);
                    if($likes == "up"){ // undo like
                        Db::getInstance()->updateLikes($cid, (-1));
                    } else {            // undo dislike
                        Db::getInstance()->updateLikes($cid, (+1));
                    }
                    
                } else { // want's to like/dislike
                    
                    Db::getInstance()->deleteLike($uid, $cid); // just to be sure (!)
                    
                    if($likes == "up"){ // -> likes
                        Db::getInstance()->insertCommentLike($uid, $cid, (1));
                        Db::getInstance()->updateLikes($cid, (+1));
                    } else { // $likes == "down"  -> dislike
                        Db::getInstance()->insertCommentLike($uid, $cid, (0));
                        Db::getInstance()->updateLikes($cid, (-1));
                    }
                    
                }
                
                // return to previous page :
                if($page != "userProfile"){ // establishment page
                
                    header('Location: ?action=' . $page . '&eid=' . $eid);
                    die();
                } else {                    // user page
                
                    header('Location: ?action=userProfile&user=' . $_POST["pageUser"]);
                    die();
                }
                    
                
            }
        }
    }
?>