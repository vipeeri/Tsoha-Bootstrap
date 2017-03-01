<?php

class Operator extends BaseModel {

    public $id, $username, $password, $status;

    // Konstruktori
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_username', 'validate_password');
    }

    public static function authenticate($username, $password) {
        $query = DB::connection()->prepare('SELECT * FROM operator WHERE username = :username AND password = :password LIMIT 1');
        $query->execute(array('username' => $username, 'password' => $password));
        $row = $query->fetch();
        if ($row) {
            return new Operator(array(
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password']
            ));
        } else {
            return null;
        }
    }

    public function getStatus() {
                return $this->status;
    }

    public static function findAllOperators() {
        $query = DB::connection()->prepare('SELECT * FROM operator');
        $query->execute();
        $rows = $query->fetchAll();
        $accounts = array();
        foreach ($rows as $row) {
            $operators[] = new Operator(array(
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password']
            ));
        }
        return $operators;
    }

    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT * FROM operator WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $operator = new Operator(array(
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password']
            ));
            return $operator;
        }
        return null;
    }

    public static function findByUserName($username) {
        $query = DB::connection()->prepare('SELECT * FROM operator WHERE username = :username LIMIT 1');
        $query->execute(array('username' => $username));
        $row = $query->fetch();
        if ($row) {
            $operator = new Operator(array(
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password']
            ));
            return $operator;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('SELECT * FROM operator WHERE username = :username');
        $query->execute(array('username' => $this->username));
        if ($query->fetch() != null) {
            return false;
        }
        $query = DB::connection()->prepare('INSERT INTO operator (username, password) VALUES (:username, :password)');
        $query->execute(array('username' => $this->username, 'password' => $this->password));
        return true;
    }

    public function validate_username() {
        $errors = array();
        if ($this->username == '' || $this->username == null) {
            $errors[] = 'Username-field can not be empty!';
        }
        if (strlen($this->username) < 2) {
            $errors[] = 'Minimum length for username is 2 characters!';
        }

        return $errors;
    }

    public function validate_password() {
        $errors = array();
        if ($this->password == '' || $this->password == null) {
            $errors[] = 'Password-field can not be empty!';
        }


        return $errors;
    }

}
