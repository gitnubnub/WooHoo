<?php

require_once("model/WooHooDB.php");
require_once("controller/RecordsController.php");
require_once("ViewHelper.php");

class RecordsRESTController {

    public static function get($id) {
        try {
            echo ViewHelper::renderJSON(WooHooDB::getRecord(["id" => $id]));
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }

    public static function index() {
        $prefix = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"]
                . $_SERVER["REQUEST_URI"];
        if (!str_ends_with($prefix, "/")) {
            $prefix = $prefix . "/";
        }
        echo ViewHelper::renderJSON(WooHooDB::getAllRecordswithURI(["prefix" => $prefix]));
    }

    public static function add() {
        $data = filter_input_array(INPUT_POST, RecordsController::getRules());

        if (RecordsController::checkValues($data)) {
            $id = WooHooDB::insertRecord($data);
            echo ViewHelper::renderJSON("", 201);
            ViewHelper::redirect(BASE_URL . "api/records/$id");
        } else {
            echo ViewHelper::renderJSON("Missing data.", 400);
        }
    }

    public static function edit($id) {
        // spremenljivka $_PUT ne obstaja, zato jo moremo narediti sami
        $_PUT = [];
        parse_str(file_get_contents("php://input"), $_PUT);
        $data = filter_var_array($_PUT, RecordsController::getRules());

        if (RecordsController::checkValues($data)) {
            $data["id"] = $id;
            WooHooDB::updateRecord($data);
            echo ViewHelper::renderJSON("", 200);
        } else {
            echo ViewHelper::renderJSON("Missing data.", 400);
        }
    }

    public static function delete($id) {
        // TODO: Implementiraj delete
        // Vrni kodo 204 v primeru uspeha oz. kodo 404, če knjiga ne obstaja
        // https://www.restapitutorial.com/httpstatuscodes.html
        
        try {
            WooHooDB::getRecord(["id" => $id]);
            WooHooDB::deleteRecord(["id" => $id]);
            echo ViewHelper::renderJSON("", 204);
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON("Record $id ne obstaja", 404);
        }
    }
    
}
