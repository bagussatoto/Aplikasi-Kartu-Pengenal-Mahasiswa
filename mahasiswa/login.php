<?php
session_start();
if (isset($_SESSION['logedin_mahasiswa'])) {
	header('location:.');
}

require_once '../library/config.php';
include '../library/f_baseUrl.php';
include '../library/f_library.php';
include '../library/f_notification.php';

 // define password hash

// $options = ['cost' => 10];
// $str = "password";
// echo password_hash($str, PASSWORD_DEFAULT, $options);

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

	<title>Login :: <?= $data_web['judul_website'] ?></title>

	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/main.css') ?>">
	
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/font-awesome-4.7.0/css/font-awesome.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/sweetalert2.css'); ?>">
	<script src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/sweetalert.min.js') ?>"></script>

</head>
<body>
	<section class="material-half-bg">
		<div class="cover"></div>
	</section>
	<section class="login-content">
		<div class="logo">
			<h1>Mahasiswa</h1>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-8">
			<?php 
			$nim_mahasiswa = ((isset($_POST['nim_mahasiswa']))?sanitize($_POST['nim_mahasiswa']):'');
			$nim_mahasiswa = trim($nim_mahasiswa);
			$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
			$password = trim($password);
			$errors = array();

			if (isset($_POST['login'])) {
				$nim_mahasiswa = sanitize($_POST['nim_mahasiswa']);
				$password = sanitize($_POST['password']);

				$sql = $mysqli->query("SELECT * FROM tb_mahasiswa WHERE nim_mahasiswa = '$nim_mahasiswa'");
				$data = mysqli_fetch_array($sql);
				
				if (mysqli_num_rows($sql) > 0) {
					if (!password_verify($password, $data['password_mahasiswa'])) {
						$errors[] = "Password Yang Anda Masukkan Salah.!";
					}
				}else{
					$errors[] = "NIM $nim_mahasiswa Tidak Ada Pada Database.";
				}

				if (!empty($errors)) {
					echo display_errors($errors);
				}else{
					$_SESSION['logedin_mahasiswa'] = TRUE;
					$_SESSION['nim_mahasiswa'] = $data['nim_mahasiswa'];
					$_SESSION['id_mahasiswa'] = $data['id_mahasiswa'];
					$_SESSION['nama_mahasiswa'] = $data['nama_mahasiswa'];

					$text = $data['nama_mahasiswa']." berhasil login.";
					echo sweetalert('Selamat.!', $text, 'success', '3000', 'false', '.');
				}
			}

			?>
		</div>
		<div class="login-box">
			<form class="login-form" method="POST" action="">
				<h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Login</h3>
				<div class="form-group">
					<label class="control-label">NIM</label>
					<input class="form-control" name="nim_mahasiswa" type="text" placeholder="NIM" value="<?= $nim_mahasiswa; ?>" autofocus>
				</div>
				<div class="form-group">
					<label class="control-label">Password</label>
					<input class="form-control" type="password" name="password" placeholder="Password" value="<?= $password; ?>">
				</div>
				<div class="form-group">
					<div class="utility">
						<p class="semibold-text mb-2"><a style="text-decoration: none;" href="<?= base_url('mahasiswa/qr-login.php'); ?>" ><i class="fa fa-angle-left fa-fw"></i> Gunakan QR Code</a></p>
						<div class="anisnated-checkbox">
							<label>
								<input type="hidden">
							</label>
						</div>
						<p class="semibold-text mb-2"><a style="text-decoration: none;" href="#" data-toggle="flip">Lupa Password ?</a></p>
					</div>
				</div>
				<div class="form-group btn-container">
					<button type="submit" name="login" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>Login</button>
				</div>
			</form>

			<form class="forget-form" action="" method="POST">
				<h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Lupa Password</h3>
				<div class="form-group">
					<label class="control-label">Email</label>
					<input class="form-control" name="email" type="email" placeholder="Email" autofocus required>
				</div>
				<div class="form-group btn-container">
					<button class="btn btn-primary btn-block" type="submit" name="reset_password"><i class="fa fa-unlock fa-lg fa-fw"></i>Reset</button>
				</div>
				<div class="form-group mt-3">
					<p class="semibold-text mb-0"><a style="text-decoration: none;" href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Kembali Login</a></p>
				</div>
			</form>
		</div>
	</section>
	<!-- Essential javascripts for application to work-->
	<script src="<?= base_url('assets/js/jquery-3.3.1.min.js'); ?>"></script>
	<script src="<?= base_url('assets/js/popper.min.js'); ?>"></script>
	<script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
	<script src="<?= base_url('assets/js/main.js'); ?>"></script>
	<!-- The javascript plugin to display page loading on top-->
	<script src="<?= base_url('assets/js/plugins/pace.min.js'); ?>"></script>
	<script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });
  </script>
</body>
</html>