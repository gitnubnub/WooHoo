<?php

require_once("model/WooHooDB.php");
require_once("ViewHelper.php");

class ProfileController {
	public static function get($id) {
		echo ViewHelper::render("view/profile.php", WooHooDB::getProfile(["id" => $id]));
	}
        
        public static function getSellers() {
		echo ViewHelper::render("view/users.php", ["sellers" => WooHooDB::getSellers()]);
	}

	public static function index() {
            echo ViewHelper::render("view/login_register.php");
	}
        
        public static function add() {
            if (isset($_SESSION['role']) && isset($_SESSION['user_id']) && $_SESSION['role'] == 'Admin') {
                $data = filter_input_array(INPUT_POST);

                $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
                $salt = bin2hex(random_bytes(16));
                $hash = password_hash($salt . $password, PASSWORD_DEFAULT);

                $data['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $data['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
                $data['surname'] = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_SPECIAL_CHARS);
                $data['hash'] = $hash;
                $data['salt'] = $salt;
                $data['role'] = 'Seller';
                $data['address'] = 'NULL';
                $data['addressNumber'] = 'NULL';
                $data['postalCode'] = 'NULL';

                $id = WooHooDB::insertProfile($data);
                echo ViewHelper::redirect(BASE_URL . "users");
            } else {
                $data = filter_input_array(INPUT_POST, self::getRules());

                if (self::checkValues($data)) {
                    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
                    $salt = bin2hex(random_bytes(16));
                    $hash = password_hash($salt . $password, PASSWORD_DEFAULT);

                    $data['hash'] = $hash;
                    $data['salt'] = $salt;
                    $data['role'] = 'Customer';

                    $id = WooHooDB::insertProfile($data);
                    $_SESSION['user_id'] = $id;
                    $_SESSION['role'] = $data['role'];
                    $_SESSION["cart"] = [];
                    echo ViewHelper::redirect(BASE_URL . "profile/" . $id);
                }
            }
        }
        
        public static function changePassword($id) {
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

            if (!empty($password)) {
                $salt = bin2hex(random_bytes(16));
                $hash = password_hash($salt . $password, PASSWORD_DEFAULT);

                $data = [
                    'hash' => $hash,
                    'salt' => $salt,
                    'id' => $id
                ];

                WooHooDB::updatePassword($data);
                echo ViewHelper::redirect(BASE_URL . "profile/" . $id);
            }
        }

	public static function edit($id) {
		$data = filter_input_array(INPUT_POST, self::getRules());

		if (self::checkValues($data)) {
			$data["id"] = $id;
			WooHooDB::updateProfile($data);
			ViewHelper::redirect(BASE_URL . "profile/" . $id);
		}
	}
        
        public static function editSeller() {
		$data = filter_input_array(INPUT_POST);
                $data['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
                $data['surname'] = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_SPECIAL_CHARS);

                $data['isActive'] = isset($_POST['isActive']) ? 1 : 0;

                WooHooDB::updateSeller($data);
                ViewHelper::redirect(BASE_URL . "users");
	}
        
        public static function login() {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

            $user = WooHooDB::getUserByEmail(['email' => $email]);

            if ($user && $user['isActive'] == true) {
                $hashedPassword = $user['hash'];
                $salt = $user['salt'];

                if (password_verify($salt . $password, $hashedPassword)) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION["cart"] = [];

                    echo ViewHelper::redirect(BASE_URL . "profile/" . $user['id']);
                } else {
                    echo ViewHelper::render("view/login_register.php", ["error" => "Invalid email or password."]);
                }
            } else {
                echo ViewHelper::render("view/login_register.php", ["error" => "Invalid email or password."]);
            }
        }
        
        public static function logout() {
            session_destroy();
            ViewHelper::redirect(BASE_URL);
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
		return [
			'name' => FILTER_SANITIZE_SPECIAL_CHARS,
			'surname' => FILTER_SANITIZE_SPECIAL_CHARS,
			'address' => FILTER_SANITIZE_SPECIAL_CHARS,
			'addressNumber' => FILTER_VALIDATE_INT,
			'postalCode'=> [
				'filter' => FILTER_VALIDATE_INT,
				'options' => [
					'min_range' => 1000,
					'max_range' => 9265
				]
			],
			'email' => FILTER_VALIDATE_EMAIL
		];
	}
}