<?php 
$id_mahasiswa = $_GET['id'];
$sql = $mysqli->query("SELECT * FROM tb_mahasiswa WHERE id_mahasiswa = '$id_mahasiswa'");
$data = mysqli_fetch_array($sql);

$nama_mahasiswa = ((isset($_POST['nama_mahasiswa']))?sanitize($_POST['nama_mahasiswa']):$data['nama_mahasiswa']);
$nama_mahasiswa = trim($nama_mahasiswa);

$email_mahasiswa = ((isset($_POST['email_mahasiswa']))?sanitize($_POST['email_mahasiswa']):$data['email_mahasiswa']);
$email_mahasiswa = trim($email_mahasiswa);

$nim_mahasiswa = ((isset($_POST['nim_mahasiswa']))?sanitize($_POST['nim_mahasiswa']):$data['nim_mahasiswa']);
$nim_mahasiswa = trim($nim_mahasiswa);

$gender = ((isset($_POST['gender']))?sanitize($_POST['gender']):$data['gender']);
$gender = trim($gender);

$tempat_lahir = ((isset($_POST['tempat_lahir']))?sanitize($_POST['tempat_lahir']):$data['tempat_lahir']);
$tempat_lahir = trim($tempat_lahir);

$tgl_lahir = ((isset($_POST['tgl_lahir']))?sanitize($_POST['tgl_lahir']):$data['tgl_lahir']);
$tgl_lahir = trim($tgl_lahir);

$alamat = ((isset($_POST['alamat']))?sanitize($_POST['alamat']):$data['alamat']);
$alamat = trim($alamat);

$angkatan_mahasiswa = ((isset($_POST['angkatan_mahasiswa']))?sanitize($_POST['angkatan_mahasiswa']):$data['angkatan_mahasiswa']);
$angkatan_mahasiswa = trim($angkatan_mahasiswa);

$jurusan_mahasiswa = ((isset($_POST['jurusan_mahasiswa']))?sanitize($_POST['jurusan_mahasiswa']):$data['jurusan_mahasiswa']);
$jurusan_mahasiswa = trim($jurusan_mahasiswa);
?>
<div class="app-title">
	<div>
		<h1>
			<a href="?page=mahasiswa" class="btn btn-default"><i class="fa fa-chevron-left"></i></a>&nbsp;
			<i class="fa fa-graduation-cap"></i> Edit Mahasiswa
		</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="?page=mahasiswa">Mahasiswa</a></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">Edit</a></li>
	</ul>
</div>
<div class="row">
	<div class="col-md-3 text-center">
		<div class="tile">
			<?php
			$file = file_exists(base_url('images/mahasiswa/'.$data['foto_mahasiswa'])); 
			if (!empty($data['foto_mahasiswa']) && !$file):
				?>
				<h3 class="tile-title">Pas Foto</h3>
				<?php 
				if (isset($_POST['hapus_foto'])) {
					$update_id = sanitize($_POST['id']);
					$foto_awal = $mysqli->query("SELECT * FROM tb_mahasiswa WHERE id_mahasiswa = '$update_id'")->fetch_object()->foto_mahasiswa;
					unlink('../images/thumbs/rounded/'.$foto_awal);
					unlink('../images/thumbs/mahasiswa/'.$foto_awal);
					unlink('../images/mahasiswa/'.$foto_awal);
					$update = $mysqli->query("UPDATE tb_mahasiswa SET foto_mahasiswa = '' WHERE id_mahasiswa = '$update_id'");
					if ($update) {
						$text = "Foto Berhasil Dihapus.";
						echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '');
					}
				}
				?>
				<form action="" method="POSt">
					<div class="tile-body">
						<input type="hidden" name="id" value="<?= $data['id_mahasiswa'] ?>">
						<img class="img-responsive img-thumbnail" src="<?= base_url('images/thumbs/mahasiswa/'.$data['foto_mahasiswa']); ?>">
					</div>
					<div class="tile-footer">
						<button type="submit" name="hapus_foto" class="btn btn-block btn-danger">Hapus <i class="fa fa-fw fa-trash"></i></button>
					</div>
					</form><?php else: ?>
					<h3 class="tile-title">Add Foto <?= $data['nama_mahasiswa']; ?></h3>
					<?php 
					$errors = array();
					if (isset($_POST['submit_foto'])) {
						error_reporting(0);
						// upload foto
						$nim_mahasiswa = sanitize($_POST['nim_mahasiswa']);
						$extensi = explode('.', $_FILES['foto']['name']);
						$nama_foto = $nim_mahasiswa.'.'.end($extensi);
						$sumber = $_FILES['foto']['tmp_name'];
						$uploadOk = 1;
						$imageFileType = strtolower(pathinfo($nama_foto, PATHINFO_EXTENSION));

						if (empty($sumber)) {
							$errors[] = "Foto tidak boleh kosong.";
						}

						$check = getimagesize($sumber);
						if ($check==false) {
							$errors[] = "Type File Harus Gambar.";
							$uploadOk = 0;
						}
						if (file_exists($nama_foto)) {
							$errors[] = "File Sudah Ada.";
							$uploadOk = 0;
						}
						if ($_FILES['foto']['size'] > 2000000) {
							$errors[] = "Ukuran File Maksimal 2Mb.";
							$uploadOk = 0;
						}
						if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
							&& $imageFileType != "gif" ) {
							$errors[] = "Etensi File Harus JPG, JPEG, PNG atau Gif.";
						$uploadOk = 0;
					}
					if ($uploadOk == 0) {
						$errors[] = "Upload foto gagal.";
					}else{
						if (!empty($errors)) {
							echo display_errors($errors);
						}else{
							$update = $mysqli->query("UPDATE tb_mahasiswa SET foto_mahasiswa = '$nama_foto' WHERE id_mahasiswa = '$id_mahasiswa'");
							if ($update) {
								// error_reporting(1);
								if(move_uploaded_file($sumber, '../images/mahasiswa/'.$nama_foto)){
									createThumbs('../images/mahasiswa/', '../images/thumbs/mahasiswa/', 200);
									gambar_bulat('../images/mahasiswa/'.$nama_foto, '../images/thumbs/rounded/', $nama_foto, 173);
								}

								$text = "Foto $data[nama_mahasiswa] berhasil diupdate.";
								echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '');
							}
						}
					}
				}
				?>
				<form enctype="multipart/form-data" action="" method="POST">
					<div class="tile-body">
						<input type="hidden" name="nim_mahasiswa" value="<?= $data['nim_mahasiswa']; ?>">
						<input type="file" name="foto" class="dropify" class="form-control" required>
					</div>
					<div class="tile-footer">
						<button class="btn btn-primary btn-block" type="submit" name="submit_foto"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
					</div>
				</form>
			<?php endif ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="tile">
			<h3 class="tile-title">Edit Data <?= $data['nama_mahasiswa']; ?></h3>
			<?php 
			$errors = array();
			if (isset($_POST['submit_info'])) {
				$nama_mahasiswa 	= sanitize($_POST['nama_mahasiswa']);
				$nim_mahasiswa 		= sanitize($_POST['nim_mahasiswa']);
				$email_mahasiswa 	= sanitize($_POST['email_mahasiswa']);
				$gender 			= sanitize($_POST['gender']);
				$tempat_lahir 		= sanitize($_POST['tempat_lahir']);
				$tgl_lahir 			= sanitize($_POST['tgl_lahir']);
				$angkatan_mahasiswa = sanitize($_POST['angkatan_mahasiswa']);
				$jurusan_mahasiswa 	= sanitize($_POST['jurusan_mahasiswa']);
				$alamat 			= sanitize($_POST['alamat']);

				if (empty($nama_mahasiswa)) {
					$errors[] = "Nama mahasiswa harus diisi.";
				}

				$sqlCekEmail = $mysqli->query("SELECT * FROM tb_mahasiswa WHERE email_mahasiswa='$email_mahasiswa' and id_mahasiswa != '$id_mahasiswa'");
				if (mysqli_num_rows($sqlCekEmail) > 0) {
					$errors[] = "Email $email_mahasiswa sudah digunakan. Mohon gunakan yang lain.";
				}

				if (!empty($errors)) {
					echo display_errors($errors);
				}else{
					$update = $mysqli->query("UPDATE tb_mahasiswa SET 
						nama_mahasiswa 	= '$nama_mahasiswa', 
						nim_mahasiswa 	= '$nim_mahasiswa', 
						email_mahasiswa = '$email_mahasiswa', 
						gender 			= '$gender', 
						tempat_lahir 	= '$tempat_lahir',
						tgl_lahir 		= '$tgl_lahir', 
						angkatan_mahasiswa = '$angkatan_mahasiswa', 
						jurusan_mahasiswa = '$jurusan_mahasiswa', 
						alamat 			= '$alamat' 
						WHERE id_mahasiswa = '$id_mahasiswa' ");

					if ($update) {
						$text = "Data $nama_mahasiswa berhasil diupdate.";
						echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '');
					}
				}
			}
			?>
			<form method="POST" action="">
				<div class="tile-body">
					<div class="form-group row">
						<label class="control-label col-md-3" for="nama_mahasiswa">Nama</label>
						<div class="col">
							<input type="text" id="nama_mahasiswa" autofocus name="nama_mahasiswa" class="form-control" value="<?= $nama_mahasiswa; ?>">
						</div>	
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="nim_mahasiswa">NIM</label>
						<div class="col">
							<input type="text" id="nim_mahasiswa"name="nim_mahasiswa" class="form-control" value="<?= $nim_mahasiswa; ?>" readonly aria-describedby="nisnHelp">
							<small class="form-text text-muted">NIM tidak dapat diubah, jika data salah silahkan hapus dan buat ulang.</small>
						</div>	
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="email_mahasiswa">Email</label>
						<div class="col">
							<input type="email" id="email_mahasiswa" autofocus name="email_mahasiswa" class="form-control" value="<?= $email_mahasiswa; ?>" required>
						</div>	
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="gender">Gender</label>
						<div class="col">
							<div class="anisnated-radio-button">
								<label>
									<input type="radio" name="gender" value="L" <?php if($gender=="L")echo "checked"; ?>><span class="label-text">Laki laki</span>
								</label>
							</div>
							<div class="anisnated-radio-button">
								<label>
									<input type="radio" name="gender" value="P" <?php if($gender=="P")echo "checked"; ?>><span class="label-text">Perempuan</span>
								</label>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="tempat_lahir">Tempat Lahir</label>
						<div class="col">
							<input type="text" name="tempat_lahir" class="form-control" id="tempat_lahir" value="<?= $tempat_lahir ?>"  placeholder="Tempat lahir">
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="tgl_lahir">Tanggal Lahir</label>
						<div class="col">
							<input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir" value="<?= $tgl_lahir ?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="alamat">Alamat</label>
						<div class="col">
							<textarea class="form-control" rows="3" name="alamat" id="alamat" placeholder="Alamat"><?= $alamat ?></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="angkatan_mahasiswa">Angkatan</label>
						<div class="col">
							<select name="angkatan_mahasiswa" id="angkatan_mahasiswa" class="pilih2 form-control">
								<option value="">---Pilih Tahun Angkatan---</option>
								<?php 
								for ($year=date('Y'); $year >= 2010 ; $year--) { 
									if ($year==$angkatan_mahasiswa) {
										$cek = "selected";
									}else{
										$cek = "";
									}
									echo "<option value=$year $cek>$year</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="row form-group">
						<label class="control-label col-md-3" for="jurusan_mahasiswa">Jurusan</label>
						<div class="col">
							<select name="jurusan_mahasiswa" id="jurusan_mahasiswa" class="pilih2 form-control">
								<option value="">---Pilih Jurusan---</option>
								<?php 
								$sql = $mysqli->query("SELECT * FROM tb_jurusan ORDER BY nama_jurusan");
								while ($dataM = mysqli_fetch_array($sql)) { 
									$id_jurusan = $dataM['id_jurusan'];
									$nama_jurusan = $dataM['nama_jurusan'];
									if ($id_jurusan==$jurusan_mahasiswa) {
										$cek = "selected";
									}else{
										$cek = "";
									}
									echo "<option value='$id_jurusan' $cek>$nama_jurusan</option>";
								}
								?>
							</select>
						</div>
						
					</div>
				</div>
				<div class="tile-footer">
					<button class="btn btn-primary btn-block" type="submit" name="submit_info"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-3 text-center">
		<div class="tile">
			<h3 class="tile-title">QR Code <?= $data['nama_mahasiswa'] ?></h3>
			<div class="tile-body">
				<img src="<?= base_url('images/mahasiswa/qr_code/'.$data['qr_code']); ?>" class="img-responsive img-thumbnail" alt="<?= $data['qr_code'] ?>">
			</div>
			<div class="tile-footer">
				<button type="button" onclick="javascript:window.location.href='<?=base_url('admin/pages/mahasiswa/download.php?file='.$data['qr_code']);?>';" class="btn btn-block btn-primary">Download <i class="fa fa-fw fa-download"></i></button>
			</div>
		</div>
	</div>
</div>
