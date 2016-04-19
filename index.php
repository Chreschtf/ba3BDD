<?php

    define ('VIEWSPATH', 'Views/' );

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ttt";


    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username,$password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    // sql to create table
        $bddFile = fopen("Bdd/Create_Annuaire.sql", "r") or die("Unable to open file!");
        $sql= fread($bddFile,filesize("Bdd/Create_Annuaire.sql"));
        fclose($bddFile);
            
        // use exec() because no results are returned
        $conn->exec($sql);
        echo "Database created successfully<br>";
    }
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }
        
    $conn = null;   
?>