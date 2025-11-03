-- Base de données
CREATE DATABASE IF NOT EXISTS facturation_db;
USE facturation_db;
-- Users (admin/gerant)
CREATE TABLE users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(50) NOT NULL,
	email VARCHAR(100) NOT NULL,
	password VARCHAR(255) NOT NULL,
	role ENUM('admin', 'gerant') NOT NULL,
	has_key VARCHAR(255) NULL,
	hash_expiry VARCHAR(255) NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO users (username, email, password, role, hash_expiry)
VALUES (
    'Andrehy',
    'mivononaandry@gmail.com',
    'AndrehyMiv123',  -- mot de passe en MD5
    'admin',
    '2025-12-31 23:59:59'
);



-- Clients
CREATE TABLE clients (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(100) NOT NULL,
	email VARCHAR(100),
	phone VARCHAR(20),
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Catégories de produits
CREATE TABLE categories (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(100) NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Produits avec photo
CREATE TABLE products (
	id INT AUTO_INCREMENT PRIMARY KEY,
	category_id INT NOT NULL,
	name VARCHAR(100) NOT NULL,
	price DECIMAL(10, 2) NOT NULL,
	photo VARCHAR(255) DEFAULT NULL,
	qte_stock INT NOT NULL DEFAULT 1,
	seuil_alert INT NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);
-- Factures
CREATE TABLE factures (
	id INT AUTO_INCREMENT PRIMARY KEY,
	numfacture VARCHAR(155) NOT NULL,
	client_id INT NOT NULL,
	date_facture DATE NOT NULL,
	total_HT DECIMAL(10, 2) DEFAULT 0,
	total_TTC DECIMAL(10, 2) DEFAULT 0,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (client_id) REFERENCES clients(id)
);
-- Items de factures (produits achetés)
CREATE TABLE facture_items (
	id INT AUTO_INCREMENT PRIMARY KEY,
	facture_id INT NOT NULL,
	product_id INT NOT NULL,
	quantity INT NOT NULL DEFAULT 1,
	priceUnit DECIMAL(10, 2) NOT NULL,
	subtotal DECIMAL(10, 2) NOT NULL,
	FOREIGN KEY (facture_id) REFERENCES factures(id) ON DELETE CASCADE,
	FOREIGN KEY (product_id) REFERENCES products(id)
);