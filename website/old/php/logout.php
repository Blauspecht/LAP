<!--------------------------------------------------------------------------------------------------------------------->
<!--    Skriptname:    logout.php                                                                                    -->
<!--    Author:        Peter Rudnik                                                                                  -->
<!--    Date:          20.06.2020                                                                                    -->
<!--    Version:       4                                                                                             -->
<!--    Beschreibung:  Logout Seite zum Session zerstören                                                            -->
<!--------------------------------------------------------------------------------------------------------------------->
<!DOCTYPE html>
<html>
<body>

<?php
session_start();
$email = $_SESSION['email'];
session_unset();
session_destroy();
error_log("I: Destroyed session for user: $email", 0);
echo "<script type='text/javascript'>window.location.assign('../index.php')</script>";
?>

</body>
</html>