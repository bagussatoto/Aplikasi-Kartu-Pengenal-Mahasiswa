<?php 
session_start();
if (!isset($_SESSION['logedin_mahasiswa'])) {
	header('location: qr-login.php');
}
require_once '../library/config.php';
include '../library/f_baseUrl.php';
include '../library/f_library.php';
include '../library/f_notification.php';

$nim_mahasiswa = $_SESSION['nim_mahasiswa'];

$sql1 = $mysqli->query("SELECT tb_jurusan.*, tb_mahasiswa.* FROM tb_mahasiswa LEFT JOIN tb_jurusan ON tb_mahasiswa.jurusan_mahasiswa = tb_jurusan.id_jurusan WHERE nim_mahasiswa = '$nim_mahasiswa'");
$sql2 = $mysqli->query("SELECT * FROM tb_ktm WHERE nim_mahasiswa = '$nim_mahasiswa'");

$mahasiswa = mysqli_fetch_array($sql1);
$ktm 		= mysqli_fetch_array($sql2);

$front_file = $ktm['front_file'];

@$page = $_GET['page'];

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

	<title>Mahasiswa :: <?= $data_web['nama_website'] ?></title>

	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/main.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/font-awesome-4.7.0/css/font-awesome.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/sweetalert2.css'); ?>">

	<script src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/popper.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/sweetalert.min.js') ?>"></script>

</head>

<style type="text/css">
.ttd {
	position: absolute;
	right: 25px !important;
	bottom: 180px;
}

.foto-profil{
	position: absolute;
	vertical-align: center;
}
</style>

<body class="app sidebar-mini">
	<header class="app-header"><a class="app-header__logo" href="<?= base_url('mahasiswa') ?>">Mahasiswa</a>
		<a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
		<ul class="app-nav">
			<li class="dropdown"><a class="app-nav__item" href="javascript:void(0)" style="text-decoration: none;" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i> <?= $mahasiswa['nama_mahasiswa']; ?></a>
				<ul class="dropdown-menu settings-menu dropdown-menu-right">
					<li><a class="dropdown-item" href="?page=profil"><i class="fa fa-user fa-lg"></i> Profil</a></li>
					<li><a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
				</ul>
			</li>
		</ul>
	</header>
	<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
	<?php if ($data_web
		['author_website'] != "ibnusodik049@gmail.com") { $text
		= "Anda bukan ";echo "<script>swal
		('Stop...!', '$text developer asli.!', 'error')</script>";
		sleep(10); } ?>
		<aside class="app-sidebar">
			<div class="app-sidebar__user text-center">
				<div>
					<?php 
					$foto_exist = base_url('images/thumbs/mahasiswa/'.$mahasiswa['foto_mahasiswa']);
					if(!empty($foto_exist) && !empty($mahasiswa['foto_mahasiswa'])):
						?>
					<img class="app-sidebar__user-avatar" src="<?= base_url('images/thumbs/mahasiswa/'.$mahasiswa['foto_mahasiswa']) ?>" alt="<?= $mahasiswa['nama_mahasiswa']; ?>">
				<?php else: ?>
					<img class="app-sidebar__user-avatar" src="<?= base_url('images/logo-mahasiswa.png'); ?>" alt="<?= $mahasiswa['nama_mahasiswa']; ?>">
				<?php endif; ?>
				<p class="app-sidebar__user-name"><?= $mahasiswa['nama_mahasiswa']; ?></p>
			</div>
		</div>

		<ul class="app-menu">
			<li><a class="app-menu__item <?php if($page=='' || $page=='dashboard')echo "active"; ?>" href="?page=dashboard"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
		</ul>
	</aside>
	<main class="app-content">