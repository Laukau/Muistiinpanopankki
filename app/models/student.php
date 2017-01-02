<?php

class Student extends BaseModel{
    public $id, $nimi, $kayttajatunnus, $salasana;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
}