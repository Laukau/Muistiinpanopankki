<?php

class Course extends BaseModel{
    public $id, $university, $title, $description, $validators;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_title', 'validate_university');
    }
    
    public static function all(){
        $query = DB::connection()->prepare('SELECT * FROM Course');
        $query->execute();
        $rows = $query->fetchAll();
        $courses = array();
        
        foreach($rows as $row){
            $courses[] = new Course(array(
                'id' => $row['id'],
                'university' => $row['university'],
                'title' => $row['title'],
                'description' => $row['description']
            ));
        }
        
        return $courses;
    }
    
    public static function students_all($student_id){
        $query = DB::connection()->prepare('SELECT * FROM Course JOIN Students_course ON Course.id = Students_course.course JOIN Student ON Students_course.student = Student.id');
        $query->execute();
        $rows = $query->fetchAll();
        $courses = array();
        
        foreach($rows as $row){
            $courses[] = new Course(array(
                'id' => $row['id'],
                'university' => $row['university'],
                'title' => $row['title'],
                'description' => $row['description']
            ));
        }
        
        return $courses;
    }
    
    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM Course WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row) {
            $course = new Course(array(
                'id' => $row['id'],
                'university' => $row['university'],
                'title' => $row['title'],
                'description' => $row['description']
            ));
            return $course;
        }
        return null;
    }
    
    public function save(){
        $query = DB::connection()->prepare('INSERT INTO Course (title, university) VALUES (:title, :university) RETURNING id');
        $query->execute(array('title' => $this->title, 'university' => $this->university));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function destroy(){
        $query = DB::connection()->prepare('DELETE FROM Course WHERE id = :id');
        $query->execute(array('id' => $this->id));
        $row = $query->fetch();
    }
    
    public function update(){
        $query = DB::connection()->prepare('UPDATE Course SET title = :title, university = :university, description = :description WHERE id = :id');
        $query->execute(array('id' => $this->id, 'title' => $this->title, 'university' => $this->university, 'description' => $this->description));
        $row = $query->fetch();
    }
    
    public function validate_title(){
        $errors = array();
        if(parent::validate_string_length($this->title, 3)){
            $errors[] = 'Nimen pituuden tulee olla vähintään kolme merkkiä!';
        }
        return $errors;
    }
    
    public function validate_university(){
        $errors = array();
        if(parent::validate_string_length($this->university, 2)){
            $errors[] = 'Yliopiston nimen pituuden tulee olla vähintään kaksi merkkiä!';
        }
        return $errors;
    }
}

