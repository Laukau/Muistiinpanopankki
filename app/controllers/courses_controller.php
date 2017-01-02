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
}
