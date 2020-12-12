<?php

try {
    $connection = new PDO("mysql:host=localhost;dbname=filmverwaltung", "root", "");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $connection->prepare("SELECT * FROM film f WHERE f.id = ? AND f.title LIKE ?;");

    $stmt->execute([$_POST['id'], "%" . $_POST['filmname'] . "%"]);
    $result = $stmt->fetch();
    $connection = null;

    print_r($result, true)
} catch (PDOException $e) {
    $connection = null;
    error_log("E: " . print_r($e, true), 0);
}

?>
