<?php

class UserController extends BaseController{
    
    public static function index(){
        self::check_logged_in();
        $users = User::all();
        View::make('user/index.html', array('users' => $users));
    }
    
    public static function show($id){
        self::check_logged_in();
        $user = User::find($id);
        $courses = Course::all();
        View::make('user/show.html', array('user' => $user), array('courses' => $courses));
    }
    
    public static function login(){
        View::make('user/login.html');
    }
    
    public static function handle_login(){
        $params = $_POST;
        
        $user = User::authenticate($params['username'], $params['password']);
        
        if(!$user){
            View::make('user/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana', 'username' => $params['username']));
        }else{
            $_SESSION['user'] = $user->id;
            
            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $user->student_name . '!' ));
        }
    }
    
    public static function logout(){
        $_SESSION['user'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }
}