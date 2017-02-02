<?php
class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('home.html');
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
//    $siivous = Task::find(1);
//    $tasks = Task::all();
//    // Kint-luokan dump-metodi tulostaa muuttujan arvon
//    Kint::dump($tasks);
//    Kint::dump($siivous);
  
    }

    public static function todo_edit() {
        View::make('suunnitelmat/todo_edit.html');
    }

    public static function todo_list() {
        View::make('task/index.html');
    }

    public static function todo_show() {
        View::make('suunnitelmat/todo_show.html');
    }

    public static function login() {
        View::make('suunnitelmat/login.html');
    }

}
