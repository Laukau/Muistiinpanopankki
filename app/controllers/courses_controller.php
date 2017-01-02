<?php

class CourseController extends BaseController {
    
    public static function index(){
        $courses = Course::all();
        View::make('course/index.html', array('courses' => $courses));
    }
    
    public static function show($kurssitunnus){
        $course = Course::find($kurssitunnus);
        View::make('course/show.html', array('course' => $course));
    }
    
    public static function create(){
        View::make('course/new.html');
    }

    public static function store(){
        $params = $_POST;
        $course = new Course(array(
           'nimi' => $params['nimi'],
           'yliopisto' => $params['yliopisto']
        ));
        $course->save();
        
        Redirect::to('/course/' . $course->kurssitunnus, array('message' => 'Kurssi on lisätty luetteloon!'));
    }
    
    public static function edit($kurssitunnus){
        $course = Course::find($kurssitunnus);
        View::make('course/edit.html', array('attributes' => $course));
    }
    /*
    public static function update($kurssitunnus){
        $params = $_POST;
        $attributes = array(
            'kurssitunnus' => $kurssitunnus,
            'nimi' => $params['nimi'],
            'yliopisto' => $params['yliopisto']
        );
        $course = new Course($attributes); 
    }*/
}
