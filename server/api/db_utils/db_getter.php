<?php
	function getName( $pdo, $table, $target, $where, $val ){
		$sql = "select * from ".$table." where ".$where."='".$val."'";
		$stmt = $pdo->query($sql);
		if( $stmt==null ) return "";
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if( $result==null ) return "";
		$name = $result[$target];
		return $name;
	}

	function getNameWhere( $pdo, $table, $target, $where ){
		$sql = "select * from ".$table." where $where";
		$stmt = $pdo->query($sql);
		if( $stmt==null ) return "";
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if( $result==null ) return "";
		$name = $result[$target];
		return $name;
	}

	function getRecord( $pdo, $table, $where ){
		$sql = "select * from ".$table." ".$where;
		$stmt = $pdo->query($sql);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function getRecords( $pdo, $table, $where ){
		$sql = "select * from ".$table." ".$where;
		$stmt = $pdo->query($sql);
		$results = array();
		foreach( $stmt as $line ){
			array_push($results, $line);
		}
		return $results;
	}

	function getIDs( $pdo, $table, $id, $where ){
		$sql = "select $id from ".$table." ".$where;
		$stmt = $pdo->query($sql);
		$results = array();
		foreach( $stmt as $line ){
			array_push($results, $line);
		}
		return $results;
	}

	function getRecordsLike( $pdo, $table, $key, $val, $where ){
		$sql = "select * from $table where $key like :key $where";
		$stmt = $pdo->prepare($sql);
		$like = '%'."$val".'%';
		$stmt->bindParam(":key", $like, PDO::PARAM_STR);
		$stmt->execute();
		$results = array();
		foreach( $stmt as $line ){
			array_push($results, $line);
		}
		return $results;
	}
?>