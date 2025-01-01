<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>WooHoo Vinyl Store</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "styles.css" ?>">
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
			<h1>WooHoo Vinyl Store</h1>
			<hr class="solid">
			<p>Have a look at what our sellers have to offer and browse for your most desired titles.</p>

			<div class="row">
				<?php foreach ($records as $article): ?>
					<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
						<div class="card">
							<div class="article-text">
								<a id="detailed" href="<?= BASE_URL . "records/" . $article["id"] ?>">
									<h4><?= $article["name"] ?></h4>
								</a>
								<h5><?= $article["artist"] ?></h5>
								<p><?= $article["price"] ?></p>
							</div>

							<div class="card-footer">
								<form action="<?= BASE_URL . "cart" ?>" method="post" style="display: inline;">
                                                                    <input type="hidden" name="id" value="<?= $article['id'] ?>">
                                                                    <input type="hidden" name="name" value="<?= htmlspecialchars($article['name'], ENT_QUOTES) ?>">
                                                                    <input type="hidden" name="artist" value="<?= htmlspecialchars($article['artist'], ENT_QUOTES) ?>">
                                                                    <input type="hidden" name="price" value="<?= $article['price'] ?>">
                                                                    <input type="hidden" name="idSeller" value="<?= $article['idSeller'] ?>">
                                                                    <button id="cartbtn" type="submit" class="btn btn-primary">
                                                                        <i class="fa-solid fa-cart-shopping"></i>
                                                                    </button>
                                                                </form>

							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<button id="addbtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRecord">
					<i class="fa-solid fa-plus"></i>
				</button>

				<div class="modal fade" tabindex="-1" role="form" aria-labelledby="addRecord" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5>Enter information about the record</h5>
								<button type="button" class="close" data-bs-dismiss="modal" aria-label="close">
									<span aria-hidden="true"></span>
								</button>
							</div>
	
							<form action="<?= BASE_URL . "records" ?>" method="post">
								<div class="modal-body">
									<p>
										<input type="text" class="form-control" name="name" value="<?= $name ?>" placeholder="Album title" required />
										<input type="text" class="form-control" name="description" value="<?= $description ?>" placeholder="Album description" required />
										<input type="text" class="form-control" name="artist" value="<?= $artist ?>" placeholder="Album artist" required />
										<input type="number" class="form-control" name="releaseYear" value="<?= $releaseYear ?>" placeholder="Year of release" required />
										<input type="number" class="form-control" name="price" value="<?= $price ?>" placeholder="Price" required />
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

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	</body>
</html>