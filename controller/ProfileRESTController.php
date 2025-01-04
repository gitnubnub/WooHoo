<?php

require_once("model/WooHooDB.php");
require_once("controller/ProfileController.php");
require_once("ViewHelper.php");

class ProfileRESTController {

    public static function login() {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        $user = WooHooDB::getUserByEmail(['email' => $email]);

        if ($user) {
            $hashedPassword = $user['hash'];
            $salt = $user['salt'];

            if (password_verify($salt . $password, $hashedPassword)) {


                echo ViewHelper::renderJSON(WooHooDB::getProfile(["id" => $user['id']]));
            } else {
                echo ViewHelper::renderJSON("Invalid email or password.", 400);
            }
        } else {
            echo ViewHelper::renderJSON("Invalid email or password.", 400);
        }
    }
    
    public static function edit($id) {
        $name = filter_input(INPUT_POST, 'name');
        $surname = filter_input(INPUT_POST, 'surname');
        $address = filter_input(INPUT_POST, 'address');
        $addressNumber = filter_input(INPUT_POST, 'addressNumber');
        $postalCode = filter_input(INPUT_POST, 'postalCode');
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        
        $params = [
            'id' => $id,
            'email' => $email,
            'name' => $name,
            'surname' => $surname,
            'address' => $address,
            'addressNumber' => $addressNumber,
            'postalCode' => $postalCode
];
            
        WooHooDB::updateProfile($params);
        echo ViewHelper::renderJSON(WooHooDB::getProfile(["id" => $id]));   
    }

    public static function get($id) {
        try {
            echo ViewHelper::renderJSON(WooHooDB::getProfile(["id" => $id]));
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }
}
