<!--------------------------------------------------------------------------------------------------------------------->
<!--    Skriptname:    playground.php                                                                                -->
<!--    Author:        Peter Rudnik                                                                                  -->
<!--    Date:          20.06.2020                                                                                    -->
<!--    Version:       4                                                                                             -->
<!--    Beschreibung:  Spielwiese für eingeloggte User                                                               -->
<!--------------------------------------------------------------------------------------------------------------------->
<?php
session_start();
if (empty($_SESSION) || !$_SESSION['valid']) {
    header("Location: login.php");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>TemplateComp AG - Playground</title>

    <link rel="stylesheet" href="stylesheets/layout.css">
    <link rel="stylesheet" href="stylesheets/playground.css">
</head>

<body>
<header>
    <img src="resources/logo.png" alt="Logo">
    <span>TemplateComp AG - Playground</span>
    <?= "<marquee class=\"rainbow\" truespeed scrolldelay=\"40\">Welcome " . $_SESSION['username'] . "!</marquee >"; ?>
</header>
<nav data-topbar>
    <?php
    if (!empty($_SESSION) && $_SESSION['valid']) {
        echo "<p onclick='location.href=\"/php/logout.php\"'>Logout</p>";
    }
    ?>
    <p onclick="location.href='index.php'">Home</p>
    <p onclick="location.href=''">Playground</p>
    <p onclick="location.href='profile.php'">Profile</p>
</nav>
<div class="content">
    <div>
        <div id="dosbox"></div>
        <br/>
        <button onclick="dosbox.requestFullScreen();">Make fullscreen</button>
        <br>
    </div>

    <script type="text/javascript" src="data/js-dos-api.js"></script>
    <script type="text/javascript">
        dosbox = new Dosbox({
            id: "dosbox",
            onload: function (dosbox) {
                dosbox.run("https://cdn.rawgit.com/darrengruber/docker-em-dosbox-doom/afad47b2/doom_shareware/doom19s_deiced.zip", "./DOOM.EXE");
            },
            onrun: function (dosbox, app) {
                console.log("App '" + app + "' is runned");
            }
        });
    </script>
</div>
<footer>
    <div>Contact:</div>
    <div>Supporthotline: +43 123 45 67 890</div>
    <div>Email: <a href="mailto:kontakt@templatecomp.at">contact@templatecomp.at</a></div>
</footer>
</body>
</html>
