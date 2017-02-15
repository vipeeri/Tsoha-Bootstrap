<?php

class TaskController extends BaseController {

    public static function index() {
        self::check_logged_in();
        $tasks = Task::all();
        $categories = Task::findCategories();
        View::make('task/index.html', array('tasks' => $tasks, 'categories' => $categories));
    }

    public static function task($id) {

        self::check_logged_in();
        $task = Task::find($id);
       $categories = Category::getCategories();
        View::make('task/show.html', array('task' => $task, 'categories' => $categories));
    }

    public static function new_task() {
        self::check_logged_in();
        $categories = Category::getCategories();
        View::make('task/new.html', array('categories' => $categories));
    }

    public static function editTask($id) {

        self::check_logged_in();
        $task = Task::find($id);
        View::make('task/edit.html', array('task' => $task));
    }

    public static function store() {
        self::check_logged_in();
        $params = $_POST;
        
        $categories = $params['categories'];
                
        $attributes = array(
            'name' => $params['name'],
            'added' => $params['added'],
            'deadline' => $params['deadline'],
            'categories' => array()
        );


        foreach ($categories as $category) {
            $attributes['categories'][] = $category;
        }

        $task = new Task($attributes);
        $errors = $task->errors();

        if (count($errors) == 0) {
            $task->save();


            Redirect::to('/task/' . $task->id, array('message' => 'New task added!'));
        } else {
            View::make('task/new.html', array('errors' => $errors, 'attributes' => $attributes, 'task' => $task, 'categories' => $categories));
        }
    }

    public static function updateTask($id) {
        self::check_logged_in();
        $params = $_POST;

        //$attributes = array(
        $task = new Task(array(
            'id' => $id,
            'name' => $params['name'],
            'added' => $params['added'],
            'deadline' => $params['deadline'],
        ));

        $errors = $task->errors();

        if (count($errors) > 0) {

            View::make('task/edit.html', array('errors' => $errors, 'task' => $task));
        } else {
            $task->update();

            Redirect::to('/task/' . $task->id, array('message' => 'Task edited succesfully!'));
        }
    }

    public static function destroyTask($id) {
        self::check_logged_in();
        $task = new Task(array('id' => $id));
        $task->destroy();

        Redirect::to('/task', array('message' => 'Task removed succesfully!'));
    }

}
