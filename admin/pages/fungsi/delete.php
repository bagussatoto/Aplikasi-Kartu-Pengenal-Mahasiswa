<?php 
$id_fungsi = $_GET['id'];
$sql = $mysqli->query("SELECT * FROM tb_fungsi WHERE id_fungsi = '$id_fungsi'");

$update = $mysqli->query("DELETE FROM tb_fungsi WHERE id_fungsi = '$id_fungsi'");
if ($update) {
	$text = "Data Berhasil Dihapus.";
	echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '?page=fungsi');
}
?>