<?php

class Task extends BaseModel {

    // Attribuutit
    public $id, $name, $deadline, $added;

    // Konstruktori
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_deadline', 'validate_added');
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
                'name' => $row['name'],
                'added' => $row['added'],
                'deadline' => $row['deadline'],
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
            ));

            return $task;
        }
    }
    
        public static function findByUserName($username)
    {
        $query = DB::connection()->prepare('SELECT * FROM operator WHERE username = :username LIMIT 1');
        $query->execute(array('username' => $name));
        $row = $query->fetch();
        if ($row) {
            $account = new Account(array(
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password'],
            ));
            return $operator;
        }
        return null;
    }

    public function save() {
        // Lisätään RETURNING id tietokantakyselymme loppuun, niin saamme lisätyn rivin id-sarakkeen arvon
        $query = DB::connection()->prepare('INSERT INTO Task (name, added, deadline) VALUES (:name, :added, :deadline) RETURNING id');
        // Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
        $query->execute(array('name' => $this->name, 'added' => $this->added, 'deadline' => $this->deadline));
        // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
        $row = $query->fetch();
        // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
        $this->id = $row['id'];
//    Kint::trace();
//    Kint::dump($row);
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Task SET (name, added, deadline) = (:name, :added, :deadline) WHERE id = :id');
        $query->execute(array('id' => $this->id, 'name' => $this->name, 'added' => $this->added, 'deadline' => $this->deadline));
        
    }

    public function destroy() {
        $query = DB::connection()->prepare("DELETE FROM Task WHERE id='$this->id'");
        $query->execute();
        //$query->execute(array('name' => $this->name, 'added' => $this->added, 'deadline' => $this->deadline));
       
        
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
        $errors = array();

        if ($this->deadline == '' || $this->deadline == null) {
            $errors[] = 'Deadline-field can not be empty!';
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
