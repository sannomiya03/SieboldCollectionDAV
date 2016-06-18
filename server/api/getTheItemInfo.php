<?php
	require_once "db_utils/db_connect.php";
	require_once "db_utils/db_getter.php";
	require_once "db_utils/db_setter.php";
	require_once "siebold_api/siebold_getter.php";
	require_once "siebold_api/siebold_setter.php";

	$pdo = connect();

	$s_no = $_GET["sid"];
	$branch_no = $_GET["bid"];

	if( $branch_id == "" ){
		$document = getRecord( $pdo, "documents", "where s_no='$s_no'" );
	}else{
		$document = getRecord( $pdo, "documents", "where s_no='$s_no' AND branch_no='$branch_no'" );
	}
	$item = array(
		"id"=>$document["document_id"],
		"title_ja"=>$document["title_ja"],
		"title_en"=>$document["title_en"],
		"project_id"=>$document["project_id"],
		"s_no"=>$document["s_no"],
		"branch_no"=>$document["branch_no"],
		"document_type"=>array(),
		"technique"=>array(),
		"pattern"=>array(),
		"age"=>"",
		"century"=>"",
		"calender_ja"=>"",
		"space"=>"",
		"depth"=>$document["depth"],
		"width"=>$document["width"],
		"height"=>$document["height"],
		"total_height"=>$document["total_height"],
		"diameter"=>$document["diameter"],
		"caliber"=>$document["caliber"],
		"hill_diameter"=>$document["hill_diameter"],
		"thickness"=>$document["thickness"],
		"relations"=>array(
				"document_type"=>array(),
				"technique"=>array(),
				"pattern"=>array(),
				"age"=>array()
			)
	);

	$did=$document["document_id"];
	$did;
	$ids = getIDs( $pdo, "types_relationships", "type_id", "where document_id='$did'" );
	foreach( $ids as $id ){
		$type = getRecord( $pdo, "types", "where type_id='".$id["type_id"]."'");
		if( $type["class"] == "document_type" ) array_push($item["document_type"],	array("name"=>$type["name"],"id"=>$type["type_id"]));
		if( $type["class"] == "technique" ) 	array_push($item["technique"],		array("name"=>$type["name"],"id"=>$type["type_id"]));
		if( $type["class"] == "pattern" ) 		array_push($item["pattern"],		array("name"=>$type["name"],"id"=>$type["type_id"]));
	}
	$ids = getIDs( $pdo, "temporals_relationships", "temporal_id", "where document_id='$did'" );
	foreach( $ids as $id ){
		$temporal = getRecord( $pdo, "temporals", "where temporal_id='".$id["temporal_id"]."'");
		if( $temporal["class"] == "age" ) 			$item["age"] = array("name"=>$temporal["name"],"id"=>$temporal["temporal_id"]);
		if( $temporal["class"] == "century" ) 		$item["document_type"] = array("name"=>$temporal["name"],"id"=>$temporal["temporal_id"]);
		if( $temporal["class"] == "calender_ja" )	$item["technique"] = array("name"=>$temporal["name"],"id"=>$temporal["temporal_id"]);
	}
	$ids = getIDs( $pdo, "spaces_relationships", "space_id", "where document_id='$did'" );
	foreach( $ids as $id ){
		$space = getRecord( $pdo, "spaces", "where space_id='".$id["space_id"]."'");
		$item["space"] = array("name"=>$space["name"],"id"=>$space["temporal_id"]);
	}

	foreach( $item["document_type"] as $obj ){
		$ids = getIDs( $pdo, "types_relationships", "document_id", "where type_id='".$obj["id"]."'" );
		foreach( $ids as $id ){
			$document = getRecord( $pdo, "documents", "where document_id='".$id["document_id"]."'" );
			array_push($item["relations"]["document_type"], $document);
			if( count($item["relations"]["document_type"])>3 ) break;
		}
	}
	foreach( $item["technique"] as $obj ){
		$ids = getIDs( $pdo, "types_relationships", "document_id", "where type_id='".$obj["id"]."'" );
		foreach( $ids as $id ){
			$document = getRecord( $pdo, "documents", "where document_id='".$id["document_id"]."'" );
			array_push($item["relations"]["technique"], $document);
			if( count($item["relations"]["technique"])>3 ) break;
		}
	}
	foreach( $item["pattern"] as $obj ){
		$ids = getIDs( $pdo, "types_relationships", "document_id", "where type_id='".$obj["id"]."'" );
		foreach( $ids as $id ){
			$document = getRecord( $pdo, "documents", "where document_id='".$id["document_id"]."'" );
			array_push($item["relations"]["pattern"], $document);
			if( count($item["relations"]["pattern"])>3 ) break;
		}
	}

	if( $item["age"]!="" ){
		$ids = getIDs( $pdo, "types_relationships", "document_id", "where type_id='".$item["age"]."'" );
		foreach( $ids as $id ){
			$document = getRecord( $pdo, "documents", "where document_id='".$id["document_id"]."'" );
			array_push($item["relations"]["age"], $document);
			if( count($item["relations"]["age"])>3 ) break;
		}
	}else if( $item["century"]!="" ){
		$ids = getIDs( $pdo, "types_relationships", "document_id", "where type_id='".$item["century"]."'" );
		foreach( $ids as $id ){
			$document = getRecord( $pdo, "documents", "where document_id='".$id["document_id"]."'" );
			array_push($item["relations"]["age"], $document);
			if( count($item["relations"]["age"])>3 ) break;
		}
	}else if( $item["calender_ja"]!="" ){
		$ids = getIDs( $pdo, "types_relationships", "document_id", "where type_id='".$item["calender_ja"]."'" );
		foreach( $ids as $id ){
			$document = getRecord( $pdo, "documents", "where document_id='".$id["document_id"]."'" );
			array_push($item["relations"]["age"], $document);
			if( count($item["relations"]["age"])>3 ) break;
		}
	}


	print json_encode($item);
?>