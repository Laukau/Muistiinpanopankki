<?php

class CourseController extends BaseController {
    
    public static function index(){
        $courses = Course::all();
        View::make('course/index.html', array('courses' => $courses));
    }
    
    public static function show($id){
        $course = Course::find($id);
        View::make('course/show.html', array('course' => $course));
    }
    
    public static function create(){
        View::make('course/new.html');
    }

    public static function store(){
        $params = $_POST;
        $attributes = array(
           'title' => $params['title'],
           'university' => $params['university'],
           'description' => $params['description']
        );
        $course = new Course($attributes);
        
        $errors = $course->errors();
        
        if(count($errors) == 0){
            $course->save();
            Redirect::to('/course/' . $course->id, array('message' => 'Kurssi on lisätty luetteloon!'));
        }else{
            View::make('course/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
        
    }
    
    public static function edit($id){
        $course = Course::find($id);
        View::make('course/edit.html', array('attributes' => $course));
    }
    
    public static function update($id){
        $params = $_POST;
        $attributes = array(
            'id' => $id,
            'title' => $params['title'],
            'university' => $params['university'],
            'description' => $params['description']
        );
        
        $course = new Course($attributes); 
        $errors = $course->errors();
        
        if(count($errors) > 0){
            View::make('course/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        }else{
            $course->update();
            Redirect::to('/course/' . $course->id, array('message' => 'Kurssia on muokattu onnistuneesti!'));
        }
        
        
    }
    
    public static function destroy($id){
        $course = new Course(array('id' => $id));
        $course->destroy();
        
        Redirect::to('/course', array('message' => 'Kurssi on poistettu onnistuneesti!'));
    }
}
