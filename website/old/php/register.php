<!--------------------------------------------------------------------------------------------------------------------->
<!--    Skriptname:    register.php                                                                                  -->
<!--    Author:        Peter Rudnik                                                                                  -->
<!--    Date:          20.06.2020                                                                                    -->
<!--    Version:       4                                                                                             -->
<!--    Beschreibung:  Registerscript, mit Passworthash, Formsubmit von ../login.php                                 -->
<!--------------------------------------------------------------------------------------------------------------------->
<?php

if (htmlspecialchars($_POST['password1']) != htmlspecialchars($_POST['password2'])) {
    echo "<script type='text/javascript'>alert('Passwords are not equal!');</script>";
    failed();
    return false;
}

if (createDataBase() && insertNewUser()) {
    success();
    return true;
}
failed();
return false;


function insertNewUser()
{
    $sql = determineInsert(empty($_FILES['fileUpload']['name']));
    $password_hash = password_hash($_POST['password1'], PASSWORD_BCRYPT);

    try {
        $connection = new PDO("mysql:host=localhost;dbname=websiteDB", "root", "");
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $connection->prepare($sql);
        $params = [$_POST['email'], $password_hash, $_POST['name'], $_POST['gender'], $_POST['bday'], $_POST['street'], $_POST['streetNr'], $_POST['city'], $_POST['plz'], $_POST['stateList'], $_POST['email']];

        if (!empty($_FILES['fileUpload']['name'])) {
            $params[count($params)] = $_FILES['fileUpload']['type'];
            $params[count($params)] = base64_encode(file_get_contents(addslashes($_FILES["fileUpload"]["tmp_name"])));
        }

        $result = $stmt->execute($params);
        $connection = null;
        error_log("I: Inserted user into user, userinformation websiteDB: " . print_r($params, true), 0);
        return $result == 1;
    } catch (PDOException $e) {
        $connection = null;
        if ($e->errorInfo[0] == 23000 && $e->errorInfo[1] == 1062) {
            echo "Email " . $_POST['email'] . " already in use!<br>";
        }
        error_log("E: " . print_r($e, true), 0);
        return false;
    }
}

function determineInsert($noImage)
{
    if ($noImage) {
        return "INSERT INTO user (email, password) VALUES (?, ?);
            INSERT INTO userinformation (name, gender, birthday, street, streetnumber, city, postalcode, state_id, user_id)
            VALUES (?, ?, ?, ?, ?, ?, ?,
                (SELECT id from state where state.name = ? LIMIT 1),
                (SELECT id from user where user.email = ? LIMIT 1));";
    }
    return "INSERT INTO user (email, password) VALUES (?, ?);
        INSERT INTO userinformation (name, gender, birthday, street, streetnumber, city, postalcode, state_id, user_id, imageMimeType, imageData)
        VALUES (?, ?, ?, ?, ?, ?, ?, 
            (SELECT id from state where state.name = ? LIMIT 1),
            (SELECT id from user where user.email = ? LIMIT 1),
            ?, ?);";
}

function createDataBase()
{
    try {
        $connection = new PDO("mysql:host=localhost", "root", "");
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $CREATE = "CREATE DATABASE IF NOT EXISTS websiteDB; 
                USE websiteDB; 
                --DROP TABLE IF EXISTS UserInformation; 
                --DROP TABLE IF EXISTS User; 
                --DROP TABLE IF EXISTS State; 
                
                CREATE TABLE IF NOT EXISTS State
                (
                    id   BIGINT UNSIGNED AUTO_INCREMENT, 
                    name varchar(100) UNIQUE NOT NULL, 
                    CONSTRAINT pk_State PRIMARY KEY (id) 
                );
                CREATE TABLE IF NOT EXISTS User
                (
                    id       BIGINT       UNSIGNED AUTO_INCREMENT, 
                    email    varchar(100) UNIQUE NOT NULL, 
                    password varchar(255) NOT NULL, 
                    CONSTRAINT pk_User PRIMARY KEY (id)
                );
                CREATE TABLE IF NOT EXISTS UserInformation
                (
                    id            BIGINT UNSIGNED AUTO_INCREMENT,
                    name          varchar(100)    NOT NULL,
                    gender        varchar(6)      NOT NULL,
                    birthday      DATE            NOT NULL,
                    street        varchar(100)    NOT NULL,
                    streetnumber  varchar(50)     NOT NULL,
                    city          varchar(100)    NOT NULL,
                    postalcode    varchar(4)      NOT NULL,
                    imageMimetype varchar(255) DEFAULT null,
                    imageData     blob         DEFAULT null,
                    state_id      BIGINT UNSIGNED NOT NULL,
                    user_id       BIGINT UNSIGNED NOT NULL,
                    CONSTRAINT pk_UserInformation PRIMARY KEY (id),
                    CONSTRAINT fk_User_UserInformation
                        FOREIGN KEY (user_id)
                            REFERENCES User (id)
                            ON DELETE CASCADE,
                    CONSTRAINT fk_State_UserInformation
                        FOREIGN KEY (state_id)
                            REFERENCES State (id)
                );";
        $connection->exec($CREATE);
        error_log("I: Created user, userinformation, state in websiteDB", 0);

        $count = $connection->query("SELECT COUNT(id) as 'count' FROM State")->fetchColumn();
        if ($count == 0) {
            $connection->exec("INSERT INTO State (name)
                    VALUES ('Burgenland'),
                           ('Kärnten'),
                           ('Niederösterreich'),
                           ('Oberösterreich'),
                           ('Salzburg'),
                           ('Steiermark'),
                           ('Tirol'),
                           ('Vorarlberg'),
                           ('Wien')");
            error_log("I: Inserted states(9) into websiteDB.State", 0);
        };
        $connection = null;
        return true;
    } catch (PDOException $e) {
        $connection = null;
        error_log("E: " . print_r($e, true), 0);
        return false;
    }
}

function success()
{
    echo "New user created!<br>";
    session_start();
    $_SESSION['valid'] = true;
    $_SESSION['timeout'] = time();
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['username'] = $_POST['name'];
    error_log("I: Created session: " . print_r($_SESSION, true), 0);
    echo "<script type='text/javascript'>
            async function waitForRelocation() {
                await new Promise(resolve => setTimeout(resolve, 3000));
                window.location.assign('../index.php')
            }
            waitForRelocation();
          </script>";
}

function failed()
{
    echo "Failed to create new user.<br>";
    echo "<script type='text/javascript'>
        async function waitForRelocation() {
            await new Promise(resolve => setTimeout(resolve, 3000));
            window.history.back();
        }
        waitForRelocation();
      </script>";
}