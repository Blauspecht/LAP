<?php
try {
    print_r($_POST);
    echo '<br/>';

    $connection = new PDO("mysql:host=localhost", "root", "");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $selectAllUsersWithAttribute =
        "SELECT * FROM test1.test2 WHERE titel LIKE ?;";
    $stmt = $connection->prepare($selectAllUsersWithAttribute);

    $stmt->execute(['%' . $_POST['searchInput'] . '%']);
    $result = $stmt->fetchAll();

    foreach ($result as $row) {
        echo '<br/>';
        echo $row['id'] . ":" . $row['titel'];
    }

    error_log("I: Fetched users", 0);
    $connection = null;
} catch (PDOException $e) {
    $connection = null;
    print_r($e);
    error_log("E: " . print_r($e, true), 0);
}