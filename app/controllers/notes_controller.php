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
    
    public static function create($course_id){
        self::check_logged_in();
        
        View::make('note/new.html', array('course_id' => $course_id));
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
            'modified' => date('Y-m-d')
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
    
    public static function update($course_id, $note_id){
        self::check_logged_in();
        
        $user_logged_in = self::get_user_logged_in();
        $params = $_POST;
        
        $attributes = array(
            'id' => $note_id,
            'subject' => $params['subject'],
            'address' => $params['address'],
            'published' => $params['published'],
            'course' => $course_id,
            'student' => $user_logged_in->id,
            'modified' => date('Y-m-d')
        );
        
        $note = new Note($attributes);
        $errors = $note->errors();
        
        if($note->student != $user_logged_in){
            Redirect::to('/course/' . $note->course, array('errors' => 'Muistiinpanoa voi muokata vain sen tehnyt opiskelija!'));
        }
        if(count($errors) == 0){
            $note->update();
            
            Redirect::to('/course/' . $note->course, array('message' => 'Muistiinpanoa on muokattu onnistuneesti!'));
        }else{
            View::make('/note/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }
    
    public static function destroy($id){
         self::check_logged_in();
        
        $user_logged_in = self::get_user_logged_in();
        $note = new Note(array('id' => $id));
        
        if($note->student === $user_logged_in){
            $note->destroy();
            Redirect::to('/course/' . $note->course, array('message' => 'Muistiinpano on poistettu!'));
        }else{
            Redirect::to('/course' . $note->course, array('errors' => 'Muistiinpanon voi poistaa vain sen tehnyt opiskelija!'));
        }
    }
}
