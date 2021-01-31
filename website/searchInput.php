<?php
try {
    print_r($_POST);
    echo '<br/>';

    $connection = new PDO("mysql:host=localhost", "root", "");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $selectAllUsersWithAttribute =
        "SELECT * FROM information_schema.user_privileges WHERE GRANTEE NOT LIKE '%%::1%%' AND GRANTEE LIKE '%?%';";
    echo $selectAllUsersWithAttribute;
    $stmt = $connection->prepare($selectAllUsersWithAttribute);

    $stmt->execute([$_POST['searchInput']]);
    $result = $stmt->fetchAll();

    print_r($stmt);
    print_r($result);


    error_log("I: Fetched users", 0);
    $connection = null;
} catch (PDOException $e) {
    $connection = null;
    error_log("E: " . print_r($e, true), 0);
}