<?php 
$id_user = $_GET['id'];
$sql = $mysqli->query("SELECT * FROM tb_user WHERE id_user = '$id_user'");
$data = mysqli_fetch_array($sql);
?>
<div class="app-title">
	<div>
		<h1>
			<a href="<?= $_SERVER['HTTP_REFERER']; ?>" class="btn btn-default"><i class="fa fa-chevron-left"></i></a>&nbsp;
			<i class="fa fa-user-secret"></i> Edit Users
		</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="?page=users">Users</a></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">Edit</a></li>
	</ul>
</div>

<div class="row user">
	<div class="col-md-12">
		<div class="profile">
			<div class="info">
				<?php 
				$file = file_exists(base_url('images/thumbs/user/'.$data['foto']));
				if(!$file && !empty($data['foto'])):
					?>
					<?php 
					$errors = array();
					if (isset($_POST['hapus_foto'])) {
						$update_id = sanitize($_POST['id']);
						$foto_awal = $mysqli->query("SELECT * FROM tb_user WHERE id_user = '$update_id'")->fetch_object()->foto;
						unlink('../images/thumbs/user/'.$foto_awal);
						unlink('../images/user/'.$foto_awal);
						$update = $mysqli->query("UPDATE tb_user SET foto = '' WHERE id_user = '$update_id'");
						if ($update) {
							$text = "Foto Berhasil Dihapus.";
							echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '?page=edit_user&id='.$update_id);
						}

					}
					?>
					<div id="lightgallery">
						<a title="<?= $data['full_name']; ?>" href="<?= base_url('images/user/'.$data['foto']); ?>">
							<img class="user-img rounded-circle" src="<?= base_url('images/thumbs/user/'.$data['foto']); ?>" />
						</a>
					</div>
					<form action="" method="POST">
						<input type="hidden" name="id" value="<?= $data['id_user']; ?>">
						<button type="submit" name="hapus_foto" class="btn btn-block btn-danger">Hapus <i class="fa fa-trash"></i></button>
						</form><?php else: ?>

						<div class="col-md-6">							
							<?php 
							$errors = array();
							if (isset($_POST['up_foto'])) {
								$update_id = sanitize($_POST['id']);

								$extensi = explode('.', $_FILES['foto']['name']);
								$nama_foto = $data['username'].'-'.round(microtime(true)).'.'.end($extensi);
								$sumber = $_FILES['foto']['tmp_name'];
								$uploadOk = 1;
								$imageFileType = strtolower(pathinfo($nama_foto, PATHINFO_EXTENSION));

								$check = getimagesize($sumber);
								if ($check==false) {
									$errors[] = "Type File Harus Gambar.";
									$uploadOk = 0;
								}
								if (file_exists($nama_foto)) {
									$errors[] = "File Sudah Ada.";
									$uploadOk = 0;
								}
								if ($_FILES['foto']['size'] > 2000000) {
									$errors[] = "Ukuran File Maksimal 2Mb.";
									$uploadOk = 0;
								}
								if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
									&& $imageFileType != "gif" ) {
									$errors[] = "Etensi File Harus JPG, JPEG, PNG atau Gif.";
								$uploadOk = 0;
							}
							if ($uploadOk==0) {
								$errors[] = "Upload Foto Gagal.";
							}else{
								if (!empty($errors)) {
									echo display_errors($errors);
								}else{
									$update = $mysqli->query("UPDATE tb_user SET foto = '$nama_foto' WHERE id_user = '$update_id'");
									if($update){
										move_uploaded_file($sumber, '../images/user/'.$nama_foto);
									// make thumbnail
										createThumbs('../images/user/', '../images/thumbs/user/', 300);
										$text = "Upload Foto Berhasil.";
										echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '?page=edit_user&id='.$update_id);
									}
								}
							}
						}
						?>
					</div>
					<form class="text-center" method="POST" action="" enctype="multipart/form-data">
						<div class="form-group">
							<input type="file" name="foto" class="dropify">
						</div>
						<div class="form-group">
							<input type="hidden" name="id" value="<?= $data['id_user']; ?>">
							<button type="submit" name="up_foto" class="btn btn-block btn-info">Upload <i class="fa fa-send fa-lg"></i></button>
						</div>
					</form>
				<?php endif; ?>
				<h4><?= $data['full_name']; ?></h4>
			</div>
			<!-- <div class="cover-image"></div> -->
		</div>
	</div>
	<div class="col-md-3">
		<div class="tile p-0">
			<ul class="nav flex-column nav-tabs user-tabs">
				<li class="nav-item"><a class="nav-link active" href="#user-info" data-toggle="tab">Info</a></li>
			</ul>
		</div>
	</div>
	<div class="col-md-9">
		<div class="tab-content">
			<div class="tab-pane active" id="user-info">
				<div class="tile user-info">
					<h4 class="line-head">Info</h4>
					<?php 
					$errors = array();
					if (isset($_POST['edit_info'])) {
						$update_id 	= sanitize($_POST['id']);
						$full_name 	= sanitize($_POST['full_name']);
						$username 	= sanitize($_POST['username']);
						$email 		= sanitize($_POST['email']);

						if (empty($full_name) || empty($username) || empty($email)) {
							$errors[] = "Kolom tidak boleh kosong.";
						}

						$sqlCekUsername = $mysqli->query("SELECT * FROM tb_user WHERE username='$username' AND id_user != '$update_id'");
						if (mysqli_num_rows($sqlCekUsername) > 0) {
							$errors[] = "Username $username sudah digunakan. Mohon gunakan yang lain.";
						}

						$sqlCekEmail = $mysqli->query("SELECT * FROM tb_user WHERE email='$email' AND id_user != '$update_id'");
						if (mysqli_num_rows($sqlCekEmail) > 0) {
							$errors[] = "Email $email sudah digunakan. Mohon gunakan yang lain.";
						}

						if (!empty($errors)) {
							echo display_errors($errors);
						}else{
							$update = $mysqli->query("UPDATE tb_user SET full_name = '$full_name', username = '$username', email = '$email' WHERE id_user = '$update_id'");
							if ($update) {
								$text = "Data $full_name berhasil diupdate.";
								echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '?page=edit_user&id='.$update_id);
							}
						}
					}
					?>
					<form method="POST" action="">
						<div class="row">
							<div class="col-md-8 mb-1">
								<label>Full Name</label>
								<input class="form-control" type="text" name="full_name" value="<?= $data['full_name']; ?>" placeholder="Full Name" autofocus>
							</div>
							<div class="clearfix"></div>
							<div class="col-md-8 mb-1">
								<label>Username</label>
								<input class="form-control" type="text" name="username" value="<?= $data['username']; ?>" placeholder="Username">
							</div>
							<div class="clearfix"></div>
							<div class="col-md-8 mb-1">
								<label>Email</label>
								<input class="form-control" type="email" name="email" value="<?= $data['email'] ?>" placeholder="Email">
							</div>
						</div>
						<div class="row mb-10">
							<div class="col-md-12">
								<input type="hidden" name="id" value="<?= $data['id_user']; ?>">
								<button class="btn btn-primary" type="submit" name="edit_info"><i class="fa fa-fw fa-lg fa-check-circle"></i> Save</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>