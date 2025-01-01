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

		try {
			$orders = WooHooDB::getAllOrders($userId, $prefix);
			echo ViewHelper::renderJSON($orders);
		} catch (Exception $e) {
			echo ViewHelper::renderJSON(["error" => $e->getMessage()], 500);
		}
	}

	public static function add() {
		$idCustomer = $_SESSION['user_id'];

		try {
			$cartGroupedBySeller = [];
			foreach ($_SESSION['cart'] as $articleId => $item) {
				$cartGroupedBySeller[$item['idSeller']][] = ['id' => $articleId, 'name' => $item['name'], 'artist' => $item['artist'], 'price' => $item['price'], 'quantity' => $item['quantity']];
			}
	
			$orderIds = [];
			foreach ($cartGroupedBySeller as $idSeller => $articles) {
				$orderId = WooHooDB::insertOrder([
					"idCustomer" => $idCustomer,
					"idSeller" => $idSeller,
				]);
				$orderIds[] = $orderId;

				foreach ($articles as $article) {
					WooHooDB::insertOrderArticle([
						"idOrder" => $orderId,
						"idArticle" => $article['id'],
					]);
				}
			}

			unset($_SESSION['cart']);
	
			echo ViewHelper::renderJSON(["orderIds" => $orderIds], 201);
		} catch (Exception $e) {
			echo ViewHelper::renderJSON("An error occurred: " . $e->getMessage(), 500);
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