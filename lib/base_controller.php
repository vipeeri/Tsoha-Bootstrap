<?php

class BaseController {

    public static function get_user_logged_in() {
        if (isset($_SESSION['operator'])) {
            $operator_id = $_SESSION['operator'];
            $operator = Operator::findOne($operator_id);

            return $operator;
        }

// Käyttäjä ei ole kirjautunut sisään
        return null;
    }

// ...


    public static function check_logged_in() {
// Toteuta kirjautumisen tarkistus tähän.
// Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).


        if (!isset($_SESSION['operator'])) {
            Redirect::to('/', array('message' => 'Login first!'));
        }
    }

}
