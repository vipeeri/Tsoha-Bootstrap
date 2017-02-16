<?php

class Priority extends BaseModel {

    public $id, $name;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name');
    }

    public static function getPriorityById($id) {
        $query = DB::connection()->prepare("SELECT *
                                            FROM priority
                                            WHERE priority.id = :id");
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $priority = new Priority(array(
                'id' => $row['id'],
                'name' => $row['name']
            ));
        }
        return $priority;
    }

    public static function getPriorityByTask($priority_id) {
        $query = DB::connection()->prepare("SELECT *
                    FROM priority
                    INNER JOIN task
                    ON priority.id = :id LIMIT 1");
        $query->execute(array('id' => $priority_id));
        $row = $query->fetch();

        if ($row) {
            $priority = new Priority(array(
                'id' => $row['id'],
                'name' => $row['name']
            ));
        }
        return $priority;
    }

    public static function getPriorities() {
        $query = DB::connection()->prepare('SELECT priority.id AS id, priority.name AS name FROM priority');
        $query->execute();
        $rows = $query->fetchAll();
        $priorities = array();
        foreach ($rows as $row) {
            $priorities[] = new Priority(array(
                'id' => $row['id'],
                'name' => $row['name']
            ));
        }
        return $priorities;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO priority(name) VALUES (:name) RETURNING id');
        $query->execute(array('name' => $this->name));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM priority WHERE id = :id');
        $query->execute(array('id' => $this->id));

    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE priority SET id = :id, name = :name WHERE id = :id');
        $query->execute(array('id' => $this->id, 'name' => $this->name));
    }
    
        public function validate_name() {
        $errors = array();
        if ($this->name == '' || $this->name == null) {
            $errors[] = 'Priority can not be empty!';
        }
        if (strlen($this->name) < 3) {
            $errors[] = 'Minimum length for priority is 3 characters!';
        }

        return $errors;
    }

}