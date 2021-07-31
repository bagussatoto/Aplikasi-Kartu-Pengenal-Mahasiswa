<?php 

$tahun_angkatan = $_GET['angkatan'];
$sql1 = $mysqli->query("SELECT angkatan_mahasiswa FROM tb_mahasiswa WHERE angkatan_mahasiswa = '$tahun_angkatan' ");
if (mysqli_num_rows($sql1) > 0) {
	

	$sql = $mysqli->query("SELECT * FROM tb_mahasiswa WHERE angkatan_mahasiswa = '$tahun_angkatan' ORDER BY tgl_input ASC");

	while ($data=mysqli_fetch_assoc($sql)) {

		// sql untuk ambil template
		$sql_t = $mysqli->query("SELECT * FROM tb_template ORDER BY id_template ASC LIMIT 1");
		$template = mysqli_fetch_array($sql_t);

		$background = imagecreatefromjpeg('../images/design_ktm/'.$template['front_template']);
		$color = imagecolorallocate($background, 0, 0, 0);
		$dir = dirname(realpath(__FILE__));
		$sep = DIRECTORY_SEPARATOR;   
		$f_arial = $dir.$sep.'arial.ttf';

		$filename = '../images/thumbs/mahasiswa/'.$data['foto_mhs'];
		$foto_mhs = imagecreatefromjpeg($filename);
		$image_size = getimagesize($filename);
		$imageWidth = $image_size[0];
		$imageHeight = $image_size[1];
		$placementX = 37;
		$placementY = 275;

		// imagecopy(dst_im, src_im, dst_x, dst_y, src_x, src_y, src_w, src_h)
		imagecopy($background, $foto_mhs, $placementX, $placementY, 0, 0, $imageWidth, $imageHeight);

		// imagettftext(image, size, angle, x, y, color, fontfile, text);
		$nois = $data['no_induk'].'/ '.$data['nisn_mahasiswa'];
		imagettftext($background, 20, 0, 530, 290, $color, $f_arial, $nois);
		// imagettftext($background, 25, 0, 587, 290, $color, $f_arial, '/');
		// imagettftext($background, 20, 0, 598, 290, $color, $f_arial, $data['nisn_mahasiswa']);
		imagettftext($background, 20, 0, 530, 325, $color, $f_arial, $data['nama_mahasiswa']);
		$ttl = $data['tempat_lahir'].', '.tgl_indonesia($data['tgl_lahir']);
		// imagettftext($background, 20, 0, 530, 360, $color, $f_arial, $data['tempat_lahir']);
		// imagettftext($background, 25, 0, 700, 360, $color, $f_arial, '/');
		imagettftext($background, 20, 0, 530, 360, $color, $f_arial, $ttl);

		$arr_str = explode(' ', $data['alamat']);
		$arr_str = array_slice($arr_str, 0, 4 );
		$alamat_baris_1 = implode(' ', $arr_str);
		imagettftext($background, 20, 0, 530, 393, $color, $f_arial, $alamat_baris_1);

		$arr_str = explode(' ', $data['alamat']);
		$arr_str = array_slice($arr_str, 4, 4 );
		$alamat_baris_2 = implode(' ', $arr_str);
		imagettftext($background, 20, 0, 530, 423, $color, $f_arial, $alamat_baris_2);

		$arr_str = explode(' ', $data['alamat']);
		$arr_str = array_slice($arr_str, 8, 4 );
		$alamat_baris_3 = implode(' ', $arr_str);
		imagettftext($background, 20, 0, 530, 453, $color, $f_arial, $alamat_baris_3);

		$arr_str = explode(' ', $data['alamat']);
		$arr_str = array_slice($arr_str, 12, 4 );
		$alamat_baris_4 = implode(' ', $arr_str);
		imagettftext($background, 20, 0, 530, 483, $color, $f_arial, $alamat_baris_4);

		$arr_str = explode(' ', $data['alamat']);
		$arr_str = array_slice($arr_str, 16, 4 );
		$alamat_baris_5 = implode(' ', $arr_str);
		imagettftext($background, 20, 0, 530, 513, $color, $f_arial, $alamat_baris_5);

		// imagettftext($background, 20, 0, 530, 393, $color, $f_arial, $alamat);
		
		$filename_qr = '../images/mahasiswa/qr_code/'.$data['qr_code'];
		$fqr_code = imagecreatefrompng($filename_qr);
		$qr_size = getimagesize($filename_qr);
		$qrWidth = $qr_size[0];
		$qrHeight = $qr_size[1];
		$placementXqr = 340; // kiri kanan
		$placementYqr = 482; // naik turun

		// imagecopy(dst_im, src_im, dst_x, dst_y, src_x, src_y, src_w, src_h)
		imagecopy($background, $fqr_code, $placementXqr, $placementYqr, 1, 1, $qrWidth, $qrHeight);

		// simpan
		$temp = "../images/kts_finish/".$tahun_angkatan;
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

// 		imagedestroy($foto_mhs);
		imagedestroy($background);

		$text = "Kartu Mahasiswa Angkatan $tahun_angkatan berhasil dibuat.";
		echo sweetalert('Selamat.!', $text, 'success', '3000', 'true', '?page=kts&tampil='.$tahun_angkatan);

	}

}else{
	$text = "Angkatan $tahun_angkatan belum ada.";
	echo sweetalert('Stop.!', $text, 'warning', '3000', 'true', '?page=kts');
}

?>