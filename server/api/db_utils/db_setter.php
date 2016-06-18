<?php
	/* ---------------------------------------------
	 * INSERT
	 * --------------------------------------------- */
	function insertItem( $pdo, $table, $key_id, $keys, $vals ){
		$where = "";
		for( $i=0; $i<count($keys); $i++ ){
			$where .= $keys[$i]."='".$vals[$i]."'";
			if( $i<count($keys)-1 ) $where .= " AND ";
		}
		$id = getNameWhere( $pdo, $table, $key_id, $where );
		if( !activeKey($keys) || !activeKey($vals) ){
			echo "no value\n";
			return;
		}
		if( $id == "" ){
			insert( $pdo, $table, $keys, $vals );
			$id = getNameWhere( $pdo, $table, $key_id, $where );
			echo "new item, id: $id\n";
			return $id;
		}else{
			echo "already exist, id: $id\n";
			return $id;
		}
	}
	function insertItemImportant( $pdo, $table, $key_id, $keys, $vals ){
		$where = "";
		for( $i=0; $i<count($keys); $i++ ){
			$where .= $keys[$i]."='".$vals[$i]."'";
			if( $i<count($keys)-1 ) $where .= " AND ";
		}
		$id = getNameWhere( $pdo, $table, $key_id, $where );
		if( $id == "" ){
			insert( $pdo, $table, $keys, $vals );
			$id = getNameWhere( $pdo, $table, $key_id, $where );
			echo "new item, id: $id\n";
			return $id;
		}else{
			echo "already exist, id: $id\n";
			return $id;
		}
	}

	function activeKey( $keys ){
		foreach( $keys as $key ){
			if( count($key)==0 || $key == null || $key == "" || $key == " " || $key == "　" || $key == "  " ) return false;
		}
		return true;
	}

	function insert( $pdo, $table, $keys, $vals ){
		$key_strings = "";
		$val_strings = "";
		for( $i=0; $i<count($keys); $i++ ){
			$key_strings.=$keys[$i];
			$val_strings.=":".$keys[$i];
			if( $i<count($keys)-1 ){
				$key_strings.=", ";
				$val_strings.=", ";
			}
		}
		$sql = "insert into $table ( $key_strings ) value ( $val_strings )";
		try {
			$stmt = $pdo->prepare($sql);
			for( $i=0; $i<count($keys); $i++ ){
				//echo ":".$keys[$i].", ".$vals[$i]."\n";
				$stmt->bindParam(":".$keys[$i], $vals[$i], PDO::PARAM_STR);
			}
			$stmt->execute();
		}catch(Exception $e){ echo $e->getMessage(); }
	}

	function insertRelationship( $pdo, $table, $attrA_id, $attrB_id, $attrA_val, $attrB_val ){
		$sql = "insert into $table ( $attrA_id, $attrB_id ) value ( :attrA_id, :attrB_id )";
		try {
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(":attrA_id", $attrA_val, PDO::PARAM_STR);
			$stmt->bindParam(":attrB_id", $attrB_val, PDO::PARAM_STR);
			$stmt->execute();
		}catch(Exception $e){ echo $e->getMessage(); }
	}




	/* ---------------------------------------------
	 * UPDATE
	 * --------------------------------------------- */
	function updateRecord( $pdo, $table, $id, $val, $where_id, $where_val ){
		$sql = "UPDATE $table SET $id=:val WHERE $where_id=:where_val";
		try {
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(":val", $val, PDO::PARAM_STR);
			$stmt->bindParam(":where_val", $where_val, PDO::PARAM_STR);
			$stmt->execute();
		}catch(Exception $e){ echo $e->getMessage(); }
	}


	/* ---------------------------------------------
	 * DELETE
	 * --------------------------------------------- */
	function deleteRecord( $pdo, $table, $key, $val ){
		$sql = "delete from $table where $key=:key";
		try {
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(":key", $val, PDO::PARAM_STR);
			$stmt->execute();
		}catch(Exception $e){ echo $e->getMessage(); }
	}

	function deleteRecordAdvanced( $pdo, $table, $keys, $vals ){
		$key_strings = "";
		for( $i=0; $i<count($keys); $i++ ){
			$key_strings.=$keys[$i]."=:".$keys[$i]." ";
			if( $i < count($keys)-1 ){
				$key_strings.=" AND ";
			}
		}
		$sql = "delete from $table where $key_strings";
		//$sql = "delete from $table where $id=:id";
		try {
			$stmt = $pdo->prepare($sql);
			for( $i=0; $i<count($keys); $i++ ){
				$stmt->bindParam(":".$keys[$i], $vals[$i], PDO::PARAM_STR);
			}
			$stmt->execute();
		}catch(Exception $e){ echo $e->getMessage(); }
	}

	function deleteRelationship( $pdo, $table, $attrA_id, $attrA_val, $attrB_id, $attrB_val ){
		$sql = "delete from $table where $attrA_id=:attrA_id && $attrB_id=:attrB_id ";
		try {
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':attrA_id', $attrA_val, PDO::PARAM_STR);
			$stmt->bindParam(':attrB_id', $attrB_val, PDO::PARAM_STR);
			$stmt->execute();
		}catch(Exception $e){ echo $e->getMessage(); }
	}
?>