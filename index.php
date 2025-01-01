<?php
session_start();

require_once("controller/RecordsController.php");
require_once("controller/OrdersController.php");
require_once("controller/ProfileController.php");

define("BASE_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php"));
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php"));

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$urls = [
	"/^api\/records$/"=> function ($method) {
		switch ($method) {
			case "POST":
				RecordsController::add();
				break;
			default:
				RecordsController::index();
				break;
		}
	},
	"/^api\/records\/(\d+)$/" => function ($method, $id) {
		switch ($method) {
			case "PUT":
				RecordsController::edit($id);
				break;
			case "DELETE":
				RecordsController::delete($id);
				break;
			default:
				RecordsController::get($id);
				break;
		}
	},
	"/^api\/orders\/(\d+)$/"=> function ($method, $userId) {
		switch ($method) {
			case "POST":
				OrdersController::add();
				break;
			default:
				OrdersController::index($userId);
				break;
		}
	},
	"/^api\/orders\/(\d+)\/(\d+)$/" => function ($method, $userId, $id) {
		switch ($method) {
			case "PUT":
				OrdersController::edit($id);
				break;
			case "DELETE":
				OrdersController::delete($id);
				break;
			default:
				OrdersController::get($id);
				break;
		}
	},
	"/^api\/profile$/"=> function ($method) {
		switch ($method) {
			case "POST":
				ProfileController::add();
				break;
			default:
				ProfileController::index();
				break;
		}
	},
	"/^api\/profile\/(\d+)$/" => function ($method, $id) {
		switch ($method) {
			case "PUT":
				ProfileController::edit($id);
				break;
			case "DELETE":
				ProfileController::delete($id);
				break;
			default:
				ProfileController::get($id);
				break;
		}
	},
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