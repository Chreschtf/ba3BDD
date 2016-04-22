<?php
class Db
{
    private static $instance = null;
    private $_db;

    private function __construct(){
        
        $username = "root";
        $password = "123soleil";

        try {
            $this->_db = new PDO('mysql:host=localhost;dbname=annuaire_horeca;charset=UTF8', $username, $password);
            $this->_db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $this->_db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
        }
        catch (PDOException $e) {
            die('Could not connet to database: '.$e->getMessage());
        }

    }

    public static function getInstance(){ # Pattern Singleton

        if (is_null(self::$instance)) {
            self::$instance = new Db();
        }
        return self::$instance;
    }
    
    /*
            INSERTS
            -------
    */
    
    public function insertUserComplete($array) {
        $query="INSERT INTO users 
                (nickname, email, password, admin) 
                VALUES 
                (:nickname, :email, :password, :admin)";
        $statement = $this->_db->prepare($query);

        $statement->bindParam(':nickname', $array[0]);
        $statement->bindParam(':email', $array[1]);
        //$pwd = hash("md5",$array[2]);
        $statement->bindParam(':password', hash("md5",$array[2]));
        $statement->bindParam(':admin', $array[3]);
        
        $statement->execute();
        
        return $this->_db->lastInsertId();

    
    public function insertUserNotComplete($array) {
        $query="INSERT INTO users 
                (nickname, password,admin) 
                VALUES 
                (:nickname,:password ,:admin)";
        $statement = $this->_db->prepare($query);

        $statement->bindParam(':nickname', $array[0]);
        $statement->bindParam(':admin', $array[1]);
        $statement->bindParam(':password', hash("md5",$array[1])); #xml admin password  = admin username
        
        $statement->execute();
        return $this->_db->lastInsertId();
    }

    public function insertEstablishment($array) {
        $query="INSERT INTO establishments 
                (ename, street, house_num, zip, city, longitude, latitude, tel, site, uid, entry_date) 
                VALUES 
                (:ename, :street, :house_num, :zip, :city, :longitude, :latitude, :tel, :site, :uid, :entry_date)";
        $statement = $this->_db->prepare($query);

        $statement->bindParam(':ename', $array[0]);
        $statement->bindParam(':street', $array[1]);
        $statement->bindParam(':house_num', $array[2]);
        $statement->bindParam(':zip', $array[3]);
        $statement->bindParam(':city', $array[4]);
        $statement->bindParam(':longitude', $array[5]);
        $statement->bindParam(':latitude', $array[6]);
        $statement->bindParam(':tel', $array[7]);
        $statement->bindParam(':site', $array[8]);
        $statement->bindParam(':uid', $array[9]);
        $statement->bindParam(':entry_date', $array[10]);
        $statement->execute();
        return $this->_db->lastInsertId();
    }

    public function insertRestaurant($array){
        $query="INSERT INTO restaurants 
                (eid, price_range, banquet_capacity, takeaway, delivery) 
                VALUES 
                (:eid, :price_range, :banquet_capacity, :takeaway, :delivery)";
        $statement= $this->_db->prepare($query);

        $statement->bindParam(':eid',  $array[0]);
        $statement->bindParam(':price_range',  $array[1]);
        $statement->bindParam(':banquet_capacity',  $array[2]);
        $statement->bindParam(':takeaway',  $array[3]);
        $statement->bindParam(':delivery',  $array[4]);

        $statement->execute();
    }

    public function insertRestaurantClosingDays($array){
        $query="INSERT INTO restaurant_closing_days 
                (eid, closing_day, hour) 
                VALUES 
                (:eid, :closing_day, :hour)";
        $statement= $this->_db->prepare($query);

        $statement->bindParam(':eid',  $array[0]);
        $statement->bindParam(':closing_day',  $array[1]);
        $statement->bindParam(':hour',  $array[2]);

        $statement->execute();
    }

    public function insertBar($array){
        $query="INSERT INTO bars 
                (eid, smoking, snack) 
                VALUES 
                (:eid, :smoking, :snack)";
        $statement= $this->_db->prepare($query);

        $statement->bindParam(':eid',  $array[0]);
        $statement->bindParam(':smoking',  $array[1]);
        $statement->bindParam(':snack',  $array[2]);

        $statement->execute();
    }

    public function insertHotel($array){
        $query="INSERT INTO hotels 
                (eid, stars, rooms, standart_price) 
                VALUES 
                (:eid, :stars, :rooms, :standart_price)";
        $statement= $this->_db->prepare($query);

        $statement->bindParam(':eid',  $array[0]);
        $statement->bindParam(':stars',  $array[1]);
        $statement->bindParam(':rooms',  $array[2]);
        $statement->bindParam(':standart_price',  $array[3]);

        $statement->execute();
    }

    public function insertComment($array){
        $query="INSERT INTO comments 
                (uid, eid, entry_date, score, text) 
                VALUES 
                (:uid, :eid, :entry_date, :score, :text)";
        $statement= $this->_db->prepare($query);

        $statement->bindParam(':uid',  $array[0]);
        $statement->bindParam(':eid',  $array[1]);
        $statement->bindParam(':entry_date',  $array[2]);
        $statement->bindParam(':score',  $array[3]);
        $statement->bindParam(':text',  $array[4]);
        
        $statement->execute();
    }

    public function insertTag($array){
        $query="INSERT INTO tags 
                (tname) 
                VALUES 
                (:tname)";
                
        $statement= $this->_db->prepare($query);
        $statement->bindParam(':tname',  $array[0]);
        $statement->execute();
        
        return $this->_db->lastInsertId();
    }

    public function insertEstablishmentTag($array){
        $query="INSERT INTO establishment_tags 
                (tid, eid, uid) 
                VALUES 
                (:tid, :eid, :uid)";
        $statement= $this->_db->prepare($query);

        $statement->bindParam(':tid',  $array[0]);
        $statement->bindParam(':eid',  $array[1]);
        $statement->bindParam(':uid',  $array[2]);

        $statement->execute();
    }

    /*
            EXISTS
            ------
    */
    
<<<<<<< HEAD
    public function checkIfUserExists($name){
        $query = "SELECT nickname 
                  FROM users
                  WHERE nickname='$name'";
        $result = $this->_db->query($query);
        return ($result->rowCount() >= 1);
    }
    

    public function nicknameExists($nickname){
        $query = "SELECT * FROM users WHERE users.nickname = ".$this->_db->quote($nickname);
        $result =$this->_db->query($query);

        return $result->rowcount()!=0;
    }
    
    public function emailAlreadyInUse($email){
        $query = "SELECT * FROM users WHERE users.email = ".$this->_db->quote($email);
        $result =$this->_db->query($query);
        
        return $result->rowcount()!=0; 
    }
   
    public function checkIfBarExists($eid){
        $query = "SELECT eid
                  FROM bars
                  WHERE bars.eid = '$eid'";
        $result = $this->_db->query($query);
        return ($result->rowCount() >= 1);
    }
    
    public function checkIfRestaurantExists($eid){
        $query = "SELECT eid
                  FROM restaurants
                  WHERE eid = '$eid'";
        $result = $this->_db->query($query);
        return ($result->rowCount() >= 1);
    }
    
    public function checkIfHotelExists($eid){
        $query = "SELECT eid
                  FROM hotels
                  WHERE hotel.eid = '$eid'";
        $result = $this->_db->query($query);
        return ($result->rowCount() >= 1);
    }
    
    
    public function checkIftagExists($name){
        $query = "SELECT *
                  FROM tags
                  WHERE tags.tname = '$name'";
        $result = $this->_db->query($query);
        return ($result->rowCount() >= 1);

    
    public function checkIfEstablishmenttagExists($tid, $eid, $uid){
        
    }
    
    public function getTagWithName($name){
        $query = "SELECT tags.tid
                  FROM tags
                  WHERE tags.tname = '$name'";
                        
        $stmt = $this->_db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['tid'];
    }   
    
        
    public function checkIfEstabTagExists($tid, $eid, $uid){
        $query = "SELECT *
                  FROM establishment_tags
                  WHERE establishment_tags.eid = '$eid' AND 
                        establishment_tags.uid = '$uid' AND 
                        establishment_tags.tid = '$tid'";
                        
        $result = $this->_db->query($query);
        return ($result->rowCount() >= 1);
    }
    
    
    /*
            SELECTS
            -------
    */
    
    public function getEstablishmentWithName($name){
        $query = 'SELECT *
                  FROM establishments
                  WHERE ename='.$name;

    }
    
    public function getUIDof($nickname){
        $query = "SELECT *
                  FROM users
                  WHERE nickname ='$nickname'";
        $stmt = $this->_db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['uid'];
        
    }
    
    public function getHorecaWithEID($table, $eid){
        $query = 'SELECT *
                  FROM'.$table.
                 'WHERE eid='.$eid;
        $result = $this->_db->query($query);

    }
    
    /*
            UPDATES / DELETES
            -----------------
    */
    
    public function deleteEstablishmentWithEID($eid){
        $query = 'DELETE 
                  FROM establishments 
                  WHERE eid='.$eid;
                 
        $this->_db->prepare($query)->execute();
    }
    
    public function modifyEstablishmentAttributes($changeAttributNames, $changeAttributValues, $searchAttributNames, $searchAttributValues){
        $query = 'UPDATE establishments 
                  SET '.
                 'WHERE ';
        
    }
    
    public function isAdmin($uid){
        $query = "SELECT *
                  FROM users
                  WHERE uid = '$uid'";
                  
        $stmt = $this->_db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($result['admin'] == 1);
    }
    
    public function setAdmin($uid, $admin){
        $query = "UPDATE users
                  SET admin = '$admin'
                  WHERE uid = '$uid'";
                  
        $this->_db->prepare($query)->execute();
    }
    
    
    
    public function validLogin($nickname,$password){
        $query = 'SELECT * from users WHERE nickname='.$this->_db->quote($matricule).' AND password='.$this->_db->quote(hash("md5",$password));
        $result = $this->_db->query($query);

        return $result->rowcount()==1;
    }
    
    
    
    /*
            SPECIFIC QUERIES
            ----------------
    */
    
    public function R1(){
        // • Tous les utilisateurs qui apprécient au moins 3 établissements que l’utilisateur "Brenda" apprécie.

        $query = 'SELECT *
                  FROM users
                  WHERE ';
                  
    }
    
    public function R2(){
        // • Tous les établissements qu’apprécie au moins un utilisateur qui apprécie tous les établissements que "Brenda" apprécie.
        
        $query = 'SELECT 
                  FROM establishments
                  WHERE ';
                  
    }
    
    public function R3(){
        // • R3 : Tous les établissements pour lesquels il y a au plus un commentaire.
        
        $query = 'SELECT *
                  FROM establishments
                  WHERE ';
                  
    }
    
    public function R4(){
        // • R4 : La liste des administrateurs n’ayant pas commenté tous les établissements qu’ils ont crées.
        
        $query = 'SELECT *
                  FROM users
                  WHERE ';
                  
    }
    
    public function R5(){
        // • R5 : La liste des établissements ayant au minimum trois commentaires, classée selon la moyenne des scores attribués.
        
        $query = 'SELECT *
                  FROM establishments
                  WHERE ';
                  
    }
    
    public function R6(){
        // • R6 : La liste des labels étant appliqués à au moins 5 établissements, classée selon la moyenne des scores des établissements ayant ce label.
        
        $query = 'SELECT *
                  FROM tags
                  WHERE ';
    }   
    


}