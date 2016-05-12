<?php
    class ProfilePictureController {
        
        public function __construct() {}
        
        public function run() {
            require_once('Controllers/CookieController.php');
            $controller = new CookieController();
            
            if (!$controller->checkCookies()) {
                header("Location:?action=login");
                die();
                
            }else{
                if(isset($_FILES['image'])){
                    $uid = (int)$_POST["uid"];
                    $error = "";
                    
                    $file_name = $_FILES['image']['name'];
                    $file_size = $_FILES['image']['size'];
                    $file_tmp = $_FILES['image']['tmp_name'];
                    $file_type = $_FILES['image']['type'];
                    
                    $name_pieces = explode('.', $file_name);
                    $file_extension = strtolower(end($name_pieces));
                    
                    if( ! in_array($file_extension, array("jpeg","jpg","png", "gif")) ){
                        $error = "Extension not allowed, please choose a JPEG, PNG or GIF file.";
                    }
                    
                    if($file_size > 2097152){
                        $error = 'Image size must be less than 2 MB';
                    }
                    
                    if($error == ""){
                        
                        $target_path = "UserImages/" . $_FILES['image']['name'];
                        $saved = move_uploaded_file($_FILES['image']['tmp_name'], $target_path);
                        if($saved)
                            Db::getInstance()->setProfilePicture($uid, $file_name);
                        else
                            $error = "Image to large";
                    }
                    
                    header('Location: ?action=userProfile&user='.$_COOKIE['username']."&error=".$error );
                    die();
                    
                    
                }
            }
        }
    }
?>