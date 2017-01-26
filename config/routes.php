<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/todo_edit', function() {
    HelloWorldController::todo_edit();
});

$routes->get('/todo_list', function() {
    HelloWorldController::todo_list();
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
