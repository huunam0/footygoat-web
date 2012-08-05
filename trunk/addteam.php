<?php
include_once("maincore.php");
include_once("dbconfig.php");
//if (!$MEMBER) exit(-1);
if (isset($_POST['id'])) {
	if (!isset($_POST['name'])) exit(-2);
	$tid = $_POST['id'];
	$tname = $_POST['name'];
	$tgroup = $_POST['group'];
	$tleague = $_POST['league'];
	
	$tpos = intval($_POST['pos']);
	$top = intval($_POST['op']);
	
	$thw = intval($_POST['hw']);
	$thd = intval($_POST['hd']);
	$thl = intval($_POST['hl']);
	$thf = intval($_POST['hf']);
	$tha = intval($_POST['ha']);
	
	$taw = intval($_POST['aw']);
	$tad = intval($_POST['ad']);
	$tal = intval($_POST['al']);
	$taf = intval($_POST['af']);
	$taa = intval($_POST['aa']);
	
	$tgd = intval($_POST['gd']);
	$tpt = intval($_POST['pt']);
	
	$sql = "INSERT INTO f_teams (team_id,team_name,team_group,team_league,team_pos) VALUE ($tid,'$tname','$tgroup','$tleague',$tpos)";
	$result = mysql_query($sql);
	$sql = "UPDATE f_teams SET team_op=$top,team_hw=$thw,team_hd=$thd,team_hl=$thl,team_hf=$thf,team_ha=$tha,team_aw=$taw,team_ad=$tad,team_al=$tal,team_af=$taf,team_aa=$taa,team_gd=$tgd,team_pts=$tpt,team_date=NOW() where team_id=$tid";
	$result = mysql_query($sql) or die("#3.".mysql_error());
	echo "OK";
} else echo "undetermined"
?>
