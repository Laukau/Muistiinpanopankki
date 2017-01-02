<?php

class Course extends BaseModel{
    public $kurssitunnus, $yliopisto, $nimi;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function all(){
        $query = DB::connection()->prepare('SELECT * FROM Kurssi');
        $query->execute();
        $rows = $query->fetchAll();
        $courses = array();
        
        foreach($rows as $row){
            $courses[] = new Course(array(
                'kurssitunnus' => $row['kurssitunnus'],
                'yliopisto' => $row['yliopisto'],
                'nimi' => $row['nimi']
            ));
        }
        
        return $courses;
    }
    
    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM Kurssi WHERE kurssitunnus = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row) {
            $course = new Course(array(
                'kurssitunnus' => $row['kurssitunnus'],
                'yliopisto' => $row['yliopisto'],
                'nimi' => $row['nimi']
            ));
            return $course;
        }
        return null;
    }
}

