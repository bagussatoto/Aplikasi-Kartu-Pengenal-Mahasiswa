<?php
session_start();
if (isset($_SESSION['logedin'])) {
	header('location:.');
}

include '../library/config.php';
include '../library/f_baseUrl.php';
include '../library/f_library.php';
include '../library/f_notification.php';
include '../library/f_mail.php';

$sql_user = $mysqli->query("SELECT * FROM tb_user LIMIT 1");
if ($sql_user->num_rows <= 0) {
	
	?>
	<script>
		window.location.assign("<?php echo base_url('admin/tambah-user.php');?>");
	</script>
	<?php
}

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

	<title>Login Admin :: <?= $data_web['judul_website'] ?></title>

	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/main.css') ?>">

	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/font-awesome-4.7.0/css/font-awesome.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/sweetalert2.css'); ?>">
	<script src="<?= base_url('assets/js/sweetalert.min.js') ?>"></script>
	

</head>
<body>
	<section class="material-half-bg">
		<div class="cover"></div>
	</section>
	<section class="login-content">
		<div class="logo">
			<h1>Admin</h1>
		</div>
		<div class="col-md-4 col-sm-6 col-xs-8">
			<?php 
			ini_set( 'display_errors', 1 );
			
			$username = ((isset($_POST['username']))?sanitize($_POST['username']):'');
			$username = trim($username);
			$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
			$password = trim($password);
			$errors = array();

			if (isset($_POST['login'])) {
				$username = sanitize($_POST['username']);
				$password = sanitize($_POST['password']);

				$sql = $mysqli->query("SELECT * FROM tb_user WHERE username = '$username' OR email = '$username'");
				$data = mysqli_fetch_array($sql);
				
				if (mysqli_num_rows($sql) > 0) {
					if (!password_verify($password, $data['password'])) {
						$errors[] = "Password Yang Anda Masukkan Salah.!";
					}
				}else{
					$errors[] = "Username $username Tidak Ada Pada Database.";
				}

				if (!empty($errors)) {
					echo display_errors($errors);
				}else{
					$_SESSION['logedin'] = TRUE;
					$_SESSION['username'] = $data['username'];
					$_SESSION['id_user'] = $data['id_user'];
					$_SESSION['full_name'] = $data['full_name'];
					$_SESSION['level'] = $data['level'];

					
					$text = $data['full_name']." Login.";
					echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '.');
				}
			}

			if (isset($_POST['reset_password'])) {
				$email 		= sanitize($_POST['email']);
				$sql_email 	= $mysqli->query("SELECT * FROM tb_user WHERE email = '$email'");
				
				if ($sql_email->num_rows <= 0) {
					$errors[] = "Email yang anda masukkan tidak ada pada Database.";
				}

				if (!empty($errors)) {
					echo display_errors($errors);
				}else{
					$data = $sql_email->fetch_array();
					
					$kode 		= RandomString(43);
					$penerima 	= $data['full_name'];
					$link 		= base_url('admin/reset-password.php?kode='.$kode);
					$status 	= 1; #1=admin, 2=mahasiswa

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
								Apakah kamu lupa password akun kamu? <br>
								Jika iya silahkan klik Reset Password dibawah ini : <br>
								<hr>
								<a href='".$link."'>Reset Password</a>
								<hr>
								Jika tidak ingin melakukan reset password dan merasa tidak mengirimkan permintaan ini. Mohon abaikan dan hapus pesan ini <br>
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
					$email_receiver 	= $email;
					$name_receiver 		= $penerima;
					$subject 			= "Reset Password Akun ".$data_web['nama_website'];
					$message 			= $pesan;
					$kirim_email = kirim_email($host, $email_user_server, $email_pass_server, $name_sender, $email_receiver, $name_receiver, $subject, $message);

					if ($kirim_email == TRUE) {
						$mysqli->query("INSERT INTO tb_reset_pass SET email = '$email', kode_reset = '$kode', level = 1");
						$text = "Cek email anda untuk melakukan reset password.!";
						$link = base_url('admin');
						echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', $link);
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
				<h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
				<div class="form-group">
					<label class="control-label">Username</label>
					<input class="form-control" name="username" type="text" placeholder="Username atau Email" value="<?= $username; ?>" autofocus>
				</div>
				<div class="form-group">
					<label class="control-label">Password</label>
					<input class="form-control" type="password" name="password" placeholder="Password" value="<?= $password; ?>">
				</div>
				<div class="form-group">
					<div class="utility">
						<a style="text-decoration: none;" class="semibold-text mb-2" href="<?=base_url()?>"><i class="fa fa-angle-left fa-fw"></i> Go Home</a>
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