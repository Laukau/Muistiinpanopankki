<?php

class Note extends BaseModel{
    public $id, $student, $course, $subject, $address, $modified, $published, $validators;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array();
    }
    
    public static function all($query){
        $query->execute();
        $rows = $query->fetchAll();
        $notes = array();
        
        foreach($rows as $row){
            $notes[] = new Note(array(
                'id' => $row['id'],
                'student' => $row['student'],
                'course' => $row['course'],
                'subject' => $row['subject'],
                'address' => $row['address'],
                'modified' => $row['modified'],
                'published' => $row['published']
            ));
        }
        
        return $notes;
    }
    
    public static function students_all(){
        $query = DB::connection()->prepare('SELECT * FROM Note JOIN Course ON Note.course = Course.id JOIN Student ON Note.student = Student.id');
        return $this->all($query);
    }
    
    public static function all_published(){
        $query = DB::connection()->prepare('SELECT * FROM Note JOIN Course ON Note.course = Course.id WHERE Note.published = true');
        return $this->all($query);
    }
    
    public static function find($id){
        
    }
    
    public function save(){
        
    }
    
    public function update(){
        
    }
    
    public function destroy(){
        
    }
    
    public function validate_address(){
        
    }
    
    public function validate_subject(){
        
    }
    
    
}
