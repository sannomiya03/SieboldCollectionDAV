<?php
	require_once "isImage.php";
	ini_set('memory_limit', '512M');

	function makeTrimImage( $filePath, $resizeSize, $saveDir  ){
		$image = imageCreateFromAny( $filePath );
		if( !$image ) return false;
		list( $image_w, $image_h ) = getimagesize( $filePath );

		$cropSize = ( $image_w < $image_h )? $image_w: $image_h;

		$cropImage = imagecrop( $image, array(
			'x' => ($image_w-$cropSize)/2,
			'y' => ($image_h-$cropSize)/2,
			'width' => $cropSize,
			'height'=> $cropSize
		));

		$resizedImage = imagecreatetruecolor( $resizeSize, $resizeSize );
		imagecopyresampled(
			$resizedImage,
			$cropImage,
			0,
			0,
			0,
			0,
			$resizeSize,
			$resizeSize,
			$cropSize,
			$cropSize
		);

		$fileName = basename($filePath);
		$saveDir = $saveDir."/".$resizeSize;
		$savePath = $saveDir."/".date("Y-m-d-H-i-s")."_".$fileName;

		if( !file_exists($saveDir) ) mkdir( $savePath, 0777 );
		if( file_exists($savePath) ) return $savePath;

		imagejpeg(
			$resizedImage,
			$savePath,
			100
		);

		imagedestroy($image);
		imagedestroy($cropImage);
		imagedestroy($resizedImage);

		return $savePath;
	}
?>