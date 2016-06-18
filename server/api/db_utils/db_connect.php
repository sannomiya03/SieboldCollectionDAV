<?php
	function connect(){
		$host = "localhost:8888";
		$dbname = "siebold_collection";
		$user = "root";
		$pass = "root";
		try{ $pdo = new PDO( "mysql:host=".$host.";dbname=".$dbname.";charset=utf8;",  $user, $pass ); }
		catch( PDOException $e ){ var_dump($e->getMessage()); exit; }
		return $pdo;
	}
?>