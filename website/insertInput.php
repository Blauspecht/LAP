<?php
try {
    $connection = new PDO("mysql:host=localhost", "root", "");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $insert =
        "INSERT INTO test1.test2(titel) VALUES(?);";
    $getValue = "SELECT * FROM test1.test2 WHERE titel = ? ORDER BY id DESC LIMIT 1;";


    $stmt = $connection->prepare($insert);
    $stmt->execute([$_POST['insertValue']]);

    $stmt = $connection->prepare($getValue);
    $stmt->execute([$_POST['insertValue']]);
    $result = $stmt->fetchAll();

    echo "Inserted TITEL value " . $result[0]['titel'] . " into test2 with ID " . $result[0]['id'];

    error_log("I: Fetched users", 0);
    $connection = null;
} catch (PDOException $e) {
    $connection = null;
    print_r($e);
    error_log("E: " . print_r($e, true), 0);
}