<?php 

require_once('../library/config.php');

$id = $_GET['id'];
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
$sql = $mysqli->query("SELECT * FROM tb_ktm WHERE id_ktm = '$id'");
$data = mysqli_fetch_assoc($sql);

	$front = '../images/ktm_finish/'.$data['tahun_ktm'].'/'.$data['front_file'];
	$beck = '../images/ktm_finish/'.$data['tahun_ktm'].'/'.$data['beck_file'];

	$content .= "
	<tr>
		<td class='text-center'>
			<img src='$front' class='img-responsive img-thumbnail foto'>
		</td>
		<td class='text-center'> </td>
		<td class='text-center'> </td>
		<td class='text-center'> </td>
		<td class='text-center'> </td>
		<td class='text-center'> </td>
		<td class='text-center'>
			<img src='$beck' class='img-responsive img-thumbnail foto'>
		</td>
	</tr>
	";

$content .= "</table>";

$html2pdf = new HTML2PDF('L','A4','en', false, 'UTF-8', array(5, 5, 5, 5)); 
$html2pdf->WriteHTML($content);
$pdfName = "kartu-mahasiswa.pdf";
$html2pdf->output($pdfName, 'I');

?>