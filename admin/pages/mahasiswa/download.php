<?php 

include '../../../library/f_baseUrl.php';
if (isset($_GET['file'])) {
	$lokasi = '../../../images/mahasiswa/qr_code/';
	$fileName = $_GET['file'];

	$filePath = $lokasi.$_GET['file'];
	if (!empty($filePath)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($filePath));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: private');
		header('Pragma: private');
		header('Content-Length: ' . filesize($filePath));
		ob_clean();
		flush();
		readfile($filePath);
		exit;
	}else{
		echo "File tidak ditemukan.";
	}

}

?>