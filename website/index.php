<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>

    <link rel="stylesheet" href="index.css">
</head>
<body>
<form action='searchInput.php' method='post'>
    <label for="searchInput">Search for User: </label>
    <input id="searchInput" name="searchInput" type="text" pattern='.+' required>
    <input type="submit" value="Submit">
</form>
<form action='insertInput.php' method='post'>
    <label for="insertValue">Insert Value into test2: </label>
    <input id="insertValue" name="insertValue" type="text" required>
    <input type="submit" value="Submit">
</form>
<table id="userTable">
    <tr>
        <th>ID</th>
        <th>TITLE</th>
    </tr>
    <?php
    try {
        $connection = new PDO("mysql:host=localhost", "root", "");
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $selectAll = "SELECT * FROM test1.test2;";

        foreach ($connection->query($selectAll) as $row) {
            printTr($row);
        }
        $connection = null;
    } catch (PDOException $e) {
        $connection = null;
        error_log("E: " . print_r($e, true), 0);
    }

    function printTr($row)
    {
        $TR = '<tr><td>%s</td><td>%s</td></tr>';
        echo sprintf($TR, $row['id'], $row['titel']);
    }

    ?>
</table>
</body>
</html>
