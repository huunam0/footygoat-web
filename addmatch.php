<?php
include_once("maincore.php");
include_once("dbconfig.php");
//if (!$MEMBER) exit(-1);
if (isset($_POST['id'])) {
	if (isset($_POST['date'])) { //add new, needed: 
		$mid = $_POST['id'];
		$mleague = $_POST['league'];
		$mhteam = $_POST['hteam'];
		$mateam = $_POST['ateam'];
		$mstatus = $_POST['status'];
		$mdate = $_POST['date'];
		$sql = "INSERT INTO f_matchs (match_id,league_id,hteam,ateam,status,match_date,date_view) VALUE ($mid,'$mleague',$mhteam,$mateam,$mstatus,'$mdate',NOW()) ON DUPLICATE KEY UPDATE league_id='$mleague',hteam=$mhteam,ateam=$mateam,status=$mstatus,match_date='$mdate',date_view=NOW()";
		$result = mysql_query($sql);
		echo mysql_error();
	} else { //update
		$mid = $_POST['id'];
		$mhgoals = $_POST['hg'];
		$magoals = $_POST['ag'];
		$mh1goals = $_POST['h1g'];
		$ma1goals = $_POST['a1g'];
		$mhreds =  $_POST['hr'];
		$mareds =  $_POST['ar'];
		$mhyellows =  $_POST['hy'];
		$mayellows =  $_POST['ay'];
		$mhshots =  $_POST['hs'];
		$mashots =  $_POST['as'];
		$mhgshots =  $_POST['hgs'];
		$magshots =  $_POST['ags'];
		$mhcorners =  $_POST['hc'];
		$macorners =  $_POST['ac'];
		$mhpossession = $_POST['hp'];
		$mapossession = $_POST['ap'];
		$sql="UPDATE f_matchs SET hgoals=$mhgoals, agoals=$magoals, h1goals=$mh1goals, a1goals=$ma1goals, hreds=$mhreds, areds=$mareds, hyellows=$mhyellows, ayellows=$mayellows, hshots=$mhshots, ashots=$mashots, hgshots=$mhgshots, agshots=$magshots, hcorner=$mhcorners, acorner=$macorners, hpossession=$mhpossession, apossession=$mapossession where match_id=$mid";
		$result = mysql_query($sql);
		echo mysql_error();
	}
} else echo "undetermined"
?>
