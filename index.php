
<?php
error_reporting(0);
include_once("maincore.php");
include_once("header.php");
//echo "<title>ABC</title>";
include_once("dbconfig.php");

echo "<script language='javascript'>var myid=".$myid.";";
echo "</script>";
?>

<script type="text/javascript">
var status= new Array("","1st","HT","2nd","ST","Ex.","","FT","AET","FT-Pens");
var momment="";
var hldelay=2000;
var rp;
function getnew() {
		$.ajax({
			url: 'gtimeline.php',
			type:"GET",
			data:{t:momment},
			//dataType: 'json',	
			success: function(json) {
				//$("#fortest").html(json);
				var obj = $.parseJSON(json);
				if (obj) {
					$("#fortest").html(json);
					//alert(obj[0]['e']);
					for (var i=0; i<obj.length;i++) {
						var mrow="#m"+obj[i]['m'];
						if (obj[i]['e']==100) {
							
						} else if (obj[i]['e']==12) {
							$(mrow).find(".status").html(status[(obj[i]['v']?obj[i]['v']:7)]).effect("highlight", {color:"#ff0000"}, hldelay);
						} else if (obj[i]['e']==10) {
							$(mrow).find(".status").html(status[(obj[i]['v']?obj[i]['v']:7)]).effect("highlight", {color:"#ff0000"}, hldelay);
						} else if (obj[i]['e']==9) {
							$(mrow).find(".status").html(status[(obj[i]['v']?obj[i]['v']:7)]).effect("highlight", {color:"#ff0000"}, hldelay);
						} else if (obj[i]['e']==8) {
							if (obj[i]['v']) $(mrow).find(".status").html(obj[i]['v']+"'").effect("highlight", {color:"#ff0000"}, hldelay);
						} else if (obj[i]['e']==7) {
							$(mrow).find(".possession .possession"+obj[i]['t']).html(obj[i]['v']).effect("highlight", {color:"#ff0000"}, hldelay);
						} else if (obj[i]['e']==6) {
							$(mrow).find(".conner .conner"+obj[i]['t']).html(obj[i]['v']).effect("highlight", {color:"#ff0000"}, hldelay);
						} else if (obj[i]['e']==5) {
							$(mrow).find(".gshots .gshots"+obj[i]['t']).html(obj[i]['v']).effect("highlight", {color:"#ff0000"}, hldelay);
						} else if (obj[i]['e']==4) {
							$(mrow).find(".shots"+obj[i]['t']).html(obj[i]['v']).effect("highlight", {color:"#ff0000"}, hldelay);
						} else if (obj[i]['e']==3) {
							$(mrow).find(".yellow .yellow"+obj[i]['t']).html(obj[i]['v']).effect("highlight", {color:"#ff0000"}, hldelay);
						} else if (obj[i]['e']==2) {
							//alert("redcard");
							$(mrow).find(".red .red"+obj[i]['t']).html(obj[i]['v']).effect("highlight", {color:"#ff0000"}, hldelay);
						} else if (obj[i]['e']==1) {
							$(mrow).find(".score1 .score1"+obj[i]['t']).html(obj[i]['v']).effect("highlight", {color:"#ff0000"}, hldelay);
						} else if (obj[i]['e']==0) {
							//alert("score");
							$(mrow).find(".score .score"+obj[i]['t']).html(obj[i]['v']).effect("highlight", {color:"#ff0000"}, hldelay);
						}
						
						momment=obj[i]['d'];
						
					}
				}
				
				
			},
			error: function(xhr, ajaxOptions, thrownError) {
				//alert("Error get team");
			}
		});
		//window.setTimeout(getNew,2000);
		//setTimeout(getnew,2000);
	}
	function getteam(teamid,away) {
		$.ajax({
			url: 'getteam.php',
			type:"GET",
			data:{id:teamid,aw:away},
			//dataType: 'json',	
			success: function(json) {
				//$("#fortest").html(json);
				var obj = $.parseJSON(json);
				//alert(json);
				if (obj) {
					//if (obj.count) {
						$("#t"+teamid).html(obj.na+(obj.po.length?" ("+obj.po+")":""));
						$("#w"+teamid).html(obj.w);
						$("#d"+teamid).html(obj.d);
						$("#l"+teamid).html(obj.l);
						$("#f"+teamid).html(obj.f);
						$("#a"+teamid).html(obj.a);
					//}
					
				}
				
				
			},
			error: function(xhr, ajaxOptions, thrownError) {
				//alert("Error get team");
			}
		});
	}
	function loadmatches() {
		$.ajax({
			url: 'getlist.php',
			type:"GET",
			//data:{d:"2012-08-15"},
			//dataType: 'json',	
			success: function(json) {
				//$("#fortest").html(json);
				var obj = $.parseJSON(json);
				var league="";
				var group="";
				var tr='';
				//alert(obj.leagues['col.1']);
				$("#bigboard tr:gt(1)").remove();
				for (var i=0; i<obj.matches.length;i++) {
					if (obj.matches[i]['lg']!=league) {
						$("#bigboard").append('<tr class="league"><td align="left" colspan="24">'+obj.leagues[obj.matches[i]['lg']]+'</td></tr>');
						league=obj.matches[i]['lg']+"";
					}
					if (obj.matches[i]['gr']) {
						if (obj.matches[i]['gr']!=group) {
							$("#bigboard").append('<tr class="group"><td align="left" colspan="24">Group '+obj.matches[i]['gr']+'</td></tr>');
							group=obj.matches[i]['gr'];
						}
					}
					tr='<tr class="match" id="m'+obj.matches[i]['id']+'">';
					tr+='<td class="status status'+obj.matches[i]['st']+'">'+(obj.matches[i]['st']<1?obj.matches[i]['da'].substr(11,5):(obj.matches[i]['mi']?obj.matches[i]['mi']+"'":status[obj.matches[i]['st']]))+'</td>';
					tr+='<td class="home" id="t'+obj.matches[i]['ht']+'">'+obj.matches[i]['ht']+'</td>';
					tr+='<td class="score"><span class="score0">'+(obj.matches[i]['st']>0?obj.matches[i]['hg']:"")+'</span> - <span class="score1">'+(obj.matches[i]['st']>0?obj.matches[i]['ag']:"")+'</span></td>';
					tr+='<td class="away" id="t'+obj.matches[i]['at']+'">'+obj.matches[i]['at']+'</td>';
					tr+='<td class="score1"><span class="score10"></span> - <span class="score11"></span></td>';
					tr+='<td class="yellow"><span class="yellow0">0</span> - <span class="yellow1">0</span></td>';
					tr+='<td class="red"><span class="red0">0</span> - <span class="red1">0</span></td>';
					tr+='<td class="shots"><span class="shots0"></span> - <span class="shots1"></span></td>';
					tr+='<td class="gshots"><span class="gshots0"></span> - <span class="gshots1"></span></td>';
					tr+='<td class="corner"><span class="corner0"></span> - <span class="corner1"></span></td>';
					tr+='<td class="possession"><span class="possession0"></span> - <span class="possession1"></span></td>';
					tr+='<td class="pshots"><span class="pshots0"></span> - <span class="pshots1"></span></td>';
					tr+='<td class="pgshots"><span class="pgshots0"></span> - <span class="pgshots1"></span></td>';
					tr+='<td class="pcorner"><span class="pcorner0"></span> - <span class="pcorner1"></span></td>';
					tr+='<td class="w0" id="w'+obj.matches[i]['ht']+'">-</td>';
					tr+='<td class="d0" id="d'+obj.matches[i]['ht']+'">-</td>';
					tr+='<td class="l0" id="l'+obj.matches[i]['ht']+'">-</td>';
					tr+='<td class="f0" id="f'+obj.matches[i]['ht']+'">-</td>';
					tr+='<td class="a0" id="a'+obj.matches[i]['ht']+'">-</td>';
					tr+='<td class="w1" id="w'+obj.matches[i]['at']+'">-</td>';
					tr+='<td class="d1" id="d'+obj.matches[i]['at']+'">-</td>';
					tr+='<td class="l1" id="l'+obj.matches[i]['at']+'">-</td>';
					tr+='<td class="f1" id="f'+obj.matches[i]['at']+'">-</td>';
					tr+='<td class="a1" id="a'+obj.matches[i]['at']+'">-</td>';
					tr+='</tr>';
					$("#bigboard").append(tr);
					getteam(obj.matches[i]['ht'],0);
					getteam(obj.matches[i]['at'],1);
					//break;//debug only
				}
				
			},
			error: function(xhr, ajaxOptions, thrownError) {
				//alert("Error get matches");
			}
		});
	}
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
		ud();
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
	$("#u1m").click(function() {
		var mi=prompt("Please enter match order","4");
		stoping=false;
		if (mi) uma(mi);
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
	
	$("#loadmatch").click();

	$("#btest").click(function(){
		if (rp) clearInterval(rp);
	});
	loadmatches();
	rp=setInterval(getnew,2000);
});
</script>
<!--<meta http-equiv='refresh' content='20'>-->
</head>
<body>

<div class="topbar" id="ontop">
<div id="topbar">

<table border='0' width='100%'>
<tr valign="middle" style="height:40px;">
<td align = 'right' >
<img src="image/goat.jpg"/>
</td>
<td align = 'left'>
<div class="white" style="position: relative">
&nbsp; <b>FootyGoat.com</b>
<a href="http://twitter.com/footygoat" class='tw' target='_blank'><span class='space20 s12'>Follow Us</span></a>
<a href="http://www.facebook.com/footygoat" class='fb' target='_blank'><span class='space20 s12'>Like Us</span></a>
<a href="http://www.petestilgoe.com/2012/01/turn-free-bets-into-free-cash" Target="_Blank"><span class='space20 s12'>Free Money</a>
</div>
</td>
<td align = 'center'>
<div>
<!--<a href="image/sample1.png" rel="oday" class="button" title="screen shot 1">HOME</a>-->
<a href='#' class="button"><span id = "upmatch" >Update matches</span></a>
<img src="image/loading16.gif" id="matchload" style="display:none;"/>
<?php 
	if ($MEMBER) { 


echo '<div class="menucontainer">
<span>
<a href="#" class="dropdown button">TRIGGER</a>
</span>
<div class="sublinks" id="triggerboard">
<div class="trig_in">
<span class="menutitle">Set your triggers:</span>
<table id ="mytriggers" class="tabtrig" RULES=ROWS FRAME=BOX>
<th><td>Triggers</td><td width="45px">Operator (<>=)</td><td width="40px">Home Team</td><td width="40px">Away Team</td></th>';

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

echo '</table>
</div>
<div align="center" style="width:70%"> <a href="#" id="applytriger" class="button3" >Save and apply triggers.</a></div>
<div class="hidedrop">Hide this panel</div>
</div>
</div>';

}

echo '</div>
</td>
<td align = "right">
<div class="white" style="vertical-align:bottom">';

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



echo '<span class="menucontainer" style="display:none;">
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
<a href="lbfb/index.php?login&oauth_provider=facebook"><img src="lbfb/images/fb_login.png" /></a><br/>
<a href="lbfb/index.php?login&oauth_provider=twitter"><img src="lbfb/images/tw_login.png" /></a>
</div>
<span class="hidedrop">Hide this panel</span>
</div>
</span>

<a href="lbfb/index.php?login&oauth_provider=twitter"><img src="lbfb/images/tw_login.png" height="30" align="middle" alt="Login by Twitter" title="Login by Twitter"/></a>
<a href="lbfb/index.php?login&oauth_provider=facebook"><img src="lbfb/images/fb_login.png" height="30" align="middle" alt="Login by Facebook" title="Login by Facebook"/></a>
<a href="register.php" rel="olaiday" class="button" style="display:none;">REGISTER</a>';

	}
?>

</div>
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
</table>



</div>

</div>
<br><br><br>
<div>
<span class="button" id="loadmatch">Load Matches</span> 
<span class="button" id="btest">Test:Stop update</span>
<a href="http://www.footygoat.com">Live Football Scores</a> | <a href="http://www.footygoat.com">Inplay Betting Alerts</a> | <a href="http://www.footygoat.com">Inplay Football Betting</a> 
</div>
<div id="fortest"></div>
<br><br><br>
<div>
</div>
</div>


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

