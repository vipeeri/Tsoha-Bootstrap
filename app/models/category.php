<?php

class Category extends BaseModel {

    public $id, $name, $task_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

//		public static function getCategoryByTask($id) {
//			$query = DB::connection()->prepare('SELECT category.id AS id, category.name AS name FROM category LIMIT 1');
//			$query->execute();
//			$row = $query->fetch();
//			if($row) {
//				$category
//				= new Category
//				(array(
//					'id' => $row['id'],
//					'name' => $row['name']
//					));
//				return $category
//				;
//			}
//			return null;
//		}
    public static function getCategoryByTask($task_id) {
        $query = DB::connection()->prepare("SELECT category.* FROM category
                    JOIN task_category 
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

}
