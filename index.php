<?php
session_start();

require_once("controller/RecordsController.php");
require_once("controller/RecordsRESTController.php");
require_once("controller/OrdersController.php");
require_once("controller/OrdersRESTController.php");
require_once("controller/ProfileController.php");
require_once("controller/ProfileRESTController.php");
require_once("controller/CartController.php");
require_once("controller/CartRESTController.php");

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
			default:
				RecordsController::get($id);
				break;
		}
	},
        "/^rate\/(\d+)$/" => function ($method, $id) {
		RecordsController::rate($id);
	},
        "/^records\/toggle\/(\d+)$/" => function ($method, $id) {
            RecordsController::delete($id);
	},
        "/^search$/" => function ($method) {
            switch ($method) {
                    case "POST":
                            RecordsController::search();
                            break;
                    default:
                            echo ViewHelper::render("view/search.php");
                            break;
		}
        },
	"/^cart$/" => function ($method) {
            if (isset($_SESSION['user_id'])) {
                switch ($method) {
                    case "POST":
                        CartController::add();
                        break;
                    default:
                        CartController::index();
                        break;
                }
            } else {
                ViewHelper::redirect(BASE_URL . "profile");
            }
        },
        "/^cart\/add\/(\d+)$/" => function ($method, $id) {
            if ($method == "POST") {
                CartController::increase($id);
            }
        },
        "/^cart\/delete\/(\d+)$/" => function ($method, $id) {
            if ($method == "POST") {
                CartController::delete($id);
            }
        },
        "/^orders$/" => function () {
            if (isset($_SESSION['user_id'])) {
                ViewHelper::redirect(BASE_URL . "orders/" . $_SESSION['user_id']);
            } else {
                ViewHelper::redirect(BASE_URL . "profile");
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
			default:
				OrdersController::get($id);
				break;
		}
	},
	"/^profile$/" => function ($method) {
		switch ($method) {
			case "POST":
				ProfileController::add();
				break;
			default:
				if (isset($_SESSION['user_id'])) {
                                    ViewHelper::redirect(BASE_URL . "profile/" . $_SESSION['user_id']);
                                } else {
                                    ProfileController::index();
                                }
				break;
		}
	},
        "/^changepassword\/(\d+)$/" => function ($method, $id) {
            ProfileController::changePassword($id);
        },
        "/^login$/" => function () {
            ProfileController::login();
        },
        "/^logout$/" => function () {
            ProfileController::logout();
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
        "/^users$/" => function ($method) {
            switch ($method) {
                case "POST":
                    ProfileController::editSeller();
                    break;
                default:
                    ProfileController::getSellers();
                    break;
            }
        },
        #REST API
        "/^api\/records\/(\d+)$/" => function ($method, $id) {
            RecordsRESTController::get($id);
        },
        "/^api\/records$/" => function ($method) {
            switch ($method) {
                case "POST":
                    RecordsRESTController::add();
                    break;
                default: // GET
                    RecordsRESTController::index();
                    break;
            }
        },
        "/^api\/login$/" => function ($method) {
            ProfileRESTController::login();
        },
        "/^api\/profile\/(\d+)$/" => function ($method, $id) {
            switch ($method) {
                case "POST":
                    ProfileRESTController::edit($id);
                    break;
                default:
                    ProfileRESTController::get($id);
                    break;
            }
	},
        "/^api\/orders\/(\d+)$/"=> function ($method, $userId) {
            switch ($method) {
                case "POST":
                    //echo ViewHelper::renderJSON("Invalid email or password.", 400);
                    OrdersRESTController::add($userId);
                    break;
                default:
                    OrdersRESTController::index($userId);
                    break;
            }
	},
        "/^api\/orders\/(\d+)\/(\d+)$/" => function ($method, $userId, $id) {
            OrdersRESTController::get($userId, $id);
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