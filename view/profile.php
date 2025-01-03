<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Profile</title>
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
			<h1>My profile</h1>
			<hr class="solid">
			
			<h3>E-mail</h3>
			<p><?= $email ?></p>

			<h3>Name and surname</h3>
			<p><?= $name ?> <?= $surname ?></p>

                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'Customer'): ?>
                            <h3>Address</h3>
                            <p><?= $address ?> <?= $addressNumber ?>, <?= $postalCode ?></p>
                        <?php endif; ?>
                        
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editProfile">
                            <i class="fa-solid fa-pen-to-square"></i> Edit profile
                        </button>
                        
                        <div id="editProfile" class="modal fade" tabindex="-1" role="form" aria-labelledby="editProfile" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5>Enter your new information</h5>
								<button type="button" class="close" data-bs-dismiss="modal" aria-label="close">
									<span aria-hidden="true"></span>
								</button>
							</div>
	
							<form action="<?= BASE_URL . "profile/" . $id ?>" method="post">
								<input type="hidden" name="id" value="<?= $id ?>" />
								<div class="modal-body">
									<p>
                                                                            <input type="email" name="email" value="<?= $email ?>" placeholder="" required />
                                                                        </p>
                                                                        <p>
                                                                            <input type="text" class="form-control" name="name" value="<?= $name ?>" placeholder="First name" required />
                                                                            <input type="text" class="form-control" name="surname" value="<?= $surname ?>" placeholder="Last name" required />
                                                                        </p>
                                                                        <p>
                                                                            <input type="text" class="form-control" name="address" value="<?= $address ?>" placeholder="Street name" required />
                                                                            <input type="number" class="form-control" name="addressNumber" value="<?= $addressNumber ?>" placeholder="House number"required />
                                                                            <input type="number" class="form-control" name="postalCode" value="<?= $postalCode ?>" placeholder="Postcode" required />
									</p>
								</div>
		
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
									<button type="submit" class="btn btn-primary">Submit</button>
								</div>
							</form>
						</div>
					</div>
                        </div>
                        
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editPassword">
				<i class="fa-solid fa-pen-to-square"></i> Change password
			</button>

                        <div id="editPassword" class="modal fade" tabindex="-1" role="form" aria-labelledby="editPassword" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                                <div class="modal-header">
                                                        <h5>Enter your new password</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="close">
                                                                <span aria-hidden="true"></span>
                                                        </button>
                                                </div>

                                                <form action="<?= BASE_URL . "changepassword/" . $id ?>" method="post">
                                                        <input type="hidden" name="id" value="<?= $id ?>" />
                                                        <div class="modal-body">
                                                                <p>
                                                                        <input type="password" name="password" value="<?= isset($password) ? $password : '' ?>" placeholder="" required />
                                                                </p>
                                                        </div>

                                                        <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                        </div>
                                                </form>
                                        </div>
                                </div>
                        </div>
                        
                        <form action="<?= BASE_URL . "logout" ?>" method="get" >
                            <button id="logoutbtn" type="submit" class="btn btn-primary">
                                Log out
                            </button>
                        </form>
		</div>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	</body>
</html>