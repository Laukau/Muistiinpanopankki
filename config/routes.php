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
  
  $routes->get('/course/:kurssitunnus', function($kurssitunnus){
      CourseController::show($kurssitunnus);
  });
  
  $routes->get('/course/1/edit', function(){
    HelloWorldController::course_edit();
  });
