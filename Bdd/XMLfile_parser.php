<?php
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
    
    mysql_select_db("annuaire_horeca");
    
    $Cafes = new SimpleXMLElement("../data/Cafes.xml", 0, true) 
                            OR die('Could not open xml file');
    
    //var_dump($Cafes);
    foreach ($Cafes->Cafe as $Cafe) {
        echo $Cafe->Informations->Name, "\n";
        $insert_query = "INSERT INTO Bars ".
                            "(smoking, snack)".
                            "VALUES ".
                            "('$Cafe->)"
    }

?>