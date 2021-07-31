<?php 
if (@$_GET['edit']) {
	$update_id = $_GET['edit'];
	$sql = $mysqli->query("SELECT * FROM tb_jurusan WHERE id_jurusan = '$update_id'");
	$data = mysqli_fetch_assoc($sql);

	$nama_jurusan = ((isset($_POST['nama_jurusan']))?sanitize($_POST['nama_jurusan']):$data['nama_jurusan']);
	$nama_jurusan = trim($nama_jurusan);

}else{
	$nama_jurusan = ((isset($_POST['nama_jurusan']))?sanitize($_POST['nama_jurusan']):'');
	$nama_jurusan = trim($nama_jurusan);	
}

$errors = array();
?><div class="app-title">
	<div>
		<h1><i class="fa fa-thumbs-o-up"></i> Jurusan</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">Jurusan</a></li>
	</ul>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="tile">
			<?php if(@$_GET['edit']): ?>
				<form method="POST" action="">
					<h3 class="tile-title">Edit Data</h3>
					<?php 
					if (isset($_POST['submit'])) {
						$update_id = sanitize($_GET['edit']);
						$nama_jurusan = sanitize($_POST['nama_jurusan']);

						if (empty($nama_jurusan)) {
							$errors[] = "Nama jurusan harus diisi.";
						}
						$sqlCek = $mysqli->query("SELECT * FROM tb_jurusan WHERE nama_jurusan = '$nama_jurusan' AND id_jurusan != '$update_id'");
						if (mysqli_num_rows($sqlCek) > 0) {
							$errors[] = "Jurusa $nama_jurusan sudah ada.";
						}
						if (!empty($errors)) {
							echo display_errors($errors);
						}else{
							$insert = $mysqli->query("UPDATE tb_jurusan SET nama_jurusan = '$nama_jurusan' WHERE id_jurusan = '$update_id'");
							if ($insert) {
								$text = "Berhasil menyimpan $nama_jurusan.";
								echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '?page=jurusan');
							}
						}
					}
					?>
					<div class="tile-body">
						<div class="form-group">
							<label class="control-label col-md-4" for="nama_jurusan">Nama Jurusan</label>
							<div class="col-md-12">
								<input class="form-control" id="nama_jurusan" type="text" placeholder="Nama Jurusan" name="nama_jurusan" autofocus value="<?= $nama_jurusan; ?>">
							</div>
						</div>
					</div>
					<div class="tile-footer">
						<div class="row">
							<div class="col-md-8 col-md-offset-3">
								<button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>

								<a href="?page=jurusan" class="btn btn-default">Batal <i class="fa fa-fw fa-remove"></i></a>
							</div>
						</div>
					</div>
					</form><?php else: ?>
					<form method="POST" action="">
						<h3 class="tile-title">Add Data</h3>
						<?php 
						if (isset($_POST['submit'])) {
							$nama_jurusan = sanitize($_POST['nama_jurusan']);

							if (empty($nama_jurusan)) {
								$errors[] = "Nama jurusan harus diisi.";
							}
							$sqlCek = $mysqli->query("SELECT * FROM tb_jurusan WHERE nama_jurusan = '$nama_jurusan'");
							if (mysqli_num_rows($sqlCek) > 0) {
								$errors[] = "Jurusa $nama_jurusan sudah ada.";
							}
							if (!empty($errors)) {
								echo display_errors($errors);
							}else{
								$insert = $mysqli->query("INSERT INTO tb_jurusan SET nama_jurusan = '$nama_jurusan'");
								if ($insert) {
									$text = "Berhasil menambah $nama_jurusan pada data Jurusan.";
									echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '?page=jurusan');
								}
							}
						}
						?>
						<div class="tile-body">
							<div class="form-group">
								<label class="control-label col-md-4" for="nama_jurusan">Nama Jurusan</label>
								<div class="col-md-12">
									<input class="form-control" id="nama_jurusan" type="text" placeholder="Nama Jurusan" name="nama_jurusan" autofocus value="<?= $nama_jurusan; ?>">
								</div>
							</div>
						</div>
						<div class="tile-footer">
							<div class="row">
								<div class="col-md-8 col-md-offset-3">
									<button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
								</div>
							</div>
						</div>
					</form>
				<?php endif; ?>
			</div>
		</div>
		<div class="col-md-8">
			<div class="tile">
				<div class="tile-body">
					<div class="table-responsive">
						<table class="table table-hover" id="tabelKu">
							<thead>
								<tr>
									<th class="text-center">Nama Jurusan</th>
									<th class="text-center">Opsi</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$sql = $mysqli->query("SELECT * FROM tb_jurusan ORDER BY nama_jurusan ASC");
								while($data = mysqli_fetch_assoc($sql)):
									?>
									<tr>
										<td class="text-center"><?= $data['nama_jurusan']; ?></td>
										<td class="text-center">				
											<a href="?page=jurusan&edit=<?= $data['id_jurusan']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>

											<a href="?page=jurusan&del=<?= $data['id_jurusan']; ?>" class="btn btn-sm btn-danger tombol-hapus"><i class="fa fa-trash"></i></a>
										</td>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php 
	if (@$_GET['del']) {
		$del_id = $_GET['del'];
		$delete = $mysqli->query("DELETE FROM tb_jurusan WHERE id_jurusan = '$del_id' ");
		if ($delete) {
			$text = "Data berhasil dihapus.";
			echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '?page=jurusan');
		}
	}
	?>