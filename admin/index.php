<?php 

include 'header.php'; 

@$page = $_GET['page'];
if ($page=="" || $page=="dashboard") {
	include 'pages/dashboard.php';
}
elseif ($page=="profil") {
	include 'pages/profil.php';
}
// Users
elseif ($page=="users") {
	include 'pages/users/data.php';
}
elseif ($page=="edit_user") {
	include 'pages/users/edit.php';
}
elseif ($page=="add_user") {
	include 'pages/users/add.php';
}
elseif ($page=="delete_user") {
	include 'pages/users/delete.php';
}
// Carousel
elseif ($page=="carousel") {
	include 'pages/carousel/data.php';
}
elseif ($page=="add_carousel") {
	include 'pages/carousel/add.php';
}
elseif ($page=="delete_carousel") {
	include 'pages/carousel/delete.php';
}
// jurusan
elseif ($page=="jurusan") {
	include 'pages/jurusan/data.php';
}
// mahasiswa
elseif ($page=="mahasiswa") {
	include 'pages/mahasiswa/data.php';
}
elseif ($page=="add_mahasiswa") {
	include 'pages/mahasiswa/add.php';
}elseif ($page=='edit_mahasiswa') {
	include 'pages/mahasiswa/edit.php';
}elseif ($page=='delete_mahasiswa') {
	include 'pages/mahasiswa/delete.php';
}elseif ($page=="upload-excel") {
	include 'pages/mahasiswa/proses.php';
}
// ktm
elseif ($page=="ktm") {
	include 'pages/ktm/data.php';
}
elseif ($page=="create_ktm") {
	include 'pages/ktm/create_ktm.php';
}
elseif ($page=="print-pdf") {
	include 'pages/ktm/print-pdf.php';
}
elseif ($page=="template") {
	include 'pages/template/data.php';
}
elseif ($page=="pengaturan") {
	include 'pages/pengaturan/data.php';
}
elseif ($page=="fungsi") {
	include 'pages/fungsi/data.php';
}
elseif ($page=="del-fungsi") {
	include 'pages/fungsi/delete.php';
}
elseif ($page=="hapus-sosmed") {
	include 'pages/pengaturan/delete_sosmed.php';
}else{
	include 'error-404.php';
	// $text = "Halaman tidak ditemukan.";
	// echo sweetalert('Oops.!', $text, 'warning', '3000', 'false', '?page=dashboard');
}

include 'footer.php';

 ?>