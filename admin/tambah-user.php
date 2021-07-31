<?php 

include '../library/config.php';
include '../library/f_baseUrl.php';
include '../library/f_library.php';
include '../library/f_notification.php';
include '../library/f_mail.php';

$sql_web = $mysqli->query("SELECT * FROM tb_pengaturan LIMIT 1");
$data_web = $sql_web->fetch_array();

$sql_user = $mysqli->query("SELECT * FROM tb_user");
if (mysqli_num_rows($sql_user) > 0) {							
	$link = base_url('admin');
	$text = "Terjadi kesalahan saat mengakses halaman ini.!";
	echo sweetalert("Oops.!", $text, "info", 3000, 'false', $link);
}
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

	<title>Konfigurasi Admin :: <?= $data_web['judul_website'] ?></title>

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
			<h1>Tambah Admin</h1>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-8">
			<?php 
			ini_set( 'display_errors', 1 );

			$full_name 		= ((isset($_POST['full_name']))?sanitize($_POST['full_name']):'');
			$full_name 		= trim($full_name);
			$username 		= ((isset($_POST['username']))?sanitize($_POST['username']):'');
			$username 		= trim($username);
			$email 			= ((isset($_POST['email']))?sanitize($_POST['email']):'');
			$email 			= trim($email);
			$password 		= ((isset($_POST['password']))?sanitize($_POST['password']):'');
			$password 		= trim($password);
			$conf_password 	= ((isset($_POST['conf_password']))?sanitize($_POST['conf_password']):'');
			$conf_password 	= trim($conf_password);
			$errors 		= array();

			if (isset($_POST['register'])) {

				$full_name 		= sanitize($_POST['full_name']);
				$username 		= sanitize($_POST['username']);
				$email 			= sanitize($_POST['email']);
				$password 		= sanitize($_POST['password']);
				$conf_password 	= sanitize($_POST['conf_password']);

				$required = array(
					'Nama' 		=> $full_name,
					'Username' 	=> $username,
					'Email' 	=> $email,
					'Password' 	=> $password,
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
					$options = ['cost' => 10];					
					$password_hash = password_hash($password, PASSWORD_DEFAULT, $options);
					$insert = $mysqli->query("INSERT INTO tb_user SET username = '$username', email = '$email', full_name = '$full_name', password = '$password_hash', level = '1'");

					if ($insert = TRUE) {
						
						$pesan 	= 
						"
						Halo $full_name <br>
						Selamat kamu sekarang adalah admin di ".$data_web['nama_website']." <br>
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
						$subject 			= "Admin baru di ".$name_sender;
						$message 			= $pesan;
						$kirim_email = kirim_email($host, $email_user_server, $email_pass_server, $name_sender, $email_receiver, $name_receiver, $subject, $message);

						// $mail = new PHPMailer;
						// $mail->isSMTP();
						// $mail->Host = 'mail.goblog252.com';
						// $mail->Username = $from;
						// $mail->Password = $data_web['pass_email_web'];
						// $mail->Port = 465;
						// $mail->SMTPAuth = true;
						// $mail->SMTPSecure = 'ssl';
						// $mail->setFrom($from, $data_web['nama_website']);
						// $mail->addAddress($to, $full_name);
						// $mail->isHTML(true);
						// $mail->Subject = $subjek;
						// $mail->Body = $pesan;
						if ($kirim_email == TRUE) {
							$text = "Admin telah ditambahkan, silahkan login untuk memulai sesi.!";
							$link = base_url('admin');
							echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', $link);
						}else{
							$text = "Data tersimpan namun email tidak terkirim.!";
							$link = base_url('admin');
							echo sweetalert('Berhasil.!', $text, 'info', '3000', 'false', $link);
						}
					}
				}
			}

			?>
		</div>
		<div class="login-box" style="height:520px;">
			<form class="login-form" method="POST" action="">
				<div class="form-group">
					<label class="control-label">Nama</label>
					<input class="form-control" name="full_name" type="text" placeholder="Nama" value="<?= $full_name; ?>" autofocus>
				</div>
				<div class="form-group">
					<label class="control-label">Username</label>
					<input class="form-control" name="username" type="text" placeholder="Username" value="<?= $username; ?>">
				</div>
				<div class="form-group">
					<label class="control-label">Email</label>
					<input class="form-control" name="email" type="email" placeholder="Email" value="<?= $email; ?>">
				</div>
				<div class="form-group">
					<label class="control-label">Password</label>
					<input class="form-control" type="password" name="password" placeholder="Password" value="<?= $password; ?>">
				</div>
				<div class="form-group">
					<label class="control-label">Konfirmasi Password</label>
					<input class="form-control" name="conf_password" type="password" placeholder="Tulis ulang password anda" value="<?= $conf_password; ?>">
				</div>
				<div class="form-group btn-container">
					<button type="submit" name="register" class="btn btn-primary btn-block">Simpan <i class="fa fa-save fa-lg fa-fw"></i></button>
				</div>
			</form>
		</div>
	</section>
	<!-- Essential javascripts for application to work-->
	<script src="<?= base_url('assets/js/jquery-3.3.1.min.js'); ?>"></script>
	<script src="<?= base_url('assets/js/popper.min.js'); ?>"></script>
	<script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
	<script src="<?= base_url('assets/js/main.js'); ?>"></script>
	<script src="<?= base_url('assets/js/plugins/pace.min.js'); ?>"></script>
	<script type="text/javascript">
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });
  </script>
</body>
</html>