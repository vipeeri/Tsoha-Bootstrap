<?php

$routes->post('/task/:id/edit', function($id) {
    TaskController::updateTask($id);
});

$routes->get('/task/:id/edit', function($id) {
    TaskController::editTask($id);
});


$routes->post('/task/:id/destroy', function($id) {
    TaskController::destroyTask($id);
});

$routes->get('/', function() {
    TaskController::index();
});


$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});


$routes->get('/task', function() {
    TaskController::index();
});

$routes->get('/task/new', function() {
    TaskController::new_task();
});

$routes->post('/task/add', function() {
    TaskController::store();
});


$routes->get('/task/:id', function($id) {
    TaskController::task($id);
});

$routes->get('/login', function(){
  // Kirjautumislomakkeen esittäminen
  UserController::login();
});
$routes->post('/login', function(){
  // Kirjautumisen käsittely
  UserController::handle_login();
});




