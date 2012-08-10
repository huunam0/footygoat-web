<?php
	include_once("maincore.php");
	include_once("dbconfig.php");
	if (!isset($_GET['t'])) exit(1);
	$truoc=$_GET['t'];
	$sql = "SELECT * FROM f_timeline where `date` > '$truoc' order by `date`";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result)) {
		echo $row['date']." ".$row['event']."-".$row['match']."<br/>";
	}
?>

