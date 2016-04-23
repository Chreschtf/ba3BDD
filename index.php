<?php
    session_start();
    define ('VIEWSPATH', 'Views/' );

    /*$servername = "localhost";
    $username = "root";
    $password = "";
    #$dbname = "";
    /*
                
            $bddFile = fopen("Bdd/Create_Annuaire.sql", "r") or die("Unable to open file!");
            $sql= fread($bddFile,filesize("Bdd/Create_Annuaire.sql"));
            fclose($bddFile);
            
            // use exec() because no results are returned
            $this->_db->exec($sql);
    
    function chargerClasse($classe) {
        if(is_readable('Models/'.$classe.'.class.php'))require 'Models/' . $classe . '.class.php';
        else   var_dump($classe);
    }
    
    spl_autoload_register('chargerClasse');   */
    
    # Require des classes automatisé pour la partie modèle de l'architecture
    /*function chargerClasse($classe) {
        if(is_readable('Models/'.$classe.'.class.php'))require 'Models/' . $classe . '.class.php';
        else   var_dump($classe);
    }
    spl_autoload_register('chargerClasse');*/   
    
    require 'Models/Db.class.php';
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
        case 'account':
            require_once('Controllers/AccountController.php');
            $controller = new AccountController();
            break;
        default: # 
            require_once('Controllers/LoginController.php');
            $controller = new LoginController();
            break;
      
    }
    $controller->run(); 
    
?>