<?php 

$nama_mahasiswa = ((isset($_POST['nama_mahasiswa']))?sanitize($_POST['nama_mahasiswa']):'');
$nama_mahasiswa = trim($nama_mahasiswa);

$nim_mahasiswa = ((isset($_POST['nim_mahasiswa']))?sanitize($_POST['nim_mahasiswa']):'');
$nim_mahasiswa = trim($nim_mahasiswa);

$email_mahasiswa = ((isset($_POST['email_mahasiswa']))?sanitize($_POST['email_mahasiswa']):'');
$email_mahasiswa = trim($email_mahasiswa);

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
			<i class="fa fa-graduation-cap"></i> Add Mahasiswa
		</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="?page=mahasiswa">Mahasiswa</a></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">Add</a></li>
	</ul>
</div>
<div class="row">
	<div class="col-md-12 col-xs-12 col-sm-12">
		<div class="tile">
			<form method="POST" action="">
				<h3 class="tile-title">Add Data</h3>
				<?php 

				if (isset($_POST['submit'])) {
					require_once '../phpqrcode/qrlib.php';

					$nama_mahasiswa 	= sanitize($_POST['nama_mahasiswa']);
					$nim_mahasiswa 		= sanitize($_POST['nim_mahasiswa']);
					$email_mahasiswa 	= sanitize($_POST['email_mahasiswa']);
					$password 			= sanitize($_POST['password']);
					$conf_password 		= sanitize($_POST['conf_password']);

					if (empty($nim_mahasiswa)) {
						$errors[] = "NIM harus diisi.";
					}
					if (empty($nama_mahasiswa)) {
						$errors[] = "Nama harus diisi.";
					}
					if (empty($email_mahasiswa)) {
						$errors[] = "Email harus diisi.";
					}
					if (strlen($nim_mahasiswa) < 10) {
						$errors[] = "Mohon masukkan NIM dengan benar.";
					}

					$sqlCeNim = $mysqli->query("SELECT * FROM tb_mahasiswa WHERE nim_mahasiswa='$nim_mahasiswa'");
					if (mysqli_num_rows($sqlCeNim) > 0) {
						$errors[] = "NIM $nim_mahasiswa sudah digunakan. Mohon gunakan yang lain.";
					}

					if (strlen($password) < 6) {
						$errors[] = "Gunakan minisnal 6 karakter untuk password.";
					}
					if ($conf_password != $password) {
						$errors[] = "Konfirmasi password salah.";
					}


					if (!empty($errors)) {
						echo display_errors($errors);
					}else{
						// qr code script
						$tempdir = "../images/mahasiswa/qr_code/";
						$pathLogo = "../images/logo-qr-code.png";
						$ex = explode(" ", $nama_mahasiswa);
						$im = implode("-", $ex);
						$file_qr = strtolower($im).'-'.$nim_mahasiswa.'.png';
						$value = $nim_mahasiswa;
						$nama_file = $file_qr;

						echo qr_code_logo($tempdir, $pathLogo, $value, $nama_file);

						$options = ['cost' => 10];					
						$password_hash = password_hash($password, PASSWORD_DEFAULT, $options);
						$insert = $mysqli->query("INSERT INTO tb_mahasiswa SET nama_mahasiswa = '$nama_mahasiswa', nim_mahasiswa = '$nim_mahasiswa', email_mahasiswa = '$email_mahasiswa', password_mahasiswa = '$password_hash', qr_code = '$file_qr'");
						if ($insert) {
							// cek id tertinggi dari tabel
							$sqlId = $mysqli->query("SELECT MAX(id_mahasiswa) as id_mahasiswa FROM tb_mahasiswa");
							$dataId = mysqli_fetch_assoc($sqlId);
							$url = "?page=edit_mahasiswa&id=".$dataId['id_mahasiswa'];

							$pesan 	= 
							"
							Halo $nama_mahasiswa, <br>
							Selamat!, kamu sekarang mempunyai akses di ".$data_web['nama_website']." <br>
							Gunakan data dibawah ini untuk login ya :<br>
							Username : $nim_mahasiswa <br>
							Password : $password <br>
							<hr>
							Silahkan klik <a href='".base_url('mahasiswa/login.php')."'>Login</a> untuk memulai sesi anda.
							<hr>
							Terimakasih <br>
							Hormat kami, <br>
							".$data_web['nama_website']."
							";

							$host 				= $data_web['server_email'];
							$email_user_server 	= $data_web['email_website'];
							$email_pass_server 	= $data_web['pass_email_web'];
							$name_sender 		= $data_web['nama_website'];
							$email_receiver 	= $email_mahasiswa;
							$name_receiver 		= $nama_mahasiswa;
							$subject 			= "Akun baru di ".$name_sender;
							$message 			= $pesan;
							$kirim_email = kirim_email($host, $email_user_server, $email_pass_server, $name_sender, $email_receiver, $name_receiver, $subject, $message);

							if ($kirim_email == TRUE) {
								$text = "Berhasil menambah $nama_mahasiswa pada data mahasiswa.";
								echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', $url);
							}else{
								$text = "Data tersimpan namun email tidak terkirim.!";
								echo sweetalert('Berhasil.!', $text, 'info', '3000', 'false', $url);
							}
						}
					}
				}

				?>
				<div class="tile-body">
					<div class="form-group row">
						<label class="control-label col-md-3" for="nim_mahasiswa">NIM Mahasiswa</label>
						<div class="col-md-9">
							<input type="number" name="nim_mahasiswa" id="nim_mahasiswa" class="form-control" placeholder="NIM Mahasiswa" maxlength="10" value="<?= $nim_mahasiswa ?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="nama_mahasiswa">Nama Mahasiswa</label>
						<div class="col-md-9">
							<input type="text" name="nama_mahasiswa" id="nama_mahasiswa" class="form-control" placeholder="Nama Mahasiswa" value="<?= $nama_mahasiswa ?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="email_mahasiswa">Email</label>
						<div class="col-md-9">
							<input type="text" name="email_mahasiswa" id="email_mahasiswa" class="form-control" placeholder="Email" value="<?= $email_mahasiswa ?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="password">Password *</label>
						<div class="col-md-9">
							<input class="form-control" type="password" name="password" placeholder="Masukkan Password" value="<?= $password; ?>" id="password">
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="conf_password">Confirm Password</label>
						<div class="col-md-9">
							<input class="form-control" type="password" name="conf_password" placeholder="Masukkan Password Confirmation" id="conf_password" value="<?= $conf_password; ?>">
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