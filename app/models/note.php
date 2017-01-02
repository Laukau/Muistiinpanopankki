<?php

class Note extends BaseModel{
    public $id, $opiskelija, $kurssi, $aihe, $osoite, $muokkauspaiva, $julkinen;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    
}
