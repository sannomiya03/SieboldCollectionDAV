<?php
	require_once "isImage.php";

	function colorAnalize($filePath){
		$image = imageCreateFromAny( $filePath );
		if( !$image ) return false;
		list( $image_w, $image_h ) = getimagesize( $filePath );

		$map = calcHSBMap( $image, $image_w, $image_h );
		$colors = getColorMap($map);
		$populars = getPopularColor($colors);

		/*echo "This image has ";
		foreach($populars as $popular){
			switch($popular){
				case 0: echo "\"PINK\" "; break;
				case 1: echo "\"RED\" "; break;
				case 2: echo "\"ORANGE\" "; break;
				case 3: echo "\"YELLOW\" "; break;
				case 4: echo "\"LIME\" "; break;
				case 5: echo "\"GREEN\" "; break;
				case 6: echo "\"CYAN\" "; break;
				case 7: echo "\"BLUE\" "; break;
				case 8: echo "\"PURPLE\" "; break;
				case 9: echo "\"GRAY\" "; break;
				case 10: echo "\"BLACK\" "; break;
				case 11: echo "\"WHITE\" "; break;
			}
		}
		echo " colors.\n";*/
		$output = array();
		foreach($populars as $popular){
			switch($popular){
				case 0: array_push( $output, "PINK" ); break;
				case 1: array_push( $output, "RED" ); break;
				case 2: array_push( $output, "ORANGE" ); break;
				case 3: array_push( $output, "YELLOW" ); break;
				case 4: array_push( $output, "LIME" ); break;
				case 5: array_push( $output, "GREEN" ); break;
				case 6: array_push( $output, "CYAN" ); break;
				case 7: array_push( $output, "BLUE" ); break;
				case 8: array_push( $output, "PURPLE" ); break;
				case 9: array_push( $output, "GRAY" ); break;
				case 10: array_push( $output, "BLACK" ); break;
				case 11: array_push( $output, "WHITE" ); break;
			}
		}
		return $output;

		imagedestroy($image);
	}

	function calcHSBMap( $image, $width, $height ){
		$map = array();
		for($x=0; $x < $width; $x++){
			for($y=0; $y < $height; $y++){
				$index = imagecolorat( $image, $x, $y );
				$rgb = imagecolorsforindex( $image, $index );
				$hsb = rgbToHsv($rgb);
				$map[$x][$y] = $hsb;
			}
		}
		return $map;
	}

	function getColorMap($map){
		$colors = array();
		for($y=0;$y<100;$y++){
			for($x=0;$x<100;$x++){
				$dists = calcDistance($map[$x][$y]);
				$color = getApproxColor($dists);
				$colors[$x][$y] = $color;
				//echo $color." ";
			}
			//echo "\n";
		}
		return $colors;
	}

	function getPopularColor($colors){
		$usedColors = array();
		for($y=0;$y<100;$y++){
			for($x=0;$x<100;$x++){
				$usedColors = colorCountUp($colors[$x][$y], $usedColors);
			}
		}
		$usedColors = calcPercentage($usedColors);
		//var_dump($usedColors);

		$popular = array();
		foreach( $usedColors as $color ){
			if( $color["per"] > 0.2 ){
				array_push($popular,$color["color"]);
			}
		}
		return $popular;
	}

	function colorCountUp($color, $usedColors){
		for( $i=0; $i<count($usedColors); $i++ ){
			if( $usedColors[$i]["color"] == $color ){
				$usedColors[$i]["count"]++;
				return $usedColors;
			}
		}
		array_push($usedColors,array(
				"color"=>$color,
				"count"=>1,
				"per"=>0
			));
		return $usedColors;
	}

	function calcPercentage($usedColors){
		$total = 10000; //because, all image size is 100*100px
		/*foreach($usedColors as $usedColor){
			$total+=$usedColor["count"];
		}
		echo $total;*/
		for( $i=0; $i<count($usedColors); $i++ ){
			$usedColors[$i]["per"] = $usedColors[$i]["count"]/$total;
		}
		return $usedColors;
	}

	function calcDistance($hsb){
		$dists = array();
		$COLORS = array(
			"pink"=>array(340,58,88),
			"red"=>array(4,76,90),
			"orange"=>array(35,81,96),
			"yellow"=>array(54,71,96),
			"lime"=>array(66,59,85),
			"green"=>array(123,44,74),
			"cyan"=>array(187,76,80),
			"blue"=>array(205,64,83),
			"purple"=>array(294,50,60),
			"gray"=>array(0,0,50),
			"black"=>array(0,100,0),
			"white"=>array(0,0,100)
		);
		foreach($COLORS as $color){
			array_push($dists, colorDistance($hsb, $color));
		}
		return $dists;
	}

	function getApproxColor($dists){
		$resultIndex = 0;
		$LowestVal = 360;
		for( $i=0; $i<count($dists); $i++){
			if( $dists[$i] < $LowestVal ){
				$resultIndex = $i;
				$LowestVal = $dists[$i];
			}
		}
		return $resultIndex;
	}

	function colorDistance($a, $b) {
		$hueDiff = 0;
		if( $a[0] > $b[0] ){
			$hueDiff = min($a[0]-$b[0], $b[0]-$a[0]+360);
		}else{
			$hueDiff = min($b[0]-$a[0], $a[0]-$b[0]+360);
		}
		return sqrt(pow($hueDiff, 2)+pow($a[1]-$b[1], 2)+pow($a[2]-$b[2], 2));
	}

	function rgbToHsv($rgb) {
		$h = 0; $s = 0; $v = 0;
		$r = $rgb["red"] / 255;
		$g = $rgb["green"] / 255;
		$b = $rgb["blue"] / 255;
		$max = max( $r, $g, $b );
		$min = min( $r, $g, $b );

		if ( $max === $min ) $h = 0;
		else if ( $max === $r ) $h = ( 60 * ($g - $b) / ( $max - $min ) + 360 ) % 360;
		else if ( $max === $g ) $h = 60 * ( $b - $r ) / ( $max - $min ) + 120;
		else if ( $max === $b ) $h = 60 * ( $r - $g ) / ( $max - $min ) + 240;

		if ( $max === 0 ) $s = 0;
		else $s = 1 - $min / $max;

		$v = $max;
		$hsv = array($h, $s * 100, $v * 100);
		return $hsv;
	}
?>