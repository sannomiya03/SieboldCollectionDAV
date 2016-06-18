<?php
	function get_documents( $pdo, $options, $andSearching ){
		if( doAdvanceSearch($options) ){
			$document_ids = array();
			foreach( $options["organization"] as $organization ){
				$ids = searchDocDirectory( $pdo, "organizations", "organization_id", "name_ja", $organization );
				$document_ids = mergeIDs( $document_ids, $ids, $andSearching );
			}
			foreach( $options["collectors"] as $collector ){
				$ids = searchDocDirectory( $pdo, "collectors", "collector_id", "name_ja", $collector );
				$document_ids = mergeIDs( $document_ids, $ids, $andSearching );
			}
			foreach( $options["types"] as $type ){
				$ids = searchDocIndirectory( $pdo, "types", "types_relationships", "type_id", "name", $type["name"], "class", $type["class"] );
				$document_ids = mergeIDs( $document_ids, $ids, $andSearching );
			}
			foreach( $options["spaces"] as $space ){
				$ids = searchDocIndirectory( $pdo, "spaces", "spaces_relationships", "space_id", "name", $space, "class", "" );
				$document_ids = mergeIDs( $document_ids, $ids, $andSearching );
			}
			foreach( $options["temporals"] as $temporal ){
				$ids = searchDocIndirectory( $pdo, "temporals", "temporals_relationships", "temporal_id", "name", $temporal["name"], "class", $temporal["class"] );
				$document_ids = mergeIDs( $document_ids, $ids, $andSearching );
			}
			foreach( $options["creators"] as $creator ){
				$ids = searchDocIndirectory( $pdo, "creators", "creators_relationships", "creator_id", "name_ja", $creator["name"], "class", $creator["class"] );
				$document_ids = mergeIDs( $document_ids, $ids, $andSearching );
			}
			foreach( $options["properties"] as $property ){
				$ids = searchDocIndirectory( $pdo, "properties", "properties_relationships", "property_id", "name", $property["name"], "class", $property["class"] );
				$document_ids = mergeIDs( $document_ids, $ids, $andSearching );
			}
			//like検索版をつくる
			foreach( $options["descriptions"] as $description ){
				$ids = searchDocIndirectoryLike( $pdo, "descriptions", "descriptions_relationships", "description_id", "content", $description["content"], "class", $description["class"] );
				$document_ids = mergeIDs( $document_ids, $ids, $andSearching );
			}
			foreach( $options["relations"] as $relation ){
				$ids = searchDocIndirectoryLike( $pdo, "relations", "relations_relationships", "relation_id", "content", $relation["content"], "class", $relation["class"] );
				$document_ids = mergeIDs( $document_ids, $ids, $andSearching );
			}
			foreach( $options["research_dates"] as $research_date ){
				$records = getRecords( $pdo, "research_dates", "where date='$research_date'" );
				foreach( $records as $record ){
					array_push( $document_ids, $record["document_id"] );
				}
			}
			foreach( $options["researchers"] as $researcher ){
				$researcher_id = getRecord( $pdo ,"researchers", "where name='".$researcher["name"]."'")["researcher_id"];
				$roll_ids = array();
				if( $researcher["role"] == "" ){
					$r_id = getNameWhere( $pdo, "researchers_roles", "role_id", "researcher_id='$researcher_id' AND (class='researcher' OR class='photographer')" );
					if( $r_id != "" ) array_push( $roll_ids, $r_id );
				}else{
					$id = getNameWhere( $pdo, "researchers_roles", "role_id", "researcher_id='$researcher_id' AND class='".$researcher["role"]."'" );
					if( $id != "" ) array_push( $roll_ids, $id );
				}

				foreach( $roll_ids as $roll_id ){
					$ids = getIDs( $pdo, " researchers_roles_relationships", "researchers_roles_relationships_id", "where role_id='$roll_id'");
					foreach( $ids as $id ){
						$doc_id = getName( $pdo, "research_dates", "document_id", "research_date_id", $id );
						array_push( $document_ids, $doc_id );
					}
				}
			}
			return $document_ids;
		}else{
			$documents = getRecords( $pdo, "documents", "" );
			return $documents;
		}
	}

	/*----------------------------------------------------------*/
	function searchDocDirectory( $pdo, $table, $id, $key, $val ){
		$relational_id = getName( $pdo, $table, $id, $key, $val );
		return getIDs( $pdo, "documents", "document_id", "where $id='$relational_id'" );
	}
	function searchDocIndirectory( $pdo, $table_a, $table_b, $id, $key_a, $val_a, $key_b, $val_b ){
		if( $val_b == "" ){
			$relational_id = getName( $pdo, $table_a, $id, $key_a, $val_a );
		}else{
			$relational_id = getNameWhere( $pdo, $table_a, $id, "$key_a='$val_a' AND $key_b='$val_b'" );
		}
		return getIDs( $pdo, $table_b, "document_id", "where $id='$relational_id'" );
	}
	function searchDocIndirectoryLike( $pdo, $table_a, $table_b, $id, $key_a, $val_a, $key_b, $val_b ){
		if( $val_b == "" ){
			$relations = getRecordsLike( $pdo, $table_a, $key_a, $val_a, "" );
		}else{
			$relations = getRecordsLike( $pdo, $table_a, $key_a, $val_a, " AND $key_b='$val_b'" );
		}
		$document_ids = array();
		foreach( $relations as $relation ){
			$relational_id = $relation[$id];
			$ids = getIDs( $pdo, $table_b, "document_id", "where $id='$relational_id'" );
			$document_ids = mergeIDs($document_ids, $ids);
		}
		return $document_ids;
	}


	/*----------------------------------------------------------*/
	function doAdvanceSearch( $options ){
		foreach( $options as $option ){
			if( count($option) > 0 ) return true;
		}
		return false;
	}

	function mergeIDs( $arr, $ids, $andSearching ){
		if( $andSearching && count($arr)>0 ){
			$output = array();
			foreach( $arr as $id ){
				if( hasID($ids, $id["document_id"]) ) array_push( $output, $id );
			}
			return $output;
		}else{
			foreach( $ids as $id ){
				array_push( $arr, $id );
			}
			return $arr;
		}
	}

	function hasID( $arr, $id ){
		foreach($arr as $aid ){
			if( $aid["document_id"] == $id ) return true;
		}
		return false;
	}
?>