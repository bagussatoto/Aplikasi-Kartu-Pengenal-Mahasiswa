<?php 

function swal_error($title, $text, $type, $timer, $condition, $link)
{	
	?>
	<script type="text/javascript">
		setTimeout(function(){
			var getlink = $(this).attr('href');
			swal({
				title : "<?= $title ?>",
				text : "<?= $text ?>",
				icon : "<?= $type ?>",
				timer : "<?= $timer ?>",
				showConfirmButton : <?= $condition ?>
			});
		}, 1);
		window.setTimeout(function() {
			window.location.replace("<?= $link ?>");
		}, <?= $timer ?>);
	</script>
	<?php
	
}

function sweetalert($title, $text, $type, $timer, $condition, $link)
{
	?>
	<script type="text/javascript">
		setTimeout(function() {
			swal({
				title : "<?= $title ?>",
				text : "<?= $text ?>",
				icon : "<?= $type ?>",
				timer : "<?= $timer ?>",
				showConfirmButton : <?= $condition ?>
			});
		}, 1000);
		window.setTimeout(function() {
			window.location.replace("<?= $link ?>");
		}, <?= $timer ?>);
	</script>
	<?php
}

function swal_hapus(){
	?>
	<script type="text/javascript">
		$('.tombol-hapus').on('click', function(e) {
			e.preventDefault();
			const href = $(this).attr('href');
			swal({
				title: "Apakah Anda Yakin?",
				text: "Data Ini Akan Terhapus!",
				icon: "warning",
				buttons: true,
				dangerMode: true
			}).then((willDelete) => {
				if (willDelete) {
					document.location.href = href;
				}
			});
		});
	</script>
	<?php
}

?>