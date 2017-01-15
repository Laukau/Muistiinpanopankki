<?php

class NoteController extends BaseController {

    public static function index() {
        $notes = array();
        $user_logged_in = self::get_user_logged_in();
        if ($user_logged_in) {
            $params = $_POST;
            $category = $params['note_category'];
            $notes = Note::all($category, $params['course_id'], $user_logged_in->id);
        }else{
            $notes = Note::all_published($params['course_id']);
        }
        
        View::make('note/index.html', array('notes' => $notes));
    }
    
    public static function create(){
        self::check_logged_in();
        
        View::make('note/create.html');
    }
    
    public static function store($course_id){
        self::check_logged_in();
        $user_logged_in = self::get_user_logged_in();
        $params = $_POST;
        
        $attributes = array(
            'subject' => $params['subject'],
            'address' => $params['address'],
            'published' => $params['published'],
            'course' => $course_id,
            'student' => $user_logged_in->id,
            'modified' => date("1")
        );
        $note = new Note($attributes);
        $errors = $note->errors();
        
        if(count($errors) == 0){
            $note->save();
            Redirect::to('/course/' . $course_id, array('message' => 'Muistiinpano on lisätty luetteloosi!'));
        }else{
            View::make('note/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }
    
    public static function edit($id){
        self::check_logged_in();
        
        $user_logged_in = self::get_user_logged_in();
        $note = Note::find($id);
        
        if($note->student === $user_logged_in){
            View::make('note/edit.html', array('attributes' => $note));
        }else{
            Redirect::to('/course/' . $note->course, array('errors' => 'Muistiinpanoa voi muokata vain sen tehnyt opiskelija!'));
        }
    }
    
    
}
