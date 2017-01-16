<?php

class Note extends BaseModel{
    public $id, $student, $course, $subject, $address, $modified, $published, $validators;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_address', 'validate_subject');
    }
    
    public static function all_helper($rows){
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
        $query = DB::connection()->prepare('SELECT * FROM Note WHERE Note.course = :course_id AND Note.student = :student_id');
        $query->execute(array('course_id' => $course_id, 'student_id' => $student_id));
        $rows = $query->fetchAll();
        return self::all_helper($rows);
    }
    
    public static function all_published($course_id){
        $query = DB::connection()->prepare('SELECT * FROM Note WHERE Note.course = :course_id AND Note.published = true');
        $query->execute(array('course_id' => $course_id));
        $rows = $query->fetchAll();
        return self::all_helper($rows);
    }
    
    public static function all_student_and_published($course_id, $student_id){
        $query = DB::connection()->prepare('SELECT * FROM Note WHERE Note.course = :course_id AND (Note.student = :student_id OR Note.published = true)');
        $query->execute(array('course_id' => $course_id, 'student_id' => $student_id));
        $rows = $query->fetchAll();
        return self::all_helper($rows);
    }
    
     public static function all($category, $course_id, $student_id){
        if($category == "all"){
            return self::all_student_and_published($course_id, $student_id);
        } else if($category == "student"){
            return self::all_student($course_id, $student_id);
        }
        return self::all_published($course_id);
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
        if(parent::validate_string_required($this->address)){
            $errors[] = 'Osoite ei saa olla tyhjä!';
        }
        return $errors;
    }
    
    public function validate_subject(){
        $errors = array();
        if(parent::validate_string_required($this->subject)){
            $errors[] = 'Otsikko ei saa olla tyhjä!';
        }else if(parent::validate_string_length($this->subject, 3)){
            $errors[] = 'Otsikon pituuden tulee olla vähintään kolme merkkiä!';
        }
        return $errors;
    }
    
    
}
