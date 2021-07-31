<?php 

$sql = $mysqli->query("SELECT * FROM tb_template ORDER BY id_template ASC LIMIT 1");
$data = mysqli_fetch_array($sql);

?>
<div class="app-title">
	<div>
		<h1><i class="fa fa-image"></i> Template Kartu</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">Template Kartu</a></li>
	</ul>
</div>

<!-- <div class="row">
	<div class="col-md-12"> -->
		<div class="tile">

			<div class="bs-component">
				<ul class="nav nav-tabs">					
					<?php if(empty($data['nama_kepsek'])): ?>
						<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#kepsek">Kepala Sekolah</a></li>
					<?php endif; ?>

					<?php if(!empty($data['nama_kepsek'])): ?>
						<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#kepsek2">Kepala Sekolah</a></li>
						<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#kartu">Template Kartu</a></li>
						<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ttds">Tanda Tangan dan Stempel</a></li>
					<?php endif; ?>
				</ul>

				<div class="tab-content" id="myTabContent">

					<?php if(!empty($data['nama_kepsek'])): ?>
						<div class="tab-pane fade" id="kartu">
							<div class="row">
								<div class="col-md-12 col-xs-12 text-center">
									<div class="tile">
										<?php if ($data['front_template'] == '' && $data['beck_template'] == ''): ?>
											<?php 
											$errors = array();
											if (isset($_POST['submit_foto'])) {
										// error_reporting(0);

												$ex_ft = explode('.', $_FILES['front_template']['name']);
												$ex_bt = explode('.', $_FILES['beck_template']['name']);

												$nama_ft = "template-depan".'.'.end($ex_ft);
												$nama_bt = "template-belakang".'.'.end($ex_bt);

												$sumber_ft = $_FILES['front_template']['tmp_name'];
												$sumber_bt = $_FILES['beck_template']['tmp_name'];

												$uploadOk = 1;

												$imageFileType_ft = strtolower(pathinfo($nama_ft, PATHINFO_EXTENSION));
												$imageFileType_bt = strtolower(pathinfo($nama_bt, PATHINFO_EXTENSION));


												$check_ft = getimagesize($sumber_ft);
												$check_bt = getimagesize($sumber_bt);
												if ($check_ft == FALSE) {
													$errors[] = "Type File Harus Gambar.";
													$uploadOk = 0;
												}
												if ($check_bt == FALSE) {
													$errors[] = "Type File Harus Gambar.";
													$uploadOk = 0;
												}

												if (file_exists($nama_ft)) {
													$errors[] = "File Sudah Ada.";
													$uploadOk = 0;
												}
												if (file_exists($nama_bt)) {
													$errors[] = "File Sudah Ada.";
													$uploadOk = 0;
												}

												if ($_FILES['front_template']['size'] > 2000000) {
													$errors[] = "Ukuran File Maksimal 2Mb.";
													$uploadOk = 0;
												}
												if ($_FILES['beck_template']['size'] > 2000000) {
													$errors[] = "Ukuran File Maksimal 2Mb.";
													$uploadOk = 0;
												}

												if($imageFileType_ft != "jpg" && $imageFileType_ft != "png" && $imageFileType_ft != "jpeg" && $imageFileType_ft != "gif" )
												{
													$errors[] = "Etensi File Harus JPG, JPEG, PNG atau Gif.";
													$uploadOk = 0;
												}
												if($imageFileType_bt != "jpg" && $imageFileType_bt != "png" && $imageFileType_bt != "jpeg" && $imageFileType_bt != "gif" )
												{
													$errors[] = "Etensi File Harus JPG, JPEG, PNG atau Gif.";
													$uploadOk = 0;
												}

												if (!empty($errors)) {
													echo display_errors($errors);
												}else{
													$insert = $mysqli->query("UPDATE tb_template SET front_template = '$nama_ft', beck_template = '$nama_bt' ");
													if ($insert) {
														move_uploaded_file($sumber_ft, '../images/design_ktm/'.$nama_ft);
														move_uploaded_file($sumber_bt, '../images/design_ktm/'.$nama_bt);

														$text = "Template kartu berhasil disimpan.";
														echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '');

													}
												}

											}
											?>
											<form enctype="multipart/form-data" action="" method="POST">
												<div class="tile-body row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label tile-title" for="front_template">Kartu Tampak Depan</label>
															<input type="file" id="front_template" name="front_template" class="dropify" class="form-control" required>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label tile-title" for="beck_template">Kartu Tampak Belakang</label>
															<input type="file" id="beck_template" name="beck_template" class="dropify" class="form-control" required>
														</div>
													</div>
												</div>
												<div class="tile-footer">
													<button class="btn btn-primary btn-block" type="submit" name="submit_foto"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
												</div>
											</form>
											<?php else: ?>
												<?php 
												$file_ft = file_exists(base_url('images/design_ktm/'.$data['front_template']));
												$file_bt = file_exists(base_url('images/design_ktm/'.$data['beck_template']));

												if (isset($_POST['hapus_foto'])) {
													$file_ft = $mysqli->query("SELECT * FROM tb_template ORDER BY id_template ASC LIMIT 1")->fetch_object()->front_template;
													$file_bt = $mysqli->query("SELECT * FROM tb_template ORDER BY id_template ASC LIMIT 1")->fetch_object()->beck_template;

													unlink('../images/design_ktm/'.$file_ft);
													unlink('../images/design_ktm/'.$file_bt);
													$update = $mysqli->query("UPDATE tb_template SET front_template = '', beck_template = '' ");
													if ($update) {
														$text = "Template kartu Berhasil Dihapus.";
														echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '');
													}
												}
												?>
												<form method="POST" action="">
													<div class="tile-body row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="control-label tile-title" for="front_template">Kartu Tampak Depan</label>
																<img src="<?= base_url('images/design_ktm/'.$data['front_template']) ?>" class="img-responsive img-thumbnail" alt="<?= $data['front_template'] ?>">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="control-label tile-title" for="beck_template">Kartu Tampak Belakang</label>
																<img src="<?= base_url('images/design_ktm/'.$data['beck_template']) ?>" class="img-responsive img-thumbnail" alt="<?= $data['beck_template'] ?>">
															</div>
														</div>
													</div>
													<div class="tile-footer">
														<button type="submit" name="hapus_foto" class="btn btn-block btn-danger">Hapus <i class="fa fa-fw fa-trash"></i></button>
													</div>
												</form>
											<?php endif ?>

										</div>
									</div>
								</div>
							</div>

							<!-- Stempel -->
							<div class="tab-pane fade" id="ttds">
								<div class="row">
									<div class="col-md-12 col-xs-12 text-center">
										<div class="tile">
											<?php if (!empty($data['stempel']) && !empty($data['tanda_tangan'])): ?>
											
											<?php 
											$file_ft = file_exists(base_url('images/design_ktm/'.$data['front_template']));
											$file_bt = file_exists(base_url('images/design_ktm/'.$data['beck_template']));

											if (isset($_POST['hapus_ttds'])) {
												$file_ttd = $mysqli->query("SELECT * FROM tb_template ORDER BY id_template ASC LIMIT 1")->fetch_object()->tanda_tangan;
												$file_stempel = $mysqli->query("SELECT * FROM tb_template ORDER BY id_template ASC LIMIT 1")->fetch_object()->stempel;

												unlink('../images/design_ktm/'.$file_ttd);
												unlink('../images/design_ktm/'.$file_stempel);
												unlink('../images/design_ktm/ttd/'.$file_ttd);
												unlink('../images/design_ktm/stempel/'.$file_stempel);
												$update = $mysqli->query("UPDATE tb_template SET tanda_tangan = '', stempel = '' ");
												if ($update) {
													$text = "Tanda Tangan dan Stempel Berhasil Dihapus.";
													echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '');
												}
											}
											?>
											<form method="POST" action="">
												<div class="tile-body row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label tile-title" for="tanda_tangan">Tanda Tangan</label>
															<img src="<?= base_url('images/design_ktm/'.$data['tanda_tangan']) ?>" class="img-responsive img-thumbnail" alt="<?= $data['tanda_tangan'] ?>">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label tile-title" for="stempel">Stempel</label>
															<img src="<?= base_url('images/design_ktm/'.$data['stempel']) ?>" class="img-responsive img-thumbnail" alt="<?= $data['stempel'] ?>">
														</div>
													</div>
												</div>
												<div class="tile-footer">
													<button type="submit" name="hapus_ttds" class="btn btn-block btn-danger">Hapus <i class="fa fa-fw fa-trash"></i></button>
												</div>
											</form>
											<?php else: ?>
												<?php 
												$errors = array();
												if (isset($_POST['submit_ttds'])) {

													$ttd = explode('.', $_FILES['tanda_tangan']['name']);
													$stempel = explode('.', $_FILES['stempel']['name']);

													$nama_ttd = "tanda-tangan".'.'.end($ttd);
													$nama_stempel = "stempel".'.'.end($stempel);

													$sumber_ttd = $_FILES['tanda_tangan']['tmp_name'];
													$sumber_stempel = $_FILES['stempel']['tmp_name'];

													$uploadOk = 1;

													$imageFileType_ttd = strtolower(pathinfo($nama_ttd, PATHINFO_EXTENSION));
													$imageFileType_stempel = strtolower(pathinfo($nama_stempel, PATHINFO_EXTENSION));


													$check_ttd = getimagesize($sumber_ttd);
													$check_stempel = getimagesize($sumber_stempel);
													if ($check_ttd == FALSE) {
														$errors[] = "Type File Harus Gambar.";
														$uploadOk = 0;
													}
													if ($check_stempel == FALSE) {
														$errors[] = "Type File Harus Gambar.";
														$uploadOk = 0;
													}

													if (file_exists($nama_ttd)) {
														$errors[] = "File Sudah Ada.";
														$uploadOk = 0;
													}
													if (file_exists($nama_stempel)) {
														$errors[] = "File Sudah Ada.";
														$uploadOk = 0;
													}

													if ($_FILES['tanda_tangan']['size'] > 1000000) {
														$errors[] = "Ukuran File Maksimal 1Mb.";
														$uploadOk = 0;
													}
													if ($_FILES['stempel']['size'] > 1000000) {
														$errors[] = "Ukuran File Maksimal 1Mb.";
														$uploadOk = 0;
													}

													if($imageFileType_ttd != "png")
													{
														$errors[] = "Etensi File Harus PNG.";
														$uploadOk = 0;
													}
													if($imageFileType_stempel != "png")
													{
														$errors[] = "Etensi File Harus PNG.";
														$uploadOk = 0;
													}

													if (!empty($errors)) {
														echo display_errors($errors);
													}else{
														$insert = $mysqli->query("UPDATE tb_template SET tanda_tangan = '$nama_ttd', stempel = '$nama_stempel' ");
														if ($insert) {
															move_uploaded_file($sumber_ttd, '../images/design_ktm/'.$nama_ttd);
															move_uploaded_file($sumber_stempel, '../images/design_ktm/'.$nama_stempel);
															
															// resize ttd
															$ttd_img 		= '../images/design_ktm/'.$nama_ttd;
															$new_ttd_img 	= '../images/design_ktm/ttd/'.$nama_ttd;
															$width 			= 200;
															$heigth 		= 100;
															resize_png($width, $heigth, $new_ttd_img, $ttd_img);

															// resize ttd
															$stempel_img 		= '../images/design_ktm/'.$nama_stempel;
															$new_stempel_img 	= '../images/design_ktm/stempel/'.$nama_stempel;
															$width 				= 115;
															$heigth 			= 115;
															resize_png($width, $heigth, $new_stempel_img, $stempel_img);

															$text = "Tanda Tangan dan Stempel berhasil disimpan.";
															echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '');

														}
													}

												}
												?>

												<form enctype="multipart/form-data" method="POST" action="">
													<div class="tile-body row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="control-label tile-title" for="tanda_tangan">Tanda Tangan</label>
																<input type="file" id="tanda_tangan" name="tanda_tangan" class="dropify-ttd" class="form-control" required>
																<small class="form-text text-muted" id="emailHelp">File harus gambar extensi *png</small>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="control-label tile-title" for="stempel">Stempel</label>
																<input type="file" id="stempel" name="stempel" class="dropify-stempel" class="form-control" required>

																<small class="form-text text-muted" id="emailHelp">File harus gambar extensi *png</small>
															</div>
														</div>
													</div>
													<div class="tile-footer">
														<button class="btn btn-primary btn-block" type="submit" name="submit_ttds"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
													</div>
												</form>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade active show" id="kepsek2">
								<div class="row">
									<div class="col-md-6 col-xs-12 text-center">
										<div class="tile">

											<?php 

											if (isset($_POST['ubah_kepsek'])) {
												$nama_kepsek = sanitize($_POST['nama_kepsek2']);
												$insert = $mysqli->query("UPDATE tb_template SET nama_kepsek = '$nama_kepsek' ");
												if ($insert) {
													$text = "Nama Kepala Sekolah berhasil disimpan.";
													echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '');
												}
											}

											?>

											<form method="POST" action="">
												<div class="tile-body">
													<div class="form-group">
														<label for="nama_kepsek2" class="control-label tile-title">Ubah Nama Kepala Sekolah</label>
														<input type="text" name="nama_kepsek2" id="nama_kepsek2" class="form-control" required autofocus autocomplete="false" value="<?= $data['nama_kepsek'] ?>" placeholder="Ibnu Sodik, S.Kom.">
													</div>
												</div>
												<div class="tile-footer">
													<button type="submit" name="ubah_kepsek" class="btn-block btn btn-primary">Simpan <i class="fa fa-send"></i></button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>

						<?php if(empty($data['nama_kepsek'])): ?>
							<div class="tab-pane fade active show" id="kepsek">
								<div class="row">
									<div class="col-md-6 col-xs-12">

										<?php 

										if (isset($_POST['submit_kepsek'])) {
											$nama_kepsek = sanitize($_POST['nama_kepsek']);
											$insert = $mysqli->query("INSERT INTO tb_template SET nama_kepsek = '$nama_kepsek' ");
											if ($insert) {
												$text = "Nama Kepala Sekolah berhasil disimpan.";
												echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '');
											}
										}

										?>

										<form method="POST" action="">
											<div class="tile-body">
												<div class="form-group">
													<label for="nama_kepsek" class="control-label tile-title">Nama Kepala Sekolah</label>
													<input type="text" name="nama_kepsek" id="nama_kepsek" class="form-control" required autofocus autocomplete="false" placeholder="Ibnu Sodik, S.Kom.">
												</div>
											</div>
											<div class="tile-footer">
												<button type="submit" name="submit_kepsek" class="btn-block btn btn-primary">Simpan <i class="fa fa-send"></i></button>
											</div>
										</form>
									</div>
								</div>
							</div>
						<?php endif; ?>

					</div>

				</div>


			</div>
		<!-- </div>
	</div> -->

<script type="text/javascript">
	$('.dropify-stempel').dropify({
		maxWidth 				: '120',
		maxHeight 				: '120',
		errorsPosition 			: 'outside',
		allowedFileExtensions 	: 'png',
		messages: {
			default: 'Stempel kartu',
			replace: 'Ganti',
			remove:  'Hapus',
			error:   'Yuhuuu, ada yang salah nih.'
		},
		error: {
			'maxWidth': 'Lebar gambar melebihi {{ value }}px.',
			'maxHeight': 'Tinggi gambar melebihi {{ value }}px.',
			'allowedFileExtensions': 'Format gambar yang diizinkan adalah hanya ({{ value }}.'
		}
	});
	$('.dropify-ttd').dropify({
		maxWidth 				: '500',
		maxHeight 				: '200',
		errorsPosition 			: 'outside',
		allowedFileExtensions 	: 'png',
		messages: {
			default: 'Tanda tangan kepala sekolah',
			replace: 'Ganti',
			remove:  'Hapus',
			error:   'Yuhuuu, ada yang salah nih.'
		},
		error: {
			'maxWidth': 'Lebar gambar melebihi {{ value }}px.',
			'maxHeight': 'Tinggi gambar melebihi {{ value }}px.',
			'allowedFileExtensions': 'Format gambar yang diizinkan adalah hanya {{ value }}.'
		}
	});
</script>