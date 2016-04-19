<?php
    session_start();
    define ('VIEWSPATH', 'Views/' );

    $servername = "localhost";
    $username = "root";
    $password = "";
    #$dbname = "";
    function chargerClasse($classe) {
    if(is_readable('Models/'.$classe.'.class.php'))require 'Models/' . $classe . '.class.php';
    else   var_dump($classe);
    }
    
    spl_autoload_register('chargerClasse');

    try {
        $conn = new PDO("mysql:host=$servername;", $username,$password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    // sql to create table
        $bddFile = fopen("Bdd/Create_Annuaire.sql", "r") or die("Unable to open file!");
        $sql= fread($bddFile,filesize("Bdd/Create_Annuaire.sql"));
        fclose($bddFile);
            
        // use exec() because no results are returned
        $conn->exec($sql);
        #echo "Database created successfully<br>";

    }
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }
        
    $conn = null;  
    
    
     $action = (isset($_GET['action'])) ? htmlentities($_GET['action']) : 'default';
    # process what action ?
    switch($action) {
        case 'signUp':
            require_once('Controllers/SignUpController.php');
            $controller = new SignUpController();
            break; #/
        
        
        default: # Par défaut, le contrôleur de l'accueil est sélectionné
            require_once('Controllers/LoginController.php');
            $controller = new LoginController();
            break;
      
    }
    # Exécution du contrôleur correspondant à l'action demandée
    $controller->run(); 
    
?>