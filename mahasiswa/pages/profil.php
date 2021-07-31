<div class="app-title">
	<div>
		<h1><i class="fa fa-user"></i> Profil</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">Profil</a></li>
	</ul>
</div>

<div class="row user">
	<div class="col-md-12">
		<div class="profile">
			<div class="info">
				<?php 
				$file = file_exists(base_url('images/thumbs/mahasiswa/'.$mahasiswa['foto_mahasiswa']));
				if(!$file && !empty($mahasiswa['foto_mahasiswa'])):
					?>

					<img class="user-img rounded-circle" src="<?= base_url('images/thumbs/mahasiswa/'.$mahasiswa['foto_mahasiswa']); ?>" alt="<?= base_url('images/thumbs/mahasiswa/'.$mahasiswa['foto_mahasiswa']); ?>" />
				<?php else: ?>
					<img src="<?= base_url('images/logo-mahasiswa.png') ?>" class="user-img rounded-circle" alt="<?= base_url('images/logo-mahasiswa.png') ?>">
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="tile p-0">
			<ul class="nav flex-column nav-tabs user-tabs">
				<li class="nav-item"><a class="nav-link active" href="#user-info" data-toggle="tab">Kartu Tanda Mahasiswa</a></li>
				<li class="nav-item"><a class="nav-link" href="#user-password" data-toggle="tab">Ganti Password</a></li>
			</ul>
		</div>
	</div>

	<div class="col-md-9">
		<div class="tab-content">
			<div class="tab-pane active" id="user-info">
				<div class="tile user-info">
					<h4 class="line-head">Kartu Tanda Mahasiswa</h4>
					<div class="table-responsive">
						<table class="table table-hover">
							<?php 
							$sqlKtm = $mysqli->query("SELECT * FROM tb_ktm WHERE nim_mahasiswa = '$mahasiswa[nim_mahasiswa]' ");
							$dataKtm = mysqli_fetch_assoc($sqlKtm);
							// sql untuk ambil template
							$sql_t = $mysqli->query("SELECT * FROM tb_template ORDER BY id_template ASC LIMIT 1");
							$template = mysqli_fetch_array($sql_t);

							$front = base_url('images/ktm_finish/'.$dataKtm['tahun_ktm'].'/'.$dataKtm['front_file']);
							$beck = base_url('images/ktm_finish/'.$dataKtm['tahun_ktm'].'/'.$dataKtm['beck_file']);
							?>							
							<tr>
								<?php if( empty($dataKtm) ): ?>
									<td class="text-center">
										<h4>Kartu anda belum dibuat. Silahkan hubungi penanggung jawab pembuatan.</h4>
									</td>
								<?php else: ?>
									<td class="text-center">
										<img src="<?= $front; ?>" alt="<?= $front; ?>" class="img-responsive img-thumbnail" style="width: 50vh;">
									</td>
									<td class="text-center">
										<img src="<?= $beck; ?>" alt="<?= $beck; ?>" class="img-responsive img-thumbnail" style="width: 50vh;">
									</td>
									<td class="text-center" style="vertical-align: middle;">
										<a href="<?= base_url('report/print-per-id.php?id='.$dataKtm['id_ktm']) ?>" class="btn btn-info" title="Download">
											<i class="fa fa-print fa-fw fa-lg"></i>
										</a>
									</td>
								<?php endif; ?>
							</tr>
						</table>
					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="user-password">
				<div class="tile user-info">
					<h4 class="line-head">Ubah Password</h4>
					<div>
						<?php 
						$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
						$password = trim($password);

						$conf_password = ((isset($_POST['conf_password']))?sanitize($_POST['conf_password']):'');
						$conf_password = trim($conf_password);

						$errors = array();

						if (isset($_POST['cpass'])) {
							$update_id 	= sanitize($_POST['id']);
							$password = sanitize($_POST['password']);	
							$conf_password = sanitize($_POST['conf_password']);	

							if (strlen($password) < 6) {
								$errors[] = "Gunakan minisnal 6 karakter untuk password.";
							}
							if ($conf_password != $password) {
								$errors[] = "Konfirmasi password salah.";
							}

							if (!empty($errors)) {
								echo display_errors($errors);
							}else{
								$options = ['cost' => 10];					
								$password_hash = password_hash($password, PASSWORD_DEFAULT, $options);
								$update = $mysqli->query("UPDATE tb_mahasiswa SET password_mahasiswa = '$password_hash' WHERE id_mahasiswa = '$update_id'");

								if ($update) {
									$text = "Password $mahasiswa[nama_mahasiswa] berhasil diupdate.";
									echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '?page=profil');
								}
							}
							echo "<hr>";
						}

						?>
					</div>
					<form method="POST" action="" class="row">
						<div class="form-group col-md-4">
							<label class="control-label">Password Baru</label>
							<input class="form-control" name="password" type="password" placeholder="Masukkan password baru anda" value="<?= $password; ?>">
						</div>
						<div class="form-group col-md-4">
							<label class="control-label">Konfirmasi Password</label>
							<input class="form-control" name="conf_password" type="password" placeholder="Tulis ulang password anda" value="<?= $conf_password; ?>">
						</div>
						<div class="form-group col-md-4 align-self-end">
							<input type="hidden" name="id" value="<?= $mahasiswa['id_mahasiswa']; ?>">
							<button class="btn btn-primary" type="submit" name="cpass"><i class="fa fa-fw fa-lg fa-check-circle"></i>Simpan</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>