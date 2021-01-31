<!--------------------------------------------------------------------------------------------------------------------->
<!--    Skriptname:    changeUser.php                                                                                -->
<!--    Author:        Peter Rudnik                                                                                  -->
<!--    Date:          20.06.2020                                                                                    -->
<!--    Version:       4                                                                                             -->
<!--    Beschreibung:  Profiländerungsscript, Formsubmit von ../profile.php                                          -->
<!--------------------------------------------------------------------------------------------------------------------->
<?php
session_start();
if (updateUser()) {
    success($_POST['name']);
    return;
}
failed();
return;

function updateUser()
{
    try {
        $connection = new PDO("mysql:host=localhost;dbname=websiteDB", "root", "");
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $connection->prepare("SELECT id FROM user WHERE user.email = ?;");
        $stmt->execute([$_SESSION['email']]);
        $id = $stmt->fetchColumn();
        error_log("I: Fetched userID $id for email " . $_SESSION['email'] . "(" . $_SESSION['timeout'] . ")", 0);

        $stmt = $connection->prepare('UPDATE userinformation
                                SET name = ?, gender = ?, birthday = ?, street = ?, streetnumber = ?, city = ?, postalcode = ? WHERE user_id = ?;');
        $result = $stmt->execute([$_POST['name'], $_POST['gender'], $_POST['birthday'], $_POST['street'], $_POST['streetnumber'], $_POST['city'], $_POST['postalcode'], $id]);
        $connection = null;
        error_log("I: Updated userinformation for userID $id: " . print_r($_POST, true), 0);
        return $result == 1;
    } catch (PDOException $e) {
        $connection = null;
        error_log("E: " . print_r($e, true), 0);
        return false;
    }
}

function success($name)
{
    echo "Changed userdata successfully!<br>";
    $_SESSION['username'] = $name;
    echo "<script type='text/javascript'>
            async function waitForRelocation() {
                await new Promise(resolve => setTimeout(resolve, 3000));
                window.location.assign('../profile.php')
            }
            waitForRelocation();
          </script>";
}

function failed()
{
    echo "Failed to change userdata.<br>";
    echo "<script type='text/javascript'>
        async function waitForRelocation() {
            await new Promise(resolve => setTimeout(resolve, 3000));
            window.history.back();
        }
        waitForRelocation();
      </script>";
}