<?php
	include_once("maincore.php");
	include_once("dbconfig.php");
	if (!isset($_GET['t'])) exit(1);
	$truoc=$_GET['t'];
	if (isset($_GET['a']) && ($_GET['a']=='1'))
		$sql = "SELECT * FROM f_timeline where `date` > '$truoc' order by `date`";
	else
		$sql = "SELECT * FROM f_timeline where `date` >= '$truoc' order by `date`";
	$result = mysql_query($sql);
	$events=array();
	while ($row = mysql_fetch_array($result)) {
		//echo $row['date']." ".$row['event']."-".$row['match']."<br/>";
		$e=array(
			"d" => $row['date'],
			"m" => $row['match'],
			"t" => $row['team'],
			"e" => $row['event'],
			"v" => $row['value']
		);
		array_push($events,$e);
	}
	echo json_encode($events);
?>

