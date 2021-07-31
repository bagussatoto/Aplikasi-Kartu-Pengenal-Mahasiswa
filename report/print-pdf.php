<?php 

require_once('../library/config.php');

$angkatan = $_GET['angkatan'];
require '../html2pdf/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;

$content = "
<style type='text/css'>
	table {
	  border-spacing: 1;
	  border-collapse: collapse;
	}
	td,
	th {
	  padding-bottom : 8px;	  
	}

	img {
	  border: 0;
	}

	.img-responsive,
	.thumbnail > img,
	.thumbnail a > img,
	.carousel-inner > .item > img,
	.carousel-inner > .item > a > img {
	  display: block;
	  max-width: 100%;
	  height: auto;
	}

	.img-thumbnail {
	  display: inline-block;
	  max-width: 100%;
	  height: auto;
	  padding: 4px;
	  line-height: 1.42857143;
	  background-color: #fff;
	  border: 1px solid #ddd;
	  border-radius: 4px;
	  -webkit-transition: all .2s ease-in-out;
	       -o-transition: all .2s ease-in-out;
	          transition: all .2s ease-in-out;
	}

	.foto {
		width: 350;
		height: auto;
	}

	.text-center {
	  text-align: center;
	}
</style>";

$content .= "<table class='table'>";
$sql = $mysqli->query("SELECT * FROM tb_ktm WHERE tahun_ktm = '$angkatan'");
while ( $data = mysqli_fetch_assoc($sql) ) {
	// sql untuk ambil template
	$sql_t = $mysqli->query("SELECT * FROM tb_template ORDER BY id_template ASC LIMIT 1");
	$template = mysqli_fetch_array($sql_t);

	$front = '../images/ktm_finish/'.$data['tahun_ktm'].'/'.$data['front_file'];
	$beck = '../images/ktm_finish/'.$data['tahun_ktm'].'/'.$data['beck_file'];

	$content .= "
	<tr>
		<td class='text-center'>
			<img src='$front' class='img-responsive img-thumbnail foto'>
		</td>
		<td class='text-center'>&nbsp;</td>
		<td class='text-center'>
			<img src='$beck' class='img-responsive img-thumbnail foto'>
		</td>
	</tr>
	";
}
$content .= "</table>";

$html2pdf = new HTML2PDF('P','F4','en');
$html2pdf->WriteHTML($content);
$pdfName = "kartu-mahasiswa-angkatan-".$angkatan.".pdf";
$html2pdf->output($pdfName, 'I');

 ?>