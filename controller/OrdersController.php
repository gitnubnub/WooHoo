<?php

require_once("WooHooDB.php");
require_once("ViewHelper.php");

class OrdersController {
	public static function get($id) {
		try {
			echo ViewHelper::renderJSON(WooHooDB::getOrder(["id" => $id]));
		} catch (InvalidArgumentException $e) {
			echo ViewHelper::renderJSON($e->getMessage(), 404);
		}
	}

	public static function index($userId) {
		$prefix = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

		if (!str_ends_with($prefix, "/")) {
			$prefix .= "/";
		}

		echo ViewHelper::renderJSON(WooHooDB::getAllOrders(["prefix" => $prefix]));
	}

	public static function add() {
		$data = filter_input_array(INPUT_POST, self::getRules());

		if (self::checkValues($data)) {
			$id = WooHooDB::insertOrder($data);
			echo ViewHelper::renderJSON("", 201);
			ViewHelper::redirect(BASE_URL . "api/orders/$id");
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
			WooHooDB::updateOrder($data);
			echo ViewHelper::renderJSON("",200);
		} else {
			echo ViewHelper::renderJSON("Missing data.",400);
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
		return;
	}
}