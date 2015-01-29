<?php
//include "../lib/config.php";
session_start();
session_unset($_SESSION['username']);
session_unset($_SESSION['password']);
session_unset($_SESSION['level']);
session_unset($_SESSION['avatar']);
session_destroy();
header("location: login.php");
?>