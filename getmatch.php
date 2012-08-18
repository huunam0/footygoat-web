<?php
	include_once("maincore.php");
	include_once("dbconfig.php");
	if (isset($_GET['id'])) {
		$mid=intval($_GET['id']);
		$sql="select * from f_matches where match_id=$mid limit 1;";
		//echo $sql;
		$result=mysql_query($sql);
		$match=array();
		if ($row=mysql_fetch_array($result)) {
			$match['st']=$row['status'];
			$match['mi']=$row['minutes'];
			$match['hg']=$row['hgoals'];
			$match['ag']=$row['agoals']; 
			$match['h1']=$row['h1goals'];
			$match['a1']=$row['a1goals'];
			$match['hr']=$row['hreds'];
			$match['ar']=$row['areds'];
			$match['hy']=$row['hyellows'];
			$match['ay']=$row['ayellows'];
			$match['hs']=$row['hshots'];
			$match['as']=$row['ashots'];
			$match['hsg']=$row['hgshots'];
			$match['asg']=$row['agshots'];
			$match['hc']=$row['hcorner'];
			$match['ac']=$row['acorner'];
			$match['hp']=$row['hpossession'];
			$match['ap']=$row['apossession'];
			$match['he']=$row['hpenalty'];
			$match['ae']=$row['apenalty'];
			/*
			$match['st']=($row['status']?$row['status']:"");
			$match['mi']=($row['minutes']?$row['minutes']:"");
			$match['hg']=($row['hgoals']?$row['hgoals']:"");
			$match['ag']=($row['agoals']?$row['agoals']:"");
			$match['h1']=($row['h1goals']?$row['h1goals']:"");
			$match['a1']=($row['a1goals']?$row['a1goals']:"");
			$match['hr']=($row['hreds']?$row['hreds']:"");
			$match['ar']=($row['areds']?$row['areds']:"");
			$match['hy']=($row['hyellows']?$row['hyellows']:"");
			$match['ay']=($row['ayellows']?$row['ayellows']:"");
			$match['hs']=($row['hshots']?$row['hshots']:"");
			$match['as']=($row['ashots']?$row['ashots']:"");
			$match['hsg']=($row['hgshots']?$row['hgshots']:"");
			$match['asg']=($row['agshots']?$row['agshots']:"");
			$match['hc']=($row['hcorner']?$row['hcorner']:"");
			$match['ac']=($row['acorner']?$row['acorner']:"");
			$match['hp']=($row['hpossession']?$row['hpossession']:"");
			$match['ap']=($row['apossession']?$row['apossession']:"");
			$match['he']=($row['hpenalty']?$row['hpenalty']:"");
			$match['ae']=($row['apenalty']?$row['apenalty']:"");
			*/
		} 
		//echo json_encode($match);
	}
	

?>

