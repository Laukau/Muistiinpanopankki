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
      HelloWorldController::login();
  });
