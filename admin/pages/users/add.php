<?php 
$full_name = ((isset($_POST['full_name']))?sanitize($_POST['full_name']):'');
$full_name = trim($full_name);

$username = ((isset($_POST['username']))?sanitize($_POST['username']):'');
$username = trim($username);

$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email = trim($email);

$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);

$conf_password = ((isset($_POST['conf_password']))?sanitize($_POST['conf_password']):'');
$conf_password = trim($conf_password);

$errors = array();
?>
<div class="app-title">
	<div>
		<h1>
			<a href="<?= $_SERVER['HTTP_REFERER']; ?>" class="btn btn-default"><i class="fa fa-chevron-left"></i></a>&nbsp;
			<i class="fa fa-user-secret"></i> Add Users
		</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="?page=users">Users</a></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">Add</a></li>
	</ul>
</div>
<div class="row">	
	<div class="col-md-6">
		<div class="tile">
			<form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
				<h3 class="tile-title">Add Data</h3>
				<?php 
				if (isset($_POST['submit'])) {
					$full_name 		= sanitize($_POST['full_name']);
					$username 		= sanitize($_POST['username']);
					$email 			= sanitize($_POST['email']);
					$password 		= sanitize($_POST['password']);
					$conf_password 	= sanitize($_POST['conf_password']);

					if (empty($full_name) || empty($username) || empty($email) || empty($password)) {
						$errors[] = "Kolom bertanda * harus diisi.";
					}

					$sqlCekUsername = $mysqli->query("SELECT * FROM tb_user WHERE username='$username'");
					if (mysqli_num_rows($sqlCekUsername) > 0) {
						$errors[] = "Username $username sudah digunakan. Mohon gunakan yang lain.";
					}

					$sqlCekEmail = $mysqli->query("SELECT * FROM tb_user WHERE email='$email'");
					if (mysqli_num_rows($sqlCekEmail) > 0) {
						$errors[] = "Email $email sudah digunakan. Mohon gunakan yang lain.";
					}

					if (strlen($password) < 6) {
						$errors[] = "Gunakan minisnal 6 karakter untuk password.";
					}
					if ($conf_password != $password) {
						$errors[] = "Konfirmasi password salah.";
					}

					// upload foto
					$extensi = explode('.', $_FILES['foto']['name']);
					$nama_foto = $username.'-'.round(microtime(true)).'.'.end($extensi);
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
					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
						$errors[] = "Etensi File Harus JPG, JPEG, PNG atau Gif.";
						$uploadOk = 0;
					}
					if ($uploadOk==0) {
						$errors[] = "Upload Foto Gagal.";
					}else{

						if (!empty($errors)) {
							echo display_errors($errors);
						}else{
							$options = ['cost' => 10];					
							$password_hash = password_hash($password, PASSWORD_DEFAULT, $options);
							$insert = $mysqli->query("INSERT INTO tb_user SET full_name = '$full_name', username = '$username', email = '$email', password = '$password_hash', foto = '$nama_foto' ");
							if ($insert = TRUE) {
								move_uploaded_file($sumber, '../images/user/'.$nama_foto);
						// make thumbnail
								createThumbs('../images/user/', '../images/thumbs/user/', 300);

								$pesan 	= 
								"
								Halo $full_name, <br>
								Selamat kamu sekarang mempunyai akses di ".$data_web['nama_website']." <br>
								Gunakan data dibawah ini untuk login ya :<br>
								Username : $username <br>
								Password : $password <br>
								<hr>
								Silahkan klik <a href='".base_url('admin')."'>Login</a> untuk memulai sesi anda.
								<hr>
								Terimakasih <br>
								Hormat kami, <br>
								".$data_web['nama_website']."
								";

						// kirim_email($host, $email_user_server, $email_pass_server, $name_sender, $email_receiver, $name_receiver, $subject, $message, $isHtml=TRUE, $auth=TRUE)
								$host 				= $data_web['server_email'];
								$email_user_server 	= $data_web['email_website'];
								$email_pass_server 	= $data_web['pass_email_web'];
								$name_sender 		= $data_web['nama_website'];
								$email_receiver 	= $email;
								$name_receiver 		= $full_name;
								$subject 			= "Anggota baru di ".$name_sender;
								$message 			= $pesan;
								$kirim_email = kirim_email($host, $email_user_server, $email_pass_server, $name_sender, $email_receiver, $name_receiver, $subject, $message);

								if ($kirim_email == TRUE) {
									$text = "Berhasil menambah $username pada data user.";
									echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '?page=users');
								}else{
									$text = "Data tersimpan namun email tidak terkirim.!";
									$link = base_url('admin');
									echo sweetalert('Berhasil.!', $text, 'info', '3000', 'false', $link);
								}
							}
						}
					}
				}
				?>
				<div class="tile-body">
					<div class="form-group row">
						<label class="control-label col-md-3" for="full_name">Name *</label>
						<div class="col-md-8">
							<input class="form-control" id="full_name" type="text" placeholder="Enter full name" name="full_name" autofocus value="<?= $full_name; ?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="username">Username *</label>
						<div class="col-md-8">
							<input class="form-control col-md-8" type="text" placeholder="Enter username" name="username" value="<?= $username; ?>" id="username">
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="email">Email</label>
						<div class="col-md-8">
							<input class="form-control col-md-8" type="email" name="email" placeholder="Enter email address" value="<?= $email; ?>" id="email">
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="password">Password *</label>
						<div class="col-md-8">
							<input class="form-control col-md-8" type="password" name="password" placeholder="Enter user Password" value="<?= $password; ?>" id="password">
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="conf_password">Confirm Password</label>
						<div class="col-md-8">
							<input class="form-control col-md-8" type="password" name="conf_password" placeholder="Enter user Password Confirmation" id="conf_password" value="<?= $conf_password; ?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="foto">Profil Photo</label>
						<div class="col-md-8">
							<input class="form-control dropify" id="foto" name="foto" type="file">
						</div>
					</div>
				</div>
				<div class="tile-footer">
					<div class="row">
						<div class="col-md-8 col-md-offset-3">
							<button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>