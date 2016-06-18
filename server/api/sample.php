<?php
	require_once "db_utils/db_connect.php";
	require_once "db_utils/db_getter.php";
	require_once "db_utils/db_setter.php";
	require_once "siebold_api/siebold_getter.php";
	require_once "siebold_api/siebold_setter.php";
	$pdo = connect();

	$options = array(
		"organization" => array(),
		"collectors" => array(),
		"types" => array(),
		"spaces" => array(),
		"temporals" => array(),
		"creators" => array(),
		"properties" => array(),
		"descriptions" => array(),
		"relations" => array(),
		"research_dates" => array(),
		"researchers" => array(),
	);
	$documents = get_documents( $pdo, $options, true );
	echo "全検索 : ".count($documents)." Results<br>";
	echo "</br>";

	$options = array(
		"organization" => array("五大陸博物館"),
		"collectors" => array(),
		"types" => array(),
		"spaces" => array(),
		"temporals" => array(),
		"creators" => array(),
		"properties" => array(),
		"descriptions" => array(),
		"relations" => array(),
		"research_dates" => array(),
		"researchers" => array(),
	);
	$documents = get_documents( $pdo, $options, true );
	echo "組織検索 : ".count($documents)." Results<br>";
	echo "</br>";

	$options = array(
		"organization" => array(),
		"collectors" => array("フィリップ・フランツ・フォン・シーボルト"),
		"types" => array(),
		"spaces" => array(),
		"temporals" => array(),
		"creators" => array(),
		"properties" => array(),
		"descriptions" => array(),
		"relations" => array(),
		"research_dates" => array(),
		"researchers" => array(),
	);
	$documents = get_documents( $pdo, $options, true );
	echo "収集者検索 : ".count($documents)." Results<br>";
	echo "</br>";

	$options = array(
		"organization" => array(),
		"collectors" => array(),
		"types" => array(array("name"=>"彫刻", "class"=>"document_type")),
		"spaces" => array(),
		"temporals" => array(),
		"creators" => array(),
		"properties" => array(),
		"descriptions" => array(),
		"relations" => array(),
		"research_dates" => array(),
		"researchers" => array(),
	);
	$documents = get_documents( $pdo, $options, true );
	echo "種別検索 : ".count($documents)." Results<br>";
	echo "</br>";

	$options = array(
		"organization" => array(),
		"collectors" => array(),
		"types" => array(),
		"spaces" => array("中国"),
		"temporals" => array(),
		"creators" => array(),
		"properties" => array(),
		"descriptions" => array(),
		"relations" => array(),
		"research_dates" => array(),
		"researchers" => array(),
	);
	$documents = get_documents( $pdo, $options, true );
	echo "空間検索 : ".count($documents)." Results<br>";
	echo "</br>";

	$options = array(
		"organization" => array(),
		"collectors" => array(),
		"types" => array(),
		"spaces" => array(),
		"temporals" => array(array("name"=>"18","class"=>"century")),
		"creators" => array(),
		"properties" => array(),
		"descriptions" => array(),
		"relations" => array(),
		"research_dates" => array(),
		"researchers" => array(),
	);
	$documents = get_documents( $pdo, $options, true );
	echo "時間検索 : ".count($documents)." Results<br>";
	echo "</br>";

	$options = array(
		"organization" => array(),
		"collectors" => array(),
		"types" => array(),
		"spaces" => array(),
		"temporals" => array(),
		"creators" => array(array("name"=>"歌川広重","class"=>"author")),
		"properties" => array(),
		"descriptions" => array(),
		"relations" => array(),
		"research_dates" => array(),
		"researchers" => array(),
	);
	$documents = get_documents( $pdo, $options, true );
	echo "制作者検索 : ".count($documents)." Results<br>";
	echo "</br>";

	$options = array(
		"organization" => array(),
		"collectors" => array(),
		"types" => array(),
		"spaces" => array(),
		"temporals" => array(),
		"creators" => array(),
		"properties" => array(array("name"=>"木造","class"=>"material")),
		"descriptions" => array(),
		"relations" => array(),
		"research_dates" => array(),
		"researchers" => array(),
	);
	$documents = get_documents( $pdo, $options, true );
	echo "属性検索 : ".count($documents)." Results<br>";
	echo "</br>";

	$options = array(
		"organization" => array(),
		"collectors" => array(),
		"types" => array(),
		"spaces" => array(),
		"temporals" => array(),
		"creators" => array(),
		"properties" => array(),
		"descriptions" => array(array("content"=>"台座","class"=>"accesory")),
		"relations" => array(),
		"research_dates" => array(),
		"researchers" => array(),
	);
	$documents = get_documents( $pdo, $options, true );
	echo "記述検索 : ".count($documents)." Results<br>";
	echo "</br>";

	$options = array(
		"organization" => array(),
		"collectors" => array(),
		"types" => array(),
		"spaces" => array(),
		"temporals" => array(),
		"creators" => array(),
		"properties" => array(),
		"descriptions" => array(),
		"relations" => array(array("content"=>"S595_1・2と三尊構成","class"=>"historical_document")),
		"research_dates" => array(),
		"researchers" => array(),
	);
	$documents = get_documents( $pdo, $options, true );
	echo "文献検索 : ".count($documents)." Results<br>";
	echo "</br>";

	$options = array(
		"organization" => array(),
		"collectors" => array(),
		"types" => array(),
		"spaces" => array(),
		"temporals" => array(),
		"creators" => array(),
		"properties" => array(),
		"descriptions" => array(),
		"relations" => array(),
		"research_dates" => array("2012-05-00"),
		"researchers" => array(),
	);
	$documents = get_documents( $pdo, $options, true );
	echo "調査日検索 : ".count($documents)." Results<br>";
	echo "</br>";

	$options = array(
		"organization" => array(),
		"collectors" => array(),
		"types" => array(),
		"spaces" => array(),
		"temporals" => array(),
		"creators" => array(),
		"properties" => array(),
		"descriptions" => array(),
		"relations" => array(),
		"research_dates" => array(),
		"researchers" => array(array("name"=>"日高薫","role"=>"")),
	);
	$documents = get_documents( $pdo, $options, true );
	echo "調査者検索 : ".count($documents)." Results<br>";
	echo "</br>";

	$options = array(
		"organization" => array(),
		"collectors" => array(),
		"types" => array(),
		"spaces" => array("中国"),
		"temporals" => array(array("name"=>"18","class"=>"century")),
		"creators" => array(),
		"properties" => array(),
		"descriptions" => array(),
		"relations" => array(),
		"research_dates" => array(),
		"researchers" => array(),
	);
	$documents = get_documents( $pdo, $options, true );
	echo "空間+時間検索 : ".count($documents)." Results<br>";
	echo "</br>";
/*
	$option = array(
		"use_web_images"=>true,
		"use_local_images"=>true,
		"terms"=>array(
			array("name"=>"3d","taxonomy"=>"category")
		)
	);
	$items = get_items( $pdo, $option );
	echo "term検索 : [3d/category] ".count($items)." Results<br>";
	echo "</br>";

	$option = array(
		"use_web_images"=>true,
		"use_local_images"=>true,
		"terms"=>array(
			array("name"=>"CYAN","taxonomy"=>"color")
		)
	);
	$items = get_items( $pdo, $option );
	echo "term検索 : [CYAN/color] ".count($items)." Results<br>";
	echo "</br>";

	$option = array(
		"use_web_images"=>true,
		"use_local_images"=>true,
		"terms"=>array(
			array("name"=>"3d","taxonomy"=>"category"),
			array("name"=>"CYAN","taxonomy"=>"color")
		)
	);
	$items = get_items( $pdo, $option );
	echo "term検索 : [3d/category],[CYAN/color] ".count($items)." Results<br>";
	echo "</br>";

	$option = array(
		"use_web_images"=>true,
		"use_local_images"=>true,
		"terms"=>array(
			array("name"=>"3d","taxonomy"=>""),
		)
	);
	$items = get_items( $pdo, $option );
	echo "term検索 : [3d/],[CYAN/color] ".count($items)." Results<br>";
	echo "</br>";

	$terms = get_terms($pdo,"category");
	echo "categories : ".count($terms)."<br>";
	foreach( $terms as $cat ){
		echo "<li>".$cat["term_id"]." / ".$cat["name"]."</li>";
	}
	echo "</br>";

	$terms = get_terms($pdo,"tag");
	echo "tags : ".count($terms)."<br>";
	foreach( $terms as $cat ){
		echo "<li>".$cat["term_id"]." / ".$cat["name"]."</li>";
	}
	echo "</br>";

	$terms = get_terms($pdo,"color");
	echo "colors : ".count($terms)."<br>";
	foreach( $terms as $cat ){
		echo "<li>".$cat["term_id"]." / ".$cat["name"]."</li>";
	}
	echo "</br>";
	*/

	/*$terms = get_terms($pdo,"keyword");
	echo "keywords : ".count($terms)."<br>";
	foreach( $categories as $cat ){
		echo "<li>".$cat["term_id"]." / ".$cat["name"]."</li>";
	}
	echo "</br>";*/

	//remove_the_item( $pdo, "local", "75" );
	//remove_the_item( $pdo, "local", "79" );
	//remove_the_item( $pdo, "local", "73" );

	//データベースの更新プログラム...webimage_add&crawring
	//タブレット操作
?>