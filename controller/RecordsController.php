<?php

require_once("model/WooHooDB.php");
require_once("ViewHelper.php");

class RecordsController {
	public static function get($id) {
		echo ViewHelper::render("view/details.php", WooHooDB::getRecord(["id" => $id]));
	}

	public static function index() {
		echo ViewHelper::render("view/home.php", ["records" => WooHooDB::getAllRecords()]);
	}

	public static function add() {
		$idSeller = $_SESSION['user_id'];
		$data = filter_input_array(INPUT_POST, self::getRules());

		if (self::checkValues($data)) {
			$id = WooHooDB::insertRecord($data);
			echo ViewHelper::redirect(BASE_URL . "records/" . $id);
		}
	}

	public static function edit($id) {
		$data = filter_input_array(INPUT_POST, self::getRules());

		if (self::checkValues($data)) {
			$data["id"] = $id;
			WooHooDB::updateRecord($data);
			echo ViewHelper::redirect(BASE_URL . "records". $data["id"]);
		}
	}

	public static function delete($id) {
		
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