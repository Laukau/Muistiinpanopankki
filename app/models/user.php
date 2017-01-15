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
        
    }
    
    public function validate_username(){
        
    }
    
    public function validate_password(){
        
    }
}