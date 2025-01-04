<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Certificate authorization</title>
    </head>
    <body>
        <?php
        
        $email = $_SESSION['login_email'] ?? null;
        $role = $_SESSION['login_role'] ?? null;

        if ($email && $role) {
            $client_cert = filter_input(INPUT_SERVER, "SSL_CLIENT_CERT");
            $cert_data = openssl_x509_parse($client_cert);

            if ($cert_data['subject']['emailAddress'] === $email) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $role;
                $_SESSION["cart"] = [];
                unset($_SESSION['login_email'], $_SESSION['login_role']);
                echo ViewHelper::redirect(BASE_URL . "profile/" . $user['id']);
            } else {
                echo ViewHelper::render("view/login_register.php", ["error" => "Invalid certificate."]);
            }
        } else {
            echo ViewHelper::render("view/login_register.php", ["error" => "Missing session data."]);
        }

        ?>
    </body>
</html>