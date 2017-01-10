<?php

class User extends BaseModel{
    public $id, $student_name, $username, $password;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
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
}