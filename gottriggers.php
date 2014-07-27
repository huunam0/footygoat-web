<?php
	include_once("maincore.php");
	include_once("dbconfig.php");
	$sql="select p_value from f_params where p_name='currentdate' limit 1;";
	$result = mysql_query($sql);
	if ($row=mysql_fetch_array($result)) {
		$cdate=$row['p_value'];
	} else
		$cdate= date("Y-n-d")."";
	$sql="select * from f_trigger where `disable`=0 and triggers<>'';";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result)) {
		$user_id=$row['user_id'];
		$sql2="select user_twitter from f_users where user_id='".$user_id."'";
		$ret=mysql_query($sql2);
		if ($usr = mysql_fetch_array($ret)) {
			$user_twitter=$usr['user_twitter'];
			$sql2="select f_matches.match_id,f_matches.hteam,f_matches.ateam,hometeam.team_name as homename,awayteam.team_name as awayname from f_matches ";
			$sql2.="left join f_teams as hometeam on f_matches.hteam=hometeam.team_id ";
			$sql2.="left join f_teams as awayteam on f_matches.ateam=awayteam.team_id ";
			$sql2.="where (status between 1 and 6)and (viewdate='".$cdate."')and".(strlen($row['triggers'])>5?$row['triggers']:"(1=0)")."and(match_id not in (select match_id from f_sent where user_id=$user_id and DATE(moment)=DATE(NOW())))";
			//echo "sql#".$sql2."#\n";
			$ret=mysql_query($sql2);
			if (mysql_num_rows($ret)) {
				echo "user#".$user_id."#".$user_twitter."#\n";
				while ($data=mysql_fetch_array($ret)) {
					$sql = "select team_id, team_pos from f_teams where team_id in (".$data['hteam'].",".$data['ateam'].")";
					$ret2 = mysql_query($sql);
					$homeinfo=$data['homename'];
					$awayinfo=$data['awayname'];
					while ($team = mysql_fetch_array($ret2)){
						if ($team['team_id']==$data['hteam']) $homeinfo .= "(".$team['team_pos'].")";
						if ($team['team_id']==$data['ateam']) $awayinfo .= "(".$team['team_pos'].")";
					}
					echo "match#".$data['match_id']."#".$homeinfo." v ".$awayinfo."#\n";
				}
			}
		}
		
	}
?>

