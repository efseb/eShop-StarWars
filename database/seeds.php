<?php
    $pdo = new PDO('mysql:host=localhost;dbname=db_starwars', 'seb', 'seb');

    // Catégories
    $sql = "INSERT INTO categories(title, description) VALUES('Armes', 'Replique exact des armes de la saga ainsi que des jeux video')";
    $pdo->query($sql);
    $sql = "INSERT INTO categories(title, description) VALUES('Costumes', 'Replique exact des tenues des personnages de la saga ainsi que des jeux video')";
    $pdo->query($sql);

    // Produits
    $published_at = date('Y-m-d');
    $sql = sprintf("INSERT INTO products(category_id, title, abstract, price, content, status, published_at) VALUES(1, 'Sabre Laser de Jedi', 'Sabre laser de Yoda version collector', 999.99,'bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla blabla bla bla bla blabla bla bla bla blabla bla bla bla blabla bla bla bla blabla bla bla bla', 'published', '%s')", $published_at);
    $pdo->query($sql);
    $published_at = date('Y-m-d');
    $sql = sprintf("INSERT INTO products(category_id, title, abstract, price, content, status, published_at) VALUES(2, 'Casque de Dark Vador', 'Casque de Dark Vador', 499.99, 'bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla blabla bla bla bla blabla bla bla bla blabla bla bla bla blabla bla bla bla blabla bla bla bla', 'published', '%s')", $published_at);
    $pdo->query($sql);

    // Images Produit
    $sql = "INSERT INTO images(product_id, name, uri, status) VALUES(1, 'Sabre Laser de Yoda', 'yoda_saber.jpg', 'published')";
    $pdo->query($sql);
    $sql = "INSERT INTO images(product_id, name, uri, status) VALUES(2, 'Masque de Dark Vador', 'masque.jpg', 'published')";
    $pdo->query($sql);

    // Tags
    $sql = "INSERT INTO tags(name) VALUES('Sabre')";
    $pdo->query($sql);
    $sql = "INSERT INTO tags(name) VALUES('DarkVador')";
    $pdo->query($sql);
    $sql = "INSERT INTO tags(name) VALUES('Jedi')";
    $pdo->query($sql);
    $sql = "INSERT INTO tags(name) VALUES('Sith')";
    $pdo->query($sql);
    $sql = "INSERT INTO tags(name) VALUES('Yoda')";
    $pdo->query($sql);
    $sql = "INSERT INTO tags(name) VALUES('Casque')";
    $pdo->query($sql);

    // Product_tag
    $sql = "INSERT INTO product_tag(product_id, tag_id) VALUES(1,1)";
    $pdo->query($sql);
    $sql = "INSERT INTO product_tag(product_id, tag_id) VALUES(1,3)";
    $pdo->query($sql);
    $sql = "INSERT INTO product_tag(product_id, tag_id) VALUES(1,5)";
    $pdo->query($sql);
    $sql = "INSERT INTO product_tag(product_id, tag_id) VALUES(2,2)";
    $pdo->query($sql);
    $sql = "INSERT INTO product_tag(product_id, tag_id) VALUES(2,4)";
    $pdo->query($sql);
    $sql = "INSERT INTO product_tag(product_id, tag_id) VALUES(2,6)";
    $pdo->query($sql);

