<div class="app-title">
	<div>
		<h1><i class="fa fa-graduation-cap"></i> Mahasiswa</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">Mahasiswa</a></li>
	</ul>
</div>
<?php if ($_SESSION['level'] == 1): ?>
	<a href="?page=add_mahasiswa" class="btn btn-primary tombol-layang tombol-modal"><i class="fa fa-fw fa-plus"></i></a>	
<?php endif ?>
<div class="row">
	<div class="col-md-12">

		<?php 
		require '../vendor/autoload.php';
		require '../phpqrcode/qrlib.php';
		use PhpOffice\PhpSpreadsheet\Spreadsheet;
		use PhpOffice\PhpSpreadsheet\Reader\Csv;
		use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
		if (isset($_POST['submit_excel'])) {

			$file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			if(isset($_FILES['berkas_excel']['name']) && in_array($_FILES['berkas_excel']['type'], $file_mimes)) {

				$arr_file = explode('.', $_FILES['berkas_excel']['name']);
				$extension = end($arr_file);

				if('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}

				$spreadsheet = $reader->load($_FILES['berkas_excel']['tmp_name']);

				$sheetData = $spreadsheet->getActiveSheet()->toArray();

				for($i = 1;$i < count($sheetData);$i++)
				{					
					$nim_mahasiswa		= $sheetData[$i]['0'];
					$nama_mahasiswa 	= $sheetData[$i]['1'];
					$tempat_lahir		= $sheetData[$i]['2'];
					$tgl_lahir			= $sheetData[$i]['3'];
					$alamat				= $sheetData[$i]['4'];
					$angkatan_mahasiswa	= $sheetData[$i]['5'];
					$gender				= $sheetData[$i]['6'];
					$email				= $sheetData[$i]['7'];

					$tgl_baru = date('Y-m-d', strtotime($tgl_lahir));

					// qr code script
					$tempdir 	= "../images/mahasiswa/qr_code/";
					$pathLogo 	= "../images/logo-qr-code.png";
					$ex 		= explode(" ", $nama_mahasiswa);
					$im 		= implode("-", $ex);
					$file_qr 	= strtolower($im).'-'.$nim_mahasiswa.'.png';
					$value 		= $nim_mahasiswa;
					$nama_file 	= $file_qr;

					echo qr_code_logo($tempdir, $pathLogo, $value, $nama_file);

					$password = "123456";
					$options = ['cost' => 10];					
					$password_hash = password_hash($password, PASSWORD_DEFAULT, $options);
					$mysqli->query("INSERT INTO tb_mahasiswa SET 
						nama_mahasiswa 		= '$nama_mahasiswa', 
						nim_mahasiswa 		= '$nim_mahasiswa',
						tempat_lahir 		= '$tempat_lahir',
						tgl_lahir 			= '$tgl_baru',
						alamat 				= '$alamat',
						angkatan_mahasiswa 	= '$angkatan_mahasiswa',
						gender 				= '$gender',
						email_mahasiswa 	= '$email',
						password_mahasiswa 	= '$password_hash',
						qr_code 			= '$file_qr'
						");
				}

				$url = "?page=mahasiswa";

				$text = "Import data mahasiswa telah selesai.";
				echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', $url);
			}
		}

		?>

		<div class="tile">
			<?php if ($_SESSION['level'] == 1): ?>				
				<button type="button" data-toggle="modal" data-target="#fileModal" class="btn btn-success btn-sm">Import Excel <i class="fa fa-fw fa-table"></i></button>
				<button type="button" onclick="javascript:window.location.href='<?=base_url('template-excel/template-mahasiswa.xlsx');?>';" class="btn btn-sm btn-info">Download Template Excel <i class="fa fa-fw fa-download"></i></button>
				<hr>
			<?php endif ?>
			<div class="tile-body">
				<?php if ($_SESSION['level'] == 1): ?>				
					<div class="tile">
						<h4 class="tile-title">Hapus Sesuai Angkatan</h4>
						<?php 

						if (isset($_POST['hapus_data_angkatan'])) {
							error_reporting(0);
							$del_tahun = sanitize($_POST['tahun_angkatan']);
							$sql_del = $mysqli->query("SELECT * FROM tb_mahasiswa WHERE angkatan_mahasiswa = '$del_tahun'");
							while ($data_del = mysqli_fetch_assoc($sql_del)) {

								$foto_awal = $mysqli->query("SELECT * FROM tb_mahasiswa WHERE id_mahasiswa = '$data_del[id_mahasiswa]'")->fetch_object()->foto_mahasiswa;
								unlink('../images/thumbs/rounded/'.$foto_awal);
								unlink('../images/thumbs/mahasiswa/'.$foto_awal);
								unlink('../images/mahasiswa/'.$foto_awal);

								$qr_code = $mysqli->query("SELECT * FROM tb_mahasiswa WHERE id_mahasiswa = '$data_del[id_mahasiswa]'")->fetch_object()->qr_code;
								unlink('../images/mahasiswa/qr_code/'.$qr_code);
								$update = $mysqli->query("DELETE FROM tb_mahasiswa WHERE angkatan_mahasiswa = '$del_tahun'");
								if ($update) {
									$text = "Data Mahasiswa Angkatan ".$del_tahun." Berhasil Dihapus.";
									echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '?page=mahasiswa');
								}
							}

						}

						?>
						<form action="" method="POST">
							<div class="tile-body">
								<div class="row form-group">
									<label class="control-label col-md-3" for="tahun_angkatan">Pilih Tahun Angkatan</label>
									<div class="col-md-6">
										<select class="form-control pilih2" name="tahun_angkatan" id="tahun_angkatan" required>
											<option value="">--- Pilih Angkatan ---</option>
											<?php 

											$sql = $mysqli->query("SELECT * FROM tb_mahasiswa GROUP BY angkatan_mahasiswa DESC");
											while ($tahun = mysqli_fetch_assoc($sql)) {
												echo '<option value="'.$tahun['angkatan_mahasiswa'].'">'.$tahun['angkatan_mahasiswa'].'</option>';
											}
											?>
										</select>										
									</div>
									<div class="col-md-3">
										<button type="submit" name="hapus_data_angkatan" class="btn btn-block btn-sm btn-secondary">Hapus <i class="fa fa-fw fa-trash"></i></button>
									</div>
								</div>
							</div>

						</form>
					</div>
					<hr>
				<?php endif; ?>
				<div class="table-responsive">
					<table class="table table-hover table-bordered" id="tabelKu" width="100%">
						<thead>
							<tr>
								<th class="text-center">Nama</th>
								<th class="text-center">NIM</th>
								<th class="text-center">Angkatan</th>
								<th class="text-center">QR Code</th>
								<th class="text-center">Foto</th>
								<?php if ($_SESSION['level'] == 1): ?>				
									<th class="text-center">Opsi</th>
								<?php endif; ?>
							</tr>
						</thead>
						<tbody>
							<?php 
							$sql = $mysqli->query("SELECT * FROM tb_mahasiswa ORDER BY tgl_input DESC");
							while($data = mysqli_fetch_assoc($sql)):
								$file = file_exists(base_url('images/thumbs/mahasiswa/'.$data['foto_mahasiswa']));
								$file_qr = file_exists(base_url('images/mahasiswa/qr_code/'.$data['qr_code']));
								?>
								<tr>
									<td><?= $data['nama_mahasiswa'] ?></td>
									<td class="text-center"><?= $data['nim_mahasiswa'] ?></td>
									<td class="text-center"><?= $data['angkatan_mahasiswa'] ?></td>
									<td class="text-center">
										<?php if(!$file_qr && !empty($data['qr_code'])): ?>
											<a href="<?=base_url('admin/pages/mahasiswa/download.php?file='.$data['qr_code']);?>" title="Download QR Code">
												<img class="img-responsive user-img-data img-thumbnail" alt="<?= $data['qr_code']; ?>" src="<?= base_url('images/mahasiswa/qr_code/'.$data['qr_code']); ?>" />
											</a>
										<?php else: ?>
											<i class="fa fa-qrcode fa-fw"></i>
										<?php endif; ?>
									</td>
									<td class="text-center">
										<?php if(!$file && !empty($data['foto_mahasiswa'])): ?>
											<a id="show_foto" data-toggle="modal" data-target="#img" href="javascript:void(0)" data-id="<?= $data['id_mahasiswa']; ?>" data-foto="<?= $data['foto_mahasiswa']; ?>">
												<img class="img-responsive user-img-data img-thumbnail" alt="<?= $data['foto_mahasiswa']; ?>" src="<?= base_url('images/thumbs/mahasiswa/'.$data['foto_mahasiswa']); ?>" />
											</a>
										<?php else: ?>
											<i class="fa fa-graduation-cap fa-fw"></i>
										<?php endif; ?>
									</td>
									<?php if ($_SESSION['level'] == 1): ?>				
										<td class="text-center">
											<a href="?page=edit_mahasiswa&id=<?= $data['id_mahasiswa']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>

											<a href="?page=delete_mahasiswa&id=<?= $data['id_mahasiswa']; ?>" class="btn btn-sm btn-danger tombol-hapus"><i class="fa fa-trash"></i></a>
										</td>
									<?php endif; ?>
								</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
</div>
<div id="img" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body" id="modal-gambar">
				<div style="padding-bottom: 5px;">
					<center>
						<img src="" id="pict" alt="" class="img-responsive img-thumbnail">
					</center>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="fileModalLabel">Import File Excel</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" enctype="multipart/form-data" action="">
				<div class="modal-body">
					<div class="form-group">
						<label for="exampleInputFile">File Upload</label>
						<input type="file" name="berkas_excel" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
						<small class="form-text text-muted" id="fileHelp">Sebelum upload download dulu template file excel nya.</small>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="submit" name="submit_excel" class="btn btn-primary">Upload</button>
				</div>						
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).on("click", "#show_foto", function() {
		var id = $(this).data('id');
		var ft = $(this).data('foto');
		$("#modal-gambar #id").val(id);
		$("#modal-gambar #pict").attr("src", "../images/mahasiswa/"+ft);
	});
</script>