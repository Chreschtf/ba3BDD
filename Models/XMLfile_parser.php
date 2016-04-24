<?php

    #session_start();
    require '../Models/Db.class.php';
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
    
    //mysql_select_db("annuaire_horeca");
    
    $Cafes = new SimpleXMLElement("../data/Cafes.xml", 0, true) 
                            OR die('Could not open xml file');
    $Restaurants = new SimpleXMLElement("../data/Restaurants.xml", 0, true) 
                            OR die('Could not open xml file');
    
    // Cafes
    foreach ($Cafes->Cafe as $Cafe) {
        
        // user (the admin who created the establishment)
        $uid = createUser($Cafe);
        
        // establishment
        $eid = createEstablishment($Cafe, $uid, "B");
        // bar
        createBar($Cafe, $eid);
        
        // comments
        foreach($Cafe->Comments->Comment as $Comment) {
            createComment($Comment, $eid);
        }
        
        // tags
        if (is_array($Cafe->Tags->Tag) || is_object($Cafe->Tags->Tag)) {
            foreach ($Cafe->Tags->Tag as $Tag) {
                createTag($Tag, $eid);
            }
        }
    }
    
    // Restaurants
    foreach ($Restaurants->Restaurant as $Restaurant) {
        
        // user (the admin who created the establishment)
        $uid = createUser($Restaurant);
        
        // establishment
        $eid = createEstablishment($Restaurant, $uid, "R");
        // restaurant
        createRestaurant($Restaurant, $eid);
        
        // closing days
        createClosingDays($Restaurant, $eid);
        
        // comments
        if (is_array($Restaurant->Comments->Comment) || is_object($Restaurant->Comments->Comment)) {
            foreach($Restaurant->Comments->Comment as $Comment) {
                createComment($Comment, $eid);
            }
        }
        
        // tags
        if (is_array($Restaurant->Tags->Tag) || is_object($Restaurant->Tags->Tag)) {
            foreach ($Restaurant->Tags->Tag as $Tag) {
                createTag($Tag, $eid);
            }
        }
    }
    
    function createUser($estab){
        $nickname = $estab['nickname'];
        $admin = true;
        $data = array($nickname, $admin, $nickname);
        if( ! Db::getInstance()->nicknameExists($nickname))
            return Db::getInstance()->insertUserNotComplete($data);
        else{
            $uid = Db::getInstance()->getUIDof($nickname);
            if( ! Db::getInstance()->isAdmin($uid) )
                Db::getInstance()->setAdmin($uid, 1);
            return $uid;
        }
    }
    
    function createEstablishment($estab, $uid, $horeca_type){
        $ename = $estab->Informations->Name;
        $street = $estab->Informations->Address->Street;
        $house_num = $estab->Informations->Address->Num;
        $zip = $estab->Informations->Address->Zip;
        $city = $estab->Informations->Address->City;
        $longitude = floatval($estab->Informations->Address->Longitude);
        $latitude = floatval($estab->Informations->Address->Latitude);
        $tel = $estab->Informations->Tel;
        $site = NULL;
        if(isset($estab->Informations->Site)){
            $site = $estab->Informations->Site['link'];
        }
        $entry_date = convertDate($estab['creationDate']);
        $data = array($ename, $street, $house_num, $zip, $city, 
                      $longitude, $latitude, $tel, $site,  (int)$uid, $entry_date, $horeca_type);
        return Db::getInstance()->insertEstablishment($data);
    }
    
    function createBar($estab, $eid){
        $smoking = (int)isset($estab->Informations->Smoking);
        $snack =  (int)isset($estab->Informations->Snack);
        $data = array((int)$eid, $smoking, $snack);
        if( ! Db::getInstance()->checkIfBarExists($eid))
            Db::getInstance()->insertBar($data);
    }
    
    function createRestaurant($Restaurant, $eid) {
        $price_range = $Restaurant->Informations->Banquet['capacity'];
        $banquet_capacity = $Restaurant->Informations->PriceRange;
        $takeaway = (int)isset($Restaurant->Informations->TakeAway);
        $delivery = (int)isset($Restaurant->Informations->Delivery);
        $data = array($eid, $price_range, $banquet_capacity, $takeaway, $delivery);
        if( ! Db::getInstance()->checkIfRestaurantExists($eid))
            Db::getInstance()->insertRestaurant($data);
    }
    
    function createClosingDays($Restaurant, $eid) {
        if (is_array($Restaurant->Informations->Closed->On) || is_object($Restaurant->Informations->Closed->Ons)) {
            foreach ($Restaurant->Informations->Closed->On as $On) {
                switch ( (int)$On['day'] ) {
                    case 0: $closing_day = 'MON'; break;
                    case 1: $closing_day = 'TUE'; break;
                    case 2: $closing_day = 'WED'; break;
                    case 3: $closing_day = 'THU'; break;
                    case 4: $closing_day = 'FRI'; break;
                    case 5: $closing_day = 'SAT'; break;
                    case 6: $closing_day = 'SUN'; break;
                }
                $hour = 'COMPLETE';
                if(isset($On['hour']))
                    $hour = strtoupper ($On['hour']);
                $data = array($eid, $closing_day, $hour);
                Db::getInstance()->insertRestaurantClosingDays($data);
            }
        }
    }
    
    function createComment($comment, $eid){
        $uid = createUserIfnotExists($comment['nickname'], 0);
        $entry_date = convertDate($comment['date']);
        $score =  (int)$comment['score'];
        $text_ = $comment;
        $data = array($uid, $eid, $entry_date, $score, $text_);
        Db::getInstance()->insertComment($data);
    }
    
    function createTag($tag, $eid){
        $name = $tag['name'];
        $data = array($name);
        $tid = Db::getInstance()->getTagWithName($name);
        if( $tid == NULL )
            $tid = Db::getInstance()->insertTag($data);
            
        foreach ($tag as $user) {
            $nickname = $user['nickname'];
            $uid = createUserIfnotExists($nickname, 0);
            if( ! Db::getInstance()->checkIfEstabTagExists($tid, $eid, $uid)){
                $data = array($tid, $eid, $uid);
                Db::getInstance()->insertEstablishmentTag($data);
            }
        }
    }
    
    function createUserIfnotExists($nickname, $admin){
        if(Db::getInstance()->nicknameExists($nickname)){
            $uid = Db::getInstance()->getUIDof($nickname);
        } else{
            $data = array($nickname, $admin, $nickname);
            $uid = Db::getInstance()->insertUserNotComplete($data);
        }
        return $uid;
    }
    
    function convertDate($dateString){
        $dateParts = explode("/", $dateString);
        $date_ = date($dateParts[2].'-'.$dateParts[1].'-'.$dateParts[0].' 00:00:00');
        return $date_;
    }
?>