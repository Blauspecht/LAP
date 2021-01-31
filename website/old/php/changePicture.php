<!--------------------------------------------------------------------------------------------------------------------->
<!--    Skriptname:    changePicture.php                                                                             -->
<!--    Author:        Peter Rudnik                                                                                  -->
<!--    Date:          20.06.2020                                                                                    -->
<!--    Version:       4                                                                                             -->
<!--    Beschreibung:  Profilbildänderungsscript, Formsubmit von ../profile.php                                      -->
<!--------------------------------------------------------------------------------------------------------------------->
<?php
session_start();

if (updatePicture()) {
    success();
    return;
}
failed();
return;

function updatePicture()
{
    try {
        $connection = new PDO("mysql:host=localhost;dbname=websiteDB", "root", "");
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $connection->prepare("SELECT id FROM user WHERE user.email = ?;");
        $stmt->execute([$_SESSION['email']]);
        $id = $stmt->fetchColumn();
        error_log("I: Fetched userID $id for email " . $_SESSION['email'] . "(" . $_SESSION['timeout'] . ")", 0);

        $mimetype = $_FILES['fileUpload']['type'];
        $content = base64_encode(file_get_contents(addslashes($_FILES["fileUpload"]["tmp_name"])));

        $stmt = $connection->prepare('UPDATE userinformation SET imageData = ?, imageMimetype = ? WHERE user_id = ?;');
        $result = $stmt->execute([$content, $mimetype, $id]);
        error_log("I: Updated userinformation.imageData & -Mimetype for userID $id", 0);
        $connection = null;
        return $result == 1;
    } catch (PDOException $e) {
        $connection = null;
        error_log("E: " . print_r($e, true), 0);
        return false;
    }
}

function success()
{
    echo "Changed user picture successfully!<br>";
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
    echo "Failed to change user picture.<br>";
    echo "<script type='text/javascript'>
        async function waitForRelocation() {
            await new Promise(resolve => setTimeout(resolve, 3000));
            window.history.back();
        }
        waitForRelocation();
      </script>";
}