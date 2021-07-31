<?php 
@$page = $_GET['page'];
?>
<ul class="app-menu">
	<li><a class="app-menu__item <?php if($page=='' || $page=='dashboard')echo "active"; ?>" href="?page=dashboard"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
	
	<li><a class="app-menu__item <?php if($page=='mahasiswa' || $page=='add-mahasiswa' || $page=='edit_mahasiswa')echo "active"; ?>" href="?page=mahasiswa"><i class="app-menu__icon fa fa-graduation-cap"></i><span class="app-menu__label">Data Mahasiswa</span></a></li>
	
		<li><a href="?page=jurusan" class="app-menu__item <?php if($page=="jurusan")echo "active"; ?>"><i class="app-menu__icon fa fa-tag"></i><span class="app-menu__label">Data Jurusan</span></a></li>
	<li><a class="app-menu__item <?php if($page=='ktm' || $page=='buat-kartu')echo "active"; ?>" href="?page=ktm"><i class="app-menu__icon fa fa-id-card"></i><span class="app-menu__label">Kartu Mahasiswa</span></a></li>

	<?php if ($_SESSION['level'] == 1): ?>		
		<li><a class="app-menu__item <?php if($page=="users" || $page=="edit_user" || $page=="add_user" || $page=="delete_user")echo "active"; ?>" href="?page=users"><i class="app-menu__icon fa fa-user-secret"></i><span class="app-menu__label">Users</span></a></li>

		<li><a class="app-menu__item <?php if($page=="template" || $page=="add_template" || $page=="delete_template")echo "active"; ?>" href="?page=template"><i class="app-menu__icon fa fa-image"></i><span class="app-menu__label">Template Kartu</span></a></li>


		<li class="treeview <?php if($page=="pengaturan" || $page=="fungsi") echo "is-expanded"; ?>"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-wrench"></i><span class="app-menu__label">Pengaturan</span><i class="treeview-indicator fa fa-angle-right"></i></a>
			<ul class="treeview-menu">
				<li><a class="treeview-item <?php if($page=="pengaturan")echo "active"; ?>" href="?page=pengaturan"><i class="icon fa fa-circle-o"></i> Website</a></li>
				<li><a class="treeview-item <?php if($page=="fungsi")echo "active"; ?>" href="?page=fungsi"><i class="icon fa fa-circle-o"></i> Data Fungsi</a></li>
			</ul>
		</li>
	<?php endif ?>
	
</ul>