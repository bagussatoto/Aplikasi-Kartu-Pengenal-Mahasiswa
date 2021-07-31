
<div class="app-title">
	<div>
		<h1><i class="fa fa-dashboard"></i> Dashboard</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
	</ul>
</div>
<div class="row">
	<?php if ($_SESSION['level'] == 1): ?>		
    <div class="col-md-6 col-lg-4">
		<a href="?page=users" style="text-decoration: none;">
			<div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
				<div class="info">
					<h4>Users</h4>
					<?php 
					$sql_user = $mysqli->query("SELECT * FROM tb_user");
					$jumlah_user = mysqli_num_rows($sql_user);
					?>
					<p><b><?= $jumlah_user; ?></b></p>
				</div>
			</div>
		</a>
	</div>
	<?php endif; ?>
	<div class="col-md-6 col-lg-4">
		<a href="?page=ktm" style="text-decoration: none;">
			<div class="widget-small info coloured-icon"><i class="icon fa fa-id-card fa-3x"></i>
				<div class="info">
					<h4>Kartu Mahasiswa</h4>
					<?php 
					$sql_ktm = $mysqli->query("SELECT * FROM tb_ktm");
					$jumlah_ktm = mysqli_num_rows($sql_ktm);
					?>
					<p><b><?= $jumlah_ktm; ?></b></p>
				</div>
			</div>
		</a>
	</div>
	<div class="col-md-6 col-lg-4">
		<a href="?page=mahasiswa" style="text-decoration: none;">
			<div class="widget-small warning coloured-icon"><i class="icon fa fa-graduation-cap fa-3x"></i>
				<div class="info">
					<h4>Mahasiswa</h4>
					<?php 
					$sql_mahasiswa = $mysqli->query("SELECT * FROM tb_mahasiswa");
					$jumlah_mahasiswa = mysqli_num_rows($sql_mahasiswa);
					?>
					<p><b><?= $jumlah_mahasiswa; ?></b></p>
				</div>
			</div>
		</a>
	</div>
</div>
<div class="row">
	<!-- <div class="col-md-6">
		<div class="tile">
			<h3 class="tile-title">Mahasiswa Sesuai Prodi</h3>
			<div class="embed-responsive embed-responsive-16by9">
				<canvas class="embed-responsive-item" id="lineChartTahun"></canvas>
			</div>
		</div>
	</div> -->
	<div class="col-md-6">
		<div class="tile">
			<h3 class="tile-title">Jumlah Mahasiswa Sesuai Tahun Angkatan</h3>
			<div class="embed-responsive embed-responsive-16by9">
				<canvas class="embed-responsive-item" id="pieChartProdi"></canvas>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	// sesuai prodi
	
	var pdataProdi = [
	<?php 
	$sqlProdi = $mysqli->query("SELECT tb_mahasiswa.*, count(*) as jumlah FROM tb_mahasiswa group by angkatan_mahasiswa");
	while($data=mysqli_fetch_assoc($sqlProdi)):
		?>
		{
			value: <?= $data['jumlah']; ?>,
			color: "<?= rand_warna(); ?>",
			highlight: "<?= rand_warna(); ?>",
			label: "<?= $data['angkatan_mahasiswa']; ?>"
		},
	<?php endwhile; ?>
	]

	var ctxp = $("#pieChartProdi").get(0).getContext("2d");
	var pieChart = new Chart(ctxp).Pie(pdataProdi);
</script>