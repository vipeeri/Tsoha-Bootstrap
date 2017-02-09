<?php

class TaskController extends BaseController {

    public static function index() {
        // Haetaan kaikki pelit tietokannasta
        $tasks = Task::all();
        // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
        View::make('task/index.html', array('tasks' => $tasks));
    }

    public static function task($id) {
        $task = Task::find($id);
        View::make('task/show.html', array('task' => $task));
    }

    public static function new_task() {
        //View::make('task/index.html');
        View::make('task/new.html');
    }

    public static function editTask($id) {
        $task = Task::find($id);
        View::make('task/edit.html', array('attributes' => $task));
    }

    public static function store() {
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
            View::make('task/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    // Pelin muokkaaminen (lomakkeen esittäminen)


    public static function updateTask($id) {
        $params = $_POST;

        $attributes = array(
            'name' => $params['name'],
            'added' => $params['added'],
            'deadline' => $params['deadline']
        );

        // Alustetaan Game-olio käyttäjän syöttämillä tiedoilla
     
        
        $task = new Task($attributes);
        $errors = $task->errors();

        if (count($errors) > 0) {
            View::make('task/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
        $task->update();

        Redirect::to('/task/' . $task->id, array('message' => 'Task edited succesfully!'));
        }
    }

    //poistaminen
    public static function destroyTask($id) {
        // Alustetaan
        $task = new Task(array('id' => $id));
        $task->destroy();

        // Ohjataan
        Redirect::to('/task', array('message' => 'Task removed succesfully!'));
    }

}
