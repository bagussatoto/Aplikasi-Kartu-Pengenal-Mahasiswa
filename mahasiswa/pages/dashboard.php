
<div class="row">
	<div class="col-md-6 col-sm-12">
		<div class="tile">
			<h3 class="tile-title"><?= $mahasiswa['nama_mahasiswa']; ?></h3>
			<div class="tile-body">
				<div class="table-responsive">
					<table class="table table-hover">
						<tr>
							<th>NIM</th>
							<td>:</td>
							<td><?= $mahasiswa['nim_mahasiswa'] ?></td>
						</tr>
						<tr>
							<th>Jurusan</th>
							<td>:</td>
							<td><?= $mahasiswa['nama_jurusan'] ?></td>
						</tr>
						<tr>
							<th>Tahun Masuk</th>
							<td>:</td>
							<td><?= $mahasiswa['angkatan_mahasiswa'] ?></td>
						</tr>
						<tr>
							<th>Tempat, Tanggal Lahir</th>
							<td>:</td>
							<td><?= $mahasiswa['tempat_lahir'].', '.(($mahasiswa['tgl_lahir'] == "0000-00-00") ? " -" : tgl_indonesia($mahasiswa['tgl_lahir'])) ?></td>
						</tr>
						<tr>
							<th>Alamat</th>
							<td>:</td>
							<td class="text-justify"><?= nl2br($mahasiswa['alamat']) ?></td>
						</tr>
					</table>
				</div>
				<!-- <?php 
				$file_exist = file_exists(base_url('images/ktm_finish/'.$ktm['tahun_ktm'].'/'.$front_file));
				if(empty($file_exist) && empty($front_file)):
					?>
				<div class="alert alert-info">
					<h4 class="text-center">Kartu Mahasiswa anda dalam proses pembuatan.</h4>	
				</div>
			<?php else: ?>
				<img src="<?= base_url('images/ktm_finish/'.$ktm['tahun_ktm'].'/'.$front_file); ?>" class="img-responsive img-thumbnail" alt="<?= $front_file; ?>">
				<?php endif; ?> -->
			</div>
			<div class="tile-footer">
				<button type="button" onclick="window.location='?page=profil'" class="btn btn-block btn-primary">Lihat Kartu <i class="fa fa-arrow-right fa-fw"></i></button>
			</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-12 text-center">
		<div class="tile">
			<h3 class="tile-title">Pas Foto</h3>
			<div class="tile-body">
				<img src="<?= base_url('images/mahasiswa/'.$mahasiswa['foto_mahasiswa']); ?>" class="img-responsive img-thumbnail" alt="<?= $mahasiswa['foto_mahasiswa'] ?>">
			</div>
			<div class="tile-footer">
				<button type="button" onclick="javascript:window.location.href='<?=base_url('mahasiswa/pages/download-foto.php?file='.$mahasiswa['foto_mahasiswa']);?>';" class="btn btn-block btn-primary">Download <i class="fa fa-fw fa-download"></i></button>
			</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-12 text-center">
		<div class="tile">
			<h3 class="tile-title">QR Code</h3>
			<div class="tile-body">
				<img src="<?= base_url('images/mahasiswa/qr_code/'.$mahasiswa['qr_code']); ?>" class="img-responsive img-thumbnail" alt="<?= $mahasiswa['qr_code'] ?>">
			</div>
			<div class="tile-footer">
				<button type="button" onclick="javascript:window.location.href='<?=base_url('admin/pages/mahasiswa/download.php?file='.$mahasiswa['qr_code']);?>';" class="btn btn-block btn-primary">Download <i class="fa fa-fw fa-download"></i></button>
			</div>
		</div>
	</div>
</div>

<div id="img" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
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