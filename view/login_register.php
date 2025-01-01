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
					<a class="nav-link" href="<?= BASE_URL . "home" ?>">
						<i class="fa-solid fa-house"></i>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?= BASE_URL . "search" ?>">
						<i class="fa-solid fa-magnifying-glass"></i>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?= BASE_URL . "cart" ?>">
						<i class="fa-solid fa-cart-shopping"></i>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?= BASE_URL . "orders" ?>">
						<i class="fa-solid fa-file-invoice"></i>
					</a>
				</li>
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
								<input type="email" class="form-control" name="email" value="<?= $email ?>" placeholder="" required /><br>
								<label class="form-label">Password</label><br>
								<input type="password" class="form-control" name="password" value="<?= $password ?>" placeholder="" required /><br>
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
			
						<form action="<?= BASE_URL . "register" ?>">
							<div class="card-body">
								<label class="form-label">E-mail</label><br>
								<input type="email" class="form-control" name="email" value="<?= $email ?>" placeholder="" required /><br>
							
								<label class="form-label">Password</label><br>
								<input type="password" class="form-control" name="password" value="<?= $password ?>" placeholder="" required /><br>

								<label class="form-label">Full name</label>
								<input type="text" class="form-control" name="name" value="<?= $name ?>" placeholder="First name" required />
								<input type="text" class="form-control" name="surname" value="<?= $surname ?>" placeholder="Last name" required /><br>

								<label class="form-label">Address</label><br>
								<input type="text" class="form-control" name="street" value="<?= $address ?>" placeholder="Street name" required />
								<input type="number" class="form-control" name="streetNo" value="<?= $addressNumber ?>" placeholder="House number"required />
								<input type="number" class="form-control" name="postcode" value="<?= $postalCode ?>" placeholder="Postcode" required /><br>
							
								<label class="form-label">I'm a ...</label><br>
								<input type="radio" class="form-check-input" id="customer" name="role" value="customer" required>
								<label class="form-check-label" for="customer">customer</label><br>
								<input type="radio" class="form-check-input" id="seller" name="role" value="seller" required>
								<label class="form-check-label" for="seller">seller</label>
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