<?php

require_once("model/WooHooDB.php");
require_once("ViewHelper.php");

class RecordsController {
	public static function get($id) {
		try {
			echo ViewHelper::renderJSON(WooHooDB::getRecord(["id" => $id]));
		} catch (InvalidArgumentException $e) {
			echo ViewHelper::renderJSON($e->getMessage(), 404);
		}
	}

	public static function index() {
		$prefix = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

		if (!str_ends_with($prefix, "/")) {
			$prefix .= "/";
		}

		echo ViewHelper::renderJSON(WooHooDB::getAllRecords(["prefix" => $prefix]));
	}

	public static function add() {
		$idSeller = $_SESSION['user_id'];
		$data = filter_input_array(INPUT_POST, self::getRules());

		if (self::checkValues($data)) {
			$id = WooHooDB::insertRecord($data);
			echo ViewHelper::renderJSON("", 201);
			ViewHelper::redirect(BASE_URL . "api/records/$id");
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
			WooHooDB::updateRecord($data);
			echo ViewHelper::renderJSON("",200);
		} else {
			echo ViewHelper::renderJSON("Missing data.",400);
		}
	}

	public static function delete($id) {
		try {
			WooHooDB::getRecord(["id" => $id]);
			WooHooDB::deleteRecord(["id"=> $id]);
			echo ViewHelper::renderJSON("", 204);
		} catch (InvalidArgumentException $e) {
			echo ViewHelper::renderJSON("Record with $id doesn't exist.", 404);
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
			'description' => FILTER_SANITIZE_SPECIAL_CHARS,
			'artist' => FILTER_SANITIZE_SPECIAL_CHARS,
			'releaseYear'=> [
				'filter' => FILTER_VALIDATE_INT,
				'options' => [
					'min_range' => 1800,
					'max_range' => date("Y")
				]
			],
			'rating' => FILTER_VALIDATE_FLOAT,
			'numberOfRatings' => FILTER_VALIDATE_INT,
			'price' => FILTER_VALIDATE_FLOAT
		];
	}
}