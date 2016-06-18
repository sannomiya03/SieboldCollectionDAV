<?php
	mb_internal_encoding("UTF-8");

	function changeRelationship( $pdo, $table, $key, $from, $to ){
		updateRecord( $pdo, $table, $key, $to, $key, $from );
	}
?>