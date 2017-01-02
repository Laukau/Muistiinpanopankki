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
    
    public static function find($kurssitunnus){
        $query = DB::connection()->prepare('SELECT * FROM Kurssi WHERE kurssitunnus = :kurssitunnus LIMIT 1');
        $query->execute(array('kurssitunnus' => $kurssitunnus));
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
    
    public function save(){
        $query = DB::connection()->prepare('INSERT INTO Kurssi (nimi, yliopisto) VALUES (:nimi, :yliopisto) RETURNING kurssitunnus');
        $query->execute(array('nimi' => $this->nimi, 'yliopisto' => $this->yliopisto));
        $row = $query->fetch();
        $this->kurssitunnus = $row['kurssitunnus'];
    }
}

