CREATE TABLE `users` (
  `id_user` int UNIQUE PRIMARY KEY,
  `user_name` varchar(100),
  `user_email` varchar(100) UNIQUE NOT NULL,
  `user_phone` char(16),
  `user_address` text,
  `user_avatar` varchar(255) DEFAULT "default.jpg",
  `user_password` varchar(255),
  `user_role` ENUM ('admin', 'staff'),
  `created_at` timestamp
);

CREATE TABLE `suppliers` (
  `id_supplier` int UNIQUE PRIMARY KEY,
  `supplier_code` varchar(64) UNIQUE NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `supplier_email` varchar(100) UNIQUE NOT NULL,
  `supplier_phone` char(16) UNIQUE,
  `supplier_address` text,
  `supplier_image` varchar(255) DEFAULT "default.jpg",
  `created_at` timestamp
);

CREATE TABLE `customers` (
  `id_customer` int UNIQUE PRIMARY KEY,
  `customer_code` varchar(64) UNIQUE NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) UNIQUE NOT NULL,
  `customer_phone` char(16),
  `customer_address` text,
  `customer_image` varchar(2255) DEFAULT "default.jpg"
);

CREATE TABLE `categories` (
  `id_category` int UNIQUE PRIMARY KEY,
  `category_code` varchar(64) UNIQUE,
  `category_name` varchar(100) NOT NULL,
  `category_description` text,
  `created_at` timestamp
);

CREATE TABLE `units` (
  `id_unit` int UNIQUE PRIMARY KEY,
  `unit_code` varchar(64) UNIQUE,
  `unit_name` varchar(100) NOT NULL,
  `unit_description` text,
  `created_at` timestamp
);

CREATE TABLE `items` (
  `id_item` int UNIQUE PRIMARY KEY,
  `id_category` int,
  `id_unit` int,
  `item_code` varchar(64) UNIQUE,
  `item_name` varchar(128) NOT NULL,
  `item_image` varchar(255) NOT NULL,
  `item_stock` int(11) NOT NULL,
  `item_stock_min` int(11) NOT NULL,
  `item_price` float,
  `item_description` text,
  `created_at` timestamp
);

CREATE TABLE `incoming_items` (
  `id_incoming_items` int UNIQUE PRIMARY KEY,
  `id_items` int,
  `id_supplier` int,
  `incoming_item_code` varchar(64) UNIQUE NOT NULL,
  `incoming_item_qty` int(11) NOT NULL,
  `created_at` timestamp
);

CREATE TABLE `outcoming_items` (
  `id_outcoming_item` int UNIQUE PRIMARY KEY,
  `id_items` int,
  `id_customer` int,
  `outcoming_item_code` varchar(64) UNIQUE,
  `outcoming_item_qty` int(11),
  `outcoming_item_price` float,
  `created_at` timestamp
);

ALTER TABLE `items` ADD FOREIGN KEY (`id_category`) REFERENCES `categories` (`id_category`);

ALTER TABLE `items` ADD FOREIGN KEY (`id_unit`) REFERENCES `units` (`id_unit`);

ALTER TABLE `incoming_items` ADD FOREIGN KEY (`id_items`) REFERENCES `items` (`id_item`);

ALTER TABLE `incoming_items` ADD FOREIGN KEY (`id_supplier`) REFERENCES `suppliers` (`id_supplier`);

ALTER TABLE `outcoming_items` ADD FOREIGN KEY (`id_items`) REFERENCES `items` (`id_item`);

ALTER TABLE `outcoming_items` ADD FOREIGN KEY (`id_customer`) REFERENCES `customers` (`id_customer`);
