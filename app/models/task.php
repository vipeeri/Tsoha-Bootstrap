<?php

class Task extends BaseModel {

    // Attribuutit
    public $id, $task_id, $name, $deadline, $description, $added, $priority, $category;

    // Konstruktori
    public function __construct($attributes) {
        parent::__construct($attributes);
        $siivous = new Task(array('id' => 1, 'name' => 'The Elder Scrolls X: Siivoa', 'description' => 'siivoa wc'));
    }

    public static function all() {
        // Alustetaan kysely tietokantayhteydellämme
        $query = DB::connection()->prepare('SELECT * FROM Task');
        // Suoritetaan kysely
        $query->execute();
        // Haetaan kyselyn tuottamat rivit
        $rows = $query->fetchAll();
        $tasks = array();

        // Käydään kyselyn tuottamat rivit läpi
        foreach ($rows as $row) {
            // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
            $tasks[] = new Task(array(
                'id' => $row['id'],
                'task_id' => $row['task_id'],
                'name' => $row['name'],
                'description' => $row['description'],
                'priority' => $row['priority'],
                'added' => $row['added'],
                'deadline' => $row['deadline'],
                'category' => $row['category']
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
                'task_id' => $row['task_id'],
                'name' => $row['name'],
                'description' => $row['description'],
                'priority' => $row['priority'],
                'added' => $row['added'],
                'deadline' => $row['deadline'],
                'category' => $row['category']
            ));

            return $task;
        }
    }

}
