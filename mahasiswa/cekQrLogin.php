<?php 
session_start();

require_once '../library/config.php';
include '../library/f_baseUrl.php';
include '../library/f_library.php';
include '../library/f_notification.php';

$id = $_POST['id'];

?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/sweetalert2.css'); ?>">
<script src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
<script src="<?= base_url('assets/js/sweetalert.min.js') ?>"></script>

<?php
$sql = $mysqli->query("SELECT * FROM tb_mahasiswa WHERE nim_mahasiswa = '$id'");
$data = mysqli_fetch_array($sql);
if (mysqli_num_rows($sql) > 0) {
	$_SESSION['logedin_mahasiswa'] = TRUE;
	$_SESSION['nim_mahasiswa'] = $data['nim_mahasiswa'];
	$_SESSION['id_mahasiswa'] = $data['id_mahasiswa'];
	$_SESSION['nama_mahasiswa'] = $data['nama_mahasiswa'];

 	// $url = base_url('mahasiswa');
	$text = $data['nama_mahasiswa']." berhasil login.";
	echo sweetalert('Selamat.!', $text, 'success', '3000', 'false', '.');
}else{
	$text = "NIM $id tidak ada pada data mahasiswa.";
	echo sweetalert('Oops.!', $text, 'warning', '3000', 'false', 'qr-login.php');
}

?>