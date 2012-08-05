<?php
include_once("maincore.php");
include_once("dbconfig.php");
//if (!$MEMBER) exit(-1);
//addleague.php?id=12&name=xy
if (isset($_POST['id'])) {
	if (!isset($_POST['name'])) exit(-2);
	$lid = $_POST['id'];
	$lname = $_POST['name'];
	$sql = "INSERT INTO f_leagues (league_id,league_name) VALUE ('$lid','$lname') ON DUPLICATE KEY UPDATE league_name='$lname'";
	$result = mysql_query($sql) or die("#1.".mysql_error());
	echo "OK";
} else echo "undetermined"
?>
