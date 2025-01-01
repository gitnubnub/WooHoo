-- Drop the database if it exists
DROP DATABASE IF EXISTS woohoo;
CREATE DATABASE woohoo;
USE woohoo;

-- Table: user
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `surname` VARCHAR(255) NOT NULL,
    `address` VARCHAR(255),
    `addressNumber` VARCHAR(100),
    `postalCode` VARCHAR(20),
    `email` VARCHAR(255) NOT NULL,
    `hash` VARCHAR(255) NOT NULL,
    `salt` VARCHAR(255) NOT NULL,
    `role` ENUM('Admin', 'Seller', 'Customer') NOT NULL
);

-- Table: orders
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `status` ENUM('neobdelano', 'potrjeno', 'preklicano', 'stornirano', 'obdelano') NOT NULL,
    `idCustomer` INT NOT NULL,
    `idSeller` INT NOT NULL,
    FOREIGN KEY (`idCustomer`) REFERENCES `users`(`id`),
    FOREIGN KEY (`idSeller`) REFERENCES `users`(`id`)
);

-- Table: articles
DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `artist` VARCHAR(255) NOT NULL,
    `releaseYear` INT NOT NULL,
    `rating` FLOAT DEFAULT 0.0,
    `numberOfRatings` INT DEFAULT 0,
    `price` FLOAT NOT NULL,
    `idSeller` INT NOT NULL,
    FOREIGN KEY (`idSeller`) REFERENCES `users`(`id`)
);

-- Table: ordersArticles
DROP TABLE IF EXISTS `ordersArticles`;
CREATE TABLE `ordersArticles` (
    `idOrder` INT NOT NULL,
    `idArticle` INT NOT NULL,
    PRIMARY KEY (`idOrder`, `idArticle`),
    FOREIGN KEY (`idOrder`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`idArticle`) REFERENCES `articles`(`id`) ON DELETE CASCADE
);

-- vnosi v tabelo
INSERT INTO `users` (`name`, `surname`, `address`, `addressNumber`, `postalCode`, `email`, `hash`, `salt`, `role`) VALUES ('Jakob', 'Kadivec', NULL, NULL, NULL, 'jk@admin.com', '1', '1', 'Admin');
INSERT INTO `users` (`name`, `surname`, `address`, `addressNumber`, `postalCode`, `email`, `hash`, `salt`, `role`) VALUES ('Mimi', 'Hrastnik', NULL, NULL, NULL, 'mimi@vinyl.net', '2', '2', 'Seller');
INSERT INTO `users` (`name`, `surname`, `address`, `addressNumber`, `postalCode`, `email`, `hash`, `salt`, `role`) VALUES ('Lojze', 'Pustišek', NULL, NULL, NULL, 'pustime@spin.si', '3', '3', 'Seller');
INSERT INTO `users` (`name`, `surname`, `address`, `addressNumber`, `postalCode`, `email`, `hash`, `salt`, `role`) VALUES ('Janko', 'Novak', 'Dvor', '3', '1355', 'jankoinmetka@gmail.com', '4', '4', 'Customer');
INSERT INTO `users` (`name`, `surname`, `address`, `addressNumber`, `postalCode`, `email`, `hash`, `salt`, `role`) VALUES ('Tim', 'Gorbačov', 'Čargova ulica, Kanal', '2a', '5210', 'timi@siol.net', '5', '5', 'Customer');

INSERT INTO `articles` (`name`, `description`, `artist`, `releaseYear`, `rating`, `numberOfRatings`, `price`, `idSeller`) VALUES ('I Want To Hold Your Hand', 'With a million preorders for “I Want To Hold Your Hand” in the UK, the single shot to number 1 in December 1963 knocking The Beatles’ own “She Loves You” from the top spot.  This was to be the first official single for The Beatles on Capitol records and was backed by an extraordinary marketing campaign.', 'The Beatles', '1963', '0.0', '0', '16.99', '2');
INSERT INTO `articles` (`name`, `description`, `artist`, `releaseYear`, `rating`, `numberOfRatings`, `price`, `idSeller`) VALUES ('Unreal Unearth', 'Unreal Unearth is the incredible third album by Hozier. The peerless singer-songwriter recorded this remarkable record with a stellar cast of producers including Bekon (Kendrick Lamar, Drake), Jennifer Decilveo (Miley Cyrus, Bat For Lashes), and Jeff Gitelman (The Weeknd, H.E.R.). The sounds, style and influences throughout the record range from folk, to rock, to blues, to soul, to anthemic pop, and all that’s in between.', 'Hozier', '2024', '0.0', '0', '45.99', '3');
INSERT INTO `articles` (`name`, `description`, `artist`, `releaseYear`, `rating`, `numberOfRatings`, `price`, `idSeller`) VALUES ('Wasteland, Baby!', 'Tracklist: 1. Nina Cried Power (Featuring Mavis Staples) 2. Almost (Sweet Music) 3. Movement 4. No Plan 5. Nobody 6. To Noise Making (Sing) 7. As It Was 8. Shrike 9. Talk Refined 10. Be 11. Dinner & Diatribes 12. Would 13. Sunlight 14. Wasteland, Baby!', 'Hozier', '2019', '0.0', '0', '27.99', '2');
INSERT INTO `articles` (`name`, `description`, `artist`, `releaseYear`, `rating`, `numberOfRatings`, `price`, `idSeller`) VALUES ('Hozier', 'Tracklist: Side A 1. Take Me To Church 2. Angel Of Small Death And The Codeine Scene 3. Jackie And Wilson Side B 1. Someone New 2. To Be Alone 3. From Eden Side C 1. In A Week (Feat. Karen Cowley) 2. Sedated 3. Work Song Side D 1. Like Real People Do 2. It Will Come Back 3. Foreigner’s God 4. Cherry Wine', 'Hozier', '2014', '0.0', '0', '27.99', '3');
INSERT INTO `articles` (`name`, `description`, `artist`, `releaseYear`, `rating`, `numberOfRatings`, `price`, `idSeller`) VALUES ('Stick Season', 'Experience the ultimate sound quality with the Stick Season Vinyl, a top 3 album on the US Billboard 200. Ranking #1 in both the Top Rock Albums and Top Alternative Albums categories, this vinyl guarantees an unparalleled listening experience. Elevate your music collection with the Stick Season Vinyl. ', 'Noah Kahan', '2023', '0.0', '0', '45.95', '2');