<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Sellers</title>
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
			<h1>All sellers</h1>
			<hr class="solid">
			
                        <?php if (!empty($sellers)): ?>
                            <?php foreach ($sellers as $seller): ?>
                                    <div class="card">
                                            <div class="article-text">
                                                <h6><?= $seller["name"] ?> <?= $seller["surname"] ?></h6>
                                                
                                                    <p id="cartbtn">This seller is
                                                        <?php if ($seller['isActive'] == TRUE): ?>
                                                            active.
                                                        <?php else: ?>
                                                            deactivated.
                                                        <?php endif; ?>
                                                    </p>
                                            </div>

                                            <div class="card-footer">
                                                <button id="cartbtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewDetails<?= $seller['id'] ?>">
                                                    <i class="fa-solid fa-pen-to-square"></i> Edit details
                                                </button>

                                                <div id="viewDetails<?= $seller['id'] ?>" class="modal fade" tabindex="-1" aria-labelledby="viewDetails" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                            <h4>Seller details</h4>
                                                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="close">
                                                                                    <span aria-hidden="true"></span>
                                                                            </button>
                                                                    </div>
                                                                    
                                                                    <form action="<?= BASE_URL . "users" ?>" method="post">
                                                                            <input type="hidden" name="id" value="<?= $seller['id'] ?>" />
                                                                            <div class="modal-body">
                                                                                    <p>
                                                                                        <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($seller['name']) ?>" placeholder="First name" required />
                                                                                        <input type="text" class="form-control" name="surname" value="<?= htmlspecialchars($seller['surname']) ?>" placeholder="Last name" required />
                                                                                    </p>
                                                                                    <p>
                                                                                        <label class="form-label">Active </label>
                                                                                        <input type="checkbox" name="isActive" value="<?= $seller['isActive'] ?>" <?php if ($seller['isActive'] == TRUE): ?> checked <?php endif; ?> />
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
                                            </div>
                                    </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        
                        <button id="addbtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSeller">
                                <i class="fa-solid fa-plus"></i>
                        </button>

                        <div id="addSeller" class="modal fade" tabindex="-1" role="form" aria-labelledby="addSeller" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                                <div class="modal-header">
                                                        <h5>Enter information about the seller</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="close">
                                                                <span aria-hidden="true"></span>
                                                        </button>
                                                </div>

                                            <form action="<?= BASE_URL . "profile" ?>" method="post">
							<div class="modal-body">
								<label class="form-label">E-mail</label><br>
								<input type="email" class="form-control" name="email" value="<?= isset($email) ? $email : '' ?>" placeholder="" required /><br>
							
								<label class="form-label">Password</label><br>
								<input type="password" class="form-control" name="password" value="<?= isset($password) ? $password : '' ?>" placeholder="" required /><br>

								<label class="form-label">Full name</label>
								<input type="text" class="form-control" name="name" value="<?= isset($name) ? $name : '' ?>" placeholder="First name" required />
								<input type="text" class="form-control" name="surname" value="<?= isset($surname) ? $surname : '' ?>" placeholder="Last name" required /><br>
                                                        </div>
							
                                                        <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                        </div>
                                                </form>
                                        </div>
                                </div>
                        </div>
		</div>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	</body>
</html>