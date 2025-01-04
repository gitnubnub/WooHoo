<?php

require_once("model/WooHooDB.php");
require_once("controller/CartController.php");
require_once("ViewHelper.php");

class CartRESTController {

    public static function add() {

        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = [];
        }

        $item = [
            "id" => $_POST["id"],
            "name" => $_POST["name"],
            "artist"=> $_POST["artist"],
            "price" => $_POST["price"],
            "idSeller" => $_POST["idSeller"],
            "quantity" => 1,
        ];

        // Check if the item already exists
        $exists = false;
        foreach ($_SESSION["cart"] as &$cartItem) {
            if ($cartItem["id"] == $item["id"]) {
                $cartItem["quantity"] += $item["quantity"];
                $exists = true;
                break;
            }
        }

        if (!$exists) {
            $_SESSION["cart"][] = $item;
        }

        echo ViewHelper::redirect(BASE_URL . "cart/");
    }

    public static function index() {
        echo ViewHelper::render("view/cart.php", ['cart' => $_SESSION['cart']]);
    }

    public static function increase($id) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
            echo ViewHelper::render("view/cart.php", ['cart' => $_SESSION['cart']]);
        }
    }
    
    public static function delete($id) {
        if (isset($_SESSION['cart'][$id])) {
			$_SESSION['cart'][$id]['quantity']--;
	
			if ($_SESSION['cart'][$id]['quantity'] <= 0) {
				unset($_SESSION['cart'][$id]);
			}
	
			echo ViewHelper::render("view/cart.php", ['cart' => $_SESSION['cart']]);
		}
    }
}
