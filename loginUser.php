<!--------------------------------------------------------------------------------------------------------------------->
<!--    Skriptname:    loginUser.php                                                                                 -->
<!--    Author:        Peter Rudnik                                                                                  -->
<!--    Date:          20.06.2020                                                                                    -->
<!--    Version:       4                                                                                             -->
<!--    Beschreibung:  Loginscript, mit Email und Passwortcheck, Formsubmit von ../login.php                         -->
<!--------------------------------------------------------------------------------------------------------------------->
<?php

try {
    $connection = new PDO("mysql:host=localhost;dbname=websiteDB", "root", "");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $connection->prepare("SELECT u.password, info.name FROM user u
                                            JOIN userinformation info ON u.id = info.user_id 
                                            WHERE u.email = ?;");

    $stmt->execute([$_POST['email']]);
    $result = $stmt->fetch();
    error_log("I: Fetched password and name for user with mail " . $_POST['email'], 0);
    $connection = null;

    if (password_verify($_POST['password'], $result['password'])) {
        success($result['name']);
        return;
    }
} catch (PDOException $e) {
    $connection = null;
    error_log("E: " . print_r($e, true), 0);
}
failed();

function success($name)
{
    echo "Login success!<br>";
    session_start();
    $_SESSION['valid'] = true;
    $_SESSION['timeout'] = time();
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['username'] = $name;
    error_log("I: Created session: " . print_r($_SESSION, true), 0);
    echo "<script type='text/javascript'>
            async function waitForRelocation() {
                await new Promise(resolve => setTimeout(resolve, 2000));
                window.location.assign('../index.php')
            }
            waitForRelocation();
          </script>";
}

function failed()
{
    echo "Failed to login.<br>";
    echo "<script type='text/javascript'>
        async function waitForRelocation() {
            await new Promise(resolve => setTimeout(resolve, 2000));
            window.location.assign('../login.php')
        }
        waitForRelocation();
      </script>";
}