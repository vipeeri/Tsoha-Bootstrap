<?php

class TaskController extends BaseController {

    public static function index() {
        // Haetaan kaikki pelit tietokannasta

        if (!self::get_user_logged_in()) {
            Redirect::to("/");
            return;
        }
        $tasks = Task::all();
        // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
        View::make('task/index.html', array('tasks' => $tasks));
    }

    public static function task($id) {
        if (!self::get_user_logged_in()) {
            Redirect::to("/");
            return;
        }
        $task = Task::find($id);
        View::make('task/show.html', array('task' => $task));
    }

    public static function new_task() {
        if (!self::get_user_logged_in()) {
            Redirect::to("/");
            return;
        }
        //View::make('task/index.html');
        View::make('task/new.html');
    }

    public static function editTask($id) {
        if (!self::get_user_logged_in()) {
            Redirect::to("/");
            return;
        }
        $task = Task::find($id);
        View::make('task/edit.html', array('task' => $task));
    }

    public static function store() {
        if (!self::get_user_logged_in()) {
            Redirect::to("/");
            return;
        }
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;
        // Alustetaan uusi Game-luokan olion käyttäjän syöttämillä arvoilla
        $attributes = array(
            'name' => $params['name'],
            'added' => $params['added'],
            'deadline' => $params['deadline']
        );

        //Kint::dump($params);
        // Kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
        $task = new Task($attributes);
        $errors = $task->errors();

        if (count($errors) == 0) {
            $task->save();


            // Ohjataan käyttäjä lisäyksen jälkeen pelin esittelysivulle
            Redirect::to('/task/' . $task->id, array('message' => 'New task added!'));
        } else {
            View::make('task/new.html', array('errors' => $errors, 'attributes' => $attributes, 'task' => $task));
        }
    }

    public static function updateTask($id) {
        if (!self::get_user_logged_in()) {
            Redirect::to("/");
            return;
        }
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'name' => $params['name'],
            'added' => $params['added'],
            'deadline' => $params['deadline']
        );

        $task = new Task($attributes);
        $errors = $task->errors();

        if (count($errors) > 0) {
            $task = Task::find($id);
            View::make('task/edit.html', array('errors' => $errors, 'attributes' => $attributes, 'task' => $task));
        } else {
            $task->update();

            Redirect::to('/task/' . $task->id, array('message' => 'Task edited succesfully!'));
        }
    }

    //poistaminen
    public static function destroyTask($id) {
        if (!self::get_user_logged_in()) {
            Redirect::to("/");
            return;
        }
        // Alustetaan
        $task = new Task(array('id' => $id));
        $task->destroy();

        // Ohjataan
        Redirect::to('/task', array('message' => 'Task removed succesfully!'));
    }

}
