<?php 

error_reporting(0);
$tahun_angkatan = $_GET['angkatan'];
$sql1 			= $mysqli->query("SELECT angkatan_mahasiswa FROM tb_mahasiswa WHERE angkatan_mahasiswa = '$tahun_angkatan' ");


if ($sql1->num_rows > 0) {
	
	$sql = $mysqli->query("SELECT tb_jurusan.*, tb_mahasiswa.* FROM tb_mahasiswa LEFT JOIN tb_jurusan ON tb_mahasiswa.jurusan_mahasiswa = tb_jurusan.id_jurusan WHERE angkatan_mahasiswa = '$tahun_angkatan' ORDER BY tgl_input ASC");

	while ($data = mysqli_fetch_assoc($sql)) {
		
		// sql untuk ambil template
		$sql_t 			= $mysqli->query("SELECT * FROM tb_template LIMIT 1");
		$template 		= mysqli_fetch_array($sql_t);			

		$background 	= imagecreatefromjpeg('../images/design_ktm/'.$template['front_template']);
		$color 			= imagecolorallocate($background, 0, 0, 0);
		$background2 	= imagecreatefromjpeg('../images/design_ktm/'.$template['beck_template']);
		$color2 		= imagecolorallocate($background2, 0, 0, 0);
		
		$dir 			= dirname(realpath(__FILE__));
		$sep 			= DIRECTORY_SEPARATOR;   
		$f_arial	 	= $dir.$sep.'arial.ttf';

		$filename = '../images/thumbs/mahasiswa/'.$data['foto_mahasiswa'];
		$foto_mahasiswa = imagecreatefromjpeg($filename);
		$image_size = getimagesize($filename);
		$imageWidth = $image_size[0];
		$imageHeight = $image_size[1];
		$placementX = 32;
		$placementY = 219;

		// imagecopy(dst_im, src_im, dst_x, dst_y, src_x, src_y, src_w, src_h)
		imagecopy($background, $foto_mahasiswa, $placementX, $placementY, 0, 0, $imageWidth, $imageHeight);

		// imagettftext(image, size, angle, x, y, color, fontfile, text);
		imagettftext($background, 25, 0, 295, 245, $color, $f_arial, $data['nama_mahasiswa']);
		imagettftext($background, 25, 0, 295, 325, $color, $f_arial, $data['nama_jurusan']);
		imagettftext($background, 25, 0, 295, 405, $color, $f_arial, $data['nim_mahasiswa']);
		imagettftext($background, 25, 0, 295, 485, $color, $f_arial, $data['angkatan_mahasiswa']);

		$filename_qr 	= '../images/mahasiswa/qr_code/'.$data['qr_code'];
		$fqr_code 		= imagecreatefrompng($filename_qr);
		$qr_size 		= getimagesize($filename_qr);
		$qrWidth 		= $qr_size[0];
		$qrHeight 		= $qr_size[1];
		$placementXqr 	= 820; // kiri kanan
		$placementYqr 	= 219; // naik turun

		// imagecopy(dst_im, src_im, dst_x, dst_y, src_x, src_y, src_w, src_h)
		imagecopy($background, $fqr_code, $placementXqr, $placementYqr, 1, 1, $qrWidth, $qrHeight);

		// nama kepala sekolah, stempel, tanda tangan
		imagettftext($background, 20, 0, 710, 580, $color, $f_arial, $template['nama_kepsek']);

		$tanda_tangan 	= "../images/design_ktm/".$template['tanda_tangan'];
		$ttd 			= imagecreatefrompng($tanda_tangan);
		$ttd_size 		= getimagesize($tanda_tangan);
		$ttd_width 		= $ttd_size[0];
		$ttd_height		= $ttd_size[1];
		$ttd_placementX = 715; # kiri kanan
		$ttd_placementY = 480; # atas bawah
		imagecopy($background, $ttd, $ttd_placementX, $ttd_placementY, 0, 0, $ttd_width, $ttd_height);

		$stempel 			= "../images/design_ktm/".$template['stempel'];	
		$stmp 				= imagecreatefrompng($stempel);

		// =================================
		// miringkan stempel
		// =================================
		$angle 				= 20; # derajat
		$rotation 			= imagerotate($stmp, $angle, imageColorAllocateAlpha($stmp, 0, 0, 0, 127));
		imagealphablending($rotation, false);
		imagesavealpha($rotation, true);
		header('Content-type: image/png');
		imagepng($rotation, "../images/design_ktm/stempel-baru.png");
		imagedestroy($stmp);
		imagedestroy($rotation);

		$stempel_baru 		= "../images/design_ktm/stempel-baru.png";
		$stmp_baru 			= imagecreatefrompng($stempel_baru);
		$stmp_size 			= getimagesize($stempel_baru);
		$stmp_width 		= $stmp_size[0];
		$stmp_height		= $stmp_size[1];
		$stmp_placementX 	= 650; # kiri kanan
		$stmp_placementY 	= 437; # atas bawah
		imagecopy($background, $stmp_baru, $stmp_placementX, $stmp_placementY, 0, 0, $stmp_width, $stmp_height);
		
		// simpan
		$temp = "../images/ktm_finish/".$tahun_angkatan;
		if (!file_exists($temp)) {
			mkdir($temp);
		}
		$ex 	= explode(" ", $data['nama_mahasiswa']);
		$im 	= implode("-", $ex);
		$front 	= strtolower($im).'-'.$data['nim_mahasiswa'].'.png';
		$beck 	= strtolower($im).'-'.$data['nim_mahasiswa'].'-beck.png';

		$sqlCek = $mysqli->query("SELECT * FROM tb_ktm WHERE tahun_ktm = '$tahun_angkatan' AND front_file = '$front'");
		if (mysqli_num_rows($sqlCek) > 0) {
			$mysqli->query("DELETE FROM tb_ktm WHERE front_file = '$front'");
		}
		
		$mysqli->query("INSERT INTO tb_ktm SET nim_mahasiswa = '$data[nim_mahasiswa]', tahun_ktm = '$tahun_angkatan', front_file = '$front', beck_file = '$beck' ");
		imagepng($background, $temp.'/'.$front);
		imagepng($background2, $temp.'/'.$beck);

// 		imagedestroy($foto_mahasiswa);
		imagedestroy($background);
		imagedestroy($background2);

		$text = "Kartu Mahasiswa Angkatan $tahun_angkatan berhasil dibuat.";
		echo sweetalert('Selamat.!', $text, 'success', '3000', 'true', '?page=ktm&tampil='.$tahun_angkatan);

	}

}else{
	$text = "Angkatan $tahun_angkatan belum ada.";
	echo sweetalert('Stop.!', $text, 'warning', '3000', 'true', '?page=ktm');
}

?>