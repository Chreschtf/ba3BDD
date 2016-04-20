<?php
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
    
    //mysql_select_db("annuaire_horeca");
    
    $Cafes = new SimpleXMLElement("../data/Cafes.xml", 0, true) 
                            OR die('Could not open xml file');
    
    //var_dump($Cafes);
    foreach ($Cafes->Cafe as $Cafe) {
        echo $Cafe->Informations->Name, "\n";
        
        // user (the admin who created the establishment)
        $nickname = $Cafe['nickname'];
        $admin = true;
        $data = array($nickname, $admin);
        $uid = Db::getInstance()->insertUserNotComplete($data);
        
        // establishment
        $ename = $Cafe->Informations->Name;
        $street = $Cafe->Informations->Address->Street;
        $house_num = $Cafe->Informations->Address->Num;
        $zip = $Cafe->Informations->Address->Zip;
        $city = $Cafe->Informations->Address->City;
        $longitude = $Cafe->Informations->Address->longitude;
        $latitude = $Cafe->Informations->Address->latitude;
        $tel = $Cafe->Informations->Tel;
        $uid = mysql_insert_id();
        $site = NULL;
        if(isset($Cafe->Informations->Site)){
            $site = $Cafe->Informations->Site;
        }
        $data = array($ename, $street, $house_num, $zip, $city, 
                      $longitude, $latitude, $tel, $site, $uid);
        $eid = Db::getInstance()->insertEstablishment($data);

        // bar
        $smoking = isset($Cafe->Informations->Smoking);
        $snack =  isset($Cafe->Informations->Snack);
        $data = array($eid, $smoking, $snack);
        Db::getInstance()->insertBar($data);

    }
    

?>