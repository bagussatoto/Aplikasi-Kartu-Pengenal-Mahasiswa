<div class="app-title">
	<div>
		<h1><i class="fa fa-user-secret"></i> Users</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="?page=dashboard">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">Users</a></li>
	</ul>
</div>
<a href="?page=add_user" class="btn btn-primary tombol-layang tombol-modal"><i class="fa fa-fw fa-plus"></i></a>
<div class="row">
	<div class="col-md-12">

		<div class="tile">
			<div class="tile-body">
				<div class="table-responsive">
					<table class="table table-hover table-bordered" id="tabelKu">
						<thead>
							<tr>
								<th class="text-center">Name</th>
								<th class="text-center">Username</th>
								<th class="text-center">Email</th>
								<th class="text-center">Foto</th>
								<th class="text-center">Opsi</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$sql = $mysqli->query("SELECT * FROM tb_user ORDER BY full_name ASC");
							while($data = mysqli_fetch_assoc($sql)):
								$file = file_exists(base_url('images/thumbs/user/'.$data['foto']));
								?>
								<tr>
									<td><?= $data['full_name'] ?></td>
									<td class="text-center"><?= $data['username'] ?></td>
									<td class="text-center"><?= $data['email'] ?></td>
									<td class="text-center">
										<?php if(!$file && !empty($data['foto'])): ?>
											<a id="show_foto" data-toggle="modal" data-target="#img" href="javascript:void(0)" data-id="<?= $data['id_user']; ?>" data-foto="<?= $data['foto']; ?>">
												<img class="img-responsive user-img-data img-thumbnail" alt="<?= $data['foto']; ?>" src="<?= base_url('images/thumbs/user/'.$data['foto']); ?>" />
											</a>
											<?php else: ?>
												<i class="fa fa-user-secret fa-fw"></i>
											<?php endif; ?>
										</td>
										<td class="text-center">
											<a href="?page=edit_user&id=<?= $data['id_user']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>

											<a href="?page=delete_user&id=<?= $data['id_user']; ?>" class="btn btn-sm btn-danger tombol-hapus"><i class="fa fa-trash"></i></a>
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

	<script type="text/javascript">
		$(document).on("click", "#show_foto", function() {
			var id = $(this).data('id');
			var ft = $(this).data('foto');
			$("#modal-gambar #id").val(id);
			$("#modal-gambar #pict").attr("src", "../images/user/"+ft);
		});
	</script>