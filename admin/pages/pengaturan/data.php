<div class="app-title">
	<div>
		<h1>
			<a href="<?= $_SERVER['HTTP_REFERER']; ?>" class="btn btn-default"><i class="fa fa-chevron-left"></i></a>&nbsp;
			<i class="fa fa-wrench"></i> Pengaturan Website
		</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
		<!-- <li class="breadcrumb-item"><a href="?page=pengaturan">Mahasiswa</a></li> -->
		<li class="breadcrumb-item"><a href="javascript:void(0)">Pengaturan Website</a></li>
	</ul>
</div>

<!-- <div class="row"> -->
	<div class="tile">
		<div class="bs-component">
			<ul class="nav nav-tabs">
				<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#basic">Basic</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#peta">Peta</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sosmed">Sosmed</a></li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade active show" id="basic">
					<div class="row">
						<div class="col-md-12 col-xs-12 text-center">

							<?php
							$file = file_exists(base_url('images/mahasiswa/'.$data_web['logo_website'])); 
							if (!empty($data_web['logo_website']) && !$file):
								?>
								<h3 class="tile-title">Logo Website</h3>
								<?php 
								if (isset($_POST['hapus_foto'])) {
					// $update_id = sanitize($_POST['id']);
									$foto_awal = $mysqli->query("SELECT * FROM tb_pengaturan")->fetch_object()->logo_website;
					// unlink('../images/thumbs/mahasiswa/'.$foto_awal);
									unlink('../assets/images/'.$foto_awal);
									$update = $mysqli->query("UPDATE tb_pengaturan SET logo_website = ''");
									if ($update) {
										$text = "Logo Berhasil Dihapus.";
										echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '');
									}
								}
								?>
								<form action="" method="POSt">
									<div class="tile-body">
										<input type="hidden" name="id" value="<?= $data_web['id_website'] ?>">
										<img class="img-responsive img-thumbnail" src="<?= base_url('assets/images/'.$data_web['logo_website']); ?>">
									</div>
									<div class="tile-footer">
										<button type="submit" name="hapus_foto" class="btn btn-block btn-danger">Hapus <i class="fa fa-fw fa-trash"></i></button>
									</div>
									</form><?php else: ?>
									<h3 class="tile-title">Add Logo Website</h3>
									<?php 
									$errors = array();
									if (isset($_POST['submit_foto'])) {
										error_reporting(0);
						// upload foto
										$extensi = explode('.', $_FILES['foto']['name']);
										$nama_foto = time().'.'.end($extensi);
										$sumber = $_FILES['foto']['tmp_name'];
										$uploadOk = 1;
										$imageFileType = strtolower(pathinfo($nama_foto, PATHINFO_EXTENSION));


										if (empty($sumber)) {
											$errors[] = "Logo tidak boleh kosong.";
										}
										$sql_cw = $mysqli->query("SELECT * FROM tb_pengaturan");
										if (mysqli_num_rows($sql_cw) == 0) {
											$errors[] = "Data Website tidak ditemukan.";
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

											$update = $mysqli->query("UPDATE tb_pengaturan SET logo_website = '$nama_foto' ");
											if ($update) {
												move_uploaded_file($sumber, '../assets/images/'.$nama_foto);

												$text = "Logo $data_web[nama_website] berhasil diupdate.";
												echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '');
											}
										}
									}
								}
								?>
								<form enctype="multipart/form-data" action="" method="POST">
									<div class="tile-body">
										<input type="file" name="foto" class="dropify-logo" class="form-control" required>
									</div>
									<div class="tile-footer">
										<button class="btn btn-primary btn-block" type="submit" name="submit_foto"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
									</div>
								</form>
							<?php endif ?>
						</div>
						<!-- sini -->
						<div class="col-md-6 col-xs-12 ">
							<div class="tile">
								<?php 
								$sql_cw = $mysqli->query("SELECT * FROM tb_pengaturan");
								$data = $sql_cw->fetch_array();

								$nama_website = ((isset($_POST['nama_website']))?sanitize($_POST['nama_website']):$data['nama_website']);
								$nama_website = trim($nama_website);

								$email_website = ((isset($_POST['email_website']))?sanitize($_POST['email_website']):$data['email_website']);
								$email_website = trim($email_website);

								$judul_website = ((isset($_POST['judul_website']))?sanitize($_POST['judul_website']):$data['judul_website']);
								$judul_website = trim($judul_website);

								$tahun_buat = ((isset($_POST['tahun_buat']))?sanitize($_POST['tahun_buat']):$data['tahun_buat']);
								$tahun_buat = trim($tahun_buat);

								$deskripsi_website = ((isset($_POST['deskripsi_website']))?sanitize($_POST['deskripsi_website']):$data['deskripsi_website']);
								$deskripsi_website = trim($deskripsi_website);

								$konten_homepage = ((isset($_POST['konten_homepage']))?sanitize($_POST['konten_homepage']):$data['konten_homepage']);
								$konten_homepage = trim($konten_homepage);

								$peta_lokasi = ((isset($_POST['peta_lokasi']))?sanitize($_POST['peta_lokasi']):$data['peta_lokasi']);
								$peta_lokasi = trim($peta_lokasi);


								if(mysqli_num_rows($sql_cw) == 0): 
									?>
									<h3 class="tile-title">Tambah Data Website</h3>
									<?php 
									$errors = array();
									if (isset($_POST['tambah_data'])) {
										$judul_website 	= sanitize($_POST['judul_website']);
										$nama_website 	= sanitize($_POST['nama_website']);
										$email_website 	= sanitize($_POST['email_website']);

										if (empty($judul_website)) {
											$errors[] = "Judul Website harus diisi.";
										}
										if (empty($nama_website)) {
											$errors[] = "Nama Website harus diisi.";
										}

										if (!empty($errors)) {
											echo display_errors($errors);
										}else{
											$update = $mysqli->query("INSERT INTO tb_pengaturan SET 
												nama_website 	= '$nama_website',
												judul_website 	= '$judul_website',
												email_website 	= '$email_website'
												");
											if ($update) {
												$text = "$nama_website berhasil disimpan.";
												echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '');
											}
										}
									}
									?>
									<form method="POST" action="">
										<div class="tile-body">						
											<div class="form-group row">
												<label class="control-label col-md-3" for="judul_website">Judul Website</label>
												<div class="col">
													<input type="text" id="judul_website" autofocus name="judul_website" class="form-control" value="<?= $judul_website; ?>" placeholder="Judul Website">
												</div>	
											</div>
											<div class="form-group row">
												<label class="control-label col-md-3" for="nama_website">Nama Website</label>
												<div class="col">
													<input type="text" id="nama_website" autofocus name="nama_website" class="form-control" value="<?= $nama_website; ?>" placeholder="Nama Website">
												</div>	
											</div>
											<div class="form-group row">
												<label class="control-label col-md-3" for="email_website">Email Website</label>
												<div class="col">
													<input type="email" id="email_website" autofocus name="email_website" class="form-control" value="<?= $email_website; ?>" placeholder="Email Website">
												</div>	
											</div>
										</div>
										<div class="tile-footer">
											<button class="btn btn-primary btn-block" type="submit" name="tambah_data"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
										</div>
										</form><?php else: ?>

										<h3 class="tile-title">Edit Data Website</h3>
										<?php 
										$errors = array();
										if (isset($_POST['update_data'])) {
											$judul_website 	= sanitize($_POST['judul_website']);
											$nama_website 	= sanitize($_POST['nama_website']);
											$email_website 	= sanitize($_POST['email_website']);
											$tahun_buat 	= sanitize($_POST['tahun_buat']);
											$deskripsi_website 	= $_POST['deskripsi_website'];

											if (empty($judul_website)) {
												$errors[] = "Judul Website harus diisi.";
											}
											if (empty($nama_website)) {
												$errors[] = "Nama Website harus diisi.";
											}

											if (!empty($errors)) {
												echo display_errors($errors);
											}else{
												$update = $mysqli->query("UPDATE tb_pengaturan SET 
													nama_website 	= '$nama_website',
													judul_website 	= '$judul_website',
													email_website 	= '$email_website',
													tahun_buat 		= '$tahun_buat',
													deskripsi_website 	= '$deskripsi_website'
													");
												if ($update) {
													$text = "Website $nama_website berhasil diperbarui.";
													echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '');
												}
											}
										}
										?>
										<form method="POST" action="">
											<div class="tile-body">						
												<div class="form-group row">
													<label class="control-label col-md-3" for="judul_website">Judul Website</label>
													<div class="col">
														<input type="text" id="judul_website" autofocus name="judul_website" class="form-control" value="<?= $judul_website; ?>" placeholder="Judul Website">
													</div>	
												</div>
												<div class="form-group row">
													<label class="control-label col-md-3" for="nama_website">Nama Website</label>
													<div class="col">
														<input type="text" id="nama_website" autofocus name="nama_website" class="form-control" value="<?= $nama_website; ?>" placeholder="Nama Website">
													</div>	
												</div>
												<div class="form-group row">
													<label class="control-label col-md-3" for="email_website">Email Website</label>
													<div class="col">
														<input type="email" id="email_website" autofocus name="email_website" class="form-control" value="<?= $email_website; ?>" placeholder="Email Website">
													</div>	
												</div>
												<div class="form-group row">
													<label class="control-label col-md-3" for="tahun_buat">Tahun Buat</label>
													<div class="col">
														<select name="tahun_buat" id="tahun_buat" class="form-control">
															<option value="">--- Pilih Tahun ---</option>
															<?php 
															for ($year=date('Y'); $year >= 2010 ; $year--) { 
																if ($year==$tahun_buat) {
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
												<div class="form-group row">
													<label class="control-label col-md-3" for="deskripsi_website">Deskripsi Website</label>
													<div class="col">
														<textarea placeholder="Deskripsi Website" name="deskripsi_website" class="form-control" rows="6" ><?= $deskripsi_website ?></textarea>
													</div>
												</div>
											</div>
											<div class="tile-footer">
												<button class="btn btn-primary btn-block" type="submit" name="update_data"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
											</div>
										</form>
									<?php endif; ?>
								</div>
							</div>

							<?php if ($sql_web->num_rows > 0): ?>			
								<div class="col-md-6 col-xs-12">
									<div class="tile">
										<h3 class="tile-title">Konten Homepage</h3>

										<?php 
										$errors = array();
										if (isset($_POST['submit_konten'])) {
											$konten_homepage 	= $_POST['konten_homepage'];

											if (empty($konten_homepage)) {
												$errors[] = "Judul Website harus diisi.";
											}

											if (!empty($errors)) {
												echo display_errors($errors);
											}else{
												$update = $mysqli->query("UPDATE tb_pengaturan SET 
													konten_homepage 	= '$konten_homepage'
													");
												if ($update) {
													$text = "Konten Homepage Website $nama_website berhasil diperbarui.";
													echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '');
												}
											}
										}
										?>
										<form method="POST" action="">
											<div class="tile-body">
												<div class="form-group row">
													<!-- <label class="control-label col-md-3" for="konten_homepage">Konten Homepage</label> -->
													<div class="col">
														<textarea placeholder="Konten Homepage" name="konten_homepage" id="konten_homepage"><?= $konten_homepage ?></textarea>
													</div>
												</div>
											</div>
											<div class="tile-footer">
												<button class="btn btn-primary btn-block" type="submit" name="submit_konten"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
											</div>
										</form>					
									</div>
								</div>
							<?php endif ?>

						</div>
					</div>

					<div class="tab-pane fade" id="peta">
						<?php if ($sql_web->num_rows > 0): ?>			
							<div class="row">
								<div class="col-md-12 col-xs-12">
									<div class="tile">
										<button data-toggle="modal" data-target="#petunjukModal" class="pull-right btn btn-info"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>
										<h3 class="tile-title">Peta Lokasi</h3>
										<?php 
										$errors = array();
										if (isset($_POST['submit_peta'])) {
											$peta_lokasi 	= $_POST['peta_lokasi'];

											if (empty($peta_lokasi)) {
												$errors[] = "Judul Website harus diisi.";
											}

											if (!empty($errors)) {
												echo display_errors($errors);
											}else{
												$update = $mysqli->query("UPDATE tb_pengaturan SET 
													peta_lokasi 	= '$peta_lokasi'
													");
												if ($update) {
													$text = "Peta Lokasi Website $nama_website berhasil diperbarui.";
													echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '');
												}
											}
										}
										?>
										<form method="POST" action="">
											<div class="tile-body">
												<div class="form-group row">
													<div class="col">
														<textarea placeholder="Konten Homepage" name="peta_lokasi" id="peta_lokasi"><?= $peta_lokasi ?></textarea>
													</div>
												</div>
											</div>
											<div class="tile-footer">
												<button class="btn btn-primary btn-block" type="submit" name="submit_peta"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
											</div>
										</form>					
									</div>
								</div>
							</div>
						<?php endif ?>

						<!-- Modal -->
						<div class="modal fade" id="petunjukModal" tabindex="-1" role="dialog" aria-labelledby="petunjukModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="petunjukModalLabel">Cara menambahkan peta dari google maps</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<ol type="1">
											<li>Kunjungi Google Map</li>
											<li>Tentukan lokasi anda</li>
											<li>Klik "Share" dan pilih tab "Embed map"</li>
											<li>Klik salin HTML</li>
											<li>Klik simbol code atau '</>' pada textarea dibawah ini </li>
											<li>Paste tag HTML tadi dan klik '</>' ulang</li>
											<li>Simpan</li>
										</ol>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="tab-pane fade" id="sosmed">
						<?php if ($sql_web->num_rows > 0): ?>			
							<div class="row">
								<div class="col-md-12 col-xs-12">
									<div class="tile">
										<a href="javascript:void(0)" data-toggle="modal" data-target="#addModal" class="btn btn-primary tombol-layang tombol-modal" aria-hidden="true"><i class="fa fa-fw fa-plus"></i></a>	

										<h3 class="tile-title">Sosmed Website</h3>
										<div class="row">
											<?php 

											$jenis_sosmed = ((isset($_POST['jenis_sosmed']))?sanitize($_POST['jenis_sosmed']): '');
											$jenis_sosmed = trim($jenis_sosmed);
											$link_sosmed = ((isset($_POST['link_sosmed']))?sanitize($_POST['link_sosmed']): '');
											$link_sosmed = trim($link_sosmed);
											$ikon_sosmed = ((isset($_POST['ikon_sosmed']))?sanitize($_POST['ikon_sosmed']): '');
											$ikon_sosmed = trim($ikon_sosmed);

											$errors = array();
											if (isset($_POST['submit_add'])) {
												$id_pemilik 	= sanitize($_POST['id_pemilik']);
												$jenis_sosmed 	= sanitize($_POST['jenis_sosmed']);
												$link_sosmed 	= sanitize($_POST['link_sosmed']);
												$ikon_sosmed 	= sanitize($_POST['ikon_sosmed']);

												$sql_cek = $mysqli->query("SELECT * FROM tb_sosmed WHERE id_pemilik = '$id_pemilik' AND link_sosmed = '$link_sosmed'");
												if ($sql_cek->num_rows > 0) {
													$errors[] = "Link tersebut sudah ada.";
												}
												if (empty($jenis_sosmed)) {
													$errors[] = "Jenis sosmed tidak boleh kosong.";
												}
												if (empty($link_sosmed)) {
													$errors[] = "Link sosmed tidak boleh kosong.";
												}

												if (!empty($errors)) {
													echo display_errors($errors);
												}else{
													$insert = $mysqli->query("INSERT INTO tb_sosmed SET
														id_pemilik = '$id_pemilik',
														jenis_sosmed = '$jenis_sosmed',
														link_sosmed = '$link_sosmed',
														ikon_sosmed = '$ikon_sosmed'
														");
													if ($insert) {
														$text = "Akun $jenis_sosmed berhasil disimpan.";
														echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '');
													}
												}

											}

											// script edit
											if (isset($_POST['submit_edit_sosmed'])) {
												$id_sosmed 		= sanitize($_POST['id_sosmed']);
												$id_pemilik 	= sanitize($_POST['id_pemilik2']);
												$jenis_sosmed 	= sanitize($_POST['jenis_sosmed2']);
												$link_sosmed 	= sanitize($_POST['link_sosmed2']);
												$ikon_sosmed 	= sanitize($_POST['ikon_sosmed2']);

												$sql_cek = $mysqli->query("SELECT * FROM tb_sosmed WHERE id_pemilik = '$id_pemilik' AND link_sosmed = '$link_sosmed'");
												if ($sql_cek->num_rows > 0) {
													$errors[] = "Link tersebut sudah ada.";
												}
												if (empty($jenis_sosmed)) {
													$errors[] = "Jenis sosmed tidak boleh kosong.";
												}
												if (empty($link_sosmed)) {
													$errors[] = "Link sosmed tidak boleh kosong.";
												}

												if (!empty($errors)) {
													echo display_errors($errors);
												}else{
													$insert = $mysqli->query("UPDATE tb_sosmed SET
														id_pemilik = '$id_pemilik',
														jenis_sosmed = '$jenis_sosmed',
														link_sosmed = '$link_sosmed',
														ikon_sosmed = '$ikon_sosmed' WHERE id_sosmed = '$id_sosmed' AND id_pemilik = '$id_pemilik'
														");
													if ($insert) {
														$text = "Berhasil mmengupdate akun $jenis_sosmed.";
														echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '');
													}
												}

											}

										####### SQL Ambil Sosmed ######
											$sql_sosmed = $mysqli->query("SELECT * FROM tb_sosmed WHERE id_pemilik = '$data_web[id_website]' ORDER BY jenis_sosmed ASC");
											while($dawe = $sql_sosmed->fetch_array()):
												?>
												<div class="col-md-4 col-xs-12">
													<div class="tile">
														<div class="tile-body">
															<div class="table-responsive">
																<table class="table">
																	<tr>
																		<th>Jenis Akun</th>
																		<td>:</td>
																		<td><?= $dawe['jenis_sosmed'] ?></td>
																	</tr>
																	<tr>
																		<th>Url Akun</th>
																		<td>:</td>
																		<td><?= $dawe['link_sosmed'] ?></td>
																	</tr>
																	<tr>
																		<th>Ikon</th>
																		<td>:</td>
																		<td><i class="fa fa-<?= $dawe['ikon_sosmed'] ?>"></i></td>
																	</tr>
																</table>
															</div>
														</div>
														<div class="tile-footer">
															<a href="javascript:void(0)" class="btn btn-warning btn-sm edit-akun" 
															data-id="<?= $dawe['id_sosmed'] ?>"
															data-pemilik="<?= $dawe['id_pemilik'] ?>"
															data-jenis="<?= $dawe['jenis_sosmed'] ?>"
															data-link="<?= $dawe['link_sosmed'] ?>"
															data-ikon="<?= $dawe['ikon_sosmed'] ?>"
															title="Edit"><i class="fa fa-pencil"></i></a>
															<a href="?page=hapus-sosmed&id=<?= $dawe['id_sosmed'] ?>" class="btn btn-danger btn-sm tombol-hapus" title="Hapus"><i class="fa fa-times"></i></a>
															<a href="<?= $dawe['link_sosmed'] ?>" target="_blank" class="btn btn-info btn-sm" title="Kunjungi"><i class="fa fa-eye"></i></a>
														</div>
													</div>
												</div>
											<?php endwhile; ?>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>

				</div>
			</div>
		</div>

		<!-- modalAddSosmed -->
		<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="sosmedAddModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="sosmedAddModalLabel">Tambah Akun Sosmed</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form method="POST" action="">
						<div class="modal-body">
							<div class="form-group row">
								<label class="control-label col-md-3" for="jenis_sosmed">Jenis Sosmed</label>
								<div class="col">
									<input type="text" id="jenis_sosmed" autofocus name="jenis_sosmed" class="form-control" value="<?= $jenis_sosmed; ?>" placeholder="Jenis Sosmed">
								</div>	
							</div>
							<div class="form-group row">
								<label class="control-label col-md-3" for="link_sosmed">Link Sosmed</label>
								<div class="col">
									<input type="text" id="link_sosmed" autofocus name="link_sosmed" class="form-control" value="<?= $link_sosmed; ?>" placeholder="Link Sosmed">
								</div>	
							</div>
							<div class="form-group row">
								<label class="control-label col-md-3" for="ikon_sosmed">Ikon Sosmed</label>
								<div class="col input-group">
									<div class="input-group-prepend"><span class="input-group-text">fa fa-</span></div>
									<input type="text" id="ikon_sosmed" autofocus name="ikon_sosmed" class="form-control" value="<?= $ikon_sosmed; ?>" placeholder="Ikon Sosmed">
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<input type="hidden" name="id_pemilik" value="<?= $data_web['id_website'] ?>">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup <i class="fa fa-times"></i></button>
							<button type="submit" name="submit_add" class="btn btn-primary">Simpan <i class="fa fa-sent"></i></button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- modalEditSosmed -->
		<div class="modal fade" id="editModalSosmed" tabindex="-1" role="dialog" aria-labelledby="sosmedEditModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="sosmedEditModalLabel">Edit Sosmed</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form method="POST" action="">
						<div class="modal-body">
							<div class="form-group row">
								<label class="control-label col-md-3" for="jenis_sosmed">Jenis Sosmed</label>
								<div class="col">
									<input type="text" id="jenis_sosmed" autofocus name="jenis_sosmed2" class="form-control" placeholder="Jenis Sosmed">
								</div>	
							</div>
							<div class="form-group row">
								<label class="control-label col-md-3" for="link_sosmed">Link Sosmed</label>
								<div class="col">
									<input type="text" id="link_sosmed" autofocus name="link_sosmed2" class="form-control" placeholder="Link Sosmed">
								</div>	
							</div>
							<div class="form-group row">
								<label class="control-label col-md-3" for="ikon_sosmed">Ikon Sosmed</label>
								<div class="col input-group">
									<div class="input-group-prepend"><span class="input-group-text">fa fa-</span></div>
									<input type="text" id="ikon_sosmed" autofocus name="ikon_sosmed2" class="form-control" placeholder="Ikon Sosmed">
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<input type="hidden" name="id_pemilik2" />
							<input type="hidden" name="id_sosmed" />
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup <i class="fa fa-times"></i></button>
							<button type="submit" name="submit_edit_sosmed" class="btn btn-primary">Simpan <i class="fa fa-sent"></i></button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- </div> -->

		<script type="text/javascript">
			// fungsi edit sosmed
			$('.edit-akun').on('click', function() {
				var id = $(this).data('id');
				var pemilik = $(this).data('pemilik');
				var jenis = $(this).data('jenis');
				var link = $(this).data('link');
				var ikon = $(this).data('ikon');

				$('[name="id_sosmed"]').val(id);
				$('[name="id_pemilik2"]').val(pemilik);
				$('[name="jenis_sosmed2"]').val(jenis);
				$('[name="link_sosmed2"]').val(link);
				$('[name="ikon_sosmed2"]').val(ikon);
				$('#editModalSosmed').modal('show');
			});

			$(document).ready(function() {
				$('#peta_lokasi').summernote({
					lang: 'id-ID',
					height : 410,
					onImageUpload : function(files, editor, welEditable) {
						sendFile(files[0], editor, welEditable);
					}
				});

				function sendFile(file, editor, welEditable) {
					data = new FormData();
					data.append("file", file);
					$.ajax({
						data: data,
						type: "POST",
						url: "<?= base_url('admin/upload_image.php') ?>",
						cache: false,
						contentType: false,
						processData: false,
						success: function(url){
							editor.insertImage(welEditable, url);
						}
					});
				}
			});

			$(document).ready(function() {
				$('#konten_homepage').summernote({
					lang: 'id-ID',
					height : 410,
					onImageUpload : function(files, editor, welEditable) {
						sendFile(files[0], editor, welEditable);
					}
				});

				function sendFile(file, editor, welEditable) {
					data = new FormData();
					data.append("file", file);
					$.ajax({
						data: data,
						type: "POST",
						url: "<?= base_url('admin/upload_image.php') ?>",
						cache: false,
						contentType: false,
						processData: false,
						success: function(url){
							editor.insertImage(welEditable, url);
						}
					});
				}
			});

			$('.dropify-logo').dropify({
				maxFileSize 			: '300K',
				maxWidth 				: '300',
				maxHeight 				: '300',
				errorsPosition 			: 'outside',
				allowedFileExtensions 	: 'png jpg',
				maxFileSizePreview 		: '300K',		
				messages: {
					default: 'Logo website',
					replace: 'Ganti',
					remove:  'Hapus',
					error:   'Yuhuuu, ada yang salah nih.'
				},
				error: {
					'fileSize': 'Ukuran gambar tidak boleh lebih dari ({{ value }}).',
					'maxWidth': 'Lebar gambar melebihi {{ value }}px.',
					'maxHeight': 'Tinggi gambar melebihi {{ value }}px.',
					'allowedFileExtensions': 'Format gambar yang diizinkan adalah hanya ({{ value }}.'
				}
			});
		</script>