<?php
include_once("maincore.php");
include_once("header.php");
include_once("dbconfig.php");
$xyz=0;
$xyz=$xyz+2;
?>
<script src="scores1.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#loadpage").click(function() {
		fd();
		if (match_list) 
			if (match_list.length>0) 
				$("#loadpage").hide();
	});
	$("#upmatch").click(function() {
		//$.ajaxSetup({ timeout: 300000 });
		ud();
	});
	$("#stopup").click(function() {
		working=true;
		stoping=true;
	});
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
<img src="image/logo.png"/>
</td>
<td align = 'left'>
<div class="white" style="position: relative">
&nbsp; <b>FOOTYGOAT</b>
</div>
</td>
<td align = 'center'>
<div>
<img src="image/loading16.gif" id="firstload" style="display:none;"/>
<a href="image/sample1.png" rel="oday" class="button" title="screen shot 1">HOME</a>
<img src="image/loading16.gif" id="matchload" style="display:none;"/>
<? if ($MEMBER) { ?>
<a href="#" class="button">TRIGGER</a>
<?}?>
</div>
</td>
<td align = 'right'>
<div class="white">
<?php
if ($MEMBER) {
?>
<a href="#" class="button"><? echo ($myname?$myname:$myid); ?></a>
<? if ($ADMIN) { ?>
<a href="#" class="button">ADMIN</a>
<?}?>
<a href="logout.php?ajax=true&height=500" rel="olaiday"  class="button">LOGOUT</a>
<?php
} else {
?>
<a href="loginpage.php?ajax=true" rel="olaiday" class="button">LOGIN</a>
<a href="#" rel="olaiday" class="button">REGISTER</a>
<?php
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
<tr class="header" align="center" valign="middle">
<td rowspan="2">Status</td>
<td rowspan="2" width="14%">Home Team</td>
<td rowspan="2" width="4%">Score</td>
<td rowspan="2" width="14%">Away Team</td>
<td rowspan="2" width="4%">1st <br> round</td>
<td rowspan="2" width="4%">Yellow<br/>Cards</td>
<td rowspan="2" width="4%">Red<br/>Cards</td>
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
<tr class="league">
<td colspan="24" class="league">Barclays Premier League</td>
</tr>
<tr class="even">
<td align="left">FT</td>
<td>Manchester City (2)</td>
<td>2-0</td>
<td>(9) Everton</td>
<td>0-0</td>
<td>1-5</td>
<td>0-0</td>
<td>19-8</td>
<td>7-3</td>
<td>7-5</td>
<td>63-37</td>
<td>70-30</td>
<td>70-30</td>
<td>58-42</td>
<td>50</td>
<td>0</td>
<td>0</td>
<td>3</td>
<td>0</td>
<td>20</td>
<td>100</td>
<td>20</td>
<td>0.5</td>
<td>1</td>
</tr>
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
<span id = "loadpage" class="button">Load Page</span>
<span id = "upmatch" class="button">Update match</span>
<span id = "stopup" class="button">Stop Update</span>
</div>
<div id="cuoitrang">
Cuoi trang
</div>

</div>

