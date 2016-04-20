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
    
    public function insertUserComplete($array) {
        $query="INSERT INTO users 
                (nickname, email, password, admin) 
                VALUES 
                (:nickname, :email, :password, :admin)";
        $statement = $this->_db->prepare($query);

        $statement->bindParam(':nickname', $array[0]);
        $statement->bindParam(':email', $array[1]);
        $statement->bindParam(':password', hash("md5",$array[2]));
        $statement->bindParam(':admin', $array[3]);
        
        $statement->execute();
        return mysql_insert_id();
    }
    
    public function insertUserNotComplete($array) {
        $query="INSERT INTO users 
                (nickname, email, password, admin) 
                VALUES 
                (:nickname, :email, :password, :admin)";
        $statement = $this->_db->prepare($query);

        $statement->bindParam(':nickname', $array[0]);
        $statement->bindParam(':email', NULL);
        $statement->bindParam(':password', NULL);
        $statement->bindParam(':admin', $array[1]);
        
        $statement->execute();
        return mysql_insert_id();
    }

    public function insertEstablishment($array) {
        $query="INSERT INTO establishments 
                (ename, street, house_num, zip, city, longitude, latitude, tel, site, uid) 
                VALUES 
                (:ename, :street, :house_num, :zip, :city, :longitude, :latitude, :tel, :site, :uid)";
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
        
        $statement->execute();
        return mysql_insert_id();
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
                (cid, uid, eid, entry_date, score) 
                VALUES 
                (:cid, :uid, :eid, :entry_date, :score)";
        $statement= $this->_db->prepare($query);

        $statement->bindParam(':cid',  $array[0]);
        $statement->bindParam(':uid',  $array[1]);
        $statement->bindParam(':eid',  $array[2]);
        $statement->bindParam(':entry_date',  $array[3]);
        $statement->bindParam(':score',  $array[4]);

        $statement->execute();
    }

    public function insertTag($array){
        $query="INSERT INTO tags 
                (tid, tname) 
                VALUES 
                (:tid, :tname)";
        $statement= $this->_db->prepare($query);

        $statement->bindParam(':tid',  $array[0]);
        $statement->bindParam(':tname',  $array[1]);

        $statement->execute();
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




    public function insertQuery($exercise){

        $query= 'SELECT level FROM levels WHERE label='.$this->_db->quote($exercise[5]);
        $resultat= $this->_db->query($query);
        $row= $resultat->fetch();
        $level= $row->level;

        $query= 'INSERT INTO exercises (number, theme, statement, query, nb_lines, num_exercise, num_level)
                  VALUES (DEFAULT, :theme, :statement, :query, :nb_lines, :num_exercise, :level)';

        $statement= $this->_db->prepare($query);

        $statement->bindParam(':num_exercise', $exercise[0]);
        $statement->bindParam(':theme', $exercise[1]);
        $statement->bindParam(':statement', $exercise[2]);
        $statement->bindParam(':query', $exercise[3]);
        $statement->bindParam(':nb_lines', $exercise[4]);
        $statement->bindParam(':level', $level);

        $statement->execute();

    }


    public function deleteLevel($level_label){

        $query= 'DELETE FROM levels WHERE label='.$this->_db->quote($level_label);
        $this->_db->prepare($query)->execute();

    }


    public function insertLevel($level_label, $level_num){

        $query= 'INSERT INTO levels (level, num_level, label) VALUES (DEFAULT,'.$level_num.','.$this->_db->quote($level_label).')';
        $this->_db->prepare($query)->execute();

    }


    public function valid_teacher($login,$password){

        $query = 'SELECT * from teachers WHERE login=' . $this->_db->quote($login) . ' AND password=' . $this->_db->quote(sha1($password));
        $result = $this->_db->query($query);
        $authenticated = false;

        if ($result->rowcount() != 0) {
            $authenticated = true;
        }

        return $authenticated;
    }



    public function valid_student($matricule,$password){

        $query = 'SELECT * from students WHERE matricule='.$this->_db->quote($matricule).' AND password='.$this->_db->quote(sha1($password));
        $result = $this->_db->query($query);
        $authenticated = false;

        if ($result->rowcount()!=0) {
            $authenticated = true;
        }

        return $authenticated;
    }


    public function update_mdp_Student($matricule,$password) {

        $query = 'UPDATE students SET password= '.$this->_db->quote(sha1($password)).' WHERE matricule=' .$this->_db->quote($matricule).'AND password is NULL';
        $this->_db->prepare($query)->execute();

    }


    public function update_mdp_Teacher($login,$password) {

        $query = 'UPDATE `sitephp`.`teachers` SET `password`= SHA1('.$this->_db->quote($password).') WHERE `teachers`.`login`=' .$this->_db->quote($login).'AND password is NULL';
        $this->_db->prepare($query)->execute();

    }


    public function select_students(){

        $query = 'SELECT * FROM students';
        $tableau = array();
        $result =$this->_db->query($query);

        if ($result->rowcount()!=0) {
            while ($row = $result->fetch()) {
                $tableau[] = new Student($row->matricule,$row->first_name,$row->last_name,$row->password);
            }
        }

        return $tableau;
    }


    public function select_name_student($matricule){

        $query = 'SELECT * FROM `sitephp`.`students` WHERE `sitephp`.`students`.`matricule`='.$this->_db->quote($matricule);
        $tableau=array();
        $result = $this->_db->query($query);

        if ($result->rowcount()!=0) {
            while ($row = $result->fetch()) {
                $tableau[] = new Student($row->matricule,$row->first_name,$row->last_name,$row->password);
            }
        }

        return $tableau;

    }


    public function select_exercise($level){

        $query = 'SELECT * FROM exercises where num_level='.$this->_db->quote($level).'';
        $tableau = array();
        $result =$this->_db->query($query);

        if ($result->rowcount()!=0) {
            while ($row = $result->fetch()) {
                $tableau[] = new Exercises($row->author,$row->last_modification,$row->nb_lines,$row->number,$row->num_exercise,$row->num_level,$row->query,$row->statement,$row->theme);
            }
        }

        return $tableau;
    }


    public function select_levels(){

        $query = 'SELECT * FROM levels';
        $tableau = array();
        $result =$this->_db->query($query);

        if ($result->rowcount()!=0) {
            while ($row = $result->fetch()) {
                $tableau[] = new Levels($row->label,$row->level,$row->num_level);
            }
        }

        return $tableau;
    }


    public function select_num_level($level){

        $query = 'SELECT * FROM levels where level='.$this->_db->quote($level);
        $tableau = array();
        $result =$this->_db->query($query);

        if ($result->rowcount()!=0) {
            while ($row = $result->fetch()) {
                $tableau[] = new Levels($row->label,$row->level,$row->num_level);
            }
        }

        return $tableau;
    }


    public function save_answer($matricule,$question_num,$answer){

        $select_answer='SELECT * FROM `sitephp`.`students_answers` WHERE student='.$this->_db->quote($matricule).' AND exercise='.$this->_db->quote($question_num).'';
        $result = $this->_db->query($select_answer);

        if ($result->rowcount()!=0){

            $query_update='UPDATE `sitephp`.`students_answers` SET answer_query ='.$this->_db->quote($answer).' WHERE student='.$this->_db->quote($matricule).' AND exercise='.$this->_db->quote($question_num).'';
            $this->_db->prepare($query_update)->execute();

        }else{

            $query_insert='INSERT INTO `sitephp`.`students_answers` (`number`, `answer_query`, `exercise`, `student`) VALUES (NULL,'.$this->_db->quote($answer).','.$this->_db->quote($question_num).','.$this->_db->quote($matricule).')';
            $this->_db->prepare($query_insert)->execute();

        }

        $authenticated = false;

        if ($result->rowcount()!=0) {
            $authenticated = true;
        }

        return $authenticated;
    }


    public function select_answer($matricule,$question_num){

        $query ='SELECT * FROM `students_answers` WHERE `exercise`='.$this->_db->quote($question_num).'AND `student`='.$this->_db->quote($matricule).'';
        $result =$this->_db->query($query);
        $tableau=array();

        if ($result->rowcount()!=0) {
            while ($row = $result->fetch()) {
                $tableau[] = new Students_answers($row->number, $row->answer_query, $row->exercise, $row->student);
            }
        }

        return $tableau;
    }


    public function select_all_answer_student($matricule, $num_level){

        $query ='SELECT * FROM students_answers stu,exercises ex WHERE stu.student='.$this->_db->quote($matricule).'AND stu.exercise = ex.number AND ex.num_level ='.$this->_db->quote($num_level);
        $result =$this->_db->query($query);
        $tableau=array();

        if ($result->rowcount()!=0) {

            while ($row = $result->fetch()) {
                $tableau[] = new Students_answers($row->number, $row->answer_query, $row->exercise, $row->student);
            }

        }

        return $tableau;
    }


    public function show_answer_DB($answer){

        $query = $answer;
        $fetch_type = PDO::FETCH_ASSOC;
        $result = $this->_db->query($query);

        $rows = $result->fetchAll($fetch_type);

        return $rows;

    }


    public function getColumnsNames($query_send){

        $query = $query_send;
        $fetch_type = PDO::FETCH_ASSOC;
        $result = $this->_db->query($query);
        $rows = $result->fetchAll($fetch_type);
        $columns = empty($rows) ? array() : array_keys($rows[0]);
        return $columns;

    }


    public function update_query($query_update,$author,$num_exercise,$nb_lines,$num_level,$statement,$theme) {

        $query = 'UPDATE `sitephp`.`exercises` SET `query`= '.$this->_db->quote($query_update).',`statement`= '.$this->_db->quote($statement) .',`author`= '.$this->_db->quote($author) .',`theme`= '.$this->_db->quote($theme) .',`nb_lines`= '.$this->_db->quote($nb_lines) .' WHERE  `exercises`.`num_exercise`='.$this->_db->quote($num_exercise).'';
        $this->_db->prepare($query)->execute();

    }


    public function update_student_last_co($matricule,$last_co){

        $query='UPDATE `sitephp`.`students` SET `last_connection`= '.$this->_db->quote($last_co).' WHERE `matricule`='.$this->_db->quote($matricule).'';
        $this->_db->prepare($query)->execute();

    }


    public function is_a_good_query($query){

        $not_allowed_words=['delete','update','create','alter','insert','truncate','drop'];
        $allowed=['bd1','bd2','bd3'];

        for($i=0;$i<count($not_allowed_words);$i++){
            if(strpos($query, $not_allowed_words[$i])!== FALSE)
                return false;
        }

        for ($i=0;$i<count($allowed);$i++){
            if(strpos($query, $allowed[$i])!==FALSE)
                return true;
        }

        return false;
    }
    
    
    public function validNickname($nickname){
        $query = "SELECT * FROM users WHERE users.nickname = ".$this->_db->quote($nickname);
        $result =$this->_db->query($query);
        
        if ($result->rowcount()!=0){
            return FALSE;
        }
        return TRUE;
        
    }
    
    public function emailAlreadyInUse($email){
        $query = "SELECT * FROM users WHERE users.email = ".$this->_db->quote($email);
        $result =$this->_db->query($query);
        
        
         if ($result->rowcount()!=0){
            return TRUE;
        }
        return FALSE; 
    }

}