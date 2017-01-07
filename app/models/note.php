<?php

class Note extends BaseModel{
    public $id, $student, $course, $subject, $address, $modified, $published;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    
}
