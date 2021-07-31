<?php 

$tahun_angkatan = $_GET['angkatan'];
$sql1 = $mysqli->query("SELECT angkatan_mahasiswa FROM tb_mahasiswa WHERE angkatan_mahasiswa = '$tahun_angkatan' ");

if (mysqli_num_rows($sql1) > 0) {
	

	$sql = $mysqli->query("SELECT * FROM tb_mahasiswa WHERE angkatan_mahasiswa = '$tahun_angkatan' ORDER BY tgl_input ASC");

	while ($data=mysqli_fetch_assoc($sql)) {

		// sql untuk ambil template
		$sql_t = $mysqli->query("SELECT * FROM tb_template LIMIT 1");
		$template = mysqli_fetch_array($sql_t);			

		$background = imagecreatefromjpeg('../images/design_ktm/'.$template['front_template']);
		$color = imagecolorallocate($background, 0, 0, 0);
		$dir = dirname(realpath(__FILE__));
		$sep = DIRECTORY_SEPARATOR;   
		$f_bahnscript = $dir.$sep.'bahnscript.ttf';
		$f_futura = $dir.$sep.'futuramdbt.ttf';

		$filename = '../images/thumbs/rounded/'.$data['foto_mahasiswa'];
		// $desti_bunder = '../images/thumbs/rounded/'.$data['foto_mahasiswa'];
		// createRoundImage($filename, $desti_bunder, $radius = 100);
		
		$foto_mahasiswa = imagecreatefrompng($filename);
		$image_size = getimagesize($filename);
		$imageWidth = $image_size[0];
		$imageHeight = $image_size[1];
		$placementX = 853; // kanan kiri
		$placementY = 196; // naik turun

		// imagecopy(dst_im, src_im, dst_x, dst_y, src_x, src_y, src_w, src_h)
		imagecopy($background, $foto_mahasiswa, $placementX, $placementY, 0, 0, $imageWidth, $imageHeight);

		// imagettftext(image, size, angle, x, y, color, fontfile, text);
		imagettftext($background, 35, 0, 86, 280, $color, $f_futura, $data['nama_mahasiswa']);

		$nois = $data['no_induk'];
		imagettftext($background, 23, 0, 430, 330, $color, $f_bahnscript, $nois);

		imagettftext($background, 23, 0, 430, 380, $color, $f_bahnscript, $data['nisn_mahasiswa']);

		$ttl = $data['tempat_lahir'].', '.tgl_indonesia($data['tgl_lahir']);
		imagettftext($background, 23, 0, 430, 430, $color, $f_bahnscript, $ttl);

		$arr_str = explode(' ', $data['alamat']);
		$arr_str = array_slice($arr_str, 0, 6 );
		$alamat_baris_1 = implode(' ', $arr_str);
		imagettftext($background, 23, 0, 430, 480, $color, $f_bahnscript, $alamat_baris_1);

		$arr_str = explode(' ', $data['alamat']);
		$arr_str = array_slice($arr_str, 6, 6 );
		$alamat_baris_2 = implode(' ', $arr_str);
		imagettftext($background, 23, 0, 430, 510, $color, $f_bahnscript, $alamat_baris_2);

		$arr_str = explode(' ', $data['alamat']);
		$arr_str = array_slice($arr_str, 12, 6 );
		$alamat_baris_3 = implode(' ', $arr_str);
		imagettftext($background, 23, 0, 430, 540, $color, $f_bahnscript, $alamat_baris_3);

		$arr_str = explode(' ', $data['alamat']);
		$arr_str = array_slice($arr_str, 18, 6 );
		$alamat_baris_4 = implode(' ', $arr_str);
		imagettftext($background, 23, 0, 430, 570, $color, $f_bahnscript, $alamat_baris_4);

		$arr_str = explode(' ', $data['alamat']);
		$arr_str = array_slice($arr_str, 22, 6 );
		$alamat_baris_5 = implode(' ', $arr_str);
		imagettftext($background, 23, 0, 430, 600, $color, $f_bahnscript, $alamat_baris_5);

		$arr_str = explode(' ', $data['alamat']);
		$arr_str = array_slice($arr_str, 28, 6 );
		$alamat_baris_6 = implode(' ', $arr_str);
		imagettftext($background, 23, 0, 430, 630, $color, $f_bahnscript, $alamat_baris_6);

		$filename_qr = '../images/mahasiswa/qr_code/'.$data['qr_code'];
		$fqr_code = imagecreatefrompng($filename_qr);
		$qr_size = getimagesize($filename_qr);
		$qrWidth = $qr_size[0];
		$qrHeight = $qr_size[1];
		$placementXqr = 83; // kiri kanan
		$placementYqr = 490; // naik turun

		// imagecopy(dst_im, src_im, dst_x, dst_y, src_x, src_y, src_w, src_h)
		imagecopy($background, $fqr_code, $placementXqr, $placementYqr, 1, 1, $qrWidth, $qrHeight);

		// Tanggal baut
		$tanggal = date('Y-m-d');
		$tanggal_buat = "Tanjunganom, ".tgl_indonesia($tanggal);
		imagettftext($background, 15, 0, 655, 600, $color, $f_bahnscript, $tanggal_buat);

		// simpan
		$temp = "../images/ktm_finish/".$tahun_angkatan;
		if (!file_exists($temp)) {
			mkdir($temp);
		}
		$ex = explode(" ", $data['nama_mahasiswa']);
		$im = implode("-", $ex);
		$nama_file = strtolower($im).'-'.$data['nisn_mahasiswa'].'.png';

		$sqlCek = $mysqli->query("SELECT * FROM tb_ktm WHERE tahun_ktm = '$tahun_angkatan' AND nama_file = '$nama_file'");
		if (mysqli_num_rows($sqlCek) > 0) {
			$mysqli->query("DELETE FROM tb_ktm WHERE nama_file = '$nama_file'");
		}
		
		$mysqli->query("INSERT INTO tb_ktm SET nisn_mahasiswa = '$data[nisn_mahasiswa]', tahun_ktm = '$tahun_angkatan', nama_file = '$nama_file' ");
		imagepng($background, $temp.'/'.$nama_file);

// 		imagedestroy($foto_mahasiswa);
		imagedestroy($background);

		$text = "Kartu Mahasiswa Angkatan $tahun_angkatan berhasil dibuat.";
		// echo sweetalert('Selamat.!', $text, 'success', '3000', 'true', '?page=ktm&tampil='.$tahun_angkatan);

	}

}else{
	$text = "Angkatan $tahun_angkatan belum ada.";
	// echo sweetalert('Stop.!', $text, 'warning', '3000', 'true', '?page=ktm');
}

?>