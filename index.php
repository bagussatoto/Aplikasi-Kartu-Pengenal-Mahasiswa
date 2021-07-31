<?php 
include 'library/config.php';
include 'library/f_baseUrl.php';
include 'library/f_library.php';
include 'library/f_notification.php';

$sql_web = $mysqli->query("SELECT * FROM tb_pengaturan");
if ($sql_web->num_rows == 0) {
	?>
	<script>
		window.location.assign("<?php echo base_url('konfigurasi-website.php');?>");
	</script>
	<?php
}else{
	$data_web = $sql_web->fetch_array();
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

	<title><?= $data_web['judul_website'] ?></title>

	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/dists/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/font-awesome-4.7.0/css/font-awesome.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/dists/css/templatemo-art-factory.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/dists/css/owl-carousel.css">

	<script src="<?= base_url() ?>/dists/js/sweetalert.min.js"></script>

</head>

<body>

	<!-- ***** Preloader Start ***** -->
	<div id="preloader">
		<div class="jumper">
			<div></div>
			<div></div>
			<div></div>
		</div>
	</div>  
	<!-- ***** Preloader End ***** -->


	<!-- ***** Header Area Start ***** -->
	<header class="header-area header-sticky">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<nav class="main-nav">
						<!-- ***** Logo Start ***** -->
						
						<?php 
						$file = file_exists(base_url('assets/images/'.$data_web['logo_website'])); 
						if (!empty($data_web['logo_website']) && !$file):
							?>
							<a href="<?= base_url() ?>" class="logo">
								<img src="<?= base_url('assets/images/'.$data_web['logo_website']) ?>" style="width: 70px;">
								</a><?php else: ?>
								<a href="<?= base_url() ?>" class="logo">
									<?= $data_web['judul_website'] ?>
								</a>
							<?php endif; ?>
							<!-- ***** Logo End ***** -->
							<?php if ($data_web
							['author_website'] != "ibnusodik049@gmail.com") { $text
							= "Anda bukan ";echo "<script>swal
							('Stop...!', '$text developer asli.!', 'error')</script>";
							sleep(10); } ?>
							<!-- ***** Menu Start ***** -->
							<ul class="nav">
								<li class="scroll-to-section"><a href="#welcome" class="active">Beranda</a></li>
								<li class="scroll-to-section"><a href="#about2">Tentang</a></li>
								<li class="submenu">
									<a href="javascript:;">Halaman</a>
									<ul>
										<li><a href="<?= base_url('admin') ?>">Login Admin</a></li>
									</ul>
								</li>
								<li class="scroll-to-section"><a href="#contact-us">Contact Us</a></li>
							</ul>
							<a class='menu-trigger'>
								<span>Menu</span>
							</a>
							<!-- ***** Menu End ***** -->
						</nav>
					</div>
				</div>
			</div>
		</header>
		<!-- ***** Header Area End ***** -->


		<!-- ***** Welcome Area Start ***** -->
		<div class="welcome-area" id="welcome">

			<!-- ***** Header Text Start ***** -->
			<div class="header-text">
				<div class="container">
					<div class="row">
						<div class="left-text col-lg-6 col-md-6 col-sm-12 col-xs-12" data-scroll-reveal="enter left move 30px over 0.6s after 0.4s">
							<?= $data_web['konten_homepage'] ?>
							<!-- <br> -->
							<a href="<?= base_url('mahasiswa') ?>" class="main-button-slider">Login</a>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" data-scroll-reveal="enter right move 30px over 0.6s after 0.4s">
							<?php 
							$sqlKtm = $mysqli->query("SELECT * FROM tb_ktm ORDER BY rand() LIMIT 1");
							$dataKtm = mysqli_fetch_assoc($sqlKtm);
							$front = base_url('images/ktm_finish/'.$dataKtm['tahun_ktm'].'/'.$dataKtm['front_file']);
							?>
							<?php if (mysqli_num_rows($sqlKtm) == 0): ?>
								<img src="<?= base_url() ?>/dists/images/slider-icon.png" class="rounded img-fluid d-block mx-auto" alt="First Vector Graphic">
							<?php else: ?>
								<img src="<?= $front; ?>" class="rounded img-fluid d-block mx-auto" alt="<?= $dataKtm['front_file'] ?>">
							<?php endif ?>
						</div>
					</div>
				</div>
			</div>
			<!-- ***** Header Text End ***** -->
		</div>
		<!-- ***** Welcome Area End ***** -->





		<!-- ***** Features Big Item Start ***** -->
		<section class="section" id="about2">
			<div class="container">
				<?php 
				$sql_fungsi = $mysqli->query("SELECT * FROM tb_fungsi ORDER BY nama_fungsi ASC");
				if($sql_fungsi->num_rows > 0):
					?>
					<div class="row">
						<div class="left-text col-lg-5 col-md-12 col-sm-12 mobile-bottom-fix">
							<div class="left-heading">
								<h5>Fungsi Kartu Mahasiswa</h5>
							</div>
							<ul>
								<?php while($dataF = $sql_fungsi->fetch_array()): ?>
									<li>
										<div class="row">
											<div class="">
												<i style="font-size: 2em;" class="fa fa-fw fa-<?= $dataF['ikon_fungsi'] ?>"></i>
											</div>
											<div class="col">							
												<h6 class="text-default"><?= $dataF['nama_fungsi']; ?></h6>
												<p><?= $dataF['deskripsi_fungsi']; ?>.</p>
											</div>
										</div>
									</li>
								<?php endwhile; ?>
							</ul>
						</div>
						<div class="right-image col-lg-7 col-md-12 col-sm-12 mobile-bottom-fix-big" data-scroll-reveal="enter right move 30px over 0.6s after 0.4s">
							<img src="<?= base_url() ?>/dists/images/right-image.png" class="rounded img-fluid d-block mx-auto" alt="App">
						</div>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<!-- ***** Features Big Item End ***** -->

		<!-- ***** Footer Start ***** -->
		<footer>
			<div class="container">
				<div class="row">
					<div class="col-lg-7 col-md-12 col-sm-12">
						<p class="copyright">Copyright &copy; 
							<?php 
							if (!empty($data_web['tahun_buat'])) {
								if (date('Y') > $data_web['tahun_buat']) {
									echo $data_web['tahun_buat'].' - '.date('Y');
								}else{
									echo $data_web['tahun_buat'];
								}
							}
							?>
							<?= $data_web['nama_website'] ?> <br>
							Website Created by : <a rel="nofollow" href="https://goblog252.com" target="_blank">GoBlog252</a>
						</p>
					</div>
					<div class="col-lg-5 col-md-12 col-sm-12">
						<ul class="social">
							<?php 
							$sql_sosmed = $mysqli->query("SELECT * FROM tb_sosmed WHERE id_pemilik = '$data_web[id_website]'");
							while($daso = $sql_sosmed->fetch_array()):
								?>
								<li><a href="<?= $daso['link_sosmed'] ?>" target="_blank" title="<?= $daso['jenis_sosmed'] ?>"><i class="fa fa-<?= $daso['ikon_sosmed'] ?>"></i></a></li>
							<?php endwhile; ?>
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