<?php
	include_once("maincore.php");
	include_once("dbconfig.php");
	if (!isset($_GET['d'])) $cdate=date("Y-m-d");
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
		$t=array(
			"id" => $row['match_id'],
			"lg" => $row['league_id'],
			"gr" => $row['group'],
			"ht" => $row['hteam'],
			"at" => $row['ateam'],
			"st" => $row['status'],
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
	
	echo json_encode(array("matches"=>$list,"leagues" => $leagues));

?>

