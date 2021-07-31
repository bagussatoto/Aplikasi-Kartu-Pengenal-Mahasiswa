<?php 
$angkatan = ((isset($_POST['angkatan']))?sanitize($_POST['angkatan']): @$_GET['tampil']);
$dataAngkatan = trim($angkatan);


if (@$_GET['hapus']) {
	$del_id = $_GET['hapus'];
	$sqlHapus = $mysqli->query("SELECT * FROM tb_ktm WHERE id_ktm = '$del_id'");
	$dataHapus = mysqli_fetch_assoc($sqlHapus);

	$foto_ktm = $mysqli->query("SELECT * FROM tb_ktm WHERE id_ktm = '$del_id'")->fetch_object()->front_file;
	$foto_ktm2 = $mysqli->query("SELECT * FROM tb_ktm WHERE id_ktm = '$del_id'")->fetch_object()->beck_file;

	unlink('../images/ktm_finish/'.$dataHapus['tahun_ktm'].'/'.$foto_ktm);
	unlink('../images/ktm_finish/'.$dataHapus['tahun_ktm'].'/'.$foto_ktm2);
	$delete = $mysqli->query("DELETE FROM tb_ktm WHERE id_ktm = '$del_id'");
	if ($delete) {
		$text = "Kartu Mahasiswa ".$dataHapus['front_file']." berhasil dihapus.";
		echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '?page=ktm&tampil='.$dataHapus['tahun_ktm']);
	}
}
?>
<div class="app-title">
	<div>
		<h1><i class="fa fa-id-card"></i> Kartu Mahasiswa</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">Kartu Mahasiswa</a></li>
	</ul>
</div>
<div class="row">
	<?php if ($_SESSION['level'] == 1): ?>				
		<div class="col-md-6">
			<div class="tile">
				<form method="POST" action="">
					<div class="tile-body">
						<h3 class="tile-title">Buat Kartu Mahasiswa</h3>
						<?php 
						if (isset($_POST['submit_c'])) {
							$sql_temp = $mysqli->query("SELECT * FROM tb_template LIMIT 1");
							if ($sql_temp->num_rows == 0 ) {
								$url = "?page=template";
								$text = "Mohon unggah template kartu terlebih dahulu.";
								echo sweetalert('Oops.!', $text, 'danger', '3000', 'true', $url);
							}else{								
								$angkatan = sanitize($_POST['angkatan']);
								$url = "?page=create_ktm&angkatan=".$angkatan;

								$text = "Permintaanmu sedang kami proses.!";
								echo sweetalert('Tunggu sebentar.!', $text, 'info', '5000', 'false', $url);
							}
						}
						?>
						<div class="form-group">
							<select name="angkatan" class="form-control" required>
								<option value="">--- Pilih Tahun Angkatan ---</option>
								<?php 

								$sql = $mysqli->query("SELECT * FROM tb_mahasiswa GROUP BY angkatan_mahasiswa DESC");
								while ($tahun = mysqli_fetch_assoc($sql)) {
									echo '<option value="'.$tahun['angkatan_mahasiswa'].'">'.$tahun['angkatan_mahasiswa'].'</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="tile-footer">
						<button type="submit" name="submit_c" class="btn btn-block btn-primary">Buat <i class="fa fa-fw fa-lg fa-cog"></i></button>
					</div>
				</form>
			</div>
		</div>
	<?php endif; ?>
	<div class="col-md-6">
		<div class="tile">
			<form method="POST" action="">
				<div class="tile-body">
					<h3 class="tile-title">Tampilkan Kartu Mahasiswa</h3>
					<div class="form-group">
						<select name="angkatan" class="form-control" required>
							<option value="">--- Pilih Tahun Angkatan ---</option>
							<?php 

							$sql = $mysqli->query("SELECT * FROM tb_ktm GROUP BY tahun_ktm DESC");
							if (mysqli_num_rows($sql) > 0) {
								while ($tahun = mysqli_fetch_assoc($sql)) {
									echo '<option value="'.$tahun['tahun_ktm'].'">'.$tahun['tahun_ktm'].'</option>';
								}
							}else{
								echo "<option value=''>Belum pernah membuat kartu.</option>";
							}
							?>
						</select>
					</div>
				</div>
				<div class="tile-footer">
					<button type="submit" name="tampil" class="btn btn-block btn-primary">Tampilkan <i class="fa fa-fw fa-lg fa-eye"></i></button>
				</div>
			</form>
		</div>
	</div>

	<?php 
	if(isset($_POST['tampil']) || @$_GET['tampil']):
		$angkatan = $dataAngkatan;
		?>
		<div class="col-md-12">
			<div class="tile">
				<div class="tile-title">Kartu Mahasiswa Angkatan <?= $angkatan; ?></div>
				<div class="tile-body">					
					<div class="table-responsive">
						<table class="table table-hover table-striped" id="tabelKu">
							<thead>
								<tr>
									<th class="text-center">Front</th>
									<th class="text-center">Beck</th>
									<?php if ($_SESSION['level'] == 1): ?>				
										<th class="text-center">Opsi</th>
									<?php endif; ?>
								</tr>
							</thead>
							<tbody>
								<?php 
								$sqlKtm = $mysqli->query("SELECT * FROM tb_ktm WHERE tahun_ktm = '$angkatan'");
								while($dataKtm = mysqli_fetch_assoc($sqlKtm)):

									// sql untuk ambil template
									$sql_t = $mysqli->query("SELECT * FROM tb_template ORDER BY id_template ASC LIMIT 1");
									$template = mysqli_fetch_array($sql_t);

									$front = base_url('images/ktm_finish/'.$dataKtm['tahun_ktm'].'/'.$dataKtm['front_file']);
									$beck = base_url('images/ktm_finish/'.$dataKtm['tahun_ktm'].'/'.$dataKtm['beck_file']);
									?>
									<tr>
										<td class="text-center">
											<img src="<?= $front; ?>" alt="<?= $front; ?>" class="img-responsive img-thumbnail" style="width: 50vh;">
										</td>
										<td class="text-center">
											<img src="<?= $beck; ?>" alt="<?= $beck; ?>" class="img-responsive img-thumbnail" style="width: 50vh;">
										</td>
										<?php if ($_SESSION['level'] == 1): ?>				
											<td class="text-center">
												<a href="<?= base_url('report/print-per-id.php?id='.$dataKtm['id_ktm']) ?>" class="btn btn-info" title="Download">
													<i class="fa fa-print fa-fw fa-lg"></i>
												</a>
												<a href="?page=ktm&hapus=<?= $dataKtm['id_ktm']; ?>" class="btn btn-danger tombol-hapus" title="Hapus">
													<i class="fa fa-trash fa-fw fa-lg"></i>
												</a>
											</td>
										<?php endif; ?>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="tile-footer">
					<a class="btn btn-primary" href="<?= base_url('report/print-pdf.php?angkatan='.$angkatan); ?>" target="_blank">Cetak &nbsp;<i class="fa fa-fw fa-lg fa-print"></i></a>
				</div>
			</div>
		</div>
	<?php endif; ?>

</div>