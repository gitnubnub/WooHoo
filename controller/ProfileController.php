<?php

require_once("model/WooHooDB.php");
require_once("ViewHelper.php");

class ProfileController {
	public static function get($id) {
		echo ViewHelper::render("view/profile.php", WooHooDB::getProfile(["id" => $id]));
	}

	public static function index() {
		
	}

	public static function add() {
		$data = filter_input_array(INPUT_POST, self::getRules());

		if (self::checkValues($data)) {
			$id = WooHooDB::insertProfile($data);
			ViewHelper::redirect(BASE_URL . "profile/" . $id);
		}
	}

	public static function edit($id) {
		$data = filter_input_array(INPUT_POST, self::getRules());

		if (self::checkValues($data)) {
			$data["id"] = $id;
			WooHooDB::updateProfile($data);
			ViewHelper::redirect(BASE_URL . "profile/" . $id);
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