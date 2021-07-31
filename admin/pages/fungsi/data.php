<div class="app-title">
	<div>
		<h1>
			<a href="<?= $_SERVER['HTTP_REFERER']; ?>" class="btn btn-default"><i class="fa fa-chevron-left"></i></a>&nbsp;
			<i class="fa fa-tag"></i> Data Fungsi
		</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
		<!-- <li class="breadcrumb-item"><a href="?page=pengaturan">Mahasiswa</a></li> -->
		<li class="breadcrumb-item"><a href="javascript:void(0)">Data Fungsi</a></li>
	</ul>
</div>
<a href="javascript:void(0)" data-toggle="modal" data-target="#addModal" class="btn btn-primary tombol-layang tombol-modal" aria-hidden="true"><i class="fa fa-fw fa-plus"></i></a>	
<div class="row">
	<div class="col-md-12">
		<?php 
		$nama_fungsi = ((isset($_POST['nama_fungsi']))?sanitize($_POST['nama_fungsi']): '');
		$nama_fungsi = trim($nama_fungsi);
		$ikon_fungsi = ((isset($_POST['ikon_fungsi']))?sanitize($_POST['ikon_fungsi']): '');
		$ikon_fungsi = trim($ikon_fungsi);
		$deskripsi_fungsi = ((isset($_POST['deskripsi_fungsi']))?sanitize($_POST['deskripsi_fungsi']): '');
		$deskripsi_fungsi = trim($deskripsi_fungsi);

		$errors = array();
		if (isset($_POST['submit_add'])) {
			$nama_fungsi = sanitize($_POST['nama_fungsi']);
			$ikon_fungsi = sanitize($_POST['ikon_fungsi']);
			$deskripsi_fungsi = $_POST['deskripsi_fungsi'];

			if (empty($nama_fungsi)) {
				$errors[] = "Nama Fungsi harus diisi.";
			}

			if (!empty($errors)) {
				echo display_errors($errors);
			}else{
				$insert = $mysqli->query("INSERT INTO tb_fungsi SET
					nama_fungsi = '$nama_fungsi',
					ikon_fungsi = '$ikon_fungsi',
					deskripsi_fungsi = '$deskripsi_fungsi'
					");
				if ($insert) {
					$text = "Funsgi baru berhasil disimpan.";
					echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '');
				}
			}

		}
		if (isset($_POST['submit_edit'])) {
			$id_fungsi 			= sanitize($_POST['id_fungsi']);
			$nama_fungsi2 		= sanitize($_POST['nama_fungsi2']);
			$ikon_fungsi2 		= sanitize($_POST['ikon_fungsi2']);
			$deskripsi_fungsi2 	= $_POST['deskripsi_fungsi2'];

			if (empty($nama_fungsi2)) {
				$errors[] = "Nama Fungsi harus diisi.";
			}

			if (!empty($errors)) {
				echo display_errors($errors);
			}else{
				$insert = $mysqli->query("UPDATE tb_fungsi SET
					nama_fungsi = '$nama_fungsi2',
					ikon_fungsi = '$ikon_fungsi2',
					deskripsi_fungsi = '$deskripsi_fungsi2' WHERE id_fungsi = '$id_fungsi'
					");
				if ($insert) {
					$text = "Funsgi baru berhasil diperbarui.";
					echo sweetalert('Berhasil.!', $text, 'success', '3000', 'false', '');
				}
			}

		}
		?>
		<div class="tile row">

			<?php 
			$sql_fu = $mysqli->query("SELECT * FROM tb_fungsi ORDER BY nama_fungsi ASC");
			while($data = $sql_fu->fetch_array()):
				?>
				<div class="col-md-4">
					<div class="tile">
						<button class="pull-right btn"><i style="font-size: 2em;" class="fa fa-<?= $data['ikon_fungsi'] ?>"></i></button>
						<h3 class="tile-title"><?= $data['nama_fungsi'] ?></h3>
						<div class="tile-body">
							<p><?= batasi_kata($data['deskripsi_fungsi'], 20) ?></p>
						</div>
						<div class="tile-footer">
							<a title="Edit" class="btn btn-warning edit-fungsi" href="javascript:void(0)" 
							data-id="<?= $data['id_fungsi'] ?>" 
							data-nama="<?= $data['nama_fungsi'] ?>" 
							data-ikon="<?= $data['ikon_fungsi'] ?>" 
							data-deskripsi="<?= $data['deskripsi_fungsi'] ?>"><i class="fa fa-pencil"></i></a>

							<a title="Hapus" class="btn btn-danger tombol-hapus" href="?page=del-fungsi&id=<?= $data['id_fungsi'] ?>"><i class="fa fa-times"></i></a>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
	</div>
</div>

<!-- addModal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addModalLabel">Tambah Data Fugsi</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action="">
				<div class="modal-body">
					<div class="form-group row">
						<label class="control-label col-md-3" for="nama_fungsi">Nama Fungsi</label>
						<div class="col">
							<input type="text" id="nama_fungsi" autofocus name="nama_fungsi" class="form-control" value="<?= $nama_fungsi; ?>" placeholder="Nama Fungsi">
						</div>	
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="ikon_fungsi">Ikon Fungsi</label>
						<div class="col input-group">
							<div class="input-group-prepend"><span class="input-group-text">fa fa-</span></div>
							<input type="text" id="ikon_fungsi" autofocus name="ikon_fungsi" class="form-control" value="<?= $ikon_fungsi; ?>" placeholder="Ikon Fungsi">
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="deskripsi_fungsi">Deskripsi Fungsi</label>
						<div class="col">
							<textarea id="summernote" name="deskripsi_fungsi"><?= $deskripsi_fungsi ?></textarea>
						</div>	
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup <i class="fa fa-times"></i></button>
					<button type="submit" name="submit_add" class="btn btn-primary">Simpan <i class="fa fa-sent"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- editModal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editModalLabel">Edit Data Fugsi</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action="" id="form-edit">
				<div class="modal-body">
					<div class="form-group row">
						<label class="control-label col-md-3" for="nama_fungsi2">Nama Fungsi</label>
						<div class="col">
							<input type="text" id="nama_fungsi" autofocus name="nama_fungsi2" class="form-control" placeholder="Nama Fungsi">
						</div>	
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="ikon_fungsi2">Ikon Fungsi</label>
						<div class="col input-group">
							<div class="input-group-prepend"><span class="input-group-text">fa fa-</span></div>
							<input type="text" id="ikon_fungsi" autofocus name="ikon_fungsi2" class="form-control" placeholder="Ikon Fungsi">
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-3" for="deskripsi_fungsi2">Deskripsi Fungsi</label>
						<div class="col">
							<textarea name="deskripsi_fungsi2" id="summernote2"></textarea>
						</div>	
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="id_fungsi">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup <i class="fa fa-times"></i></button>
					<button type="submit" name="submit_edit" class="btn btn-primary">Simpan <i class="fa fa-sent"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">

		// fungsi script
		$('.edit-fungsi').on('click', function() {
			var id = $(this).data('id');
			var name = $(this).data('nama');
			var ikon = $(this).data('ikon');
			var desc = $(this).data('deskripsi');

			$('[name="id_fungsi"]').val(id);
			$('[name="nama_fungsi2"]').val(name);
			$('[name="ikon_fungsi2"]').val(ikon);
			$('#summernote2').summernote('code', desc);
			$('#editModal').modal('show');
		});
		$(document).ready(function(){
			$('#summernote2').summernote({
				lang: 'id-ID',
				height : 300,
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

		})
	</script>