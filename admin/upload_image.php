<?php 

if (isset($_FILES['file']['name'])) {
	$sumber = $_FILES['file']['tmp_name'];
	$extensi = explode('.', $_FILES['file']['name']);
	$nama_foto = time().'.'.end($extensi);
	$imageFileType = strtolower(pathinfo($nama_foto, PATHINFO_EXTENSION));

	move_uploaded_file($sumber, '../images/posts/'.$nama_foto);
	// make thumbnail
	createThumbs('../images/posts/', '../images/thumbs/posts/', 200);
}

?>