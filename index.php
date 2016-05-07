<?php
    session_start();
    define ('VIEWSPATH', 'Views/' );

    /*                
            $bddFile = fopen("Bdd/Create_Annuaire.sql", "r") or die("Unable to open file!");
            $sql= fread($bddFile,filesize("Bdd/Create_Annuaire.sql"));
            fclose($bddFile);
            
            // use exec() because no results are returned
            $this->_db->exec($sql);*/  
    require 'Models/Db.class.php';
    #require 'Models/XMLfile_parser.php';
    #XMLParser::parseFiles();
    $action = (isset($_GET['action'])) ? htmlentities($_GET['action']) : 'default';
    
    $commentController = NULL;
    
    require_once (VIEWSPATH . 'header.php');
    
    # process what action ?
    switch($action) {
        case 'login':
            require_once('Controllers/LoginController.php');
            $controller = new LoginController();
            break;
        case 'signUp':
            require_once('Controllers/SignUpController.php');
            $controller = new SignUpController();
            break; #/
        case 'userProfile':
            $user = (isset($_GET['user'])) ? htmlentities($_GET['user']) : '';
            require_once('Controllers/UserProfileController.php');
            $controller = new UserProfileController($user);
            break;
        case 'search':
            require_once('Controllers/SearchController.php');
            $controller = new SearchController();
            break;
        case 'logout':
            require_once('Controllers/LogoutController.php');
            $controller = new LogoutController();
            break;
        case 'barProfile':
            $barId = (isset($_GET['eid'])) ? htmlentities($_GET['eid']) : '';
            require_once("Controllers/BarProfileController.php");
            $controller = new BarProfileController();
            $controller->setId($barId);
            break;
        case 'hotelProfile':
            $hotelId = (isset($_GET['eid'])) ? htmlentities($_GET['eid']) : '';
            require_once("Controllers/HotelProfileController.php");
            $controller = new HotelProfileController();
            $controller->setId($hotelId);
            break;
        case 'restaurantProfile':
            $restaurantId = (isset($_GET['eid'])) ? htmlentities($_GET['eid']) : '';
            require_once("Controllers/RestaurantProfileController.php");
            $controller = new RestaurantProfileController();
            $controller->setId($restaurantId);
            break;
        case 'createComment':
            $uid = (isset($_POST['uid'])) ? htmlentities($_POST['uid']) : '';
            $eid = (isset($_POST['eid'])) ? htmlentities($_POST['eid']) : '';
            require_once('Controllers/CreateCommentController.php');
            $controller = new CreateCommentController($uid,$eid);
            break;
        case 'createTag':
            $uid = (isset($_GET['uid'])) ? htmlentities($_GET['uid']) : '';
            $eid = (isset($_GET['eid'])) ? htmlentities($_GET['eid']) : '';
            require_once('Controllers/CreateTagController.php');
            $controller = new CreateTagController($uid,$eid);
            break;
        case 'queryScreen':
            require_once('Controllers/QueryController.php');
            $controller = new QueryController();
            break;
        case 'deleteEstablishment':
            require_once('Controllers/DeleteEstabController.php');
            $controller = new DeleteEstabController();
            break;
        case 'modifyEstablishment':
            require_once('Controllers/DeleteEstabController.php');
            $controller = new DeleteEstabController();
            break;
        case 'createEstablishment':
            $horeca_type = (isset($_GET['horeca_type'])) ? htmlentities($_GET['horeca_type']) : '';
            require_once('Controllers/CreateEstablishmentController.php');
            $controller = new CreateEstablishmentController();
            $controller->setType($horeca_type);
            break;
        default: # 
            require_once('Controllers/LoginController.php');
            $controller = new LoginController();
            break;
      
    }
    
    $controller->run(); 
    
    require_once (VIEWSPATH . 'footer.php');
?>