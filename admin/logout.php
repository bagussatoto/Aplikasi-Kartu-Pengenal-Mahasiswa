<?php 
session_start();
session_destroy();
unset($_SESSION['logedin']);
unset($_SESSION['id_ser']);
header('Location: login.php');
?>