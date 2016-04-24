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
        default: # 
            require_once('Controllers/LoginController.php');
            $controller = new LoginController();
            break;
      
    }
    $controller->run(); 
    
?>