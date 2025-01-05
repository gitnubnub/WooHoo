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
                    <form action="<?= BASE_URL . "search" ?>" method="post">
			<div class="input-group">                            
				<input type="search" class="form-control" name="searchTerm" placeholder="Search for an album or artist" />
				<div class="input-group-append">
					<button class="btn btn-primary" type="submit">
						<i class="fa-solid fa-magnifying-glass"></i>
					</button>
				</div>                            
			</div>
                    </form>
                    
                        <?php if (isset($results)): ?>
                            <?php foreach ($results as $article): ?>
                                        <div class="card">
                                                <div class="article-text">
                                                        <a id="detailed" href="<?= BASE_URL . "records/" . $article["id"] ?>">
                                                                <h4><?= $article["name"] ?></h4>
                                                        </a>
                                                        <h5><?= $article["artist"] ?></h5>
                                                        <p><?= $article["price"] ?> €</p>
                                                </div>

                                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'Customer'): ?>
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
                                            <?php endif; ?>
                                        </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="margin: 10px">No results for the given search term.
                        <?php endif; ?>
                </div>
		
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	</body>
</html>