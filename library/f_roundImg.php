<?php 

function imageCreateCorners($sourceImageFile, $radius = 20) {
    # test source image
	if (file_exists($sourceImageFile)) {
		$res = is_array($info = getimagesize($sourceImageFile));
	}
	else $res = false;

    # open image
	if ($res) {
		$w = $info[0];
		$h = $info[1];

		switch ($info['mime']) {
			case 'image/jpeg': $src = imagecreatefromjpeg($sourceImageFile);
			break;
			case 'image/gif': $src = imagecreatefromgif($sourceImageFile);
			break;
			case 'image/png': $src = imagecreatefrompng($sourceImageFile);
			break;
			default:
			$res = false;
		}
	}

    # create corners
	if ($res) {

      $q = 8; # change this if you want
      $radius *= $q;

      # find unique color
      do {
      	$r = rand(0, 255);
      	$g = rand(0, 255);
      	$b = rand(0, 255);
      }
      while (imagecolorexact($src, $r, $g, $b) < 0);

      $nw = $w*$q;
      $nh = $h*$q;

      $img = imagecreatetruecolor($nw, $nh);
      $alphacolor = imagecolorallocatealpha($img, $r, $g, $b, 127);
      imagealphablending($img, false);
      imagesavealpha($img, true);
      imagefilledrectangle($img, 0, 0, $nw, $nh, $alphacolor);

      imagefill($img, 0, 0, $alphacolor);
      imagecopyresampled($img, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);

      imagearc($img, $radius-1, $radius-1, $radius*2, $radius*2, 180, 270, $alphacolor);
      imagefilltoborder($img, 0, 0, $alphacolor, $alphacolor);
      imagearc($img, $nw-$radius, $radius-1, $radius*2, $radius*2, 270, 0, $alphacolor);
      imagefilltoborder($img, $nw-1, 0, $alphacolor, $alphacolor);
      imagearc($img, $radius-1, $nh-$radius, $radius*2, $radius*2, 90, 180, $alphacolor);
      imagefilltoborder($img, 0, $nh-1, $alphacolor, $alphacolor);
      imagearc($img, $nw-$radius, $nh-$radius, $radius*2, $radius*2, 0, 90, $alphacolor);
      imagefilltoborder($img, $nw-1, $nh-1, $alphacolor, $alphacolor);
      imagealphablending($img, true);
      imagecolortransparent($img, $alphacolor);

      # resize image down
      $dest = imagecreatetruecolor($w, $h);
      imagealphablending($dest, false);
      imagesavealpha($dest, true);
      imagefilledrectangle($dest, 0, 0, $w, $h, $alphacolor);
      imagecopyresampled($dest, $img, 0, 0, 0, 0, $w, $h, $nw, $nh);

      # output image
      $res = $dest;
      imagedestroy($src);
      imagedestroy($img);
  }

  return $res;
}

function createRoundImage($sourceFile, $destinationFile, $radius = 100){
	$roundImage = imageCreateCorners($sourceFile, $radius);
	imagepng($roundImage, $destinationFile, 9);

	$filename = pathinfo($destinationFile, PATHINFO_BASENAME);
	return $filename;
}

?>