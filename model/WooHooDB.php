<?php

require_once 'model/AbstractDB.php';

class WooHooDB extends AbstractDB {

	public static function insertRecord(array $params) {
		return parent::modify("INSERT INTO articles (name, description, artist, releaseYear, price, idSeller) "
			. "VALUES (:name, :description, :artist, :releaseYear, :price, :idSeller)", $params);
	}

	public static function insertOrder(array $params) {
		return parent::modify("INSERT INTO orders (status, price, idCustomer, idSeller) "
			. "VALUES ('unprocessed', :price, :idCustomer, :idSeller)", $params);
	}

	public static function insertOrderArticle(array $params) {
		return parent::modify("INSERT INTO ordersArticles (idOrder, idArticle) VALUES (:idOrder, :idArticle)", $params);
	}

	public static function insertProfile(array $params) {
            return parent::modify("INSERT INTO users (name, surname, address, addressNumber, postalCode, email, role, hash, salt) "
                . "VALUES (:name, :surname, :address, :addressNumber, :postalCode, :email, :role, :hash, :salt)", $params);
        }

	public static function updateRecord(array $params) {
		return parent::modify("UPDATE articles SET name = :name, artist = :artist, description = :description, releaseYear = :releaseYear, "
			. "price = :price WHERE id = :id", $params);
	}
        
        public static function updateRating(array $params) {
		return parent::modify("UPDATE articles SET rating = :rating, numberOfRatings = :numberOfRatings WHERE id = :id", $params);
	}

	public static function updateOrder(array $params) {
		return parent::modify("UPDATE orders SET status = :status WHERE id = :id", $params);
	}

	public static function updateProfile(array $params) {
		return parent::modify("UPDATE users SET  email = :email, name = :name, surname = :surname, address = :address, addressNumber = :addressNumber, "
			. "postalCode = :postalCode WHERE id = :id", $params);
	}
        
        public static function updateSeller(array $params) {
		return parent::modify("UPDATE users SET  name = :name, surname = :surname, isActive = :isActive WHERE id = :id", $params);
	}
        
        public static function updatePassword(array $params) {
            return parent::modify("UPDATE users SET hash = :hash, salt = :salt WHERE id = :id", $params);
        }

	public static function deactivateRecord(array $params) {
		return parent::modify("UPDATE articles SET isActive = :isActive WHERE id = :id", $params);
	}

	public static function deleteProfile(array $id) {
		return parent::modify("DELETE FROM users WHERE id = :id", $id);
	}

	public static function getRecord(array $id) {
		$records = parent::query("SELECT id, name, description, artist, releaseYear, rating, numberOfRatings, price, isActive, idSeller "
			. "FROM articles WHERE id = :id", $id);
		
		if (count($records) == 1) {
			return $records[0];
		} else {
			throw new InvalidArgumentException("No such record");
		}
	}

	public static function getOrder(array $id) {
		$orders = parent::query("SELECT id, status, idCustomer, idSeller FROM orders WHERE id = :id", $id);
		
		if (count($orders) == 1) {
			return $orders[0];
		} else {
			throw new InvalidArgumentException("No such order");
		}
	}

	public static function getProfile(array $id) {
		$records = parent::query("SELECT id, name, surname, address, addressNumber, postalCode, email, role "
			. "FROM users WHERE id = :id", $id);
		
		if (count($records) == 1) {
			return $records[0];
		} else {
			throw new InvalidArgumentException("No such record");
		}
	}
        
        public static function getUserByEmail(array $params) {
            $records = parent::query("SELECT id, hash, salt, isActive, role FROM users WHERE email = :email", $params);

            if (count($records) == 1) {
                return $records[0];
            } else {
                return null;
            }
        }

	public static function getAllRecords() {
		return parent::query("SELECT id, name, artist, price, idSeller FROM articles WHERE isActive = TRUE");
	}
        
        public static function getSellers() {
		return parent::query("SELECT id, name, surname, isActive FROM users WHERE role = 'Seller'");
	}
        
        public static function getAllRecordsFromSeller($sellerId) {
		return parent::query("SELECT id, name, artist, price, idSeller, isActive FROM articles WHERE idSeller = :idSeller", ["idSeller" => $sellerId]);
	}
        
        public static function getAllRecordswithURI(array $prefix) {
            return parent::query("SELECT id, name, artist, price, idSeller, "
                            . "          CONCAT(:prefix, id) as uri "
                            . "FROM articles "
                            . "ORDER BY id ASC", $prefix);
        }

	public static function getAllOrders($userId) {
            return parent::query(
                "SELECT 
                    o.id AS orderId, 
                    o.status, 
                    o.price, 
                    o.idSeller, 
                    u.name AS sellerName, 
                    u.surname AS sellerSurname, 
                    a.id AS articleId, 
                    a.name AS articleName, 
                    a.artist AS articleArtist, 
                    a.price AS articlePrice
                 FROM orders o
                 JOIN users u ON o.idSeller = u.id
                 LEFT JOIN ordersArticles oa ON o.id = oa.idOrder
                 LEFT JOIN articles a ON oa.idArticle = a.id
                 WHERE o.idCustomer = :idCustomer",
                ["idCustomer" => $userId]
            );
        }
        
        public static function getAllOrdered($userId) {
		return parent::query(
                    "SELECT 
                        o.id AS orderId, 
                        o.status, 
                        o.price,
                        c.name AS customerName, 
                        c.surname AS customerSurname, 
                        c.address AS customerStreet, 
                        c.addressNumber AS customerNumber, 
                        c.postalCode AS customerPost, 
                        a.id AS articleId, 
                        a.name AS articleName, 
                        a.artist AS articleArtist, 
                        a.price AS articlePrice
                     FROM orders o
                     JOIN users s ON o.idSeller = s.id
                     JOIN users c ON o.idCustomer = c.id
                     LEFT JOIN ordersArticles oa ON o.id = oa.idOrder
                     LEFT JOIN articles a ON oa.idArticle = a.id
                     WHERE o.idSeller = :idSeller",
                    ["idSeller" => $userId]
                );
	}
        
        public static function searchRecords($searchTerm) {
            return parent::query(
                "SELECT id, name, artist, price, idSeller 
                 FROM articles 
                 WHERE isActive = TRUE 
                 AND MATCH(name, artist, description) AGAINST (:searchTerm IN BOOLEAN MODE)", 
                ["searchTerm" => $searchTerm]
            );
        }
}