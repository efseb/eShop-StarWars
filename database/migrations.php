<?php

    $pdo = new PDO('mysql:host=localhost;dbname=db_starwars', 'seb', 'seb');
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users(
          id INT UNSIGNED NOT NULL AUTO_INCREMENT,
          username VARCHAR(20),
          password VARCHAR(100),
          PRIMARY KEY(id)
        )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS customers(
          id INT UNSIGNED NOT NULL AUTO_INCREMENT,
          email TEXT,
          number VARCHAR(100),
          number_command INT UNSIGNED,
          PRIMARY KEY(id)
        )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS categories(
          id INT UNSIGNED NOT NULL AUTO_INCREMENT,
          title VARCHAR(100) NOT NULL,
          description TEXT,
          PRIMARY KEY(id)
        )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS tags(
          id INT UNSIGNED NOT NULL AUTO_INCREMENT,
          name VARCHAR(100) NOT NULL,
          PRIMARY KEY(id)
        )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS products(
          id INT UNSIGNED NOT NULL AUTO_INCREMENT,
          category_id INT UNSIGNED NOT NULL,
          title VARCHAR(100) NOT NULL,
          abstract VARCHAR(250) NOT NULL,
          price DECIMAL(5,2),
          content TEXT,
          status ENUM('published', 'unpublished'),
          published_at DATE,
          PRIMARY KEY(id),
          CONSTRAINT products_category_id_categories FOREIGN KEY(category_id) REFERENCES categories(id) ON DELETE CASCADE
        )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS product_tag(
          product_id INT UNSIGNED NOT NULL,
          tag_id INT UNSIGNED NOT NULL,
          CONSTRAINT product_tag_product_id_products FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE,
          CONSTRAINT product_tag_tag_id_tags FOREIGN KEY(tag_id) REFERENCES tags(id) ON DELETE CASCADE,
          UNIQUE(product_id, tag_id)
        )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS images(
          id INT UNSIGNED NOT NULL AUTO_INCREMENT,
          product_id INT UNSIGNED NOT NULL,
          name VARCHAR(20),
          uri VARCHAR(100),
          published_at DATE,
          status ENUM('published', 'unpublished'),
          PRIMARY KEY(id),
          CONSTRAINT images_product_id_products FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE
        )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `histories`(
          id INT UNSIGNED NOT NULL AUTO_INCREMENT,
          product_id INT UNSIGNED NOT NULL,
          customer_id INT UNSIGNED NOT NULL,
          price DECIMAL(10,2),
          total DECIMAL(10,2),
          quantity INT UNSIGNED NOT NULL,
          status ENUM('done', 'todo') NOT NULL DEFAULT 'todo',
          PRIMARY KEY(id),
          CONSTRAINT histories_product_id_products FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE,
          CONSTRAINT histories_customer_id_customers FOREIGN KEY(customer_id) REFERENCES customers(id) ON DELETE CASCADE
        )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
    ");

