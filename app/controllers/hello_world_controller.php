<?php
  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('suunnitelmat/home.html');
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      $logiikka = new Course(array(
         'title' => 'logiikka',
          'university' => 'HY'
      ));
      $errors = $logiikka->errors();
      
      Kint::dump($errors);
    }
    
    public static function course_list(){
        View::make('suunnitelmat/course_list.html');
    }
    
    public static function course_show(){
        View::make('suunnitelmat/course_show.html');
    }
    
    public static function course_edit(){
        View::make('suunnitelmat/course_edit.html');
    }
    
    public static function login(){
        View::make('suunnitelmat/login.html');
    }
  }
