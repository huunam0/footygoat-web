<?php
	include_once("maincore.php");
	include_once("dbconfig.php");
	//$today = isset($_GET['date'])?$_GET['date']:date("Y-n-d")."";
	$sql="select p_value from f_params where p_name='currentdate' limit 1;";
	$result = mysql_query($sql);
	if ($row=mysql_fetch_array($result)) {
		$today=$row['p_value'];
	} else
		$today= date("Y-n-d")."";
	$sql = "SELECT * FROM f_matches where viewdate='$today' order by `order`";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result)) {
		echo $row['order']." ".$row['match_id']."-".$row['status']."<br/>";
	}
?>

