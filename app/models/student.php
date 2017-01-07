<?php

class Student extends BaseModel{
    public $id, $student_name, $username, $password;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
}