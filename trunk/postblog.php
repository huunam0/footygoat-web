<?php
	include_once("maincore.php");
	include_once("dbconfig.php");
	if (!isset($_GET['m'])) die("khong co tham so");
	$m = $_GET['m'];
	
	
	
	
	
	//$post_id = insert_post($title,$content,$slug);
	//echo add_post_category($post_id,"Chealsea");
	//echo add_post_category($post_id,"Man");
	//echo add_post_tag($post_id,"Chelsea");
	//echo add_post_tag($post_id,"Man");
	//echo lookup_info("f_matches","hteam","match_id=334630");
	post_match($m);
	//post a match
	function post_match($match_id) {
		$match = get_match($match_id);
		if ($match!="") {
			$hteam = get_team($match['hteam']);
			$ateam = get_team($match['ateam']);
			$league = get_league($match['league_id']);
			$mdate = substr($match['match_date'],0,10);
			if (($hteam!="")&&($ateam!="")) {
				$title="Football betting alert - ".$hteam['team_name']." (".$hteam['team_pos'].") v (".$ateam['team_pos'].") ".$ateam['team_name']."";
				$slug="match-".$match_id."-".date("Y-m-d");
				$content="<table>";
				$content.="<tr><td>".$match['minutes']."'</td><td align='right'>".$hteam['team_name']."</td><td>-</td><td>".$ateam['team_name']."</td></tr>";
				$content.="<tr><td>Score</td><td align='right'>".$match['hgoals']."</td><td>-</td><td>".$match['agoals']."</td></tr>";
				$content.="<tr><td>Score in 1st</td><td align='right'>".$match['h1goals']."</td><td>-</td><td>".$match['a1goals']."</td></tr>";
				$content.="<tr><td>Yellow cards</td><td align='right'>".$match['hyellows']."</td><td>-</td><td>".$match['ayellows']."</td></tr>";
				$content.="<tr><td>Red cards</td><td align='right'>".$match['hreds']."</td><td>-</td><td>".$match['areds']."</td></tr>";
				$content.="<tr><td>Shots</td><td align='right'>".$match['hshots']."</td><td>-</td><td>".$match['ashots']."</td></tr>";
				$content.="<tr><td>Shots on goal</td><td align='right'>".$match['hgshots']."</td><td>-</td><td>".$match['agshots']."</td></tr>";
				$content.="<tr><td>Corner kick</td><td align='right'>".$match['hcorner']."</td><td>-</td><td>".$match['acorner']."</td></tr>";
				$content.="<tr><td>Time of possession</td><td align='right'>".$match['hpossession']."</td><td>-</td><td>".$match['apossession']."</td></tr>";
				$content.="</table>";
				$post_id=insert_post($title,$content,$slug);
				if ($post_id) {
					add_post_category($post_id,$hteam['team_name']);
					add_post_category($post_id,$ateam['team_name']);
					add_post_category($post_id,$league['league_name']);
					//add_post_category($post_id,$mdate);
					
					add_post_tag($post_id,$hteam['team_name']);
					add_post_tag($post_id,$ateam['team_name']);
					add_post_tag($post_id,$league['league_name']);
					add_post_tag($post_id,$hteam['team_name']." vs ".$ateam['team_name']);
					//add_post_tag($post_id,$hteam['team_name']." vs ".$ateam['team_name']." ".$mdate);
					//add_post_tag($post_id,$mdate);
					
				}
				
				return true;
			}
			
		}
		return false;
	}
	//lookup infos
	function lookup_info($table, $field, $condition='') {
		if ($condition)
			$sql="select $field from $table where $condition";
		else
			$sql="select $field from $table";
		$sql.=" limit 1";
		$result=mysql_query($sql);
		if ($result) {
			if ($data=mysql_fetch_array($result)) {
				return $data[$field];
			} else {
				return "";
			}
		} else {
			return "";
		}
	}
	function get_league($league_id) {
		$sql="select * from f_leagues where league_id='$league_id' limit 1";
		$result=mysql_query($sql);
		if ($result) {
			if ($data=mysql_fetch_array($result)) {
				return $data;
			} else {
				return "";
			}
		} else {
			return "";
		}
	}
	function get_team($team_id) {
		$sql="select * from f_teams where team_id=$team_id limit 1";
		$result=mysql_query($sql);
		if ($result) {
			if ($data=mysql_fetch_array($result)) {
				return $data;
			} else {
				return "";
			}
		} else {
			return "";
		}
	}
	function get_match($match_id) {
		$sql="select * from f_matches where match_id=$match_id limit 1";
		$result=mysql_query($sql);
		if ($result) {
			if ($data=mysql_fetch_array($result)) {
				return $data;
			} else {
				return "";
			}
		} else {
			return "";
		}
	}
	//post
	function insert_post($title,$content,$slug='') {
		$today = date("Y-m-d H:i:s");
		$sql="INSERT INTO `wp_posts` (`post_author`,`post_date`,`post_date_gmt`,`post_content`,`post_title`,`post_excerpt`,`post_status`,`comment_status`,`ping_status`,`post_password`,`post_name`,`to_ping`,`pinged`,`post_modified`,`post_modified_gmt`,`post_content_filtered`,`post_parent`,`guid`,`menu_order`,`post_type`,`post_mime_type`,`comment_count`) VALUES ('1','$today','$today','".mysql_real_escape_string($content)."','$title','','publish','open','open','','$slug','','','$today','$today','','0','','0','post','','0');";
		//echo $sql;
		$post_id=0;
		$result = mysql_query($sql);
		if ($result) {
			$post_id= mysql_insert_id();
			$sql = "update wp_posts set guid='http://footygoat.com/blog/?p=.$post_id.' where ID=$post_id;";
			$result = mysql_query($sql);
		}
		return $post_id;
	}
	//insert category
	function insert_term($term_name,$term_type,$slug='') { //$term_type = category or post_tag
		$sql="select * from `wp_terms` where `name`='$term_name'";
		$result = mysql_query($sql);
		if (mysql_num_rows($result)) {
			//echo $sql;
			$data=mysql_fetch_array($result);
			$cat_id=$data['term_id'];
		} else {
			$sql="INSERT INTO `wp_terms` (`name`,`slug`,`term_group`) VALUES ('$term_name','$slug','0');";
			$result = mysql_query($sql);
			$cat_id= mysql_insert_id();
			//echo $sql;
		}
		$sql="select * from `wp_term_taxonomy` where `term_id`='$cat_id' and `taxonomy`='$term_type'";
		$result = mysql_query($sql);
		if (mysql_num_rows($result)) {
			$data=mysql_fetch_array($result);
			$tt_id=$data['term_taxonomy_id'];
		} else {
			$sql="INSERT INTO `wp_term_taxonomy` (`term_id`,`taxonomy`,`description`,`parent`,`count`) VALUES ('$cat_id','$term_type','','0','1');";
			$result = mysql_query($sql);
			$tt_id= mysql_insert_id();
		}
		//echo "tt$tt_id<br/>";
		return  $tt_id;
	}
	function get_term($term_name,$term_type) { //$term_type = category or post_tag
		$sql="SELECT term_taxonomy_id,taxonomy FROM wp_term_taxonomy JOIN wp_terms USING (term_id) WHERE wp_term_taxonomy.taxonomy='$term_type' AND wp_terms.name='$term_name'";
		$result = mysql_query($sql);
		$cat_id=0;
		if ($data=mysql_fetch_array($result)) {
			$cat_id=$data['term_taxonomy_id'];
		}
		return $cat_id;
	}
	function add_term_to_post($post_id,$term_name,$term_type) {
		$slug=str_replace(" ","-",$term_name);
		$term_id=insert_term($term_name,$term_type,$slug);
		//echo "tt: $term_id<br/>";
		if ($term_id) {
			$sql="INSERT IGNORE INTO `wp_term_relationships` (`object_id`,`term_taxonomy_id`,`term_order`) VALUES ('$post_id','$term_id','0');";
			$result = mysql_query($sql);
			return mysql_insert_id();
		}
		return 0;
	}
	function add_post_category($post_id,$cat_name) {
		return add_term_to_post($post_id,$cat_name,'category');
	}
	function add_post_tag($post_id,$tag_name) {
		return add_term_to_post($post_id,$tag_name,'post_tag');
	}
?>

