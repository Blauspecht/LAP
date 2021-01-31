<!--------------------------------------------------------------------------------------------------------------------->
<!--    Skriptname:    index.php                                                                                     -->
<!--    Author:        Peter Rudnik                                                                                  -->
<!--    Date:          20.06.2020                                                                                    -->
<!--    Version:       4                                                                                             -->
<!--    Beschreibung:  Startseite der Anwendung                                                                      -->
<!--------------------------------------------------------------------------------------------------------------------->
<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>TemplateComp AG - Webshop</title>

    <link rel="stylesheet" href="stylesheets/layout.css">
    <link rel="stylesheet" href="stylesheets/index.css">
    <link rel="icon" href="resources/logo.png">
</head>

<body>
<header>
    <img src="resources/logo.png" alt="Logo">
    <span>TemplateComp AG - Webshop</span>
    <?php
    if (!empty($_SESSION) && $_SESSION['valid']) {
        echo "<marquee class=\"rainbow\" truespeed scrolldelay=\"40\">Welcome " . $_SESSION['username'] . "!</marquee >";
    } else {
        echo "<marquee class=\"rainbow\" truespeed scrolldelay=\"40\">Party like it's 1999!</marquee>";
    }
    ?>
</header>
<nav data-topbar>
    <?php
    if (!empty($_SESSION) && $_SESSION['valid']) {
        echo "<p onclick='location.href=\"php/logout.php\"'>Logout</p>";
    } else {
        echo "<p onclick='location.href = \"login.php\"'>Login</p>";
    }
    ?>
    <p onclick="location.href=''">Home</p>
    <?php
    if (!empty($_SESSION) && $_SESSION['valid']) {
        echo "<p onclick='location.href=\"playground.php\"'>Playground</p>";
        echo "<p onclick='location.href=\"profile.php\"'>Profile</p>";
    }
    ?>
</nav>
<div class="content">
    <div class="left">
        <section class="box"><h1>Current Sale!</h1></section>
        <article class="box">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
            ut labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
            ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
            nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
            anim id est laborum.
        </article>
    </div>
    <div class="right">
        <aside class="box"><img src="resources/templateProduct.jpg" alt="Template Product"></aside>
    </div>
</div>
<footer>
    <div>Contact:</div>
    <div>Supporthotline: +43 123 45 67 890</div>
    <div>Email: <a href="mailto: kontakt@templatecomp.at">contact@templatecomp.at</a></div>
</footer>
</body>
</html>
