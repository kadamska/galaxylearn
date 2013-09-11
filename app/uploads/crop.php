<?php
/* Cropping 

	$targ_w = $targ_h = 150;
	$jpeg_quality = 90;

	$src = 'demo_files/pool.jpg';
	$img_r = imagecreatefromjpeg($src);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
	$targ_w,$targ_h,$_POST['w'],$_POST['h']);

	header('Content-type: image/jpeg');
	imagejpeg($dst_r,null,$jpeg_quality);

// the code
	list($w_orig, $h_orig) = getimagesize($target);
	$src_x = ($w_orig / 2) - ($w / 2);
	$src_y = ($h_orig / 2) - ($h / 2);
	$ext = strtolower($ext);
	$img = "";

	if ($ext == "gif"){ 
		$img = imagecreatefromgif($target);
	} else if($ext =="png"){ 
		$img = imagecreatefrompng($target);
	} else { 
		$img = imagecreatefromjpeg($target);
	}

	$tci = imagecreatetruecolor($w, $h);

	imagecopyresampled($tci, $img, 0, 0, $src_x, $src_y, $w, $h, $w, $h);

	if ($ext == "gif"){ 
		imagegif($tci, $newcopy);
	} else if($ext =="png"){ 
		imagepng($tci, $newcopy);
	} else { 
		imagejpeg($tci, $newcopy, 90);
	}
*/
?>