<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Search</title>
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
			<div class="input-group">
				<input type="search" class="form-control" placeholder="Search for an album or artist" />
				<div class="input-group-append">
					<button class="btn btn-primary" type="button">
						<i class="fa-solid fa-magnifying-glass"></i>
					</button>
				</div>
			</div>
		</div>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	</body>
</html>