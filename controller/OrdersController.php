<?php

require_once("model/WooHooDB.php");
require_once("ViewHelper.php");

class OrdersController {
	public static function get($id) {
		echo ViewHelper::render("", WooHooDB::getOrder(["id" => $id]));
	}

	public static function index($userId) {
		echo ViewHelper::render("view/orders.php", ["orders" => WooHooDB::getAllOrders($userId)]);
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
	
			echo ViewHelper::redirect(BASE_URL . 'orders/' . $idCustomer);
		} catch (Exception $e) {
			echo ViewHelper::renderJSON("An error occurred: " . $e->getMessage(), 500);
		}
	}

	public static function edit($id) {
		$data = filter_input_array(INPUT_POST, self::getRules());

		if (self::checkValues($data)) {
			$data["id"] = $id;
			WooHooDB::updateOrder($data);
			echo ViewHelper::redirect(BASE_URL . 'orders/' . $_SESSION['user_id']);
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