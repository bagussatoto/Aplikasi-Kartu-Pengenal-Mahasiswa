<?php 

include 'header.php';

@$page = $_GET['page'];
if ($page=="" || $page=="dashboard") {
	include 'pages/dashboard.php';
}
elseif ($page=="profil") {
	include 'pages/profil.php';
}else{
	include 'error-404.php';
	// $text = "Halaman tidak ditemukan.";
	// echo sweetalert('Oops.!', $text, 'warning', '3000', 'false', '?page=dashboard');
}

include 'footer.php';

 ?>