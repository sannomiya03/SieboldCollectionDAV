<?php
	require_once "colorAnalize.php";

	$file_path = "testImages/smp01.jpg";
	$colors = colorAnalize($file_path);
	var_dump($colors);
?>