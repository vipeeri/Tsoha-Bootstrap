<?php

class Task extends BaseModel {

    // Attribuutit
    public $id, $name, $deadline, $added, $operator_id, $category_id, $category, $priority, $priority_id;

    // Konstruktori
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_deadline', 'validate_added');
    }

    public static function all() {
        // Alustetaan kysely tietokantayhteydellämme
        //SELECT task.name AS name, tas.added AS added, task.deadline AS deadline, category.name AS category
        //SELECT inventory.creature_id AS creature_id, inventory.weapon_id AS weapon_id       
        $query = DB::connection()->prepare("SELECT * 
                FROM Task
                WHERE operator_id = :operatorid");
        // Suoritetaan kysely
        $query->execute(array('operatorid' => $_SESSION['operator']));
        //$query->execute();
        // Haetaan kyselyn tuottamat rivit
        $rows = $query->fetchAll();
        $tasks = array();

        // Käydään kyselyn tuottamat rivit läpi
        foreach ($rows as $row) {
            // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
            $tasks[] = new Task(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'added' => $row['added'],
                'deadline' => $row['deadline'],
                'priority_id' => $row['priority_id']
            ));
        }


        return $tasks;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Task WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $task = new Task(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'added' => $row['added'],
                'deadline' => $row['deadline'],
                'operator_id' => $row['operator_id'],
                'priority_id' => $row['priority_id']
            ));

            return $task;
        }
    }

    public function findCategories() {
        return Category::getCategoryByTask($this->id);
    }

    public function findPriority() {
        return Priority::getPriorityById($this->priority_id);
    }

    public function save($category_id_list) {
        $query = DB::connection()->prepare('INSERT INTO Task (name, added, deadline, operator_id, priority_id) VALUES (:name, :added, :deadline, :operator_id, :priority_id) RETURNING id');
        $query->execute(array('name' => $this->name, 'added' => $this->added, 'deadline' => $this->deadline, 'operator_id' => $_SESSION['operator'], 'priority_id' => $this->priority));
        $row = $query->fetch();
        $this->id = $row['id'];

        foreach ($category_id_list as $category_id) {
            $query = DB::connection()->prepare('INSERT INTO task_category (task_id, category_id) VALUES (:task_id, :category_id)');
            $query->execute(array('task_id' => $this->id, 'category_id' => $category_id));
        }
    }

    public function update($category_id_list) {
        $query = DB::connection()->prepare('UPDATE Task SET (name, added, deadline, operator_id, priority_id) = (:name, :added, :deadline, :operator_id, :priority_id) WHERE id = :id');
        $query->execute(array('id' => $this->id, 'name' => $this->name, 'added' => $this->added, 'deadline' => $this->deadline, 'operator_id' => $_SESSION['operator'], 'priority_id' => $this->priority));

        $query = DB::connection()->prepare('DELETE FROM task_category WHERE task_id = :task_id');
        $query->execute(array('task_id' => $this->id));

        foreach ($category_id_list as $category_id) {
            $query = DB::connection()->prepare('INSERT INTO task_category (task_id, category_id) VALUES (:task_id, :category_id)');
            $query->execute(array('task_id' => $this->id, 'category_id' => $category_id));
        }
    }

    public function destroy() {

        $query = DB::connection()->prepare('DELETE FROM task_category WHERE task_id = :id');
        $query->execute(array('id' => $this->id));
        $query = DB::connection()->prepare('DELETE FROM task WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }
    

    

    public function validate_name() {
        $errors = array();
        if ($this->name == '' || $this->name == null) {
            $errors[] = 'Name-field can not be empty!';
        }
        if (strlen($this->name) < 3) {
            $errors[] = 'Minimum length for name is 3 characters!';
        }

        return $errors;
    }

    public function validate_deadline() {
        $today = date("Y-m-d");
        $errors = array();

        if ($this->deadline == '' || $this->deadline == null) {
            $errors[] = 'Deadline-field can not be empty!';
        }

        if ($this->deadline < $today) {
            $errors[] ='Deadline can not be in the past!';
        }

        return $errors;
    }

    public function validate_added() {
        $errors = array();
        if ($this->added == '' || $this->added == null) {
            $errors[] = 'Added-field can not be empty!';
        }

        
        return $errors;
    }


}
