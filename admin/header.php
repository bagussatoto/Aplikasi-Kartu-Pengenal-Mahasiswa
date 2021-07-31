<?php 
session_start();
if (!isset($_SESSION['logedin'])) {
	header('location: login.php');
}
include '../library/config.php';
include '../library/f_baseUrl.php';
include '../library/f_library.php';
include '../library/f_roundImg.php';
include '../library/f_notification.php';
include '../library/f_qrCode.php';
include '../library/f_mail.php';

$id_user = $_SESSION['id_user'];
$sql = $mysqli->query("SELECT * FROM tb_user WHERE id_user = '$id_user'");
$user = mysqli_fetch_array($sql);

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
  
  <title>Admin :: <?= $data_web['nama_website'] ?></title>

  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/main.css'); ?>">

  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/dropify.min.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/sweetalert2.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/font-awesome-4.7.0/css/font-awesome.min.css'); ?>">
  <link href="<?= base_url() ?>/assets/summernote/summernote-bs4.min.css" rel="stylesheet" />


  <script src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/popper.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>

  <script src="<?= base_url('assets/js/sweetalert.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/plugins/dropify.min.js') ?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/js/plugins/chart.js') ?>"></script>  

  <script src="<?= base_url() ?>/assets/summernote/summernote-bs4.min.js"></script>
  <script src="<?= base_url() ?>/assets/summernote/lang/summernote-id-ID.js"></script>

</head>
<body class="app sidebar-mini">
  <header class="app-header"><a class="app-header__logo" href="<?= base_url('admin') ?>">Administrator</a>
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <ul class="app-nav">
      <li class="dropdown"><a class="app-nav__item" href="javascript:void(0)" style="text-decoration: none;" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i> <?= $user['full_name']; ?></a>
        <ul class="dropdown-menu settings-menu dropdown-menu-right">
          <li><a class="dropdown-item" href="?page=profil"><i class="fa fa-user fa-lg"></i> Profile</a></li>
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
      <div class="app-sidebar__user">
        <?php 
        $file = file_exists(base_url('images/thumbs/user/'.$user['foto']));
        if(!$file && !empty($user['foto'])):
         ?>
         <img class="app-sidebar__user-avatar" src="<?= base_url('images/thumbs/user/'.$user['foto']) ?>" alt="<?= $user['full_name']; ?>"><?php else: ?>
         <i class="fa fa-user-secret fa-lg "></i>&nbsp;
       <?php endif; ?>
       <div>
        <p class="app-sidebar__user-name"><?= $user['full_name']; ?></p>
      </div>
    </div>
    <?php include 'menu.php'; ?>
  </aside>
  <main class="app-content">