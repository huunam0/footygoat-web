<?php
	include_once("maincore.php");
	include_once("dbconfig.php");
	//$today = isset($_GET['date'])?$_GET['date']:date("Y-n-d")."";
	$today= date("Y-n-d")."";
	$tomorrow= date("Y-n-d",strtotime("+1 days"));
	$sql = "SELECT * FROM f_matches where match_date between '$today 6:01' and '$tomorrow 6:00' order by `order`";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result)) {
		echo $row['order']." ".$row['match_id']."-".$row['status']."<br/>";
	}
?>

