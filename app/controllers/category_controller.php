<?php

class CategoryController extends BaseController {

    public static function allCategories() {
        self::check_logged_in();


        View::make('/category/index.html', array('categories' => Category::getCategoryByOperator(self::get_user_logged_in()->id)));
    }

    public static function category($id) {
        self::check_logged_in();
        $category = Category::getCategoryById($id);
        View::make('/category/show.html', array('category' => $category));
    }

    public static function newCategory() {
        self::check_logged_in();
        View::make('/category/new.html');
    }

    public static function editCategory($id) {
        self::check_logged_in();
        $category = Category::getCategoryById($id);
        View::make('/category/edit.html', array('category' => $category));
    }

    public static function updateCategory($id) {
        self::check_logged_in();
        $params = $_POST;

        $category = new Category(array(
            'id' => $id,
            'name' => $params['name'],
            'operator_id' => $params['operator_id']
        ));

        $errors = $category->errors();
        if (count($errors) > 0) {

            View::make('category/edit.html', array('errors' => $errors, 'category' => $category));
        } else {

            $category->update(array());


            Redirect::to('/category/' . $category->id, array('message' => 'Category edited succesfully!'));
        }
    }

    public static function storeCategory() {
        self::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'name' => $params['name'],
            'operator_id' => self::get_user_logged_in()->id
        );


        $category = new Category($attributes);
        $errors = $category->errors();

        if (count($errors) > 0) {
            View::make('category/new.html', array('errors' => $errors, 'attributes' => $attributes, 'category' => $category));
        } else {


            $category->save();

            Redirect::to('/category/' . $category->id, array('message' => 'New category added!'));
        }
    }

    public static function destroyCategory($id) {
        self::check_logged_in();
        $category = new Category(array('id' => $id));
        $category->destroy();

        Redirect::to('/category/all', array('message' => 'Category removed succesfully!'));
    }

}
