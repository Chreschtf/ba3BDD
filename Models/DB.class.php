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
                (nickname, email, password) 
                VALUES 
                (:nickname, :email, :password)";
        $statement = $this->_db->prepare($query);
        $statement->bindParam(':nickname', $array[0]);
        $statement->bindParam(':email', $array[1]);
        $statement->bindParam(':password', password_hash($array[2], PASSWORD_BCRYPT));
        $statement->execute();
        
        return $this->_db->lastInsertId();
    }
    
    public function insertUserNotComplete($array) {
        $query="INSERT INTO users 
                (nickname, admin, password) 
                VALUES 
                (:nickname, :admin, :password )";
        $statement = $this->_db->prepare($query);

        $statement->bindParam(':nickname', $array[0]);
        $statement->bindParam(':admin', $array[1]);
        $pwd = password_hash($array[2], PASSWORD_BCRYPT);
        $statement->bindParam(':password', $pwd); #xml admin password  = admin username
        
        $statement->execute();
        return $this->_db->lastInsertId();
    }

    public function insertEstablishment($array) {
        $query="INSERT INTO establishments 
                (ename, street, house_num, zip, city, longitude, latitude, tel, site, uid, entry_date, horeca_type) 
                VALUES 
                (:ename, :street, :house_num, :zip, :city, :longitude, :latitude, :tel, :site, :uid, :entry_date, :horeca_type)";
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
        $statement->bindParam(':horeca_type', $array[11]);
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

    public function checkIfUserExists($name){
        $query = "SELECT nickname 
                  FROM users
                  WHERE nickname= :name";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return count($result) >= 1;
    }

    public function nicknameExists($nickname){
        $query = "SELECT * 
                  FROM users 
                  WHERE users.nickname = :nickname";
                  
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':nickname', $nickname);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return count($result) >= 1;
    }
    
    public function emailAlreadyInUse($email){
        $query = "SELECT * 
                  FROM users 
                  WHERE users.email = :email";
                  
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return count($result) >= 1;
    }
   
    public function checkIfBarExists($eid){
        $query = "SELECT eid
                  FROM bars
                  WHERE bars.eid = :eid";
                  
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':eid', $eid);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return count($result) >= 1;
    }
    
    public function checkIfRestaurantExists($eid){
        $query = "SELECT eid
                  FROM restaurants
                  WHERE eid = :eid";
                  
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':eid', $eid);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return count($result) >= 1;
    }
    
    public function checkIfHotelExists($eid){
        $query = "SELECT eid
                  FROM hotels
                  WHERE hotel.eid = '$eid'";
                  
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':eid', $eid);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return count($result) >= 1;
    }
    
    
    public function checkIftagExists($name){
        $query = "SELECT *
                  FROM tags
                  WHERE tags.tname = :name";
                  
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return count($result) >= 1;
    }
    
    
    public function getTagWithName($tname){
        $query = "SELECT tags.tid
                  FROM tags
                  WHERE tags.tname = :tname";
                          
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':tname', $tname);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['tid'];
    }         
    
        
    public function checkIfEstabTagExists($tid, $eid, $uid){
        $query = "SELECT *
                  FROM establishment_tags
                  WHERE establishment_tags.eid = :eid AND 
                        establishment_tags.uid = :uid AND 
                        establishment_tags.tid = :tid ";
                  
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':eid', $eid);
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':tid', $tid);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return count($result) >= 1;
    }
    
    
    /*
            SELECTS
            -------
    */
    
    public function getEstablishmentsWithSimilarName($name,$type){
        $query = "SELECT * 
                  FROM establishments 
                  WHERE ename LIKE :name";
                          
        $stmt = $this->_db->prepare($query);
        $newName= '%'.$name.'%';
        $stmt->bindParam(":name",$newName);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }      
    
    public function getBars($searchQuery){
        $query = $this->_db->prepare("SELECT e.*, b.* 
                                    FROM establishments e, bars b 
                                    WHERE e.horeca_type = 'Bar' AND 
                                    (e.ename LIKE :query OR e.street LIKE :query OR e.city LIKE :query) AND 
                                    e.eid = b.eid"); 
        $newQuery='%'.$searchQuery.'%';
        $query->bindParam(':query',$newQuery);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
        
    }
    
    public function getUsersWithSimilarName($name){
        $query = "SELECT * 
                  FROM users 
                  WHERE nickname LIKE :name";
                        
        $stmt = $this->_db->prepare($query);
        $newName= '%'.$name.'%';
        $stmt->bindParam(":name",$newName);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }    

    public function getUIDof($nickname){
        $query = "SELECT * 
                  FROM users 
                  WHERE nickname = :nickname";
                  
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(":nickname",$nickname);
        $stmt->execute();
        $stmt = $stmt->fetch(PDO::FETCH_ASSOC);
        #if (count($result)!=1){
        #    return "NULL";
        #}
        return $stmt['uid'];
        
    }
    
    public function getUserData($uid){
        $query = "SELECT * 
                  FROM users 
                  WHERE uid = :userid";
                  
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(":userid",$uid);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function getBarData($eid){
        $query = "SELECT * 
                  FROM establishments,bars 
                  WHERE establishments.eid = :eid AND
                  bars.eid = establishments.eid";
                  
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(":eid",$eid);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function tagSearch($tag){
        $query = "SELECT e.*, c.*,tname 
                  FROM establishments e, bars c,tags t,establishment_tags et 
                  WHERE t.tname LIKE :tag AND t.tid = et.tid AND et.eid = e.eid AND et.eid = c.eid";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(":tag",$tag);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    
    /*
            UPDATES / DELETES
            -----------------
    */
    
    public function deleteEstablishmentWithEID($eid){
        $query = "DELETE 
                  FROM establishments 
                  WHERE eid= :eid";
                 
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(":eid", $eid);
        $stmt->execute();
    }
    
    public function modifyEstablishmentAttributes($changeAttributNames, $changeAttributValues, $searchAttributNames, $searchAttributValues){
        $query = 'UPDATE establishments 
                  SET '.
                 'WHERE ';
                         
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(":eid", $eid);
        $stmt->execute();
    }
    
    public function isAdmin($uid){
        $query = "SELECT *
                  FROM users
                  WHERE uid = :uid";
                  
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam("uid", $uid);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($result['admin'] == 1);
    }
    
    public function setAdmin($uid, $admin){
        $query = "UPDATE users
                  SET admin = :admin
                  WHERE uid = :uid ";
                         
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(":admin", $admin);
        $stmt->bindParam(":uid", $uid);
        $stmt->execute();
    }
    
    
    
    public function validLogin($nickname, $password){
        $query = "SELECT password 
                  FROM users 
                  WHERE nickname = :nickname";
                  
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':nickname', $nickname);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($result)!=1){
            return false;
        }
        if (password_verify($password, $result[0]['password'])){
            return true;
        }      
        return false;
    }
    
    
    
    /*
            SPECIFIC QUERIES
            ----------------
    */
    
    public function R1(){
        // • Tous les utilisateurs qui apprécient au moins 3 établissements que l’utilisateur "Brenda" apprécie.

        $query = "SELECT u1.*
                  FROM users u1, comments c1
                  WHERE u1.nickname != 'Brenda' AND c1.uid = u1.uid AND c1.score >= 4 AND c1.eid IN (
                      SELECT DISTINCT c2.eid
                      FROM comments c2, users u2
                      WHERE c2.score >= 4 AND u2.nickname = 'Brenda' AND c2.uid = u2.uid
                      )
                  GROUP BY u1.uid
                  HAVING COUNT( DISTINCT c1.eid ) >= 3";
                  
        $stmt = $this->_db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function R2(){
        // • Tous les établissements qu’apprécie au moins un utilisateur qui apprécie tous les établissements que "Brenda" apprécie.

        $query = "SELECT DISTINCT e1.*
                  FROM users u1, establishments e1, comments c1
                  WHERE u1.uid = c1.uid AND u1.nickname != 'Brenda' AND e1.eid = c1.eid AND c1.score >= 4 AND 
                        EXISTS (
                            SELECT DISTINCT c2.*
                            FROM comments c2 
                            WHERE u1.uid = c2.uid AND c2.score >= 4 AND c2.uid = u1.uid AND e1.eid = c2.eid AND c2.eid IN (
                                SELECT c2.eid
                                FROM comments c3, users u2
                                WHERE c3.score >= 4 AND u2.nickname = 'Brenda' AND c3.uid = u2.uid AND c3.eid = e1.eid
                            )
                       )";
                  
        $stmt = $this->_db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function R3(){
        // • R3 : Tous les établissements pour lesquels il y a au plus un commentaire.

        $query = "SELECT e1.*
                  FROM establishments e1
                  WHERE NOT EXISTS (
                        SELECT c1.*
                        FROM comments c1
                        WHERE e1.eid = c1.eid
                  ) OR e1.eid IN (
                        SELECT c2.eid
                        FROM comments c2
                        WHERE c2.eid = e1.eid
                        GROUP BY e1.eid
                        HAVING COUNT( c2.cid ) = 1
                  )";
                  
        $stmt = $this->_db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function R4(){
        // • R4 : La liste des administrateurs n’ayant pas commenté tous les établissements qu’ils ont crées.

        $query = "SELECT u1.*
                  FROM users u1
                  WHERE u1.admin = 1 AND EXISTS (
                        SELECT e1.*
                        FROM establishments e1
                        WHERE u1.uid = e1.uid AND NOT EXISTS (
                            SELECT c1.*
                            FROM comments c1
                            WHERE c1.eid = e1.eid AND c1.uid = u1.uid
                        )
                  )";
                  
        $stmt = $this->_db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function R5(){
        // • R5 : La liste des établissements ayant au minimum trois commentaires, classée selon la moyenne des scores attribués.

        $query = "SELECT e1.*
                  FROM establishments e1, comments c1
                  WHERE e1.eid = c1.eid 
                  GROUP BY e1.eid 
                  HAVING COUNT( DISTINCT c1.cid ) >= 3
                  ORDER BY AVG( c1.score )";
                  
        $stmt = $this->_db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();         
    }
    
    public function R6(){
        // • R6 : La liste des labels étant appliqués à au moins 5 établissements, classée selon la moyenne des scores des établissements ayant ce label.

        $query = "SELECT t1.* 
                  FROM tags t1, establishment_tags et1 
                  WHERE t1.tid = et1.tid 
                  HAVING COUNT( DISTINCT et1.eid ) >= 5 
                  ORDER BY (
                      SELECT SUM(c1.score)/COUNT(*) 
                      FROM establishments e1, comments c1, establishment_tags et2
                      WHERE e1.eid = c1.eid AND et2.tid = t1.tid AND et2.eid = e1.eid
                  )";
                  
        $stmt = $this->_db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();  
    }   
    


}