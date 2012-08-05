<?php
//input: id,hteam,ateam,status, trigger
error_reporting(E_ALL);
include_once("maincore.php");
include_once("dbconfig.php");
if (isset($_POST['id'])) {
	$status_text = array("","1st","","2nd","FT","");
	$mid = intval($_POST['id']);
	$hteam = intval($_POST['home']);
	$ateam = intval($_POST['away']);
	$status = intval($_POST['status']);
	$trigger = intval($_POST['trigger']);
	$ht = $trigger>=10;
	$at = $trigger % 10 == 1;
	
	$sql = "select * from f_teams where team_id=$hteam";
	//echo "\n".$sql;
	$result = mysql_query($sql);
	$hrow = mysql_fetch_array($result);
	//print_r($hrow);
	$sql = "select * from f_teams where team_id=$ateam";
	//echo "\n".$sql;
	$result = mysql_query($sql);
	$arow = mysql_fetch_array($result);
	//print_r($arow);
	$to = $myemail;
	$subject = "Match ".$hrow['team_name']." - ".$arow['team_name'].". ";
	if ($ht) $subject .= "Home got triggers. ";
	if ($at) $subject .= "Away got triggers. ";
	$message = "Hi $myname,";
	$message .= "\n\r+ Match ".$hrow['team_name']." - ".$arow['team_name'];
	$message .= "\n\r+ Status: ".$status_text[$status];
	$message .= "\n\r+ Home team: ".($ht?" got trigger:":"");
	$message .= "\n\r   -"."Position \t:\t".$hrow['team_pos'];
	$message .= "\n\r   -"."Games Played \t:\t".$hrow['team_pos'];
	$message .= "\n\r   -"."Wins \t:\t".$hrow['team_hw'];
	$message .= "\n\r   -"."Draws \t:\t".$hrow['team_hd'];
	$message .= "\n\r   -"."Losses \t:\t".$hrow['team_hl'];
	$message .= "\n\r   -"."Goals Scored \t:\t".$hrow['team_hf'];
	$message .= "\n\r   -"."Goals Against \t:\t".$hrow['team_ha'];
	$message .= "\n\r";
	$message .= "\n\r+ Away team ".($at?" got trigger:":"");
	$message .= "\n\r   -"."Position \t:\t".$hrow['team_pos'];
	$message .= "\n\r   -"."Games Played \t:\t".$hrow['team_pos'];
	$message .= "\n\r   -"."Wins \t:\t".$hrow['team_aw'];
	$message .= "\n\r   -"."Draws \t:\t".$hrow['team_ad'];
	$message .= "\n\r   -"."Losses \t:\t".$hrow['team_al'];
	$message .= "\n\r   -"."Goals Scored \t:\t".$hrow['team_af'];
	$message .= "\n\r   -"."Goals Against \t:\t".$hrow['team_aa'];
	$message .= "\n\r";
	$message .= "\n\rHave a nice day.\n\rFOOTYGOAT.";
	// Always set content-type when sending HTML email
	//$headers = "MIME-Version: 1.0" . "\r\n";
	//$headers .= "Content-type:text/html;charset=utf-8" . "\r\n";
	// More headers
	$headers .= 'From: admin@footygoat.com'. "\r\n";
	//$headers .= 'Cc: huunam0@gmail.com' . "\r\n";
	mail($to,$subject,$message,$headers); 
	echo "\nSENT";
	//echo "\n".$subject;
	//echo "\n".$message;
}
else echo "INVALID";
?>
