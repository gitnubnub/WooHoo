<?php

require_once("model/WooHooDB.php");
require_once("ViewHelper.php");

class RecordsController {
	public static function get($id) {
		echo ViewHelper::render("view/details.php", WooHooDB::getRecord(["id" => $id]));
	}

	public static function index() {
            if (isset($_SESSION['role']) && isset($_SESSION['user_id']) && $_SESSION['role'] == 'Seller') {
                echo ViewHelper::render("view/home.php", ["records" => WooHooDB::getAllRecordsFromSeller($_SESSION['user_id'])]);
            } else {
		echo ViewHelper::render("view/home.php", ["records" => WooHooDB::getAllRecords()]);
            }
	}

	public static function add() {
		$idSeller = $_SESSION['user_id'];
		$data = filter_input_array(INPUT_POST, self::getRules());
                $data['idSeller'] = $idSeller;

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
			ViewHelper::redirect(BASE_URL . "records/" . $id);
		}
	}

	public static function delete($id) {
            $data = filter_input_array(INPUT_POST);
            $data["id"] = $id;
            $data["isActive"] = isset($data["isActive"]) && $data["isActive"] == true ? 0 : 1;
            
            WooHooDB::deactivateRecord($data);
            ViewHelper::redirect(BASE_URL . "records/" . $id);
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
			'price' => FILTER_VALIDATE_FLOAT
		];
	}
}