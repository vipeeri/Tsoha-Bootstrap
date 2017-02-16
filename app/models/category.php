<?php

class Category extends BaseModel {

    public $id, $name;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name');
    }

    public static function getCategoryById($id) {
        $query = DB::connection()->prepare("SELECT *
                                            FROM category
                                            WHERE category.id = :id");
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $category = new Category(array(
                'id' => $row['id'],
                'name' => $row['name']
            ));
        }
        return $category;
    }

    public static function getCategoryByTask($task_id) {
        $query = DB::connection()->prepare("SELECT category. * FROM category
                    INNER JOIN task_category
                    ON task_category.category_id = category.id
                    WHERE task_category.task_id = :id");

        $query->execute(array('id' => $task_id));
        $rows = $query->fetchAll();
        $categories = array();
        foreach ($rows as $row) {
            $categories[] = new Category(array(
                'id' => $row['id'],
                'name' => $row['name']
            ));
        }
        return $categories;
    }

    public static function getCategories() {
        $query = DB::connection()->prepare('SELECT category.id AS id, category.name AS name FROM category');
        $query->execute();
        $rows = $query->fetchAll();
        $categories = array();
        foreach ($rows as $row) {
            $categories[] = new Category(array(
                'id' => $row['id'],
                'name' => $row['name']
            ));
        }
        return $categories;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO category(name) VALUES (:name) RETURNING id');
        $query->execute(array('name' => $this->name));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM task_category WHERE category_id = :id');
        $query->execute(array('id' => $this->id));
        $query = DB::connection()->prepare('DELETE FROM category WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE category SET id = :id, name = :name WHERE id = :id');
        $query->execute(array('id' => $this->id, 'name' => $this->name));
    }
    
        public function validate_name() {
        $errors = array();
        if ($this->name == '' || $this->name == null) {
            $errors[] = 'Category can not be empty!';
        }
        if (strlen($this->name) < 3) {
            $errors[] = 'Minimum length for category is 3 characters!';
        }

        return $errors;
    }

}
