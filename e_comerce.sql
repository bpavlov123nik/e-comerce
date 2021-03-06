CREATE DATABASE IF NOT EXISTS ecomerce;
USE ecomerce;

CREATE TABLE IF NOT EXISTS artists(
	artist_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	first_name VARCHAR(20) DEFAULT NULL,
	middle_name VARCHAR(20) DEFAULT NULL,
	last_name VARCHAR(40) NOT NULL,
	PRIMARY KEY(artist_id),
	UNIQUE full_name(first_name, middle_name, last_name)
)ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS prints(
	print_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	artist_id INT UNSIGNED NOT NULL,
	print_name VARCHAR(60) NOT NULL,
	price DECIMAL(6, 2) UNSIGNED NOT NULL,
	size VARCHAR(60) DEFAULT NULL,
	description VARCHAR(255) DEFAULT NULL,
	PRIMARY KEY(print_id),
	INDEX(artist_id),
	INDEX(print_name),
	INDEX(price)
)ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS customers(
	customer_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	email VARCHAR(60) NOT NULL,
	pass CHAR(40) NOT NULL,
	PRIMARY KEY(customer_id),
	UNIQUE(email),
	INDEX login(email, pass)
)ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS orders(
	order_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	total DECIMAL(10, 2) UNSIGNED NOT NULL,
	order_date TIMESTAMP,
	PRIMARY KEY(order_id),
	INDEX(order_date)
)ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS order_content(
	oc_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	order_id INT UNSIGNED NOT NULL,
	print_id INT UNSIGNED NOT NULL,
	quantity TINYINT UNSIGNED NOT NULL DEFAULT 1,
	price DECIMAL(6, 2) UNSIGNED NOT NULL,
	ship_date DATETIME DEFAULT NULL,
	PRIMARY KEY(oc_id),
	INDEX(order_id),
	INDEX(print_id),
	INDEX(ship_date)
)ENGINE=MyISAM;