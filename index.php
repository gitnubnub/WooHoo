<?php
session_start();

require_once("controller/RecordsController.php");
require_once("controller/OrdersController.php");
require_once("controller/ProfileController.php");

define("BASE_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php"));
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$urls = [
	"/^$/"=> function () {
		ViewHelper::redirect(BASE_URL . "records");
	},
	"/^records$/"=> function ($method) {
		if ($method == "POST") {
			RecordsController::add();
		} else {
			RecordsController::index();
		}
	},
	"/^records\/(\d+)$/" => function ($method, $id) {
		switch ($method) {
			case "POST":
				RecordsController::edit($id);
				break;
			case "PUT":
				RecordsController::delete($id);
				break;
			default:
				RecordsController::get($id);
				break;
		}
	},
	"/^cart$/" => function ($method) {
        switch ($method) {
            case "POST":
                CartController::add();
                break;
            default:
                CartController::index();
                break;
        }
    },
    "/^api\/cart\/(\d+)$/" => function ($method, $id) {
        if ($method == "DELETE") {
			CartController::delete($id);
        }
    },
	"/^orders\/(\d+)$/"=> function ($method, $userId) {
		switch ($method) {
			case "POST":
				OrdersController::add();
				break;
			default:
				OrdersController::index($userId);
				break;
		}
	},
	"/^orders\/(\d+)\/(\d+)$/" => function ($method, $userId, $id) {
		switch ($method) {
			case "POST":
				OrdersController::edit($id);
				break;
			case "PUT":
				OrdersController::delete($id);
				break;
			default:
				OrdersController::get($id);
				break;
		}
	},
	"/^profile$/"=> function ($method) {
		switch ($method) {
			case "POST":
				ProfileController::add();
				break;
			default:
				ProfileController::index();
				break;
		}
	},
	"/^profile\/(\d+)$/" => function ($method, $id) {
		switch ($method) {
			case "POST":
				ProfileController::edit($id);
				break;
			case "PUT":
				ProfileController::delete($id);
				break;
			default:
				ProfileController::get($id);
				break;
		}
	},
	"/^.*$/" => function () {
		echo "Unmatched path: " . $_SERVER["REQUEST_URI"];
		exit;
	}
];

foreach ($urls as $pattern => $controller) {
	if (preg_match($pattern, $path, $params)) {
		try {
			$params[0] = $_SERVER["REQUEST_METHOD"];
			$controller(...$params);
		} catch (InvalidArgumentException $e) {
			ViewHelper::error404();
		} catch (Exception $e) {
			ViewHelper::displayError($e, true);
		}

		exit();
	}
}

ViewHelper::displayError(new InvalidArgumentException("No controller matched."), true);