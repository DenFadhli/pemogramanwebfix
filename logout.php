<?php  

session_start();
$_SESSION = [];
session_unset();
session_destroy();
unset($_COOKIE);

header("Location:login.php");

exit;


?>