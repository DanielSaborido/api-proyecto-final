-- Eliminar tablas si existen
    DROP TABLE IF EXISTS 'category_product';
    DROP TABLE IF EXISTS 'order_details';
    DROP TABLE IF EXISTS 'comments_and_ratings';
    DROP TABLE IF EXISTS 'shipments';
    DROP TABLE IF EXISTS 'orders';
    DROP TABLE IF EXISTS 'customers';
    DROP TABLE IF EXISTS 'users';
    DROP TABLE IF EXISTS 'products';
    DROP TABLE IF EXISTS 'categories';
    DROP TABLE IF EXISTS 'payment_methods';

-- Migración para la tabla "categories"
CREATE TABLE IF NOT EXISTS 'categories' (
    'id' BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    'picture' VARCHAR(255) NULL,
    'name' VARCHAR(255) NOT NULL,
    'description' TEXT NULL,
    'created_at' TIMESTAMP NULL,
    'updated_at' TIMESTAMP NULL,
    PRIMARY KEY ('id')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migración para la tabla "products"
CREATE TABLE IF NOT EXISTS 'products' (
    'id' BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    'picture' VARCHAR(255) NULL,
    'name' VARCHAR(255) NOT NULL,
    'description' TEXT NULL,
    'price' DECIMAL(10, 2) NOT NULL,
    'availability' BOOLEAN NOT NULL DEFAULT true,
    'quantity' INT NOT NULL,
    'category_id' BIGINT(20) unsigned NOT NULL,
    'deleted_at' TIMESTAMP NULL,
    'created_at' TIMESTAMP NULL,
    'updated_at' TIMESTAMP NULL,
    PRIMARY KEY ('id'),
    FOREIGN KEY ('category_id') REFERENCES 'product_categories'('id') ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migración para la tabla "customers"
CREATE TABLE IF NOT EXISTS 'customers' (
    'id' BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    'picture' VARCHAR(255) NULL,
    'name' VARCHAR(255) NOT NULL,
    'email' VARCHAR(255) UNIQUE NOT NULL,
    'password' VARCHAR(255) NOT NULL,
    'address' TEXT NOT NULL,
    'phone_number' VARCHAR(20) NOT NULL,
    'token' VARCHAR(255) UNIQUE NOT NULL,
    'created_at' TIMESTAMP NULL,
    'updated_at' TIMESTAMP NULL,
    PRIMARY KEY ('id')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migración para la tabla "orders"
CREATE TABLE IF NOT EXISTS 'orders' (
    'id' BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    'customer_id' BIGINT(20) unsigned NOT NULL,
    'order_date' TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    'status' VARCHAR(255) NOT NULL DEFAULT 'pending',
    'total' DECIMAL(10, 2) NOT NULL,
    'payment_method' VARCHAR(255) NOT NULL,
    'created_at' TIMESTAMP NULL,
    'updated_at' TIMESTAMP NULL,
    PRIMARY KEY ('id'),
    FOREIGN KEY ('customer_id') REFERENCES 'customers'('id') ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migración para la tabla "order_details"
CREATE TABLE IF NOT EXISTS 'order_details' (
    'id' BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    'order_id' BIGINT(20) unsigned NOT NULL,
    'product_id' BIGINT(20) unsigned NOT NULL,
    'quantity' INT NOT NULL,
    'unit_price' DECIMAL(10, 2) NOT NULL,
    'subtotal' DECIMAL(10, 2) NOT NULL,
    'created_at' TIMESTAMP NULL,
    'updated_at' TIMESTAMP NULL,
    PRIMARY KEY ('id'),
    FOREIGN KEY ('order_id') REFERENCES 'orders'('id') ON DELETE CASCADE,
    FOREIGN KEY ('product_id') REFERENCES 'products'('id') ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migración para la tabla "payment_methods"
CREATE TABLE IF NOT EXISTS 'payment_methods' (
    'id' BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    'customer_id' BIGINT(20) unsigned NOT NULL,
    'card_number' VARCHAR(255) NOT NULL,
    'expiry_date' VARCHAR(255) NOT NULL,
    'cvv' VARCHAR(255) NOT NULL,
    'created_at' TIMESTAMP NULL,
    'updated_at' TIMESTAMP NULL,
    PRIMARY KEY ('id'),
    FOREIGN KEY ('customer_id') REFERENCES 'customers'('id') ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migración para la tabla "comments_and_ratings"
CREATE TABLE IF NOT EXISTS 'comment_and_ratings' (
    'id' BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    'product_id' BIGINT(20) unsigned NOT NULL,
    'customer_id' BIGINT(20) unsigned NOT NULL,
    'title' VARCHAR(255) NULL,
    'comment' TEXT NOT NULL,
    'rating' INT NOT NULL,
    'created_at' TIMESTAMP NULL,
    'updated_at' TIMESTAMP NULL,
    PRIMARY KEY ('id'),
    FOREIGN KEY ('product_id') REFERENCES 'products'('id') ON DELETE CASCADE,
    FOREIGN KEY ('customer_id') REFERENCES 'customers'('id') ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migración para la tabla "shipments"
CREATE TABLE IF NOT EXISTS 'shipments' (
    'id' BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    'order_id' BIGINT(20) unsigned NOT NULL,
    'shipping_date' TIMESTAMP NULL,
    'status' VARCHAR(255) NOT NULL DEFAULT 'pending',
    'created_at' TIMESTAMP NULL,
    'updated_at' TIMESTAMP NULL,
    PRIMARY KEY ('id'),
    FOREIGN KEY ('order_id') REFERENCES 'orders'('id') ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migración para la tabla pivote "category_product"
CREATE TABLE IF NOT EXISTS 'category_product' (
    'product_id' BIGINT(20) unsigned NOT NULL,
    'category_id' BIGINT(20) unsigned NOT NULL,
    'created_at' TIMESTAMP NULL,
    'updated_at' TIMESTAMP NULL,
    FOREIGN KEY ('product_id') REFERENCES 'products'('id') ON DELETE CASCADE,
    FOREIGN KEY ('category_id') REFERENCES 'categories'('id') ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migración para la tabla "users"
CREATE TABLE IF NOT EXISTS 'users' (
    'id' BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    'picture' VARCHAR(255) NULL,
    'name' VARCHAR(255) NOT NULL,
    'email' VARCHAR(255) UNIQUE NOT NULL,
    'password' VARCHAR(255) NOT NULL,
    'phone_number' VARCHAR(20) NOT NULL,
    'token' VARCHAR(255) UNIQUE NOT NULL,
    'created_at' TIMESTAMP NULL,
    'updated_at' TIMESTAMP NULL,
    PRIMARY KEY ('id')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `picture`, `name`, `email`, `password`, `phone_number`, `token`, `created_at`, `updated_at`)
VALUES
(1, 'user1.jpg', 'John Doe', 'johndoe@example.com', 'password123', '1234567890', 'A_1_715472', NOW(), NOW()),
(2, 'user2.jpg', 'Jane Doe', 'janedoe@example.com', 'password123', '0987654321', 'U_2_718472', NOW(), NOW());

INSERT INTO `customers` (`id`, `picture`, `name`, `email`, `password`, `address`, `phone_number`, `token`, `created_at`, `updated_at`)
VALUES
(1, 'customer1.jpg', 'John Smith', 'johnsmith@example.com', 'password123', '123 Main St', '1234567890', 'token123', NOW(), NOW()),
(2, 'customer2.jpg', 'Jane Smith', 'janesmith@example.com', 'password123', '456 Elm St', '0987654321', 'token456', NOW(), NOW());

INSERT INTO `categories` (`id`, `picture`, `name`, `description`, `created_at`, `updated_at`)
VALUES
(1, 'category1.jpg', 'Verduras', 'Verduras frescas', NOW(), NOW()),
(2, 'category2.jpg', 'Frutas', 'Frutas frescas', NOW(), NOW());

INSERT INTO `products` (`id`, `picture`, `name`, `description`, `price`, `availability`, `quantity`, `category_id`, `created_at`, `updated_at`)
VALUES
(1, 'product1.jpg', 'Lechuga', 'Lechuga fresca', 1.99, 1, 10, 1, NOW(), NOW()),
(2, 'product2.jpg', 'Manzanas', 'Manzanas frescas', 0.99, 1, 20, 2, NOW(), NOW()),
(3, 'product3.jpg', 'Pimientos', 'Pimientos frescos', 1.49, 1, 15, 1, NOW(), NOW());

INSERT INTO `orders` (`id`, `customer_id`, `order_date`, `status`, `total`, `payment_method`, `created_at`, `updated_at`)
VALUES
(1, 1, NOW(), 'pending', 1.99, 'credit card', NOW(), NOW()),
(2, 2, NOW(), 'pending', 0.99, 'paypal', NOW(), NOW());

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`, `subtotal`, `created_at`, `updated_at`)
VALUES
(1, 1, 1, 1, 1.99, 1.99, NOW(), NOW()),
(2, 2, 2, 2, 0.99, 1.98, NOW(), NOW());

INSERT INTO `payment_methods` (`id`, `customer_id`, `card_number`, `expiry_date`, `cvv`, `created_at`, `updated_at`)
VALUES
(1, 1, '1234-5678-9012-3456', '2025-12-31', '123', NOW(), NOW()),
(2, 2, '9876-5432-1098-7654', '2026-06-30', '456', NOW(), NOW());

INSERT INTO `comment_and_ratings` (`id`, `product_id`, `customer_id`, `title`, `comment`, `rating`, `created_at`, `updated_at`)
VALUES
(1, 1, 1, 'Buena lechuga', 'Esta lechuga es fresca!', 5, NOW(), NOW()),
(2, 2, 2, 'Buenas manzanas', 'Estas manzanas son deliciosas!', 4, NOW(), NOW());

INSERT INTO `shipments` (`id`, `order_id`, `shipping_date`, `status`, `created_at`, `updated_at`)
VALUES
(1, 1, NOW(), 'pending', NOW(), NOW()),
(2, 2, NOW(), 'pending', NOW(), NOW());
