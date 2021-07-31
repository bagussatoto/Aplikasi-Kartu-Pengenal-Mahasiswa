<?php 
error_reporting(0);
$id_user = $_GET['id'];
$sql = $mysqli->query("SELECT * FROM tb_user WHERE id_user = '$id_user'");

$foto_awal = $mysqli->query("SELECT * FROM tb_user WHERE id_user = '$id_user'")->fetch_object()->foto;
unlink('../images/thumbs/user/'.$foto_awal);
unlink('../images/user/'.$foto_awal);
$update = $mysqli->query("DELETE FROM tb_user WHERE id_user = '$id_user'");
if ($update) {
	$text = "Data Berhasil Dihapus.";
	echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '?page=users');
}
?>