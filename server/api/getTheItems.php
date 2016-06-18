<?php
	require_once "db_utils/db_connect.php";
	require_once "db_utils/db_getter.php";
	require_once "db_utils/db_setter.php";
	require_once "siebold_api/siebold_getter.php";
	require_once "siebold_api/siebold_setter.php";
	$pdo = connect();
	$MAX_PAGE_ITEM = 30;
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

	$page = 0;
	$keyword = "";
	$select = "";
	if(isset($_POST['page'])) $page = $_POST["page"];
	if(isset($_POST['keyword'])) $keyword = $_POST["keyword"];
	if(isset($_POST['select'])) $select = $_POST["select"];

	if( $select == "資料種別" ) array_push($options["types"], array("name"=>$keyword, "class"=>"document_type"));
	if( $select == "技法")　array_push($options["types"], array("name"=>$keyword, "class"=>"technique"));
	if( $select == "文様")　array_push($options["types"], array("name"=>$keyword, "class"=>"pattern"));

	// get items
	$document_ids = get_documents( $pdo, $options, true );
	foreach($document_ids as $key => $value) {
		$name[$key] = $value['branch_no'];
		$price[$key] = $value['s_no'];
	}
	$sort = array_multisort( $price, SORT_DESC, SORT_NUMERIC, $name, SORT_ASC, SORT_STRING, $document_ids);
	//$document_ids = array_multisort( $price, SORT_DESC, SORT_NUMERIC, $name, SORT_ASC, SORT_STRING, $document_ids);

	// set page items
	$active_ids = array();
	for( $i=0; $i<$MAX_PAGE_ITEM; $i++ ){
		if( $i+$page*$MAX_PAGE_ITEM >= count($document_ids) ) continue;
		array_push( $active_ids, $document_ids[$i+$page*$MAX_PAGE_ITEM]["document_id"]);
	}

	// convert items->the_items
	$the_items = array();
	foreach( $active_ids as $active_id ){
		$document = getRecord( $pdo, "documents", "where document_id='$active_id'");
		$item = array(
			"id"=>$document["document_id"],
			"name"=>$document["title_ja"],
			"project_id"=>$document["project_id"],
			"s_no"=>$document["s_no"],
			"branch_no"=>$document["branch_no"],
			"document_type"=>array(),
			"technique"=>array(),
			"pattern"=>array(),
			"age"=>"",
			"century"=>"",
			"calender_ja"=>"",
			"space"=>""
			);
		$ids = getIDs( $pdo, "types_relationships", "type_id", "where document_id='$active_id'" );
		foreach( $ids as $id ){
			$type = getRecord( $pdo, "types", "where type_id='".$id["type_id"]."'");
			if( $type["class"] == "document_type" ) array_push($item["document_type"], $type["name"]);
			if( $type["class"] == "technique" ) array_push($item["technique"], $type["name"]);
			if( $type["class"] == "pattern" ) array_push($item["pattern"], $type["name"]);
		}
		$ids = getIDs( $pdo, "temporals_relationships", "temporal_id", "where document_id='$active_id'" );
		foreach( $ids as $id ){
			$temporal = getRecord( $pdo, "temporals", "where temporal_id='".$id["temporal_id"]."'");
			if( $temporal["class"] == "age" ) $item["age"] = $temporal["name"];
			if( $temporal["class"] == "century" ) $item["document_type"] = $temporal["name"];
			if( $temporal["class"] == "calender_ja" ) $item["technique"] = $temporal["name"];
		}
		$ids = getIDs( $pdo, "spaces_relationships", "space_id", "where document_id='$active_id'" );
		foreach( $ids as $id ){
			$space = getRecord( $pdo, "spaces", "where space_id='".$id["space_id"]."'");
			$item["space"] = $space["name"];
		}
		array_push( $the_items, $item );
	}

	// export
	print json_encode(array(
		"size"=>count($document_ids),
		"items"=>$the_items
	));

	function compare($a, $b){
		if ($a["s_no"] == $b["s_no"])  return 0;
		return ($a["s_no"] < $b["s_no"]) ? -1 : 1;
	}
?>