<?php 
session_start();
session_destroy();
unset($_SESSION['logedin_mahasiswa']);
unset($_SESSION['nisn_mahasiswa']);
header('Location: qr-login.php');
?>