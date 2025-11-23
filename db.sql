CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
);

CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_name` varchar(100) NOT NULL,
  `sender_email` varchar(100) NOT NULL,
  `message_text` text NOT NULL,
  `is_processed` tinyint(1) NOT NULL DEFAULT 0,
  `received_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
);

CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `service_price` int(11) NOT NULL,
  `is_processed` tinyint(1) NOT NULL DEFAULT 0,
  `order_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
);

CREATE TABLE `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description_short` text NOT NULL,
  `price` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `page_title` varchar(100) NOT NULL,
  `page_subtitle` varchar(255) NOT NULL,
  `page_description` text NOT NULL,
  `page_features` text NOT NULL,
  `performer_name` varchar(100) NOT NULL,
  `performer_role` varchar(100) NOT NULL,
  `performer_photo_url` varchar(255) NOT NULL,
  `performer_bio` text NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `role_short` varchar(100) NOT NULL,
  `role_full` varchar(100) NOT NULL,
  `photo_url` varchar(255) NOT NULL,
  `bio_short` text NOT NULL,
  `bio_full` text NOT NULL,
  `competencies` text NOT NULL,
  PRIMARY KEY (`id`)
);
