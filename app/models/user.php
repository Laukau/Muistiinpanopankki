<?php

class User extends BaseModel{
    public $id, $student_name, $username, $password, $validators;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_student_name', 'validate_username', 'validate_password');
    }
    
    public function __toString() {
        return $this->student_name;
    }
    
    public static function all(){
        $query = DB::connection()->prepare('SELECT * FROM Student');
        $query->execute();
        $rows = $query->fetchAll();
        $users = array();
        
        foreach($rows as $row){
            $users[] = new User(array(
                'id' => $row['id'],
                'student_name' => $row['student_name'],
                'username' => $row['username'],
                'password' => $row['password']
            ));
        }
        
        return $users;
    }
    
    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM Student WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row) {
            $user = new User(array(
                'id' => $row['id'],
                'student_name' => $row['student_name'],
                'username' => $row['username'],
                'password' => $row['password']
            ));
            return $user;
        }
        return null;
    }
    
    public function username_exists(){
        $query = DB::connection()->prepare('SELECT * FROM Student WHERE username = :username LIMIT 1');
        $query->execute(array('username' => $this->username));
        $row = $query->fetch();
        if($row){
            return true;
        }
        return false;
    }
    
    public function save(){
        $query = DB::connection()->prepare('INSERT INTO Student (student_name, username, password) VALUES (:student_name, :username, :password) RETURNING id');
        $query->execute(array('student_name' => $this->student_name, 'username' => $this->username, 'password' => $this->password));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function update(){
        $query = DB::connection()->prepare('UPDATE Student SET student_name = :student_name, username = :username, password = :password WHERE id = :id');
        $query->execute(array('id' => $this->id, 'student_name' => $this->student_name, 'username' => $this->username, 'password' => $this->password));
    }
    
    public function destroy(){
        $query = DB::connection()->prepare('DELETE FROM Student WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }
    
    public static function authenticate($username, $password){
        $query = DB::connection()->prepare('SELECT * FROM Student WHERE username = :username AND password = :password LIMIT 1');
        $query->execute(array('username' => $username, 'password' => $password));
        $row = $query->fetch();
        if($row){
            $user = new User(array(
               'id' => $row['id'], 
                'student_name' => $row['student_name'],
                'username' => $row['username'],
                'password' => $row['password']
            ));
            return $user;
        }else{
            return null;
        }
    }
    
    public function validate_student_name(){
        $errors = array();
        if(parent::validate_string_required($this->student_name)){
            $errors[] = 'Nimi ei saa olla tyhjä!';
        }else if(parent::validate_string_length($this->student_name, 2)){
            $errors[] = 'Nimen pituuden tulee olla vähintään kaksi merkkiä!';
        }
        return $errors;
    }
    
    public function validate_username(){
        $errors = array();
        if(parent::validate_string_required($this->username)){
            $errors[] = 'Käyttäjätunnus ei saa olla tyhjä!';
        }else if(parent::validate_string_length($this->username, 6)){
            $errors[] = 'Käyttäjätunnuksen pituuden tulee olla vähintään 6 merkkiä!';
        }
        return $errors;
    }
    
    public function validate_password(){
        $errors = array();
        
        if(parent::validate_string_required($this->password)){
            $errors[] = 'Salasana ei saa olla tyhjä!';
        }else if(parent::validate_string_length($this->password, 6)){
            $errors[] = 'Salasanan pituuden tulee olla vähintään 6 merkkiä!';
        } /*else if(!preg_match('/[A-Za-Z0-9]+/', $this->password)){
            $errors[] = 'Salasanan tulee sisältää pieniä ja isoja kirjaimia sekä numeroita!';
        }*/
        return $errors;
    }
    
    public function join_course($course){
        $query = DB::connection()->prepare('INSERT INTO Students_course (student, course) VALUES (:student, :course) RETURNING id');
        $query->execute(array('student' => $this->id, 'course' => $course));
        $row = $query->fetch();
        $this->id = $row['id'];
    
    }
    
    public function leave_course($course){
        $query = DB::connection()->prepare('DELETE FROM Students_course WHERE student = :id AND course = :course');
        $query->execute(array('id' => $this->id, 'course' => $course));
        
    }
    
    public function student_on_courses(){
        $query = DB::connection()->prepare('SELECT * FROM Students_course WHERE student = :student');
        $query->execute(array('student' => $this->id));
        $rows = $query->fetchAll();
        
        if($rows){
            return true;
        }
        return false;
    }
    
    public function leave_all_courses(){
        $query = DB::connection()->prepare('DELETE FROM Students_course WHERE student = :id');
        $query->execute(array('id' => $this->id));
        
    }
}