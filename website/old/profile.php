<!--------------------------------------------------------------------------------------------------------------------->
<!--    Skriptname:    profile.php                                                                                   -->
<!--    Author:        Peter Rudnik                                                                                  -->
<!--    Date:          20.06.2020                                                                                    -->
<!--    Version:       4                                                                                             -->
<!--    Beschreibung:  Benutzerseite für eingeloggte User                                                            -->
<!--------------------------------------------------------------------------------------------------------------------->
<?php
session_start();
if (empty($_SESSION) || !$_SESSION['valid']) {
    header("Location: login.php");
    return;
}

try {
    $connection = new PDO("mysql:host=localhost;dbname=websiteDB", "root", "");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $connection->prepare("SELECT id FROM user WHERE user.email = ?;");
    $stmt->execute([$_SESSION['email']]);
    $id = $stmt->fetchColumn();

    $stmt = $connection->prepare('SELECT * FROM userinformation WHERE user_id = ?;');
    $stmt->execute([$id]);
    $user = $stmt->fetch();
    error_log("I: Fetched userID $id for email " . $_SESSION['email'] . "(" . $_SESSION['timeout'] . ")", 0);
    $connection = null;
} catch (PDOException $e) {
    $connection = null;
    error_log("E: " . print_r($e, true), 0);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>TemplateComp AG - Profile</title>

    <link rel="stylesheet" href="stylesheets/layout.css">
    <link rel="stylesheet" href="stylesheets/profile.css">
</head>

<body>
<header>
    <img src="resources/logo.png" alt="Logo">
    <span>TemplateComp AG - Profile</span>
    <?= '<marquee class="rainbow" truespeed scrolldelay="40">Welcome ' . $_SESSION['username'] . '!</marquee >'; ?>
</header>
<nav data-topbar>
    <?php
    if (!empty($_SESSION) && $_SESSION['valid']) {
        echo "<p onclick='location.href=\"php/logout.php\"'>Logout</p>";
    }
    ?>
    <p onclick="location.href='index.php'">Home</p>
    <p onclick="location.href='playground.php'">Playground</p>
    <p onclick="location.href=''">Profile</p>
</nav>
<div class="content">
    <div class='form'>
        <div class="flex-container">
            <form class="userInfo" id="registerForm" action="php/changeUser.php" method="post">
                <h3>Userdata:</h3>
                <label for='email' title='Email'>
                    Email: <input id='email' type='text' disabled value='<?= $_SESSION['email'] ?>'>
                </label>
                <br>
                <label for='name' title='Name'>
                    Name: <input id='name' name="name" type='text' value='<?= $user['name'] ?>'>
                </label>
                <br>
                <label for='gender' title='Gender'>
                    Gender: <input id='gender' name="gender" type='text' value='<?= $user['gender'] ?>'>
                </label>
                <br>
                <label for='birthday' title='Birthday'>
                    Birthday: <input id='birthday' name="birthday" type='date' value='<?= $user['birthday'] ?>'>
                </label>
                <br>
                <h3>Adressdata:</h3>
                <label for='street' title='Street'>
                    Street: <input id='street' name="street" type='text' value='<?= $user['street'] ?>'>
                </label>
                <br>
                <label for='streetnumber' title='Streetnumber'>
                    Streetnumber: <input id='streetnumber' name="streetnumber" type='text'
                                         value='<?= $user['streetnumber'] ?>'>
                </label>
                <br>
                <label for='city' title='City'>
                    City: <input id='city' name="city" type='text' value='<?= $user['city'] ?>'>
                </label>
                <br>
                <label for='postalcode' title='Postalcode'>
                    Postalcode: <input id='postalcode' name="postalcode" type='text' value='<?= $user['postalcode'] ?>'>
                </label>
                <br>
                <label for='submit' title='Submit'>
                    Submit: <input id='submit' type='submit' value='Change Userinformation'>
                </label>
            </form>
            <form class="userPicture" id="registerForm" action="php/changePicture.php" method="post"
                  enctype="multipart/form-data">
                <h3>Profilepicture</h3>
                <?php echo "<img height='640px' width='640px' src='data:image;base64," . $user['imageData'] . "'/>"; ?>
                <input class="block" type="file" name="fileUpload" accept="image/png, image/jpeg">
                <label for='submit' title='Submit'>
                    Submit: <input id='submit' type='submit' value='Change Profile Picture'>
                </label>
            </form>
        </div>
    </div>
</div>
<footer>
    <div>Contact:</div>
    <div>Supporthotline: +43 123 45 67 890</div>
    <div>Email: <a href="mailto:kontakt@templatecomp.at">contact@templatecomp.at</a></div>
</footer>
</body>
</html>
