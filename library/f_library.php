<?php 
function RandomString($panjang = 29)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $panjang; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

function singkatan($string)
{
  $array = explode(" ", $string);
  $singkatan = "";
  foreach ($array as $value) {
    $singkatan .= substr($value, 0, 1);
  }
  return $singkatan;
}

function rand_warna() {
 $chars = 'ABCDEF0123456789';
 $color = '#';
 for ( $i = 0; $i < 6; $i++ ) {
  $color .= $chars[rand(0, strlen($chars) - 1)];
}
return $color;
}

function batasi_kata($kalimat_lengkap, $jumlah_kata)
{
  $arr_str = explode(' ', $kalimat_lengkap);
  $arr_str = array_slice($arr_str, 0, $jumlah_kata );
  return implode(' ', $arr_str);
}

function word_limiter($str, $limit = 10){

  if (stripos($str, " ")) {

    $ex_str = explode(" ", $str);

    if (count($ex_str) > $limit) {
      $str_s = '';
      for ($i=0; $i < $limit ; $i++) { 
        $str_s .= $ex_str[$i] . " ";
      }
      return $str_s . "&hellip;";

    }else{
      return $str;
    }
  }else{
    return $str;
  }
}

function sanitize($text){
  global $mysqli;
  $safetext = $mysqli->real_escape_string(stripslashes(strip_tags(htmlspecialchars($text,ENT_QUOTES))));
  return $safetext;
}

// function sanitize($dirty){
//  return htmlentities($dirty, ENT_QUOTES,"UTF-8");
// }

function tgl_indonesia($tanggal){
  $bulan = array (1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $split = explode('-', $tanggal);
  return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0]; 
}

function tgl_indonesia2($tgl){
  $nama_bulan = array(1=>"Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agust", "Sept", "Okt", "Nov", "Des");

  $tanggal = substr($tgl,8,2);
  $bulan = $nama_bulan[(int)substr($tgl,5,2)];
  $tahun = substr($tgl,0,4);
  
  return $tanggal.' '.$bulan.' '.$tahun;     
} 

function tanggal($date){
  return date("d M Y, h:i:s A", strtotime($date));
}

function display_errors($errors){
  $display='';
  foreach ($errors as $error) {
   $display .= '<div class="alert alert-warning alert-dismissable" role="alert">';
   $display .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
   $display .= '<p class="text-left">'.$error.'</p>';
   $display .= '</div>';
 }
 return $display;
}

function createThumbs( $pathToImages, $pathToThumbs, $thumbWidth )
{
  // open the directory
  $dir = opendir( $pathToImages );

  // loop through it, looking for any/all JPG files:
  while (false !== ($fname = readdir( $dir ))) {
    // parse path for the extension
    $info = pathinfo($pathToImages . $fname);
    // continue only if this is a JPEG image
    if ( strtolower($info['extension']) == 'png' )
    {
      // load image and get image size
      $img = imagecreatefrompng( "{$pathToImages}{$fname}" );
      $width = imagesx( $img );
      $height = imagesy( $img );

      // calculate thumbnail size
      $new_width = $thumbWidth;
      $new_height = floor( $height * ( $thumbWidth / $width ) );

      // create a new temporary image
      $tmp_img = imagecreatetruecolor( $new_width, $new_height );

      // copy and resize old image into new image
      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

      // save thumbnail into a file
      imagepng( $tmp_img, "{$pathToThumbs}{$fname}" );
    }
    elseif ( strtolower($info['extension']) == 'jpg' )
    {
      // load image and get image size
      $img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
      $width = imagesx( $img );
      $height = imagesy( $img );

      // calculate thumbnail size
      $new_width = $thumbWidth;
      $new_height = floor( $height * ( $thumbWidth / $width ) );

      // create a new temporary image
      $tmp_img = imagecreatetruecolor( $new_width, $new_height );

      // copy and resize old image into new image
      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

      // save thumbnail into a file
      imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
    }
    elseif ( strtolower($info['extension']) == 'gif' )
    {
      // load image and get image size
      $img = imagecreatefromgif( "{$pathToImages}{$fname}" );
      $width = imagesx( $img );
      $height = imagesy( $img );

      // calculate thumbnail size
      $new_width = $thumbWidth;
      $new_height = floor( $height * ( $thumbWidth / $width ) );

      // create a new temporary image
      $tmp_img = imagecreatetruecolor( $new_width, $new_height );

      // copy and resize old image into new image
      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

      // save thumbnail into a file
      imagegif( $tmp_img, "{$pathToThumbs}{$fname}" );
    }
  }
  // close the directory
  closedir( $dir );
}

// call createThumb function and pass to it as parameters the path
// to the directory that contains images, the path to the directory
// in which thumbnails will be placed and the thumbnail's width.
// We are assuming that the path will be a relative path working
// both in the filesystem, and through the web for links
// createThumbs("upload/","upload/thumbs/",100);


function resize_png($width = NULL, $height = NULL, $targetFile, $originalFile) {
  $img = imagecreatefrompng($originalFile);

  $imgWidth = imagesx($img);
  $imgHeight = imagesy($img);
  // $newWidth = intval($imgWidth / 2);
  // $newHeight = intval($imgHeight /2);
  $newWidth = $width;
  $newHeight = $height;

  $newImage = imagecreatetruecolor($newWidth, $newHeight);
  imagealphablending($newImage, false);
  imagesavealpha($newImage,true);
  $transparency = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
  imagefilledrectangle($newImage, 0, 0, $newHeight, $newHeight, $transparency);
  imagecopyresampled($newImage, $img, 0, 0, 0, 0, $newWidth, $newHeight, $imgWidth, $imgHeight);
  imagepng($newImage,$targetFile);
}

function gambar_bulat($file, $direktori, $nama, $ukuran=285)
{
  $filename   = $file;
  // $fname     = readdir($filename);
  $image_s  = imagecreatefromstring(file_get_contents($filename));
  $width    = imagesx($image_s);
  $height   = imagesy($image_s);

  $new_width  = $ukuran;
  $new_height = $ukuran;

  $image = imagecreatetruecolor($new_width, $new_height);
  imagealphablending($image, true);
  imagecopyresampled($image, $image_s, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

// buat mask
  $mask = imagecreatetruecolor($new_width, $new_height);
  $transparan = imagecolorallocate($mask, 255, 0, 0);
  imagecolortransparent($mask, $transparan);

  imagefilledellipse($mask, $new_width/2, $new_height/2, $new_width, $new_height, $transparan);

  $red = imagecolorallocate($mask, 0, 0, 0);
  imagecopymerge($image, $mask, 0, 0 ,0 , 0, $new_width, $new_height, 100);
  imagecolortransparent($image, $red);
  imagefill($image, 0, 0, $red);

  // output
  // header('Content-type: image/png');
  // imagepng($image);
  imagepng($image, $direktori.$nama);
  imagedestroy($image);
  imagedestroy($mask);
  // closedir($filename);
}

?>