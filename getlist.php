<?php
	include_once("maincore.php");
	include_once("dbconfig.php");
	$cdate="";
	if (isset($_GET['d'])) {
		$cdate=$_GET['d'];
	}
	//mysql_query("insert into f_ajax_calls (func,params,moment) value ('getlist','$cdate',NOW());");
	if (strlen($cdate)<8) {
		$sql="select p_value from f_params where p_name='currentdate' limit 1;";
		$result = mysql_query($sql);
		if ($row=mysql_fetch_array($result)) {
			$cdate=$row['p_value'];
		} else
			$cdate= date("Y-n-d")."";
	}
	//else $cdate=$_GET['d'];
	
	$sql = "SELECT * FROM f_matches where viewdate='".$cdate."' order by `order`";
	//echo $sql;
	$result = mysql_query($sql);
	$list = array();
	$leagues = array();
	$str_league="";
	while ($row = mysql_fetch_array($result)) {
		/**/
		if (strpos($str_league,'"'.$row['league_id'].'"')===false) {
			$str_league.='"'.$row['league_id'].'",';
		}
		//if ($row['status']>0)
		$t=array(
			"id" => $row['match_id']."",
			"lg" => $row['league_id']."",
			"gr" => $row['group']."",
			"ht" => $row['hteam']."",
			"at" => $row['ateam']."",
			"hg" => $row['hgoals']."",
			"ag" => $row['agoals']."",
			"hg1" => $row['h1goals']."",
			"ag1" => $row['a1goals']."",
			"hr" => $row['hreds']."",
			"ar" => $row['areds']."",
			"hy" => $row['hyellows']."",
			"ay" => $row['ayellows']."",
			"hs" => $row['hshots']."",
			"as" => $row['ashots']."",
			"hgs" => $row['hgshots']."",
			"ags" => $row['agshots']."",
			"hc" => $row['hcorner']."",
			"ac" => $row['acorner']."",
			"hpo" => $row['hpossession']."",
			"apo" => $row['apossession']."",
			"st" => $row['status']."",
			"mi" => $row['minutes']."",
			"da" => $row['match_date']);
		
		array_push($list,$t);
	}
	//
	$str_league=substr($str_league,0,strlen($str_league)-1);
	//lecho $str_league."<br/>";
	$sql = "Select * from f_leagues2 where league_id in (".$str_league.")";
	//echo $sql;
	$result = mysql_query($sql);
	while ($row=mysql_fetch_array($result)) {
		//array_push($leagues,array($row['league_id'] => $row['league_name']));
		array_push($leagues[$row['league_id']]= $row['league_name']);
	}
	
	//echo $list."<br/>".$leagues;
	
	echo json_encode(array("matches"=>$list,"leagues" => $leagues,"date" => $cdate));

?>

