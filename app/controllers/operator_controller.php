<?php

class OperatorController extends BaseController {

    public static function login() {

        if (self::get_user_logged_in()) {
            Redirect::to('/task');
        }
        View::make('operator/login.html');
    }

    public static function handle_login() {
        $params = $_POST;

        $operator = Operator::authenticate($params['username'], $params['password']);

        if (!$operator) {
            View::make('operator/login.html', array('errors' => array('Wrong username or password!'), 'username' => $params['username']));
        } else {
            $_SESSION['operator'] = $operator->id;

            Redirect::to('/task', array('message' => 'Welcome back, ' . $operator->username . '!'));
        }
    }
    

    public static function logout() {
        $_SESSION['operator'] = null;
        Redirect::to('/', array('message' => 'You have logged out succesfully!'));
    }

    public static function register() {
        View::make('operator/new.html');
    }

    public static function createAccount() {
        $params = $_POST;
        $operator = new Operator(array(
            'username' => $params['username'],
            'password' => $params['password']
        ));
        $errors = $operator->errors();

        if (Operator::findByUserName($operator->username) != null) {
            $errors += array('Account exists already');
        }


        if (count($errors) > 0) {
            View::make('operator/new.html', array('errors' => $errors, 'operator' => $operator));
            return false;
        }
        if ($operator->save() == true) {
            Redirect::to('/', array('message' => 'Account created!'));
        }
    }

}
