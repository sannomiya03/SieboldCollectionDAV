<?php
	require_once "./../api/db_utils/db_connect.php";
	require_once "./../api/db_utils/db_getter.php";
	require_once "./../api/db_utils/db_setter.php";
	require_once "./../api/siebold_api/siebold_getter.php";
	require_once "./../api/siebold_api/siebold_setter.php";
	$pdo = connect();

	echo "UPDATE > temporals_relationships / temporal_id : from 21 to 1, ";
	changeRelationship( $pdo, "temporals_relationships", "temporal_id", "21", "1");
	echo "done\n";
	echo "DELETE > temporals / temporal_id 21, ";
	deleteRecord( $pdo, "temporals", "temporal_id","21" );
	echo "done\n";
?>