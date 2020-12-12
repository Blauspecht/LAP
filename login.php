<!--------------------------------------------------------------------------------------------------------------------->
<!--    Skriptname:    login.php                                                                                     -->
<!--    Author:        Peter Rudnik                                                                                  -->
<!--    Date:          20.06.2020                                                                                    -->
<!--    Version:       4                                                                                             -->
<!--    Beschreibung:  Login- und Registrierungsseite                                                                -->
<!--------------------------------------------------------------------------------------------------------------------->
<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>TemplateComp AG - User Login</title>

    <link rel="stylesheet" href="stylesheets/layout.css">
    <link rel="stylesheet" href="stylesheets/login.css">
</head>

<?php
if (!empty($_SESSION) && $_SESSION['valid']) {
    header("Location: index.php");
}
?>
<body>
<header>
    <img src="resources/logo.png" alt="Logo">
    <span>TemplateComp AG - User Login</span>
    <marquee class="rainbow" truespeed scrolldelay="40">Party like it's 1999!</marquee>
</header>
<nav data-topbar>
    <p onclick="location.href=''">Login</p>
    <p onclick="location.href='index.php'">Home</p>
</nav>
<div class='content'>
    <div class='loginForm box'>
        <h2 style='padding: 10px'>Login:</h2>
        <form id='loginForm' action='php/loginUser.php' method='post'>
            <input class='block' type='email' name='email' placeholder='E-Mail *'>
            <input class='block' type='password' name='password' placeholder='Password *'
                   pattern='.{8,}' title='Min. 8 Characters' required>
            <br>
            <input class='block' type='submit' value='Login'>
        </form>
    </div>

    <div class="registerForm box">
        <h2 class="heading">Register:</h2>
        <form id="registerForm" action="php/register.php" method="post" enctype="multipart/form-data">
            <div class="register-container">
                <div class="accountInfo">
                    <h3>Account Info</h3>
                    <div class="block height">
                        <input type="radio" id="male" name="gender" value="male" checked>
                        <label for="male">Male</label>
                        <input type="radio" id="female" name="gender" value="female">
                        <label for="female">Female</label>
                        <input type="radio" id="other" name="gender" value="other">
                        <label for="other">Other</label>
                    </div>
                    <input class="block" type="text" name="name" placeholder="Name *" pattern="[A-Za-z\s]{3,}"
                           title="Min. 3 Characters(A-Z and a-z)"
                           required
                    >
                    <input class="block" name="bday" type="date">
                    <input class="block" type="email" name="email" placeholder="E-Mail *">
                    <input class="block" type="password" name="password1" placeholder="Password *" pattern=".{8,}"
                           title="Min. 8 Characters"
                           required>
                    <input class="block" type="password" name="password2" placeholder="Repeat Password *"
                           pattern=".{8,}" title="Min. 8 Characters" required>
                </div>
                <div class="adressInfo">
                    <h3>Adress Info</h3>
                    <input class="block" type="text" name="street" placeholder="Street *" required>
                    <input class="block" type="text" name="streetNr" placeholder="Number *" required>
                    <input class="block" type="text" name="city" placeholder="City *" required>
                    <div class="block height">
                        <label for="state">State*</label>
                        <select id="state" name="stateList" form="registerForm" required>
                            <option value="">Choose a state!</option>
                            <option value="burgenland">Burgenland</option>
                            <option value="kaernten">Kärnten</option>
                            <option value="noesterreich">Niederösterreich</option>
                            <option value="ooesterreich">Oberösterreich</option>
                            <option value="salzburg">Salzburg</option>
                            <option value="steiermark">Steiermark</option>
                            <option value="tirol">Tirol</option>
                            <option value="vorarlberg">Vorarlberg</option>
                            <option value="wien">Wien</option>
                        </select>
                    </div>
                    <input class="block" type="text" name="plz" placeholder="Postalcode *" required
                           pattern="[\d]{4}" title="4 Digits">
                </div>
            </div>
            <div class="fileInfo">
                <h3>Profile Picture Upload</h3>
                <input class="block" type="file" name="fileUpload" accept="image/png, image/jpeg">
            </div>
            <br>
            <input type="submit" value="Register!">
            <input type="reset" value="Clear form">
        </form>
    </div>
</div>
<footer>
    <div>Contact:</div>
    <div>Supporthotline: +43 123 45 67 890</div>
    <div>Email: <a href="mailto:kontakt@templatecomp.at">contact@templatecomp.at</a></div>
</footer>
</body>
</html>
