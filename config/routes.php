<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  
  $routes->get('/course', function() {
    HelloWorldController::course_list();
  });
  
  $routes->get('/course/1', function() {
    HelloWorldController::course_show();
  });
  
  $routes->get('/course/1/edit', function() {
    HelloWorldController::course_edit();
  });
