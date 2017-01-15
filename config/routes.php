<?php

  $routes->get('/', function(){
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function(){
    HelloWorldController::sandbox();
  });
  
  $routes->get('/course', function(){
    CourseController::index();
  });
  
  $routes->post('/course', function(){
     CourseController::store(); 
  });
  
  $routes->get('/course/new', function(){
     CourseController::create(); 
  });
  
  $routes->get('/course/:id', function($id){
      CourseController::show($id);
  });
  
  $routes->post('/course/:id', function($id){
      NoteController::index();
  });
  
  $routes->get('/course/:id/edit', function($id){
      CourseController::edit($id);
  });
  
  $routes->post('/course/:id/edit', function($id){
      CourseController::update($id);
  });
  
  $routes->post('/course/:id/destroy', function($id){
      CourseController::destroy($id);
  });
  
  $routes->get('/login', function(){
      UserController::login();
  });
  
  $routes->post('/login', function() {
      UserController::handle_login();
  });
  
  $routes->get('/user', function(){
      UserController::index();
  });
  
  $routes->get('/user/:id', function($id) {
      UserController::show($id); 
  });
  
  $routes->post('/logout', function(){
      UserController::logout(); 
  });

  $routes->get('/registration', function() {
      UserController::register(); 
  });
  
  $routes->post('/', function() {
      UserController::store(); 
  });
  
  $routes->get('/user/:id/edit', function($id){
      UserController::edit($id);
  });
  
  $routes->post('/user/:id/edit', function($id){
      UserController::update($id);
  });
  
  $routes->post('/user/:id/destroy', function($id){
      UserController::destroy($id);
  });
  
  
  
  
  $routes->get('/course/:course_id/note/new', function($course_id){
     NoteController::create($course_id); 
  });
  
  $routes->post('/course/:course_id/note', function($course_id){
     NoteController::store($course_id); 
  });
  
  
  $routes->get('/course/:course_id/note/:note_id/edit', function($course_id, $note_id){
      Note_Controller::edit($note_id);
  });
  
  $routes->post('/course/:course_id/note/:note_id/edit', function($course_id, $note_id){
      NoteController::update($course_id, $note_id);
  });
  
  $routes->post('/course/:course_id/note/:note_id/destroy', function($course_id, $note_id){
      Note_Controller::destroy($note_id);
  });
  