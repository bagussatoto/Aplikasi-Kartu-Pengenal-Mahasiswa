<?php
session_start();
if (isset($_SESSION['logedin_mahasiswa'])) {
	header('location:.');
}

require_once '../library/config.php';
include '../library/f_baseUrl.php';
include '../library/f_library.php';

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

	<title>Login QR :: <?= $data_web['judul_website'] ?></title>

	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/main.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/font-awesome-4.7.0/css/font-awesome.min.css'); ?>">

</head>
<body><section class="material-half-bg">
	<div class="cover"></div>
</section>
<section class="login-content">
	<div class="logo">
		<h1>Login With Qr Code</h1>
	</div>
	<div class="login-box">
		<div class="col-md-12">
			<br>
			<div class="text-center">
				<canvas></canvas>
				<br>
				<select class="form-control col-md-12"></select>
			</div>
			<hr>
			<div class="">
				<a style="text-decoration: none;" class="semibold-text mb-2" href="<?=base_url()?>"><i class="fa fa-angle-left fa-fw"></i> Go Home</a>
				<a style="text-decoration: none;" class="pull-right semibold-text mb-2" href="<?=base_url('mahasiswa/login.php')?>">Login Dengan Data <i class="fa fa-angle-right fa-fw"></i></a>
			</div>
		</div>
	</div>
</section>
<!-- Essential javascripts for application to work-->
<script src="<?= base_url('assets/js/jquery-3.3.1.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('mahasiswa/js/qrcodelib.js'); ?>"></script>
<script src="<?= base_url('mahasiswa/js/webcodecamjquery.js'); ?>"></script>
<!-- The javascript plugin to display page loading on top-->
<script type="text/javascript">
	var arg = {
		resultFunction: function(result) {
            //$('.hasilscan').append($('<input name="noijazah" value=' + result.code + ' readonly><input type="submit" value="Cek"/>'));
           // $.post("../cek.php", { noijazah: result.code} );
           var redirect = 'cekQrLogin.php';
           $.redirectPost(redirect, {id: result.code});
       }
   };

   var decoder = $("canvas").WebCodeCamJQuery(arg).data().plugin_WebCodeCamJQuery;
   decoder.buildSelectMenu("select");
   decoder.play();
    /*  Without visible select menu
        decoder.buildSelectMenu(document.createElement('select'), 'environment|back').init(arg).play();
        */
        $('select').on('change', function(){
        	decoder.stop().play();
        });

    // jquery extend function
    $.extend(
    {
    	redirectPost: function(location, args)
    	{
    		var form = '';
    		$.each( args, function( key, value ) {
    			form += '<input type="hidden" name="'+key+'" value="'+value+'">';
    		});
    		$('<form action="'+location+'" method="POST">'+form+'</form>').appendTo('body').submit();
    	}
    });
</script>
</body>
</html>