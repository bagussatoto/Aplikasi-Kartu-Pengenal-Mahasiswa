$(document).ready(function() {

	$('.dropify').dropify({
		messages: {
			default: 'Drag atau drop untuk memilih gambar',
			replace: 'Ganti',
			remove:  'Hapus',
			error:   'error'
		}
	});
	
	$('.tombol-hapus').on('click', function(e) {
    e.preventDefault();
    const href = $(this).attr('href');
    swal({
     title: "Apakah Anda Yakin?",
     text: "Data Ini Akan Saya Hapus!",
     icon: "warning",
     buttons: true,
     dangerMode: true
   }).then((willDelete) => {
    if (willDelete) {
      document.location.href = href;
    }
  });
 });

  $('#tabelKu').DataTable();
  // $('#pilihDua').select2();

  $('#summernote').summernote({
    lang: 'id-ID',
    height : 250,
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

  $('.pilih2').select2();

});