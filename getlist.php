<?php
	include_once("maincore.php");
	include_once("dbconfig.php");
	if (!isset($_GET['d'])) {
		$cdate=date("Y-m-d");
		if (date("H")<="06") {
			$cdate = date("Y-m-d", strtotime($cdate)-86400);
		}
	}
	else $cdate=$_GET['d'];
	$ndate = date("Y-m-d", strtotime($cdate)+86400);
	//echo $cdate."/".$ndate;
	$sql = "SELECT * FROM f_matches where match_date between '$cdate 6:01:00' and '$ndate 6:00:00' order by `order`";
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
		if ($row['status']>0)
		$t=array(
			"id" => $row['match_id'],
			"lg" => $row['league_id'],
			"gr" => $row['group'],
			"ht" => $row['hteam'],
			"at" => $row['ateam'],
			"hg" => $row['hgoals'],
			"ag" => $row['agoals'],
			"hg1" => $row['h1goals'],
			"ag1" => $row['a1goals'],
			"hr" => $row['hreds'],
			"ar" => $row['areds'],
			"hy" => $row['hyellows'],
			"ay" => $row['ayellows'],
			"hs" => $row['hshots'],
			"as" => $row['ashots'],
			"hgs" => $row['hgshots'],
			"ags" => $row['agshots'],
			"hc" => $row['hcorner'],
			"ac" => $row['acorner'],
			"hpo" => $row['hpossession'],
			"apo" => $row['apossession'],
			"st" => $row['status'],
			"mi" => ($row['status']>=7?"":$row['minutes']),
			"da" => $row['match_date']);
		else
		$t=array(
			"id" => $row['match_id'],
			"lg" => $row['league_id'],
			"gr" => $row['group'],
			"ht" => $row['hteam'],
			"at" => $row['ateam'],
			"hg" => "",
			"ag" => "",
			"hg1" => "",
			"ag1" => "",
			"hr" => "",
			"ar" => "",
			"hy" => "",
			"ay" => "",
			"hs" => "",
			"as" => "",
			"hgs" => "",
			"ags" => "",
			"hc" => "",
			"ac" => "",
			"hpo" => "",
			"apo" => "",
			"st" => $row['status'],
			"mi" => "",
			"da" => $row['match_date']);
		array_push($list,$t);
	}
	//
	$str_league=substr($str_league,0,strlen($str_league)-1);
	//lecho $str_league."<br/>";
	$sql = "Select * from f_leagues where league_id in (".$str_league.")";
	//echo $sql;
	$result = mysql_query($sql);
	while ($row=mysql_fetch_array($result)) {
		//array_push($leagues,array($row['league_id'] => $row['league_name']));
		array_push($leagues[$row['league_id']]= $row['league_name']);
	}
	
	//echo $list."<br/>".$leagues;
	
	echo json_encode(array("matches"=>$list,"leagues" => $leagues,"date" => $cdate));

?>

