<?php
error_reporting(0);
include_once("maincore.php");
include_once("header.php");
//echo "<title>ABC</title>";
include_once("dbconfig.php");
mysql_query("insert into f_logs (`ip`,`moment`) value ('".$_SERVER['REMOTE_ADDR']."',NOW())");
date_default_timezone_set("Europe/London");
echo "<script type='text/javascript'>var myid=".$myid.";";
echo "</script>";
?>
<script src="getting.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#Content2").css($("#Content").offset());
	$("#loadpage").click(function() {
		fd();
		if (match_list) 
			if (match_list.length>0) 
				$("#loadpage").hide();
	});
	$("#upmatch").click(function() {
		stoping=false;
		getnew1();
	});
	$("#stopup").click(function() {
		working=true;
		stoping=true;
		//uma(7);
	});
	$("#login_submit").click(function() {
		$.post("login.php",{user_id:$("#login_user").val(),password:$("#login_pass").val()},function(data){
			alert(data);
			if (data.indexOf("OK")>=0) {
				location.reload();
			}
		});
		
	});
	$("#btlogout").click(function() {
		$.post("logout.php",function(data){
			location.reload();
		});
	});
	
	$("#applytriger").click(function() {
		location.reload();
	});
	$("#submitinfos").click(function() {
		if ($("#myemail").val().length>0) {
		$.post("setinfos.php",{email:$("#myemail").val(),news:$("#getnewsletter").is(':checked')?1:0},function(data){
			alert(data);
		});
		$(".sublinks").hide();
		} else {
			alert("Enter your email then submit.");
		}
	});
	
	$("#loadmatch").click(function(){
		isViewAll=!isViewAll;
		if (isViewAll) {
			$("tr.match").show();
		} else {
			$("tr.match").has("td.status0").hide();
			$("tr.match").has("td.status7").hide();
		}
	});

	$("#btest").click(function(){
		//if (rp) clearInterval(rp);
		if (rp) {
			clearTimeout(rp);
			rp=null;
		}
		else getnew1();
	});
	//loadmatches();
	if (myid>0)
	getnew1();
});
</script>

</head>
<body>

<div id="ontop">
<div id="topbar">

<table border='0' width='100%'>
<tr valign="middle" style="height:40px;">
<td align = 'right' width="5%">
<img src="image/goat.jpg"/>
</td>
<td align = 'left' width="40%">
<div class="white" style="position: relative">
<b>FootyGoat.com</b>
<a href="http://twitter.com/footygoat" class='tw' target='_blank'><span class='space20 s12'>Follow Us</span></a>
<a href="http://www.facebook.com/footygoat" class='fb' target='_blank'><span class='space20 s12'>Like Us</span></a>
<a href="http://www.petestilgoe.com/2012/01/turn-free-bets-into-free-cash" Target="_Blank"><span class='space20 s12'>Free Money</a>
</div>
</td>
<td>
<span id="nbm0"></span>
<span id="nbm1"></span>
<span id="nbm2"></span>
</td>
<td align = 'center' width="25%">
<div>
<!--<a href="image/sample1.png" rel="oday" class="button" title="screen shot 1">HOME</a>-->
<a href='#' class="button"><span id = "upmatch" >Update matches</span></a>
<img src="image/loading16.gif" id="matchload" style="display:none;"/>
<?php 
	if ($MEMBER) { 


echo '<div class="menucontainer">
<span>
<a href="trigger.php" target="_blank" class="button">TRIGGER</a>
</span>';
/*
<div class="sublinks" id="triggerboard">
<div class="trig_in">
<span class="menutitle">Set your triggers:</span>
<table id ="mytriggers" class="tabtrig" RULES=ROWS FRAME=BOX>
<th><td>Triggers</td><td width="45px">Operator (<>=)</td><td width="40px">Home Team</td><td width="40px">Away Team</td></th>';
*/
/*
	$sql = "SELECT * FROM f_fields";
	$result = mysql_query($sql);
	$cl = array("odd","even");
	$i=0;
	while ($row = mysql_fetch_array($result)) {
		$sql="select * from f_trigger where user_id=$myid and field_id=".$row['field_id']." limit 1";
		$result2 = mysql_query($sql);
		$row2=mysql_fetch_array($result2);
		echo "<tr class='".$cl[$i]."' id='trig_".$myid."_".$row['field_id']."'>";
		echo "<td>".$row['field_id']."</td>";
		echo "<td>".$row['field_name']."</td>";
		echo "<td><span id='trig_oper_".$myid."_".$row['field_id']."' class='operator'>".$row2['operater']."</span></td>";
		echo "<td><span id='trig_home_".$myid."_".$row['field_id']."' class='addtrigger'>".$row2['hvalue']."</span></td>";
		echo "<td><span id='trig_away_".$myid."_".$row['field_id']."' class='addtrigger'>".$row2['avalue']."</span></td>";
		echo "</tr>";
		$i=1-$i;
	}
*/
/*
echo '</table>
</div>
<div align="center" style="width:70%"> <a href="#" id="applytriger" class="button3" >Save and apply triggers.</a></div>
<div class="hidedrop">Hide this panel</div>
</div>
</div>';
*/
echo "</div>";
}

echo '</div>
</td>
<td>


<a href="#" class=" button">'.(date("M j, Y")).'</a>
</td><td align = "right" >
';

if ($MEMBER) {


echo '<div class="menucontainer">
<span>
<a href="#" class="dropdown button">'.($myname?$myname:$myid).'</a>
</span>
<div class="sublinks" id="userinfo">
<div class="trig_in">
<table border="0" id="privateinfos">
<tr><td>Email to send alerts:<br/><input type="text" name="myemail" id="myemail" value="'.$myemail.'" size="26"></td></tr>
<tr><td><input type="checkbox" name="getnewsletter" id="getnewsletter" checked> Get newsletters</td></tr>
<tr><td><button id="submitinfos">Submit</button> <!--<input type="submit" name="submit" value="submit">--></td></tr>
</table>
</div>
<span class="hidedrop">Hide this panel</span>
</div>
</div>';

 
	if ($ADMIN) { 

echo '<a href="#" class="button">ADMIN</a>';
 
	}

echo '<a href="#" class="button" id="btlogout">LOGOUT</a>';

} else {



echo '<span class="" style="display:block;">
<span>
<a href="#" class="dropdown button">LOGIN BY</a>
</span>
<div class="sublinks" id="loginpage">
<div class="trig_in">
<table border="0" style="display:none;">
<tr><td>User:</td><td><input type="text" id="login_user" name="loginuser"/></td></tr>
<tr><td>Pass:</td><td><input type="password" id="login_pass" name="loginpass"/></td></tr>
<tr><td> </td><td><span id="login_submit" class="button" style="height:14px;">Login</span></td></tr>
</table>
<a href="lbfb/index.php?login&oauth_provider=facebook"><img width="90" src="lbfb/images/fb_login.png" /></a><br/>
<a href="lbfb/index.php?login&oauth_provider=twitter"><img width="90" src="lbfb/images/tw_login.png" /></a>
</div>
<span class="hidedrop">Hide this panel</span>
</div>
</span>
<!--
<a href="lbfb/index.php?login&oauth_provider=twitter"><img src="lbfb/images/tw_login.png" height="30" align="middle" alt="Login by Twitter" title="Login by Twitter"/></a>
<a href="lbfb/index.php?login&oauth_provider=facebook"><img src="lbfb/images/fb_login.png" height="30" align="middle" alt="Login by Facebook" title="Login by Facebook"/></a>
<a href="register.php" rel="olaiday" class="button" style="display:none;">REGISTER</a>-->';

	}
?>


</td>
</tr>
</table>
</div>
</div>

<div id="maindoc">
<div id="Content">

<div class="Box2">


<table id="bigboard">
<thead>
<tr class="header" align="center" valign="middle">
<td rowspan="2">Status</td>
<td rowspan="2" width="16%">Home Team</td>
<td rowspan="2" width="3%">Score</td>
<td rowspan="2" width="16%">Away Team</td>
<td rowspan="2" width="3%">1st <br> round</td>
<td rowspan="2" width="3%">Yellow<br/>Cards</td>
<td rowspan="2" width="3%">Red<br/>Cards</td>
<td rowspan="2" width="4%">Shots</td>
<td rowspan="2" width="4%">Shots<br/>on goal</td>
<td rowspan="2" width="4%">Corner<br/>kicks</td>
<td rowspan="2" width="4%">% Time of<br/>Possession</td>
<td rowspan="2" width="4%">% Shots</td>
<td rowspan="2" width="4%">% Shots<br/>on goal</td>
<td rowspan="2" width="4%">% Corner<br/>kicks</td>
<td colspan="5">Home Team (%)</td>
<td colspan="5">Away Team (%)</td>

</tr>
<tr class="header" align="center" valign="middle">
<td width="2%">W</td>
<td width="2%">D</td>
<td width="2%">L</td>
<td width="2%">F</td>
<td width="2%">A</td>
<td width="2%">W</td>
<td width="2%">D</td>
<td width="2%">L</td>
<td width="2%">F</td>
<td width="2%">A</td>
</tr>
</thead>
<tr class="odd">
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>

</table>



</div>


<div id="Content2">

<div class="Box22">
<table id="bigboard2">
<tr class="header" align="center" valign="middle">
<td rowspan="2">Status</td>
<td rowspan="2" width="16%">Home Team</td>
<td rowspan="2" width="3%">Score</td>
<td rowspan="2" width="16%">Away Team</td>
<td rowspan="2" width="3%">1st <br> round</td>
<td rowspan="2" width="3%">Yellow<br/>Cards</td>
<td rowspan="2" width="3%">Red<br/>Cards</td>
<td rowspan="2" width="4%">Shots</td>
<td rowspan="2" width="4%">Shots<br/>on goal</td>
<td rowspan="2" width="4%">Corner<br/>kicks</td>
<td rowspan="2" width="4%">% Time of<br/>Possession</td>
<td rowspan="2" width="4%">% Shots</td>
<td rowspan="2" width="4%">% Shots<br/>on goal</td>
<td rowspan="2" width="4%">% Corner<br/>kicks</td>
<td colspan="5">Home Team (%)</td>
<td colspan="5">Away Team (%)</td>

</tr>
<tr class="header" align="center" valign="middle">
<td title="% games team has won at home" width="2%">W</td>
<td width="2%">D</td>
<td width="2%">L</td>
<td width="2%">F</td>
<td width="2%">A</td>
<td width="2%">W</td>
<td width="2%">D</td>
<td width="2%">L</td>
<td width="2%">F</td>
<td width="2%">A</td>
</tr>
</table>



</div>

</div>
<br><br><br>
<div>
<span class="button" id="loadmatch">Hide Matches</span> 
<span class="button" id="btest">Stop/Start Update</span>
<a href="http://www.footygoat.com">Live Football Scores</a> | <a href="http://www.footygoat.com">Inplay Betting Alerts</a> | <a href="http://www.footygoat.com">Inplay Football Betting</a> 
</div>
<div id="fortest"></div>
<br><br><br>
<div>
</div>
</div>
<textarea rows="20" cols="100" id="debug4" style="display:none;">

</textarea>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-348273-71']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>

