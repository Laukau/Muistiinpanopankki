<?php

class Note extends BaseModel{
    public $id, $student, $course, $subject, $address, $modified, $published, $validators;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_address', 'validate_subject');
    }
    
    public static function all($category, $course_id, $student_id){
        if($category == "all"){
            return $this->all_student_and_published($course_id, $student_id);
        } else if($category == "student"){
            return $this->all_student($course_id, $student_id);
        }
        return $this->all_published($course_id);
    }
    
    public static function all_helper($query){
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
    
    public static function all_student($course_id, $student_id){
        $query = DB::connection()->prepare('SELECT * FROM Note JOIN Course ON Note.course = Course.id JOIN Student ON Note.student = Student.id WHERE Course.id = :course_id AND Student.id = :student_id');
        $query->execute(array('course_id' => $course_id, 'student_id' => $student_id));
        $rows = $query->fetchAll();
        return $rows;
    }
    
    public static function all_published($course_id){
        $query = DB::connection()->prepare('SELECT * FROM Note JOIN Course ON Note.course = Course.id WHERE Course.id = :course_id AND Note.published = true');
        $query->execute(array('course_id' => $course_id));
        $rows = $query->fetchAll();
        return $rows;
    }
    
    public static function all_student_and_published($course_id, $student_id){
        $query = DB::connection()->prepare('SELECT * FROM Note JOIN Course ON Note.course = Course.id JOIN Student ON Note.student = Student.id WHERE Course.id = :course_id AND (Student.id = :student_id OR Note.published = true)');
        $query->execute(array('course_id' => $course_id, 'student_id' => $student_id));
        $rows = $query->fetchAll();
        return $rows;
    }
    
    
    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM Note WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row) {
            $note = new Note(array(
                'id' => $row['id'],
                'student' => $row['student'],
                'course' => $row['course'],
                'subject' => $row['subject'],
                'address' => $row['address'],
                'modified' => $row['modified'],
                'published' => $row['published']
            ));
            return $note;
        }
        return null;
    }
    
    public function save(){
        $query = DB::connection()->prepare('INSERT INTO Note (student, course, subject, address, modified, published) VALUES (:student, :course, :subject, :address, :modified, :published) RETURNING id');
        $query->execute(array('student' => $this->student, 'course' => $this->course, 'subject' => $this->subject, 'address' => $this->address, 'modified' => $this->modified, 'published' => $this->published));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function update(){
        $query = DB::connection()->prepare('UPDATE Note SET student = :student, course = :course, subject = :subject, address = :address, modified = :modified, published = :published WHERE id = :id');
        $query->execute(array('id' => $this->id, 'student' => $this->student, 'course' => $this->course, 'subject' => $this->subject, 'address' => $this->address, 'modified' => $this->modified, 'published' => $this->published));
    }
    
    public function destroy(){
        $query = DB::connection()->prepare('DELETE FROM Note WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }
    
    public function validate_address(){
        $errors = array();
        
        return $errors;
    }
    
    public function validate_subject(){
        $errors = array();
        if(parent::validate_string_required($this->title)){
            $errors[] = 'Otsikko ei saa olla tyhjä!';
        }else if(parent::validate_string_length($this->title, 3)){
            $errors[] = 'Otsikon pituuden tulee olla vähintään kolme merkkiä!';
        }
        return $errors;
    }
    
    
}
