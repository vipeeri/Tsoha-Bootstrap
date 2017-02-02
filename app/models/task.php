<?php

class Task extends BaseModel {

    // Attribuutit
    public $id, $name, $deadline, $added;

    // Konstruktori
    public function __construct($attributes) {
        parent::__construct($attributes);
       // $siivous = new Task(array('id' => 1, 'name' => 'Siivoa'));
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
    
    public function save(){
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

}
