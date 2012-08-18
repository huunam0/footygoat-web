<?php
	include_once("maincore.php");
	include_once("dbconfig.php");
	if (isset($_GET['id'])) {
		$tid=intval($_GET['id']);
		$hora=0;
		if (isset($_GET['aw'])) $hora=intval($_GET['aw']);
		$sql="select * from f_teams where team_id=$tid limit 1;";
		//echo $sql;
		$result=mysql_query($sql);
		$team=array();
		$team['na']="";
		$team['po']="";
		$team['w']="";
		$team['d']="";
		$team['l']="";
		$team['f']="";
		$team['a']="";
		if ($row=mysql_fetch_array($result)) {
			$team['na']=$row['team_name'];
			if ($row['team_updated']) {
				$team['po']=$row['team_pos']."";
				if ($hora) {//away
					$team['w']=$row['team_aw'];
					$team['d']=$row['team_ad'];
					$team['l']=$row['team_al'];
					$team['f']=$row['team_af'];
					$team['a']=$row['team_aa'];
				} else {//home
					$team['w']=$row['team_hw'];
					$team['d']=$row['team_hd'];
					$team['l']=$row['team_hl'];
					$team['f']=$row['team_hf'];
					$team['a']=$row['team_ha'];
				}
			}
		} 
		echo json_encode($team);
	}
	

?>

