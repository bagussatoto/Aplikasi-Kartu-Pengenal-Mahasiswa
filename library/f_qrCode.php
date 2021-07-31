<?php 

function qr_code_logo($path, $pathLogo, $value, $name_file)
{
	// folder untuk simpan qr
	$tempdir = $path;
	// buat folder jika belum ada
	if (!file_exists($tempdir)) {
		mkdir($tempdir);
	}
	// logo untuk qr
	$logoPath = $pathLogo;
	// isi qr
	$codeContents = $value;
	// buat qr
	QRcode::png($codeContents, $tempdir.$name_file, QR_ECLEVEL_H, 7, 1);

	// ambil file qr
	$QR = imagecreatefrompng($tempdir.$name_file);
	// mulai gambar
	$logo = imagecreatefromstring(file_get_contents($logoPath));
	imagecolortransparent($logo, imagecolorallocatealpha($logo, 0, 0, 0, 127));
	imagealphablending($logo, false);
	imagesavealpha($logo, true);

	$QR_width = imagesx($QR);
	$QR_height = imagesy($QR);

	$logoWidth = imagesx($logo);
	$logoHeight = imagesy($logo);

	// scale logo
	$logoQrWidth = $QR_width / 5;
	$scale = $logoWidth / $logoQrWidth;

	$logoQrHeight = $logoHeight / $scale;

	imagecopyresampled($QR, $logo, $QR_width/2.4, $QR_height/2.4, 0, 0, $logoQrWidth, $logoQrHeight, $logoWidth, $logoHeight);

	// save qr with logo
	imagepng($QR, $tempdir.$name_file);

}

 ?>