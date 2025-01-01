<?php

class CartController {
    public static function add() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = [];
        }

        $item = [
            "id" => $data["id"],
            "name" => $data["name"],
			"artist"=> $data["artist"],
            "price" => $data["price"],
			"idSeller" => $data["idSeller"],
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

        echo ViewHelper::renderJSON(['message' => 'Item added to cart', 'cart' => $_SESSION['cart']]);
    }

    public static function index() {
        echo ViewHelper::render("view/cart.php", ['cart' => $_SESSION['cart']]);
    }

    public static function delete($id) {
        if (isset($_SESSION['cart'][$id])) {
			$_SESSION['cart'][$id]['quantity']--;
	
			if ($_SESSION['cart'][$id]['quantity'] <= 0) {
				unset($_SESSION['cart'][$id]);
			}
	
			echo ViewHelper::renderJSON([
				'message' => 'Item quantity reduced or removed from cart',
				'cart' => $_SESSION['cart']
			]);
		} else {
			echo ViewHelper::renderJSON(['error' => 'Item not found in cart'], 404);
		}
    }
}
