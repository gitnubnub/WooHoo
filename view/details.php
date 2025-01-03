<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Details</title>
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
				<div class="col-md-9">
					<h1><?= $name ?></h1>
					<h3><?= $artist ?></h3>
					<p><?= $description ?></p>
					<h6>Released: <?= $releaseYear ?></h6>
				</div>

				<div class="col-md-3">
					<div class="card">
						<div id="ratingcard">
							<h2><?= $price ?> €</h2>
							<p>
								<?= $rating ?> average based on <?= $numberOfRatings ?> reviews.
							</p>
			
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star"></span>
						</div>
                                                
                                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'Customer'): ?>
						<div class="card-footer">
							<form action="<?= BASE_URL . "cart" ?>" method="post" style="display: inline;">
								<input type="hidden" name="id" value="<?= $id ?>">
								<input type="hidden" name="name" value="<?= htmlspecialchars($name, ENT_QUOTES) ?>">
								<input type="hidden" name="artist" value="<?= htmlspecialchars($artist, ENT_QUOTES) ?>">
								<input type="hidden" name="price" value="<?= $price ?>">
								<input type="hidden" name="idSeller" value="<?= $idSeller ?>">
								<button id="cartbtn" type="submit" class="btn btn-primary">
									<i class="fa-solid fa-cart-shopping"></i>
								</button>
							</form>
						</div>
                                            <?php endif; ?>
					</div>
				</div>
			</div>
                    
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'Seller'): ?>
                           <p>This article is
                                <?php if ($isActive == TRUE): ?>
                                    active.
                                <?php else: ?>
                                    deactivated.
                                <?php endif; ?>
                            </p>
                            
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editDetails">
                                <i class="fa-solid fa-pen-to-square"></i> Edit details
                            </button>

                            <div id="editDetails" class="modal fade" tabindex="-1" role="form" aria-labelledby="editProfile" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                                <div class="modal-header">
                                                        <h5>Enter new information</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="close">
                                                                <span aria-hidden="true"></span>
                                                        </button>
                                                </div>

                                                <form action="<?= BASE_URL . "records/" . $id ?>" method="post">
                                                        <input type="hidden" name="id" value="<?= $id ?>" />
                                                        <div class="modal-body">
                                                            <p>
                                                                <input type="text" class="form-control" name="name" value="<?= $name ?>" placeholder="Album title" required />
                                                                <input type="text" class="form-control" name="artist" value="<?= $artist ?>" placeholder="Album artist" required />
                                                            </p>

                                                            <p>
                                                                <input type="text" class="form-control" name="description" value="<?= $description ?>" placeholder="Album description" required />
                                                            </p>

                                                            <p>
                                                                <input type="number" class="form-control" name="releaseYear" value="<?= $releaseYear ?>" placeholder="Year of release" required />
                                                            </p>
                                                            <p>
                                                                <input type="number" class="form-control" name="price" value="<?= $price ?>" placeholder="Price" step="0.01" required />
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
                    
                            <form action="<?= BASE_URL . "records/toggle/" . $id ?>" method="post" style="display: inline;">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <input type="hidden" name="isActive" value="<?= $isActive ?>">
                                    <?php if ($isActive == TRUE): ?>
                                        <button type="submit" class="btn btn-primary">
                                            Deactivate article
                                        </button>
                                    <?php else: ?>
                                        <button type="submit" class="btn btn-primary">
                                            Activate article
                                        </button>
                                    <?php endif; ?>                                    
                            </form>
                    <?php endif; ?>
		</div>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	</body>
</html>