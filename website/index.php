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
    <input id="searchInput" name="searchInput" type="text" pattern='.{2,}' required>
    <input type="submit" value="Submit">
</form>
<table id="userTable">
    <tr>
        <th>GRANTEE</th>
        <th>TABLE_CATALOG</th>
        <th>PRIVILEGE_TYPE</th>
        <th>IS_GRANTABLE</th>
    </tr>
    <?php
    try {
        $connection = new PDO("mysql:host=localhost", "root", "");
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $selectAllUsers = "SELECT * FROM information_schema.user_privileges WHERE GRANTEE NOT LIKE '%::1%';";

        foreach ($connection->query($selectAllUsers) as $row) {
            printTr($row);
        }
        $connection = null;
    } catch (PDOException $e) {
        $connection = null;
        error_log("E: " . print_r($e, true), 0);
    }

    function printTr($row)
    {
        $TR = '<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>';
        echo sprintf($TR, $row['GRANTEE'], $row['TABLE_CATALOG'], $row['PRIVILEGE_TYPE'], $row['IS_GRANTABLE']);
    }

    ?>
</table>
</body>
</html>
