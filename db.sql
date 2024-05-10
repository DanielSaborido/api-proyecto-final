-- Eliminar tablas si existen
DROP TABLE IF EXISTS category_product;
DROP TABLE IF EXISTS order_details;
DROP TABLE IF EXISTS comments_and_ratings;
DROP TABLE IF EXISTS shipments;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS payment_methods;

-- Migración para la tabla "categories"
CREATE TABLE IF NOT EXISTS categories (
	id BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    picture VARCHAR(255),
	name VARCHAR(255),
	description TEXT,
	created_at TIMESTAMP NULL,
	updated_at TIMESTAMP NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migración para la tabla "products"
CREATE TABLE IF NOT EXISTS `products` (
    `id` BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    `picture` VARCHAR(255),
    `name` VARCHAR(255),
    `description` TEXT,
    `price` DECIMAL(10, 2),
    `availability` BOOLEAN,
    `quantity` INT,
    `category_id` BIGINT(20) unsigned NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migración para la tabla "customers"
CREATE TABLE IF NOT EXISTS `customers` (
    `id` BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    `picture` VARCHAR(255),
    `name` VARCHAR(255),
    `email` VARCHAR(255),
    `address` TEXT,
    `phone_number` VARCHAR(20),
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migración para la tabla "orders"
CREATE TABLE IF NOT EXISTS `orders` (
    `id` BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    `customer_id` BIGINT(20) unsigned NOT NULL,
    `order_date` TIMESTAMP,
    `status` VARCHAR(255),
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migración para la tabla "order_details"
CREATE TABLE IF NOT EXISTS `order_details` (
    `id` BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    `order_id` BIGINT(20) unsigned NOT NULL,
    `product_id` BIGINT(20) unsigned NOT NULL,
    `quantity` INT,
    `unit_price` DECIMAL(10, 2),
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migración para la tabla "payment_methods"
CREATE TABLE IF NOT EXISTS `payment_methods` (
    `id` BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255),
    `description` TEXT,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migración para la tabla "comments_and_ratings"
CREATE TABLE IF NOT EXISTS `comments_and_ratings` (
    `id` BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    `product_id` BIGINT(20) unsigned NOT NULL,
    `customer_id` BIGINT(20) unsigned NOT NULL,
    `comment` TEXT,
    `rating` INT,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migración para la tabla "shipments"
CREATE TABLE IF NOT EXISTS `shipments` (
    `id` BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    `order_id` BIGINT(20) unsigned NOT NULL,
    `shipping_date` TIMESTAMP,
    `status` VARCHAR(255),
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migración para la tabla pivote "category_product"
CREATE TABLE IF NOT EXISTS `category_product` (
    `product_id` BIGINT(20) unsigned NOT NULL,
    `category_id` BIGINT(20) unsigned NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migración para la tabla "users"
CREATE TABLE IF NOT EXISTS users (
	id BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    picture VARCHAR(255),
	name VARCHAR(255),
	email VARCHAR(255) UNIQUE,
	password VARCHAR(255),
	remember_token VARCHAR(100),
	created_at TIMESTAMP NULL,
	updated_at TIMESTAMP NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserciones para la tabla "categories"
INSERT INTO categories (name, description, created_at, updated_at) VALUES
('Frutas', 'Variedad de frutas frescas.', NOW(), NOW()),
('Verduras', 'Selección de verduras frescas y orgánicas.', NOW(), NOW()),
('Hierbas Aromáticas', 'Hierbas frescas para condimentar tus platos.', NOW(), NOW()),
('Raíces y Tubérculos', 'Variedad de raíces y tubérculos frescos.', NOW(), NOW());

-- Inserciones para la tabla "products"
INSERT INTO products (name, description, price, availability, category_id, created_at, updated_at) VALUES
('Manzanas', 'Manzanas frescas y jugosas.', 1.99, true, 1, NOW(), NOW()),
('Plátanos', 'Plátanos maduros y sabrosos.', 0.99, true, 1, NOW(), NOW()),
('Naranjas', 'Naranjas dulces y jugosas.', 2.49, true, 1, NOW(), NOW()),
('Pepinos', 'Pepinos crujientes y refrescantes.', 1.29, true, 2, NOW(), NOW()),
('Tomates', 'Tomates rojos y sabrosos.', 1.79, true, 2, NOW(), NOW()),
('Lechuga', 'Lechuga fresca y crujiente.', 1.49, true, 2, NOW(), NOW()),
('Albahaca', 'Albahaca fresca para dar sabor a tus platos.', 0.79, true, 3, NOW(), NOW()),
('Cilantro', 'Cilantro fresco para condimentar tus comidas.', 0.69, true, 3, NOW(), NOW()),
('Perejil', 'Perejil fresco para agregar sabor a tus platos.', 0.59, true, 3, NOW(), NOW()),
('Zanahorias', 'Zanahorias frescas y crujientes.', 1.19, true, 4, NOW(), NOW()),
('Papas', 'Papas frescas y deliciosas.', 0.99, true, 4, NOW(), NOW()),
('Cebollas', 'Cebollas frescas y sabrosas.', 1.09, true, 4, NOW(), NOW());

-- Inserciones para la tabla "customers"
INSERT INTO customers (name, email, address, phone_number, created_at, updated_at) VALUES
('Juan Pérez', 'juan@example.com', 'Calle Principal 123', '555-1234', NOW(), NOW()),
('María Gómez', 'maria@example.com', 'Avenida Central 456', '555-5678', NOW(), NOW()),
('Pedro Rodríguez', 'pedro@example.com', 'Plaza Mayor 789', '555-9012', NOW(), NOW());

-- Inserciones para la tabla "users" (usuarios con permisos de administrador)
INSERT INTO users (name, email, password, created_at,updated_at) VALUES
('Admin', 'admin@example.com', '$2y$10$RlJIf9yvt8XOfWUyMVNf0eCx4vxcFI4fYZ.X5.wa7mByAM9UH36J6', NOW(), NOW());
-- Contraseña: password