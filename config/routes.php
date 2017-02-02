<?php

$routes->get('/', function() {
    TaskController::index();
});

$routes->get('/todo_edit', function() {
    HelloWorldController::todo_edit();
});

$routes->get('/todo_show', function() {
    HelloWorldController::todo_show();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/login', function() {
    HelloWorldController::login();
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




