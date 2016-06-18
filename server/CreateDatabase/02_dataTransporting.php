<?php
	require_once "./../api/db_utils/db_connect.php";
	require_once "./../api/db_utils/db_getter.php";
	require_once "./../api/db_utils/db_setter.php";

	$pdo = connect();

	$FILE_PATHS = array(
		"./databasePlan/佐々木-Documents.csv",
		"./databasePlan/原田一敏-Documents.csv",
		"./databasePlan/原田博二-Documents.csv",
		"./databasePlan/大久保-Documents.csv",
		"./databasePlan/日高-Documents.csv",
		"./databasePlan/櫻庭-Documents.csv",
		"./databasePlan/澤田-Documents.csv",
		"./databasePlan/福岡-Documents.csv",
		"./databasePlan/青山-Documents.csv"
	);

	foreach($FILE_PATHS as $FILE_PATH){
		echo "START $FILE_PATH \n";
		dataTransport( $pdo, $FILE_PATH );
		echo "COMPLETE ---------------------------\n";
	}

	function dataTransport( $pdo, $file_path ){
		$records = array();
		$file = new SplFileObject( $file_path );
		$file->setFlags(SplFileObject::READ_CSV);
		foreach($file as $line){
			if(!is_null($line[0])){
				array_push($records, array(
					"document_id" => mb_convert_kana($line[0],'kvrn'),
					"organization_ja" => mb_convert_kana($line[1],'kvrn'),
					"organization_or" => mb_convert_kana($line[2],'kvrn'),
					"collection_location_no" => mb_convert_kana($line[3],'kvrn'),
					"project_id" => mb_convert_kana($line[4],'kvrn'),
					"location_shelf" => mb_convert_kana($line[5],'kvrn'),
					"location_no" => mb_convert_kana($line[6],'kvrn'),
					"title_ja" => mb_convert_kana($line[7],'kvrn'),
					"title_en" => mb_convert_kana($line[8],'kvrn'),
					"title_or" => mb_convert_kana($line[9],'kvrn'),
					"type" => mb_convert_kana($line[10],'kvrn'),
					"author" => mb_convert_kana($line[11],'kvrn'),
					"time_age" => mb_convert_kana($line[12],'kvrn'),
					"time_cen" => explode("-", mb_convert_kana($line[13],'kvrn')),
					"time_ad" => mb_convert_kana($line[14],'kvrn'),
					"time_ja" => mb_convert_kana($line[15],'kvrn'),
					"space" => explode("、",mb_convert_kana($line[16],'kvrn')),
					"count" => mb_convert_kana($line[17],'kvrn'),
					"depth" => mb_convert_kana($line[18],'kvrn'),
					"width" => mb_convert_kana($line[19],'kvrn'),
					"height" => mb_convert_kana($line[20],'kvrn'),
					"total_height" => mb_convert_kana($line[21],'kvrn'),
					"diameter" => mb_convert_kana($line[22],'kvrn'),
					"caliber" => mb_convert_kana($line[23],'kvrn'),
					"hill_diameter" => mb_convert_kana($line[24],'kvrn'),
					"thickness" => mb_convert_kana($line[25],'kvrn'),
					"shape" => mb_convert_kana($line[26],'kvrn'),
					"material" => explode("、", mb_convert_kana($line[27],'kvrn')),
					"technique" => explode("、", mb_convert_kana($line[28],'kvrn')),
					"pattern" => explode("、", mb_convert_kana($line[29],'kvrn')),
					"stamp" => mb_convert_kana($line[30],'kvrn'),
					"publisher" => mb_convert_kana($line[31],'kvrn'),
					"accesory" => explode("、", mb_convert_kana($line[32],'kvrn')),
					"collector_ja" => mb_convert_kana($line[33],'kvrn'),
					"collector_or" => mb_convert_kana($line[34],'kvrn'),
					"collected_period" => mb_convert_kana($line[35],'kvrn'),
					"collected_place" => mb_convert_kana($line[36],'kvrn'),
					"collection_method" => mb_convert_kana($line[37],'kvrn'),
					"collection_index_no" => mb_convert_kana($line[38],'kvrn'),
					"collection_description_ja" => str_replace("  ", "", mb_convert_kana($line[39],'kvrn')),
					"collection_description_or" => str_replace("  ", " ", mb_convert_kana($line[40],'kvrn')),
					"researcher" => explode(":", mb_convert_kana($line[41],'kvrn')),
					"researched_date" => explode(":", mb_convert_kana($line[42],'kvrn')),
					"photographer" => explode(":", mb_convert_kana($line[43],'kvrn')),
					"historical_document" => mb_convert_kana($line[44],'kvrn'),
					"relation_document" => mb_convert_kana($line[45],'kvrn'),
					"note_1" => mb_convert_kana($line[46],'kvrn'),
					"note_2" => mb_convert_kana($line[47],'kvrn'),
					"p" => mb_convert_kana($line[48],'kvrn'),
					"volume" => mb_convert_kana($line[49],'kvrn'),
					"s_no" => mb_convert_kana($line[50],'kvrn'),
					"branch_no" => mb_convert_kana($line[51],'kvrn')
				));
			}
		}
		foreach( $records as $record ){
			echo "INSERT > collector                       : ";
			$table = "collectors";
			$key_id = "collector_id";
			$keys = array("name_ja","name_original");
			$vals = array($record["collector_ja"],$record["collector_or"]);
			$collector_id = insertItem( $pdo, $table, $key_id, $keys, $vals );

			echo "INSERT > organization                    : ";
			$table = "organizations";
			$key_id = "organization_id";
			$keys = array("name_ja","name_original");
			$vals = array($record["organization_ja"],$record["organization_or"]);
			$organization_id = insertItem( $pdo, $table, $key_id, $keys, $vals );

			echo "INSERT > document                        : ";
			$table = "documents";
			$key_id = "document_id";
			$keys = array(
				"document_id",
				"organization_id",
				"collection_location_no",
				"project_id",
				"location_shelf",
				"location_no",
				"p",
				"volume",
				"s_no",
				"branch_no",
				"title_ja",
				"title_en",
				"ad",
				"collector_id",
				"period",
				"location",
				"method",
				"collection_index_no",
				"description_ja",
				"description_original",
				"depth",
				"width",
				"height",
				"total_height",
				"diameter",
				"caliber",
				"hill_diameter",
				"thickness",
				"count");
			$vals = array(
				$record["document_id"],
				$organization_id,
				$record["collection_location_no"],
				$record["project_id"],
				$record["location_shelf"],
				$record["location_no"],
				$record["p"],
				$record["volume"],
				$record["s_no"],
				$record["branch_no"],
				$record["title_ja"],
				$record["title_en"],
				$record["time_ad"],
				$collector_id,
				$record["collected_period"],
				$record["collected_place"],
				$record["collection_method"],
				$record["collection_index_no"],
				$record["collection_description_ja"],
				$record["collection_description_or"],
				$record["depth"],
				$record["width"],
				$record["height"],
				$record["total_height"],
				$record["diameter"],
				$record["caliber"],
				$record["hill_diameter"],
				$record["thickness"],
				$record["count"]);
			$document_id = insertItemImportant( $pdo, $table, $key_id, $keys, $vals );
			$document_id = $record["document_id"];
			if( $document_id == "" ) continue;

			echo "INSERT > type                            : ";
			$table = "types";
			$key_id = "type_id";
			$keys = array("name","class");
			$vals = array($record["type"],"document_type");
			$type_id = insertItem( $pdo, $table, $key_id, $keys, $vals );
			if( $type_id != "" ){
				echo "INSERT > types_relationships             : ";
				$table = "types_relationships";
				$key_id = "types_relationships_id";
				$keys = array("document_id","type_id");
				$vals = array($document_id,$type_id);
				$id = insertItem( $pdo, $table, $key_id, $keys, $vals );
			}

			foreach( $record["technique"] as $technique ){
				echo "INSERT > technique                       : ";
				$table = "types";
				$key_id = "type_id";
				$keys = array("name","class");
				$vals = array($technique,"technique");
				$type_id = insertItem( $pdo, $table, $key_id, $keys, $vals );
				if( $type_id != "" ){
					echo "INSERT > types_relationships             : ";
					$table = "types_relationships";
					$key_id = "types_relationships_id";
					$keys = array("document_id","type_id");
					$vals = array($document_id,$type_id);
					$id = insertItem( $pdo, $table, $key_id, $keys, $vals );
				}
			}

			foreach( $record["pattern"] as $pattern ){
				echo "INSERT > pattern                         : ";
				$table = "types";
				$key_id = "type_id";
				$keys = array("name","class");
				$vals = array($pattern,"pattern");
				$type_id = insertItem( $pdo, $table, $key_id, $keys, $vals );
				if( $type_id != "" ){
					echo "INSERT > types_relationships             : ";
					$table = "types_relationships";
					$key_id = "types_relationships_id";
					$keys = array("document_id","type_id");
					$vals = array($document_id,$type_id);
					$id = insertItem( $pdo, $table, $key_id, $keys, $vals );
				}
			}

			foreach( $record["space"] as $space ){
				$part="all";
				if( strpos($space,"：") !== false ){
					$part = explode("：", $space)[0];
					$space = explode("：", $space)[1];
				}else if( strpos($space,":") !== false ){
					$part = explode(":", $space)[0];
					$space = explode(":", $space)[1];
				}
				echo "INSERT > space                           : ";
				$table = "spaces";
				$key_id = "space_id";
				$keys = array("name");
				$vals = array($space);
				$space_id = insertItem( $pdo, $table, $key_id, $keys, $vals );
				if( $space_id != "" ){
					echo "INSERT > spaces_relationships            : ";
					$table = "spaces_relationships";
					$key_id = "spaces_relationships_id";
					$keys = array("document_id","space_id","part");
					$vals = array($document_id,$space_id,$part);
					$id = insertItem( $pdo, $table, $key_id, $keys, $vals );
				}
			}
			echo "INSERT > temporal                        : ";
			$table = "temporals";
			$key_id = "temporal_id";
			$keys = array("name","class");
			$vals = array($record["time_age"],"age");
			$temporal_id = insertItem( $pdo, $table, $key_id, $keys, $vals );
			if( $temporal_id != "" ){
				echo "INSERT > temporals_relationships         : ";
				$table = "temporals_relationships";
				$key_id = "temporals_relationships_id";
				$keys = array("document_id","temporal_id");
				$vals = array($document_id,$temporal_id);
				$id = insertItem( $pdo, $table, $key_id, $keys, $vals );
			}

			echo "INSERT > temporal                        : ";
			$table = "temporals";
			$key_id = "temporal_id";
			$keys = array("name","class");
			$vals = array($record["time_ja"],"calender_ja");
			$temporal_id = insertItem( $pdo, $table, $key_id, $keys, $vals );
			if( $temporal_id != "" ){
				echo "INSERT > temporals_relationships         : ";
				$table = "temporals_relationships";
				$key_id = "temporals_relationships_id";
				$keys = array("document_id","temporal_id");
				$vals = array($document_id,$temporal_id);
				$id = insertItem( $pdo, $table, $key_id, $keys, $vals );
			}

			foreach( $record["time_cen"] as $cen ){
				$cen = str_replace("c", "", $cen);
				$cen = str_replace("世紀", "", $cen);
				echo "INSERT > temporal                        : ";
				$table = "temporals";
				$key_id = "temporal_id";
				$keys = array("name","class");
				$vals = array($cen,"century");
				$temporal_id = insertItem( $pdo, $table, $key_id, $keys, $vals );
				if( $temporal_id != "" ){
					echo "INSERT > temporals_relationships         : ";
					$table = "temporals_relationships";
					$key_id = "temporals_relationships_id";
					$keys = array("document_id","temporal_id");
					$vals = array($document_id,$temporal_id);
					$id = insertItem( $pdo, $table, $key_id, $keys, $vals );
				}
			}
			echo "INSERT > creator                         : ";
			$table = "creators";
			$key_id = "creator_id";
			$keys = array("name_ja","class");
			$vals = array($record["author"],"author");
			$creator_id = insertItem( $pdo, $table, $key_id, $keys, $vals );
			if( $creator_id != "" ){
				echo "INSERT > creators_relationships          : ";
				$table = "creators_relationships";
				$key_id = "creators_relationships_id";
				$keys = array("document_id","creator_id");
				$vals = array($document_id,$creator_id);
				$id = insertItem( $pdo, $table, $key_id, $keys, $vals );
			}

			echo "INSERT > creator                         : ";
			$table = "creators";
			$key_id = "creator_id";
			$keys = array("name_ja","class");
			$vals = array($record["publisher"],"publisher");
			$creator_id = insertItem( $pdo, $table, $key_id, $keys, $vals );
			if( $creator_id != "" ){
				echo "INSERT > creators_relationships          : ";
				$table = "creators_relationships";
				$key_id = "creators_relationships_id";
				$keys = array("document_id","creator_id");
				$vals = array($document_id,$creator_id);
				$id = insertItem( $pdo, $table, $key_id, $keys, $vals );
			}

			echo "INSERT > shape                           : ";
			$table = "properties";
			$key_id = "property_id";
			$keys = array("name","class");
			$vals = array($record["shape"],"shape");
			$property_id = insertItem( $pdo, $table, $key_id, $keys, $vals );
			if( $property_id != "" ){
				echo "INSERT > shape_relationship              : ";
				$table = "properties_relationships";
				$key_id = "properties_relationships_id";
				$keys = array("document_id","property_id");
				$vals = array($document_id,$property_id);
				$id = insertItem( $pdo, $table, $key_id, $keys, $vals );
			}

			foreach( $record["material"] as $material ){
				echo "INSERT > material                        : ";
				$table = "properties";
				$key_id = "property_id";
				$keys = array("name","class");
				$vals = array($material,"material");
				$property_id = insertItem( $pdo, $table, $key_id, $keys, $vals );
				if( $property_id != "" ){
					echo "INSERT > material_relationship           : ";
					$table = "properties_relationships";
					$key_id = "properties_relationships_id";
					$keys = array("document_id","property_id");
					$vals = array($document_id,$property_id);
					$id = insertItem( $pdo, $table, $key_id, $keys, $vals );
				}
			}
			echo "INSERT > stamp                           : ";
			$table = "descriptions";
			$key_id = "description_id";
			$keys = array("content","class");
			$vals = array($record["stamp"],"stamp");
			$stamp_id = insertItem( $pdo, $table, $key_id, $keys, $vals );
			if( $stamp_id != "" ){
				echo "INSERT > stamp_relationship              : ";
				$table = "descriptions_relationships";
				$key_id = "descriptions_relationships_id";
				$keys = array("document_id","description_id");
				$vals = array($document_id,$stamp_id);
				$id = insertItem( $pdo, $table, $key_id, $keys, $vals );
			}
			foreach( $record["accesory"] as $accesory ){
				echo "INSERT > accesory                        : ";
				$table = "descriptions";
				$key_id = "description_id";
				$keys = array("content","class");
				$vals = array($accesory,"accesory");
				$accesory_id = insertItem( $pdo, $table, $key_id, $keys, $vals );
				if( $accesory_id != "" ){
					echo "INSERT > accesory_relationship           : ";
					$table = "descriptions_relationships";
					$key_id = "descriptions_relationships_id";
					$keys = array("document_id","description_id");
					$vals = array($document_id,$accesory_id);
					$id = insertItem( $pdo, $table, $key_id, $keys, $vals );
				}
			}
			echo "INSERT > note                            : ";
			$table = "descriptions";
			$key_id = "description_id";
			$keys = array("content","class");
			$vals = array($record["note_1"],"note");
			$note_id = insertItem( $pdo, $table, $key_id, $keys, $vals );
			if( $note_id != "" ){
				echo "INSERT > note_relationship               : ";
				$table = "descriptions_relationships";
				$key_id = "descriptions_relationships_id";
				$keys = array("document_id","description_id");
				$vals = array($document_id,$note_id);
				$id = insertItem( $pdo, $table, $key_id, $keys, $vals );
			}
			echo "INSERT > note                            : ";
			$table = "descriptions";
			$key_id = "description_id";
			$keys = array("content","class");
			$vals = array($record["note_2"],"note");
			$note_id = insertItem( $pdo, $table, $key_id, $keys, $vals );
			if( $note_id != "" ){
				echo "INSERT > note_relationship               : ";
				$table = "descriptions_relationships";
				$key_id = "descriptions_relationships_id";
				$keys = array("document_id","description_id");
				$vals = array($document_id,$note_id);
				$id = insertItem( $pdo, $table, $key_id, $keys, $vals );
			}

			echo "INSERT > historical_document             : ";
			$table = "relations";
			$key_id = "relation_id";
			$keys = array("content","class");
			$vals = array($record["historical_document"],"historical_document");
			$historical_document_id = insertItem( $pdo, $table, $key_id, $keys, $vals );
			if( $historical_document_id != "" ){
				echo "INSERT > historical_document_relationship: ";
				$table = "relations_relationships";
				$key_id = "relations_relationships_id";
				$keys = array("document_id","relation_id");
				$vals = array($document_id,$historical_document_id);
				$id = insertItem( $pdo, $table, $key_id, $keys, $vals );
			}
			echo "INSERT > relation_document               : ";
			$table = "relations";
			$key_id = "relation_id";
			$keys = array("content","class");
			$vals = array($record["relation_document"],"historical_document");
			$relation_document_id = insertItem( $pdo, $table, $key_id, $keys, $vals );
			if( $relation_document_id != "" ){
				echo "INSERT > relation_document_relationship  : ";
				$table = "relations_relationships";
				$key_id = "relations_relationships_id";
				$keys = array("document_id","relation_id");
				$vals = array($document_id,$relation_document_id);
				$id = insertItem( $pdo, $table, $key_id, $keys, $vals );
			}

			$date_ids = array();
			foreach( $record["researched_date"] as $date ){
				echo "INSERT > researched_date                 : ";
				$table = "research_dates";
				$key_id = "research_date_id";
				$keys = array("document_id","date");
				$date = str_replace("/", "-", $date);
				if( count(explode("-", $date))<3 ){
					$date.="-00";
				}
				$vals = array($document_id, $date);
				$id = insertItem( $pdo, $table, $key_id, $keys, $vals );
				if( $id != "" ){
					array_push( $date_ids, $id );
				}
			}
			foreach( $record["researcher"] as $researcher ){
				echo "INSERT > researcher                      : ";
				$table = "researchers";
				$key_id = "researcher_id";
				$keys = array("name");
				$vals = array($researcher);
				$researcher_id = insertItem( $pdo, $table, $key_id, $keys, $vals );
				if( $researcher_id != "" ){
					echo "INSERT > researchers_roles               : ";
					$table = "researchers_roles";
					$key_id = "role_id";
					$keys = array("researcher_id","class");
					$vals = array($researcher_id,"researcher");
					$roll_id = insertItem( $pdo, $table, $key_id, $keys, $vals );
					foreach( $date_ids as $date_id ){
						echo "INSERT > researchers_roles_relationships : ";
						$table = "researchers_roles_relationships";
						$key_id = "researchers_roles_relationships_id";
						$keys = array("research_date_id","role_id");
						$vals = array($date_id,$roll_id);
						$id = insertItem( $pdo, $table, $key_id, $keys, $vals );
					}
				}
			}
			foreach( $record["photographer"] as $photographer ){
				echo "INSERT > photographer                    : ";
				$table = "researchers";
				$key_id = "researcher_id";
				$keys = array("name");
				$vals = array($photographer);
				$researcher_id = insertItem( $pdo, $table, $key_id, $keys, $vals );
				if( $researcher_id != "" ){
					echo "INSERT > researchers_roles               : ";
					$table = "researchers_roles";
					$key_id = "role_id";
					$keys = array("researcher_id","class");
					$vals = array($researcher_id,"photographer");
					$roll_id = insertItem( $pdo, $table, $key_id, $keys, $vals );
					foreach( $date_ids as $date_id ){
						echo "INSERT > researchers_roles_relationships : ";
						$table = "researchers_roles_relationships";
						$key_id = "researchers_roles_relationships_id";
						$keys = array("research_date_id","role_id");
						$vals = array($date_id,$roll_id);
						$id = insertItem( $pdo, $table, $key_id, $keys, $vals );
					}
				}
			}
		}
	}
?>