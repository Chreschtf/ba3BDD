<?php
    session_start();
    require '../Models/Db.class.php';
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
    
    //mysql_select_db("annuaire_horeca");
    
    $Cafes = new SimpleXMLElement("../data/Cafes.xml", 0, true) 
                            OR die('Could not open xml file');
    
    //var_dump($Cafes);
    foreach ($Cafes->Cafe as $Cafe) {
        
        // user (the admin who created the establishment)
        $uid = createUser($Cafe);
        
        // establishment
        $eid = createEstablishment($Cafe, $uid);

        // bar
        createBar($Cafe, $eid);
    }
    
    function createUser($estab){
        $nickname = $estab['nickname'];
        $admin = true;
        $data = array($nickname, $admin);
        if( ! Db::getInstance()->nicknameExists($nickname))
            return Db::getInstance()->insertUserNotComplete($data);
        else
            return Db::getInstance()->getUIDof($nickname);
    }
    
    function createEstablishment($estab, $uid){
        $ename = $estab->Informations->Name;
        $street = $estab->Informations->Address->Street;
        $house_num = $estab->Informations->Address->Num;
        $zip = $estab->Informations->Address->Zip;
        $city = $estab->Informations->Address->City;
        $longitude = (int)$estab->Informations->Address->longitude;
        $latitude = (int)$estab->Informations->Address->latitude;
        $tel = $estab->Informations->Tel;
        $site = NULL;
        if(isset($estab->Informations->Site)){
            $site = $estab->Informations->Site;
        }
        $entry_date = $estab['creationDate'];
        $data = array($ename, $street, $house_num, $zip, $city, 
                      $longitude, $latitude, $tel, $site,  (int)$uid, $entry_date);
        return Db::getInstance()->insertEstablishment($data);
    }
    
    function createBar($estab, $eid){
        $smoking = (int)isset($Cafe->Informations->Smoking);
        $snack =  (int)isset($Cafe->Informations->Snack);
        $data = array((int)$eid, $smoking, $snack);
        if( ! Db::getInstance()->checkIfBarExists($eid, 'b'))
            Db::getInstance()->insertBar($data);
    }

?>