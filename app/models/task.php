<?php

class Task extends BaseModel {

    // Attribuutit
    public $id, $task_id, $name, $deadline, $description, $added, $priority, $category;

    // Konstruktori
    public function __construct($attributes) {
        parent::__construct($attributes);
    }

}
