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
	echo post_match($m);
	//post a match
	function post_match($match_id) {
		$match = get_match($match_id);
		$post_id=0;
		if ($match!="") {
			$hteam = get_team($match['hteam']);
			$ateam = get_team($match['ateam']);
			$league = get_league($match['league_id']);
			$mdate = substr($match['match_date'],0,10);
			if (($hteam!="")&&($ateam!="")) {
				$title="Football betting alert - ".$hteam['team_name']." (".$hteam['team_pos'].") v ".$ateam['team_name']." (".$ateam['team_pos'].")";
				//$slug="match-".$match_id."-".date("Y-m-d");
				$slug=make_post_slug($title);
				$content="<table>";
				//Add basic infos
				$content.="<tr><td>".$match['minutes']."'</td><td style='text-align: center;'>".$hteam['team_name']."</td><td style='text-align: center;'>-</td><td style='text-align: center;'>".$ateam['team_name']."</td></tr>";
				$content.="<tr><td>Score</td><td style='text-align: center;'>".$match['hgoals']."</td><td style='text-align: center;'>-</td><td style='text-align: center;'>".$match['agoals']."</td></tr>";
				$content.="<tr><td>Score in 1st</td><td style='text-align: center;'>".$match['h1goals']."</td><td style='text-align: center;'>-</td><td style='text-align: center;'>".$match['a1goals']."</td></tr>";
				$content.="<tr><td>Yellow cards</td><td style='text-align: center;'>".$match['hyellows']."</td><td style='text-align: center;'>-</td><td style='text-align: center;'>".$match['ayellows']."</td></tr>";
				$content.="<tr><td>Red cards</td><td style='text-align: center;'>".$match['hreds']."</td><td style='text-align: center;'>-</td><td style='text-align: center;'>".$match['areds']."</td></tr>";
				$content.="<tr><td>Shots</td><td style='text-align: center;'>".$match['hshots']."</td><td style='text-align: center;'>-</td><td style='text-align: center;'>".$match['ashots']."</td></tr>";
				$content.="<tr><td>Shots on goal</td><td style='text-align: center;'>".$match['hgshots']."</td><td style='text-align: center;'>-</td><td style='text-align: center;'>".$match['agshots']."</td></tr>";
				$content.="<tr><td>Corner kick</td><td style='text-align: center;'>".$match['hcorner']."</td><td style='text-align: center;'>-</td><td style='text-align: center;'>".$match['acorner']."</td></tr>";
				$content.="<tr><td>Time of possession</td><td style='text-align: center;'>".$match['hpossession']."</td><td style='text-align: center;'>-</td><td style='text-align: center;'>".$match['apossession']."</td></tr>";
				//Add %WDLFA
				$s1=$hteam['team_hw']+$hteam['team_hd']+$hteam['team_hl'];
				$s2=$ateam['team_aw']+$ateam['team_ad']+$ateam['team_al'];;
				$content.="<tr><td>% W</td><td style='text-align: center;'>".div0($hteam['team_hw']*100,$hteam['team_op'],0,0)."</td><td style='text-align: center;'>-</td><td style='text-align: center;'>".div0($ateam['team_aw']*100,$ateam['team_op'],0,0)."</td></tr>";
				$content.="<tr><td>% D</td><td style='text-align: center;'>".div0($hteam['team_hd']*100,$hteam['team_op'],0,0)."</td><td style='text-align: center;'>-</td><td style='text-align: center;'>".div0($ateam['team_ad']*100,$ateam['team_op'],0,0)."</td></tr>";
				$content.="<tr><td>% L</td><td style='text-align: center;'>".div0($hteam['team_hl']*100,$hteam['team_op'],0,0)."</td><td style='text-align: center;'>-</td><td style='text-align: center;'>".div0($ateam['team_al']*100,$ateam['team_op'],0,0)."</td></tr>";
				$content.="<tr><td>% F</td><td style='text-align: center;'>".div0($hteam['team_hf'],$s1,1,0)."</td><td style='text-align: center;'>-</td><td style='text-align: center;'>".div0($ateam['team_af'],$s2,1,0)."</td></tr>";
				$content.="<tr><td>% A</td><td style='text-align: center;'>".div0($hteam['team_ha'],$s1,1,0)."</td><td style='text-align: center;'>-</td><td style='text-align: center;'>".div0($ateam['team_aa'],$s2,1,0)."</td></tr>";
				
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
				
				
			}
			
		}
		return $post_id;
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
		$sql="INSERT INTO `wp_posts` (`post_author`,`post_date`,`post_date_gmt`,`post_content`,`post_title`,`post_excerpt`,`post_status`,`comment_status`,`ping_status`,`post_password`,`post_name`,`to_ping`,`pinged`,`post_modified`,`post_modified_gmt`,`post_content_filtered`,`post_parent`,`guid`,`menu_order`,`post_type`,`post_mime_type`,`comment_count`) VALUES ('1','$today','$today','".mysql_real_escape_string($content)."','$title','','draft','open','open','','$slug','','','$today','$today','','0','','0','post','','0');";
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
function div0($a,$b,$n=0,$d=0) {
	if (is_nan($a))  return $d;
	if (is_nan($b))  return $d;
	if ($b==0) return $d;
	return round($a/$b,$n);
}
function slugify0($str) {
	$table = array(
        'Š'=>'S', 'š'=>'s',
		'Đ'=>'Dj', 'đ'=>'dj',
		'Ž'=>'Z', 'ž'=>'z',
		'Č'=>'C', 'č'=>'c',
		'Ć'=>'C', 'ć'=>'c',
        'À'=>'A',
		'Á'=>'A', 'á'=>'a',
		'Â'=>'A', 'â'=>'a',
		'Ã'=>'A', 'ã'=>'a',
		'Ä'=>'A', 'ä'=>'a',
		'Å'=>'A',
		'Æ'=>'A',
		'Ç'=>'C',
		'È'=>'E',
		'É'=>'E',
        'Ê'=>'E',
		'Ë'=>'E',
		'Ì'=>'I',
		'Í'=>'I',
		'Î'=>'I',
		'Ï'=>'I',
		'Ñ'=>'N',
		'Ò'=>'O',
		'Ó'=>'O',
		'Ô'=>'O',
        'Õ'=>'O',
		'Ö'=>'O',
		'Ø'=>'O',
		'Ù'=>'U',
		'Ú'=>'U',
		'Û'=>'U',
		'Ü'=>'U',
		'Ý'=>'Y',
		'Þ'=>'B',
		'ß'=>'Ss',
        'à'=>'a',
		
		'å'=>'a', 
		'æ'=>'a', 
		'ç'=>'c', 
		'è'=>'e', 
		'é'=>'e',
        'ê'=>'e', 
		'ë'=>'e', 
		'ì'=>'i', 
		'í'=>'i', 
		'î'=>'i', 
		'ï'=>'i', 
		'ð'=>'o', 
		'ñ'=>'n', 
		'ò'=>'o', 
		'ó'=>'o',
        'ô'=>'o', 
		'õ'=>'o', 
		'ö'=>'o', 
		'ø'=>'o', 
		'ù'=>'u', 
		'ú'=>'u', 
		'û'=>'u', 
		'ý'=>'y', 
		'ý'=>'y', 
		'þ'=>'b',
        'ÿ'=>'y', 
		'Ŕ'=>'R', 
		'ŕ'=>'r'
    );
	return strtr($str,$table);
}
function slugify($str, $delimiter='-') {
	$clean = slugify0($str);
	if (function_exists('iconv'))
	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $clean);
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	return $clean;
}
function make_post_slug($bname) {
	$slug = slugify($bname);
	$noi="-";
	while (true) {
		$sql = "select guid from wp_post where guid='$slug' limit 1";
		$result = mysql_query($sql);
		if (mysql_num_rows($result)) {
			$slug.=$noi.chr(rand(48,57));
			$noi="";
		} else {
			break;
		}
	}
	return $slug;
}
?>

