-- Create tables without data

CREATE TABLE `merchant` (
  `mid` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `merchantname` VARCHAR(70) NOT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `product` (
  `product_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` TEXT NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  `quantity` INT NOT NULL,
  `img_url` VARCHAR(255) NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `merchant_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`product_id`),
  INDEX `user_idx` (`user_id`),
  INDEX `merchant_idx` (`merchant_id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `reset` (
  `rUID` INT UNSIGNED NOT NULL,
  `token` VARCHAR(200) NOT NULL,
  `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`rUID`),
  CONSTRAINT `reset_ibfk_1` FOREIGN KEY (`rUID`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `sale` (
  `sale_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` INT UNSIGNED NOT NULL,
  `merchant_id` INT UNSIGNED NOT NULL,
  `Timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `quantity` INT NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  `discount` DECIMAL(10, 2) NOT NULL,
  `selling_price` DECIMAL(10, 2) NOT NULL,
  `payment_method` TEXT NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`sale_id`, `product_id`),
  INDEX `product_idx` (`product_id`),
  INDEX `user_idx` (`user_id`),
  INDEX `merchant_idx` (`merchant_id`),
  FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `user` (
  `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `merchant_id` INT UNSIGNED NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `fullname` VARCHAR(255) NOT NULL,
  `address` VARCHAR(255) NOT NULL,
  `mobile` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  INDEX `merchant_idx` (`merchant_id`),
  FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
