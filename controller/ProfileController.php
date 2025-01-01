<?php

require_once("WooHooDB.php");
require_once("ViewHelper.php");

class ProfileController {
	public static function get($id) {
		try {
			echo ViewHelper::renderJSON(WooHooDB::getProfile(["id" => $id]));
		} catch (InvalidArgumentException $e) {
			echo ViewHelper::renderJSON($e->getMessage(), 404);
		}
	}

	public static function index() {
		
	}

	public static function add() {
		$data = filter_input_array(INPUT_POST, self::getRules());

		if (self::checkValues($data)) {
			$id = WooHooDB::insertProfile($data);
			echo ViewHelper::renderJSON("", 201);
			ViewHelper::redirect(BASE_URL . "api/profile/$id");
		} else {
			echo ViewHelper::renderJSON("Missing data.",400);
		}
	}

	public static function edit($id) {
		$_PUT = [];
		parse_str(file_get_contents("php://input"), $_PUT);
		$data = filter_var_array($_PUT, self::getRules());

		if (self::checkValues($data)) {
			$data["id"] = $id;
			WooHooDB::updateProfile($data);
			echo ViewHelper::renderJSON("",200);
		} else {
			echo ViewHelper::renderJSON("Missing data.",400);
		}
	}

	public static function delete($id) {
		try {
			WooHooDB::getProfile(["id" => $id]);
			WooHooDB::deleteProfile(["id"=> $id]);
			echo ViewHelper::renderJSON("", 204);
		} catch (InvalidArgumentException $e) {
			echo ViewHelper::renderJSON("User with $id doesn't exist.", 404);
		}
	}

	public static function checkValues($input) {
		if (empty($input)) {
			return false;
		}

		$result = true;
		foreach ($input as $value) {
			$result = $result && $value != false;
		}

		return $result;
	}

	public static function getRules() {
		return [
			'name' => FILTER_SANITIZE_SPECIAL_CHARS,
			'surname' => FILTER_SANITIZE_SPECIAL_CHARS,
			'address' => FILTER_SANITIZE_SPECIAL_CHARS,
			'addressNumber' => FILTER_VALIDATE_INT,
			'postalCode'=> [
				'filter' => FILTER_VALIDATE_INT,
				'options' => [
					'min_range' => 1000,
					'max_range' => 9265
				]
			],
			'email' => FILTER_VALIDATE_EMAIL
		];
	}
}