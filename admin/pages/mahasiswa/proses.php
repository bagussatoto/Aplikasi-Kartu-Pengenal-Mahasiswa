<?php 


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
if (isset($_POST['submit'])) {
	
	include '../../../library/config.php';
	include '../../../library/f_baseUrl.php';
	include '../../../library/f_qrCode.php';
	require '../../../vendor/autoload.php';
	require '../../../phpqrcode/qrlib.php';

	$file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

	if(isset($_FILES['berkas_excel']['name']) && in_array($_FILES['berkas_excel']['type'], $file_mimes)) {

		$arr_file = explode('.', $_FILES['berkas_excel']['name']);
		$extension = end($arr_file);

		if('csv' == $extension) {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
		} else {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		}

		$spreadsheet = $reader->load($_FILES['berkas_excel']['tmp_name']);

		$sheetData = $spreadsheet->getActiveSheet()->toArray();
		for($i = 1;$i <= count($sheetData);$i++)
		{
			$nim_mahasiswa		= $sheetData[$i]['0'];
			$nama_mahasiswa 	= $sheetData[$i]['1'];
			$tempat_lahir		= $sheetData[$i]['2'];
			$tgl_lahir			= $sheetData[$i]['3'];
			$alamat				= $sheetData[$i]['4'];
			$angkatan_mahasiswa	= $sheetData[$i]['5'];
			$gender				= $sheetData[$i]['6'];
			$email				= $sheetData[$i]['7'];

			$tgl_baru = date('Y-m-d', strtotime($tgl_lahir));

		// qr code script
			$tempdir = "../../../images/mahasiswa/qr_code/";
			$pathLogo = "../../../images/logo-qr-code.png";
			$ex = explode(" ", $nama_mahasiswa);
			$im = implode("-", $ex);
			$file_qr = strtolower($im).'-'.$nim_mahasiswa.'.png';
			$value = $nim_mahasiswa;
			$nama_file = $file_qr;

			echo qr_code_logo($tempdir, $pathLogo, $value, $nama_file);

			$password = "123456";
			$options = ['cost' => 10];					
			$password_hash = password_hash($password, PASSWORD_DEFAULT, $options);
			$mysqli->query("INSERT INTO tb_mahasiswa SET 
				nama_mahasiswa 		= '$nama_mahasiswa', 
				nim_mahasiswa 		= '$nim_mahasiswa',
				tempat_lahir 		= '$tempat_lahir',
				tgl_lahir 			= '$tgl_baru',
				alamat 				= '$alamat',
				angkatan_mahasiswa 	= '$angkatan_mahasiswa',
				gender 				= '$gender',
				email_mahasiswa 	= '$email',
				password_mahasiswa 	= '$password_hash',
				qr_code 			= '$file_qr'
				");
		}
		header("Location: ".base_url('admin/?page=mahasiswa')); 
	}
}

?>