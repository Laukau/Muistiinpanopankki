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
