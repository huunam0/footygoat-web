<?php
	include_once("maincore.php");
	include_once("dbconfig.php");
	if (!isset($_GET['o'])) exit(1);
	$bid=intval($_GET['o']);
	$sql = "SELECT * FROM f_timeline2 where `id` > '$bid' order by `id`";
	$result = mysql_query($sql);
	$events=array();
	while ($row = mysql_fetch_array($result)) {
		//echo $row['date']." ".$row['event']."-".$row['match']."<br/>";
		$e=array(
			"id" => $row['id'],
			"d" => $row['date'],
			"m" => $row['match'],
			"h" => $row['home'],
			"e" => $row['event'],
			"a" => $row['away']
		);
		array_push($events,$e);
	}
	echo json_encode($events);
?>

