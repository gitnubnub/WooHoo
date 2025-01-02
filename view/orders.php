<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Orders</title>
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
			<h1>Your orders</h1>
			<hr class="solid">
			
                        <?php if (!empty($groupedOrders)): ?>
                            <h3>Unprocessed orders</h3>
                            <?php foreach ($groupedOrders as $order): ?>
                                <?php if ($order['status'] == 'unprocessed'): ?>
                                    <div class="card">
                                            <div class="article-text">
                                                    <?php if (!isset($_SESSION['role']) || $_SESSION['role'] == 'Customer'): ?>
                                                        <h6>From: <?= $order["sellerName"] ?> <?= $order["sellerSurname"] ?></h6>
                                                    <?php endif; ?>

                                                    <?php if (!isset($_SESSION['role']) || $_SESSION['role'] == 'Seller'): ?>
                                                        <h6>From: <?= $order["customerName"] ?> <?= $order["customerSurname"] ?></h6>
                                                    <?php endif; ?>
                                                
                                                    <p>Status: <?= $order["status"] ?></p>
                                                    <p id="price"><?= $order["price"] ?> €</p>
                                            </div>

                                            <div class="card-footer">
                                                <button id="cartbtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewDetails<?= $order['orderId'] ?>">
                                                    View details
                                                </button>

                                                <div id="viewDetails<?= $order['orderId'] ?>" class="modal fade" tabindex="-1" aria-labelledby="viewDetails" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                            <h4>Order details</h4>
                                                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="close">
                                                                                    <span aria-hidden="true"></span>
                                                                            </button>
                                                                    </div>
                                                                    
                                                                    <div class="modal-body">
                                                                        <?php if (!isset($_SESSION['role']) || $_SESSION['role'] == 'Customer'): ?>
                                                                            <h5>Seller:</h5>
                                                                            <p><?= $order["sellerName"] ?> <?= $order["sellerSurname"] ?></p>
                                                                        <?php endif; ?>
                                                                        
                                                                        <?php if (!isset($_SESSION['role']) || $_SESSION['role'] == 'Seller'): ?>
                                                                            <h5>Customer:</h5>
                                                                            <p><?= $order["customerName"] ?> <?= $order["customerSurname"] ?></p>
                                                                            <p><?= $order["customerStreet"] ?> <?= $order["customerNumber"] ?>, <?= $order["customerPost"] ?></p>
                                                                        <?php endif; ?>
                                                                        
                                                                        <h5>Status:</h5>
                                                                        <p><?= $order["status"] ?></p>
                                                                        
                                                                        <h5>Articles:</h5>
                                                                        <?php if (!empty($order["articles"])): ?>
                                                                            <ul>
                                                                                <?php foreach ($order["articles"] as $article): ?>
                                                                                    <li>
                                                                                        <b><?= $article["name"] ?></b> by <b><?= $article["artist"] ?></b> - <?= $article["price"] ?> €
                                                                                    </li>
                                                                                <?php endforeach; ?>
                                                                            </ul>
                                                                        <?php else: ?>
                                                                            <p>No articles in this order.</p>
                                                                        <?php endif; ?>
                                                                        
                                                                        <h5>Total price:</h5>
                                                                        <p><?= $order["price"] ?> €</p>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                </div>
                                            </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            
                            <h3>Confirmed orders</h3>
                            <?php foreach ($groupedOrders as $order): ?>
                                <?php if ($order['status'] == 'confirmed'): ?>
                                    <div class="card">
                                            <div class="article-text">
                                                    <?php if (!isset($_SESSION['role']) || $_SESSION['role'] == 'Customer'): ?>
                                                        <h6>From: <?= $order["sellerName"] ?> <?= $order["sellerSurname"] ?></h6>
                                                    <?php endif; ?>

                                                    <?php if (!isset($_SESSION['role']) || $_SESSION['role'] == 'Seller'): ?>
                                                        <h6>From: <?= $order["customerName"] ?> <?= $order["customerSurname"] ?></h6>
                                                    <?php endif; ?>
                                                    
                                                    <p>Status: <?= $order["status"] ?></p>
                                                    <p id="price"><?= $order["price"] ?> €</p>
                                            </div>

                                            <div class="card-footer">
                                                <button id="cartbtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewDetails<?= $order['orderId'] ?>">
                                                    View details
                                                </button>

                                                <div id="viewDetails<?= $order['orderId'] ?>" class="modal fade" tabindex="-1" aria-labelledby="viewDetails" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                            <h4>Order details</h4>
                                                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="close">
                                                                                    <span aria-hidden="true"></span>
                                                                            </button>
                                                                    </div>
                                                                    
                                                                    <div class="modal-body">
                                                                        <?php if (!isset($_SESSION['role']) || $_SESSION['role'] == 'Customer'): ?>
                                                                            <h5>Seller:</h5>
                                                                            <p><?= $order["sellerName"] ?> <?= $order["sellerSurname"] ?></p>
                                                                        <?php endif; ?>
                                                                        
                                                                        <?php if (!isset($_SESSION['role']) || $_SESSION['role'] == 'Seller'): ?>
                                                                            <h5>Customer:</h5>
                                                                            <p><?= $order["customerName"] ?> <?= $order["customerSurname"] ?></p>
                                                                            <p><?= $order["customerStreet"] ?> <?= $order["customerNumber"] ?>, <?= $order["customerPost"] ?></p>
                                                                        <?php endif; ?>
                                                                        
                                                                        <h5>Status:</h5>
                                                                        <p><?= $order["status"] ?></p>
                                                                        
                                                                        <h5>Articles:</h5>
                                                                        <?php if (!empty($order["articles"])): ?>
                                                                            <ul>
                                                                                <?php foreach ($order["articles"] as $article): ?>
                                                                                    <li>
                                                                                        <b><?= $article["name"] ?></b> by <b><?= $article["artist"] ?></b> - <?= $article["price"] ?> €
                                                                                    </li>
                                                                                <?php endforeach; ?>
                                                                            </ul>
                                                                        <?php else: ?>
                                                                            <p>No articles in this order.</p>
                                                                        <?php endif; ?>
                                                                        
                                                                        <h5>Total price:</h5>
                                                                        <p><?= $order["price"] ?> €</p>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                </div>
                                            </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            
                            <h3>Cancelled orders</h3>
                            <?php foreach ($groupedOrders as $order): ?>
                                <?php if ($order['status'] == 'cancelled'): ?>
                                    <div class="card">
                                            <div class="article-text">
                                                    <?php if (!isset($_SESSION['role']) || $_SESSION['role'] == 'Customer'): ?>
                                                        <h6>From: <?= $order["sellerName"] ?> <?= $order["sellerSurname"] ?></h6>
                                                    <?php endif; ?>

                                                    <?php if (!isset($_SESSION['role']) || $_SESSION['role'] == 'Seller'): ?>
                                                        <h6>From: <?= $order["customerName"] ?> <?= $order["customerSurname"] ?></h6>
                                                    <?php endif; ?>
                                                    
                                                    <p>Status: <?= $order["status"] ?></p>
                                                    <p id="price"><?= $order["price"] ?> €</p>
                                            </div>

                                            <div class="card-footer">
                                                <button id="cartbtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewDetails<?= $order['orderId'] ?>">
                                                    View details
                                                </button>

                                                <div id="viewDetails<?= $order['orderId'] ?>" class="modal fade" tabindex="-1" aria-labelledby="viewDetails" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                            <h4>Order details</h4>
                                                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="close">
                                                                                    <span aria-hidden="true"></span>
                                                                            </button>
                                                                    </div>
                                                                    
                                                                    <div class="modal-body">
                                                                        <?php if (!isset($_SESSION['role']) || $_SESSION['role'] == 'Customer'): ?>
                                                                            <h5>Seller:</h5>
                                                                            <p><?= $order["sellerName"] ?> <?= $order["sellerSurname"] ?></p>
                                                                        <?php endif; ?>
                                                                        
                                                                        <?php if (!isset($_SESSION['role']) || $_SESSION['role'] == 'Seller'): ?>
                                                                            <h5>Customer:</h5>
                                                                            <p><?= $order["customerName"] ?> <?= $order["customerSurname"] ?></p>
                                                                            <p><?= $order["customerStreet"] ?> <?= $order["customerNumber"] ?>, <?= $order["customerPost"] ?></p>
                                                                        <?php endif; ?>
                                                                        
                                                                        <h5>Status:</h5>
                                                                        <p><?= $order["status"] ?></p>
                                                                        
                                                                        <h5>Articles:</h5>
                                                                        <?php if (!empty($order["articles"])): ?>
                                                                            <ul>
                                                                                <?php foreach ($order["articles"] as $article): ?>
                                                                                    <li>
                                                                                        <b><?= $article["name"] ?></b> by <b><?= $article["artist"] ?></b> - <?= $article["price"] ?> €
                                                                                    </li>
                                                                                <?php endforeach; ?>
                                                                            </ul>
                                                                        <?php else: ?>
                                                                            <p>No articles in this order.</p>
                                                                        <?php endif; ?>
                                                                        
                                                                        <h5>Total price:</h5>
                                                                        <p><?= $order["price"] ?> €</p>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                </div>
                                            </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            
                            <h3>Reversed orders</h3>
                            <?php foreach ($groupedOrders as $order): ?>
                                <?php if ($order['status'] == 'reserved'): ?>
                                    <div class="card">
                                            <div class="article-text">
                                                    <?php if (!isset($_SESSION['role']) || $_SESSION['role'] == 'Customer'): ?>
                                                        <h6>From: <?= $order["sellerName"] ?> <?= $order["sellerSurname"] ?></h6>
                                                    <?php endif; ?>

                                                    <?php if (!isset($_SESSION['role']) || $_SESSION['role'] == 'Seller'): ?>
                                                        <h6>From: <?= $order["customerName"] ?> <?= $order["customerSurname"] ?></h6>
                                                    <?php endif; ?>
                                                
                                                    <p>Status: <?= $order["status"] ?></p>
                                                    <p id="price"><?= $order["price"] ?> €</p>
                                            </div>

                                            <div class="card-footer">
                                                <button id="cartbtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewDetails<?= $order['orderId'] ?>">
                                                    View details
                                                </button>

                                                <div id="viewDetails<?= $order['orderId'] ?>" class="modal fade" tabindex="-1" aria-labelledby="viewDetails" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                            <h4>Order details</h4>
                                                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="close">
                                                                                    <span aria-hidden="true"></span>
                                                                            </button>
                                                                    </div>
                                                                    
                                                                    <div class="modal-body">
                                                                        <?php if (!isset($_SESSION['role']) || $_SESSION['role'] == 'Customer'): ?>
                                                                            <h5>Seller:</h5>
                                                                            <p><?= $order["sellerName"] ?> <?= $order["sellerSurname"] ?></p>
                                                                        <?php endif; ?>
                                                                        
                                                                        <?php if (!isset($_SESSION['role']) || $_SESSION['role'] == 'Seller'): ?>
                                                                            <h5>Customer:</h5>
                                                                            <p><?= $order["customerName"] ?> <?= $order["customerSurname"] ?></p>
                                                                            <p><?= $order["customerStreet"] ?> <?= $order["customerNumber"] ?>, <?= $order["customerPost"] ?></p>
                                                                        <?php endif; ?>
                                                                        
                                                                        <h5>Status:</h5>
                                                                        <p><?= $order["status"] ?></p>
                                                                        
                                                                        <h5>Articles:</h5>
                                                                        <?php if (!empty($order["articles"])): ?>
                                                                            <ul>
                                                                                <?php foreach ($order["articles"] as $article): ?>
                                                                                    <li>
                                                                                        <b><?= $article["name"] ?></b> by <b><?= $article["artist"] ?></b> - <?= $article["price"] ?> €
                                                                                    </li>
                                                                                <?php endforeach; ?>
                                                                            </ul>
                                                                        <?php else: ?>
                                                                            <p>No articles in this order.</p>
                                                                        <?php endif; ?>
                                                                        
                                                                        <h5>Total price:</h5>
                                                                        <p><?= $order["price"] ?> €</p>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                </div>
                                            </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        
                        <?php else: ?>
				<p>You don't have any orders.</p>
			<?php endif; ?>
		</div>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	</body>
</html>