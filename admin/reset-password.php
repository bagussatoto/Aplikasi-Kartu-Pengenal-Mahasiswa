<?php 

require_once '../library/config.php';
include '../library/f_baseUrl.php';
include '../library/f_library.php';
include '../library/f_notification.php';
include '../library/f_mail.php';

$sql_web = $mysqli->query("SELECT * FROM tb_pengaturan LIMIT 1");
$data_web = $sql_web->fetch_array();

?>
<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="<?= $data_web['author_website']; ?>">
	<meta name="description" content="<?= $data_web['deskripsi_website'] ?>">

	<link rel="icon" href="<?= base_url('assets/images/'.$data_web['logo_website']) ?>">
	<link itemprop="thumbnailUrl" href="<?= base_url('assets/images/'.$data_web['logo_website']) ?>">
	<span itemprop="thumbnail" itemscope itemtype="http://schema.org/ImageObject">
		<link itemprop="url" href="<?= base_url('assets/images/'.$data_web['logo_website']) ?>">
	</span>
	<link rel="shortcut icon" href="<?= base_url('assets/images/'.$data_web['logo_website']) ?>" type="image/x-icon" />
	<link rel="apple-touch-icon" href="<?= base_url('assets/images/'.$data_web['logo_website']) ?>">

	<link rel="canonical" href="<?= base_url(''); ?>">

	<!-- og:property -->
	<meta property="og:locale" content="id_ID" />
	<meta property="og:type" content="website" />
	<meta property="og:site_name" content="<?= $data_web['nama_website'] ?>">
	<meta property="og:title" content="<?= $data_web['judul_website'] ?>">
	<meta property="og:description" content="<?= $data_web['deskripsi_website'] ?>"> 
	<meta property="og:url" content="<?= base_url('') ?>">
	<meta property="og:image" content="<?= base_url('assets/images/'.$data_web['logo_website']) ?>">
	<meta property="og:image:secure_url" content="<?= base_url('assets/images/'.$data_web['logo_website']) ?>" />
	<meta property="og:image:width" content="560" />
	<meta property="og:image:height" content="315" />

	<title>Reset Password :: <?= $data_web['judul_website'] ?></title>

	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/main.css') ?>">
	
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/font-awesome-4.7.0/css/font-awesome.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/sweetalert2.css'); ?>">
	<script src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/sweetalert.min.js') ?>"></script>

</head>
<body>

	<?php

	$kode = $_GET['kode'];

	$sql = $mysqli->query("SELECT * FROM tb_reset_pass WHERE kode_reset = '$kode'");
	$cek = mysqli_num_rows($sql);
	if (empty($cek)) {
		$text = "Mohon periksa kembali link anda.!";
		$link = base_url();
		echo sweetalert('Oops.!', $text, 'error', '3000', 'false', $link);
	}else{
		$data = mysqli_fetch_array($sql);
	}

	?>

	<section class="material-half-bg">
		<div class="cover"></div>
	</section>
	<section class="login-content">
		<div class="logo">
			<h1>Reset Password</h1>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-8">
			<?php 

			if (isset($_POST['reset_password'])) {
				$password 		= sanitize($_POST['password']);
				$conf_password 	= sanitize($_POST['conf_password']);

				$required = array(
					'Password Baru'			=> $password,
					'Konfirmasi password' 	=> $conf_password,
				);
				
				foreach ($required as $key => $value) {
					if (empty($value)) {
						$errors[] = $key." harus diisi.!";
					}
				}

				if (strlen($password) < 6) {
					$errors[] = "Gunakan minimal 6 karakter untuk password.";
				}
				if ($conf_password != $password) {
					$errors[] = "Konfirmasi password salah.";
				}

				if (!empty($errors)) {
					echo display_errors($errors);
				}else{
					$sql_email 	= $mysqli->query("SELECT * FROM tb_user WHERE email = '$data[email]'");
					$data_email = $sql_email->fetch_array();

					$penerima 	= $data_email['full_name'];
					$link 		= base_url('admin');

					$pesan 	= 
					"
					<!DOCTYPE html>
					<html>
						<head>
							<meta charset='utf-8'>
						</head>
						<body>

							<style>


							html {
								font-family: sans-serif;
								line-height: 1.15;
								-webkit-text-size-adjust: 100%;
								-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
							}

							body {
								margin: 0;
								font-family: 'Lato', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
								font-size: 0.875rem;
								font-weight: 400;
								line-height: 1.5;
								color: #212529;
								text-align: left;
								background-color: #FFF;
							}

							[tabindex='-1']:focus {
								outline: 0 !important;
							}

							hr {
								-webkit-box-sizing: content-box;
								box-sizing: content-box;
								height: 0;
								overflow: visible;
							}

							h1, h2, h3, h4, h5, h6 {
								margin-top: 0;
								margin-bottom: 0.5rem;
							}

							p {
								margin-top: 0;
								margin-bottom: 1rem;
							}
							</style>
							<p>
								Halo <b>$penerima</b>, <br>
								Selamat, Reset Password akun kamu pada ".$data_web['nama_website']." berhasil. <br>
								Gunakan data dibawah ini untuk login ya :<br>
								Username : ".$data_email['username']." <br>
								Password : $password <br>
								<hr>
								Silahkan klik <a href='".$link."'>Login</a> untuk memulai sesi anda.
								<hr>
								Terimakasih <br>
								Hormat kami, <br>
								<strong>".$data_web['nama_website']."</strong>
							</p>
						</body>
					</html>
					";
					$host 				= $data_web['server_email'];
					$email_user_server 	= $data_web['email_website'];
					$email_pass_server 	= $data_web['pass_email_web'];
					$name_sender 		= $data_web['nama_website'];
					$email_receiver 	= $data['email'];
					$name_receiver 		= $penerima;
					$subject 			= "Reset Password Akun ".$data_web['nama_website'];
					$message 			= $pesan;
					$kirim_email = kirim_email($host, $email_user_server, $email_pass_server, $name_sender, $email_receiver, $name_receiver, $subject, $message);

					if ($kirim_email == TRUE) {
						$options = ['cost' => 10];					
						$password_hash = password_hash($password, PASSWORD_DEFAULT, $options);
						// update password akun
						$mysqli->query("UPDATE tb_user SET password = '$password_hash'");
						// hapus data dari tabel reset
						$mysqli->query("DELETE FROM tb_reset_pass WHERE email = '$data[email]' AND level = '1'");

						$text = "Reset Password akun berhasil.!";
						$link = base_url('admin');
						echo sweetalert('Selamat.!', $text, 'success', '3000', 'false', $link);
					}else{
						$text = "Terjadi kesalahan saat mengirim pesan ke email anda.!";
						$link = base_url('admin');
						echo sweetalert('Informasi.!', $text, 'info', '3000', 'false', $link);
					}
				}
			}

			?>
		</div>
		<div class="login-box">
			<form class="login-form" method="POST" action="">
				<h3 class="login-head">
					<i class="fa fa-lg fa-fw fa-unlock"></i> Reset Password
				</h3>
				<div class="form-group">
					<label class="control-label">Password Baru</label>
					<input class="form-control" name="password" type="password" id="password" placeholder="Password Baru" autofocus>
				</div>
				<div class="form-group">
					<label class="control-label">Konfirmasi Password</label>
					<input class="form-control" type="password" name="conf_password" placeholder="Konfirmasi Password" id="password2">
				</div>
				<div class="form-group">
					<div class="utility">
						<div class="animated-checkbox">
							<label>
								<input type="checkbox"><span class="label-text" onclick="show_pass()"> Lihat Password</span>
							</label>
						</div>
						<p class="semibold-text mb-2"><a href="<?= base_url('admin') ?>" style="text-decoration: none;">Login ?</a></p>
					</div>
				</div>
				<div class="form-group btn-container">
					<button type="submit" name="reset_password" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>Reset</button>
				</div>
			</form>
		</div>
	</section>

	<script type="text/javascript">
		function show_pass() {
			var x = document.getElementById("password");
			var y = document.getElementById("password2");
			if (x.type  === "password" && y.type === "password") {
				x.type = "text";
				y.type = "text";
			}else{
				x.type = "password";
				y.type = "password";
			}
		}
	</script>

</body>
</html>