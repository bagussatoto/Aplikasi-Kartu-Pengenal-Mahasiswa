<?php 

include 'library/config.php';
include 'library/f_baseUrl.php';
include 'library/f_library.php';
include 'library/f_notification.php';
$sql_web = $mysqli->query("SELECT * FROM tb_pengaturan");
if (mysqli_num_rows($sql_web) > 0) {							
	$link = base_url('.');
	$text = "Data sudah ada.!";
	echo sweetalert("Oops.!", $text, "info", 3000, 'false', $link);
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Konfigurasi Website</title>	

	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/dists/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/font-awesome-4.7.0/css/font-awesome.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/dists/css/templatemo-art-factory.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/dists/css/owl-carousel.css">

	<script src="<?= base_url() ?>/dists/js/sweetalert.min.js"></script>
</head>
<body>

	<style type="text/css">
	input:focus,
	textarea:focus {
		color: white;
	}
</style>

<div id="preloader">
	<div class="jumper">
		<div></div>
		<div></div>
		<div></div>
	</div>
</div>

<header class="header-area header-sticky">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<nav class="main-nav">
					<!-- ***** Logo Start ***** -->
					<a href="<?= base_url() ?>" class="logo">Konfigurasi</a>
					<!-- ***** Logo End ***** -->
					<!-- ***** Menu Start ***** -->
					<a class='menu-trigger'>
						<span>Menu</span>
					</a>
					<!-- ***** Menu End ***** -->
				</nav>
			</div>
		</div>
	</div>
</header>

<div class="welcome-area" id="welcome">
	<div class="container">
		<div class="header-text">
			<div class="container">
				<div class="row">
					<div class="left-text col-lg-6 col-md-6 col-sm-12 col-xs-12" data-scroll-reveal="enter left move 30px over 0.6s after 0.4s">
						<h3 class="text-justify">
							Aplikasi kartu tanda mahasiswa dibuat untuk otomatisasi dalam pengelolaan serta pembuatan kartu tanda mahasiswa secara online
						</h3>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<section class="section" id="contact-us">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php 

				if (isset($_POST['submit'])) {
					$judul_website 		= sanitize($_POST['judul_website']);
					$nama_website 		= sanitize($_POST['nama_website']);
					$email_website 		= sanitize($_POST['email_website']);
					$pass_email_web 	= sanitize($_POST['pass_email_web']);
					$server_webmail 	= sanitize($_POST['server_webmail']);
					$tahun_buat 		= sanitize($_POST['tahun_buat']);
					$deskripsi_website 	= sanitize($_POST['deskripsi_website']);

					$sql_web = $mysqli->query("SELECT * FROM tb_pengaturan");
					if (mysqli_num_rows($sql_web) > 0) {							
						$link = base_url('index.php');
						$text = "Data sudah ada.!";
						echo sweetalert("Oops.!", $text, "info", 3000, 'false', $link);
					}else{
						$mysqli->query("INSERT INTO tb_pengaturan SET judul_website = '$judul_website', nama_website = '$nama_website', email_website = '$email_website', pass_email_web = '$pass_email_web', server_email = '$server_webmail', tahun_buat = '$tahun_buat', deskripsi_website = '$deskripsi_website' ");
						$link = base_url('index.php');
						$text = "Data berhasil disimpan.!";
						echo sweetalert("Berhasil.!", $text, "success", 3000, 'false', $link);
					}
				}

				?>
				<div class="contact-form">
					<form action="" method="POST">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<fieldset>
									<input name="judul_website" type="text" placeholder="Judul Website" required="" class="contact-field">
								</fieldset>
							</div>
							<div class="col-md-6 col-sm-12">
								<fieldset>
									<input name="nama_website" type="text" placeholder="Nama Website" required="" class="contact-field">
								</fieldset>
							</div>
							<div class="col-md-6 col-sm-12">
								<fieldset>
									<input name="email_website" type="email" placeholder="Webmail" required="" class="contact-field">
								</fieldset>
							</div>
							<div class="col-md-6 col-sm-12">
								<fieldset>
									<input name="pass_email_web" type="password" placeholder="Password Webmail" required="" class="contact-field">
								</fieldset>
							</div>
							<div class="col-md-6 col-sm-12">
								<fieldset>
									<input name="server_webmail" type="text" placeholder="Server Webmail" required="" class="contact-field">
								</fieldset>
							</div>
							<div class="col-md-6 col-sm-12">
								<fieldset>
									<input name="tahun_buat" type="number" min="0" placeholder="Tahun Pembuatan" required="" class="contact-field">
								</fieldset>
							</div>
							<div class="col-lg-12">
								<fieldset>
									<textarea name="deskripsi_website" rows="6" placeholder="Deskripsi Website" required="" class="contact-field"></textarea>
								</fieldset>
							</div>
							<div class="col-lg-12">
								<fieldset>
									<button type="submit" name="submit" class="main-button">Simpan</button>
								</fieldset>
							</div>
						</div>
					</form>
				</div>					
			</div>
		</div>
	</div>
</section>

<footer>
	<div class="container">
		<div class="row">
			<div class="col-lg-7 col-md-12 col-sm-12">
				<p class="copyright">Copyright &copy; 
					<?php 
					date('Y');
					?>
					Website Created by : <a rel="nofollow" href="https://goblog252.com" target="_blank">GoBlog252</a>
				</p>
			</div>
			<div class="col-lg-5 col-md-12 col-sm-12">
				<ul class="social">
					<li><a href="https://goblog252.com" target="_blank" title="GoBlog252"><i class="fa fa-globe"></i></a></li>
					<li><a href="https://www.youtube.com/channel/UCDpKx6bLrAqmhVdCaWf4_1g" target="_blank" title="Go Blog252"><i class="fa fa-youtube"></i></a></li>
					<li><a href="https://instagram.com/goblog252" target="_blank" title="Instagram"><i class="fa fa-instagram"></i></a></li>
					<li><a href="https://facebook.com/goblog.252" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>
					<li><a href="https://t.me/gosourcecode" target="_blank" title="Go Source Code"><i class="fa fa-telegram"></i></a></li>
					<li><a href="https://api.whatsapp.com/send/?phone=629523995814&text=Halo kak GoBlog252&app_absent=0" target="_blank" title="Chat WhatsApp"><i class="fa fa-whatsapp"></i></a></li>
				</ul>
			</div>
		</div>
	</div>
</footer>

<!-- jQuery -->
<script src="<?= base_url() ?>/dists/js/jquery-2.1.0.min.js"></script>

<!-- Bootstrap -->
<script src="<?= base_url() ?>/dists/js/popper.js"></script>
<script src="<?= base_url() ?>/dists/js/bootstrap.min.js"></script>

<!-- Plugins -->
<script src="<?= base_url() ?>/dists/js/owl-carousel.js"></script>
<script src="<?= base_url() ?>/dists/js/scrollreveal.min.js"></script>
<script src="<?= base_url() ?>/dists/js/waypoints.min.js"></script>
<script src="<?= base_url() ?>/dists/js/jquery.counterup.min.js"></script>
<script src="<?= base_url() ?>/dists/js/imgfix.min.js"></script> 

<!-- Global Init -->
<script src="<?= base_url() ?>/dists/js/custom.js"></script>

</body>
</html>