<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Log in or register</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "styles.css" ?>"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
	</head>

	<body>
		<nav id="pagenav" class="navbar sticky-top justify-content-center">
			<ul class="nav nav-pills">
				<li class="nav-item">
					<a class="nav-link" href="<?= BASE_URL . "records" ?>">
						<i class="fa-solid fa-house"></i>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?= BASE_URL . "search" ?>">
						<i class="fa-solid fa-magnifying-glass"></i>
					</a>
				</li>
				
                                <?php if (!isset($_SESSION['role']) || $_SESSION['role'] == 'Customer'): ?>
                                    <li class="nav-item">
                                            <a class="nav-link" href="<?= BASE_URL . "cart" ?>">
                                                    <i class="fa-solid fa-cart-shopping"></i>
                                            </a>
                                    </li>
                                <?php endif; ?>
                                    
				<?php if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin'): ?>
                                    <li class="nav-item">
                                            <a class="nav-link" href="<?= BASE_URL . "orders" ?>">
                                                    <i class="fa-solid fa-file-invoice"></i>
                                            </a>
                                    </li>
                                <?php endif; ?>
                                        
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'): ?>
                                    <li class="nav-item">
                                            <a class="nav-link" href="<?= BASE_URL . "users" ?>">
                                                    <i class="fa-solid fa-users"></i>
                                            </a>
                                    </li>
                                <?php endif; ?>
                                    
				<li class="nav-item">
					<a class="nav-link" href="<?= BASE_URL . "profile" ?>">
						<i class="fa-solid fa-user"></i>
					</a>
				</li>
			</ul>
		</nav>
		
		<div id="content">
			<div class="row">
				<div class="col-sm-12 col-md-6">
					<div class="card">
						<div class="card-header">
							LOG INTO AN EXISTING ACCOUNT
						</div>
			
						<form action="<?= BASE_URL . "login" ?>" method="post">
							<div class="card-body">
								<label class="form-label">E-mail</label><br>
								<input type="email" class="form-control" name="email" value="<?= isset($email) ? $email : '' ?>" placeholder="" required /><br>
								<label class="form-label">Password</label><br>
								<input type="password" class="form-control" name="password" value="<?= isset($password) ? $password : '' ?>" placeholder="" required /><br>
							</div>
							
							<div class="card-footer">
								<button class="btn btn-primary" type="submit">Submit</button>
							</div>
						</form>
					</div>
				</div>

				<div class="col-sm-12 col-md-6">
					<div class="card">
						<div class="card-header">
							CREATE A NEW ACCOUNT
						</div>
			
						<form action="<?= BASE_URL . "profile" ?>" method="post">
							<div class="card-body">
								<label class="form-label">E-mail</label><br>
								<input type="email" class="form-control" name="email" value="<?= isset($email) ? $email : '' ?>" placeholder="" required /><br>
							
								<label class="form-label">Password</label><br>
								<input type="password" class="form-control" name="password" value="<?= isset($password) ? $password : '' ?>" placeholder="" required /><br>

								<label class="form-label">Full name</label>
								<input type="text" class="form-control" name="name" value="<?= isset($name) ? $name : '' ?>" placeholder="First name" required />
								<input type="text" class="form-control" name="surname" value="<?= isset($surname) ? $surname : '' ?>" placeholder="Last name" required /><br>

								<label class="form-label">Address</label><br>
								<input type="text" class="form-control" name="address" value="<?= isset($address) ? $address : '' ?>" placeholder="Street name" required />
								<input type="text" class="form-control" name="addressNumber" value="<?= isset($addressNumber) ? $addressNumber : '' ?>" placeholder="House number"required />
								<input type="number" class="form-control" name="postalCode" value="<?= isset($postalCode) ? $postalCode : '' ?>" placeholder="Postcode" required /><br>
                                                                                                                                
                                                                <label for="captcha">Please enter the CAPTCHA text</label><br>
                                                                <img src="captcha.php"><br>
                                                                <input type="text" name="captcha" value="<?= isset($captcha) ? $captcha : '' ?>" required />
							</div>
							
							<div class="card-footer">
								<button class="btn btn-primary" type="submit">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

	</body>
</html>