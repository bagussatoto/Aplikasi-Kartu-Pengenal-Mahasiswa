<?php 
$id_sosmed = $_GET['id'];
$sql = $mysqli->query("SELECT * FROM tb_sosmed WHERE id_sosmed = '$id_sosmed'");

$update = $mysqli->query("DELETE FROM tb_sosmed WHERE id_sosmed = '$id_sosmed'");
if ($update) {
	$text = "Data Berhasil Dihapus.";
	echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '?page=pengaturan');
}
?>