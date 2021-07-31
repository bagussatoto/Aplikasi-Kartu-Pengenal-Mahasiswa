<?php 
error_reporting(0);
$id_mahasiswa = $_GET['id'];
$sql = $mysqli->query("SELECT * FROM tb_mahasiswa WHERE id_mahasiswa = '$id_mahasiswa'");

$foto_awal = $mysqli->query("SELECT * FROM tb_mahasiswa WHERE id_mahasiswa = '$id_mahasiswa'")->fetch_object()->foto_mhs;
unlink('../images/thumbs/rounded/'.$foto_awal);
unlink('../images/thumbs/mahasiswa/'.$foto_awal);
unlink('../images/mahasiswa/'.$foto_awal);

$qr_code = $mysqli->query("SELECT * FROM tb_mahasiswa WHERE id_mahasiswa = '$id_mahasiswa'")->fetch_object()->qr_code;
unlink('../images/mahasiswa/qr_code/'.$qr_code);

$update = $mysqli->query("DELETE FROM tb_mahasiswa WHERE id_mahasiswa = '$id_mahasiswa'");
if ($update) {
	$text = "Data Berhasil Dihapus.";
	echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '?page=mahasiswa');
}
?>