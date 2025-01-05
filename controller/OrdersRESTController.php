<?php

require_once("model/WooHooDB.php");
require_once("controller/OrdersController.php");
require_once("ViewHelper.php");

class OrdersRESTController {

    public static function get($userId, $id) {
        try {
            $orders = WooHooDB::getAllOrders($userId);
            $groupedOrders = [];

            foreach ($orders as $order) {
                if ($order['orderId'] == $id) {
                    if (!isset($groupedOrders[$order['orderId']])) {
                        $groupedOrders[$order['orderId']] = [
                            'orderId' => $order['orderId'],
                            'status' => $order['status'],
                            'price' => $order['price'],
                            'idSeller' => $order['idSeller'],
                            'sellerName' => $order['sellerName'],
                            'sellerSurname' => $order['sellerSurname'],
                            'articles' => []
                        ];
                    }

                    $groupedOrders[$order['orderId']]['articles'][] = [
                        'articleId' => $order['articleId'],
                        'name' => $order['articleName'],
                        'artist' => $order['articleArtist'],
                        'price' => $order['articlePrice']
                    ];
                }
            }

            if (!empty($groupedOrders)) {
                echo ViewHelper::renderJSON(['groupedOrders' => $groupedOrders]);
            } else {
                echo ViewHelper::renderJSON(['message' => 'Order not found']);
            }
        } catch (Exception $ex) {
            echo ViewHelper::renderJSON(['error' => 'An error occurred']);
        }
    }

    public static function index($userId) {
        try {
            $orders = WooHooDB::getAllOrders($userId);
            $groupedOrders = [];

            foreach ($orders as $order) {
                if (!isset($groupedOrders[$order['orderId']])) {
                    $groupedOrders[$order['orderId']] = [
                        'orderId' => $order['orderId'],
                        'status' => $order['status'],
                        'price' => $order['price'],
                        'idSeller' => $order['idSeller'],
                        'sellerName' => $order['sellerName'],
                        'sellerSurname' => $order['sellerSurname'],
                        'articles' => []
                    ];
                }

                $groupedOrders[$order['orderId']]['articles'][] = [
                    'articleId' => $order['articleId'],
                    'name' => $order['articleName'],
                    'artist' => $order['articleArtist'],
                    'price' => $order['articlePrice']
                ];
            }
            echo ViewHelper::renderJSON(['groupedOrders' => $groupedOrders]);
        } catch (Exception $ex) {
            
        }
    }

    public static function add($userId) {
        $rawData = file_get_contents('php://input');

        // Decode the raw JSON data into an associative array
        $cartItems = json_decode($rawData, true);

        // Check for JSON decoding errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            die('Invalid JSON data');
        }

        try {
            $cartGroupedBySeller = [];
            foreach ($cartItems as $item) {
                $articleId = $item['articleId'];
                $quantity = $item['quantity'];

                // Fetch the article record by articleId
                $article = WooHooDB::getRecord(['id' => $articleId]);

                // Group items by seller
                $cartGroupedBySeller[$article['idSeller']][] = [
                    'id' => $articleId,
                    'name' => $article['name'],
                    'artist' => $article['artist'],
                    'price' => $article['price'],
                    'quantity' => $quantity
                ];

                echo "Article ID: $articleId, Quantity: $quantity\n";
            }

            $orderIds = [];
            foreach ($cartGroupedBySeller as $idSeller => $articles) {
                $totalPrice = 0;
                foreach ($articles as $article) {
                    $totalPrice += $article['price'] * $article['quantity'];
                }

                // Insert the order and get the order ID
                $orderId = WooHooDB::insertOrder([
                    "price" => $totalPrice,
                    "idCustomer" => $userId,
                    "idSeller" => $idSeller
                ]);
                $orderIds[] = $orderId;

                // Insert each article into the order
                foreach ($articles as $article) {
                    for ($i = 0; $i < $article['quantity']; $i++) {
                        WooHooDB::insertOrderArticle([
                            "idOrder" => $orderId,
                            "idArticle" => $article['id'],
                        ]);
                    }
                }
            }

            // Respond based on whether any orders were created
            if (empty($cartGroupedBySeller)) {
                echo ViewHelper::renderJSON("Order not made", 300);
            } else {
                echo ViewHelper::renderJSON("Order sent", 200);
            }
        } catch (Exception $e) {
            echo ViewHelper::renderJSON("Order not made", 400);
        }
    }
}