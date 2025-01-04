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

    public static function add() {
            $idCustomer = $_SESSION['user_id'];

            try {
                    $cartGroupedBySeller = [];
                    foreach ($_SESSION['cart'] as $articleId => $item) {
                            $cartGroupedBySeller[$item['idSeller']][] = ['id' => $item['id'], 'name' => $item['name'], 'artist' => $item['artist'], 'price' => $item['price'], 'quantity' => $item['quantity']];
                    }

                    $orderIds = [];
                    foreach ($cartGroupedBySeller as $idSeller => $articles) {
                            $totalPrice = 0;
                            foreach ($articles as $article) {
                                $totalPrice += $article['price'] * $article['quantity'];
                            }

                            $orderId = WooHooDB::insertOrder([
                                "price" => $totalPrice,
                                "idCustomer" => $idCustomer,
                                "idSeller" => $idSeller
                            ]);
                            $orderIds[] = $orderId;

                            foreach ($articles as $article) {
                                for ($i = 0; $i < $article['quantity']; $i++) {
                                    WooHooDB::insertOrderArticle([
                                            "idOrder" => $orderId,
                                            "idArticle" => $article['id'],
                                    ]);
                                }
                            }
                    }

                    unset($_SESSION['cart']);
                    $_SESSION['cart'] = [];

                    echo ViewHelper::redirect(BASE_URL . 'orders/' . $idCustomer);
            } catch (Exception $e) {
                    echo ViewHelper::renderJSON("An error occurred: " . $e->getMessage(), 500);
            }
    }

    public static function edit($id) {
            $data = filter_input_array(INPUT_POST);

            $data["id"] = $id;
            WooHooDB::updateOrder($data);
            echo ViewHelper::redirect(BASE_URL . 'orders/' . $_SESSION['user_id']);
    }
}
