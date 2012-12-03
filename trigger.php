<?php
include_once("maincore.php");
include_once("dbconfig.php");
if (!$MEMBER) {
	echo "You must login to use this function.";
	exit();
}
if (isset($_GET['enable'])) {
	mysql_query("update f_trigger set disable=0 where user_id=$myid") or die("Cannot enable your triggers");
}
if (isset($_GET['disable'])) {
	mysql_query("update f_trigger set disable=1 where user_id=$myid") or die("Cannot disable your triggers");
}
if (isset($_GET['edit'])) {
if (isset($_POST['submit'])) {
	$nb = count($_POST['trigger']);
	$sql="";
	for ($i=0;$i<$nb; $i++) {
		if (strlen($_POST['number'][$i])) {
			if ($sql) $sql.=",";
			$sql.="($myid,".$_POST['team'][$i].",".$_POST['trigger'][$i].",'".$_POST['operator'][$i]."',".$_POST['number'][$i].")";
		}
	}
	if ($sql) {
		$sql="insert into f_condition (`user_id`,`isaway`,`field_id`,`operater`,`value`) Value ".$sql;
	}
	$sql2="delete from f_condition where user_id=".$myid;
	$ret=mysql_query($sql2) or die(mysql_error());
	if ($sql)
		$ret=mysql_query($sql) or die(mysql_error());
	echo "<h2>Your triggers are saved:</h2>";
	$sql="select * from f_condition,f_fields where f_condition.field_id=f_fields.field_id and user_id=$myid";
	/**/
	$ret=mysql_query($sql) or die(mysql_error());
	$triggersm="";
	$triggerst="";
	while ($row = mysql_fetch_array($ret)) {
		//echo "<div class='oldtrigger'><span style='display:none;'>".$row['trigger_id']."</span>".($row['isaway']?"Away":"Home")." - ".$row['field_name']." ".$row['operater']." ".$row['value']."</div>";
		if ($row['field_in']=='m') {
			if ($triggersm) $triggersm.="and";
			$triggersm.="(".($row['isaway']?"a":"h").$row['field_tag'].$row['operater'].$row['value'].")";
		} else {
			if ($triggerst) $triggerst.="and";
			$triggerst.="(".($row['isaway']?"awayteam":"hometeam").".team_".($row['isaway']?"a":"h").$row['field_tag'].$row['operater'].$row['value'].")";
		}
	}
	if (($triggerst) && ($triggersm)) {
		$triggersm.="and".$triggerst;
	} else {
		$triggersm.=$triggerst;
	}
	mysql_query("update f_trigger set triggersm='' where user_id=$myid");
	$sql="insert into f_trigger (user_id,triggersm,triggerst) VALUE ($myid,'".$triggersm."','".$triggerst."') ON DUPLICATE KEY UPDATE triggersm='".$triggersm."' ;";
	mysql_query($sql);
	redirect("trigger.php");
	//echo $triggersm;
	
	/**/
}
else {
	
	include_once("header.php");
	
	$sql="select * from f_fields order by field_order";
	$ret = mysql_query($sql);
	$conds="";
	if ($ret)
	while ($row=mysql_fetch_array($ret)) {
		$conds.="<option value='".$row['field_id']."'>".$row['field_name']."</option>";
	}
	echo '<script type="text/javascript">var toption="'.$conds.'";</script>';
?>
<script type="text/javascript">
$(document).ready(function(){
	//$("#condboard").append('<div class="onetrigger" style="overflow: auto;"> <select name="team[]" class="team"><option value="0">Home</option><option value="1">Away</option></select> <select name="trigger[]" class="chon">'+toption+'</select> <select name="operator[]" class="step2"><option>&gt;</option><option>&ge;</option><option>=</option><option>&lt;</option><option>&le;</option><option>&ne;</option></select> <input name="number[]" type="text" size="2" maxlength="3"  class="step3"/> .</div>');
	
	$("#addcond").click(function(){
		//if ($("#condboard").fi)
		var isfilled = true;
		$(".step3").each(function(){
			if (!$(this).val()) {
				isfilled=false;
				return false;
			}
		});
		if (isfilled)
		$("#condboard").append('<div class="onetrigger" style="overflow: auto;"> <select name="team[]" class="team"><option value="0">Home</option><option value="1">Away</option></select> <select name="trigger[]" class="chon">'+toption+'</select> <select name="operator[]" class="step2"><option>&gt;</option><option>&gt;=</option><option>=</option><option>&lt;</option><option>&lt;=</option><option>&lt;&gt;</option></select> <input name="number[]" type="text" size="2" maxlength="3"  class="step3"/> .</div>');
		//alert(toption);==?
	});
	$(".todo").live("click",function(){
		//if (confirm("Do you really want to delete this condition?\n"+$(this).parent().text())==true)
		$(this).parent().remove();
	});
	$(".todid").live("click",function(){
		//if (confirm("Do you really want to delete this condition?\n"+$(this).parent().text())==true)
		alert($(this).parent().find("span:first").text());
	});
	$(".onetrigger").live({
		mouseenter:function(){
			$(this).css("background-color","#afff00");
			$(this).append('<span class="todo">Delete this trigger</span> ');
		},
		mouseleave:function(){
			$(this).css("background-color","#ffffff");
			$(this).find("span.todo").remove();
		}
	});
	$(".oldtrigger").hover(
		function(){
			$(this).css("background-color","#afff00");
			$(this).append('<span class="todid">Delete this trigger</span> ');
		},
		function(){
			$(this).css("background-color","#ffffff");
			$(this).find("span.todid").remove();
		}
	);
	//$("#addcond").click();
});
</script>
</head>
<body>
<h2>Set your own triggers </h2>
<form name="input" action="?edit" method="post">
<div id="condboard">
<?php
$sql="select * from f_condition,f_fields where f_condition.field_id=f_fields.field_id and user_id=$myid";
$ret=mysql_query($sql);
$i=1;
while ($row = mysql_fetch_array($ret)) {
	//echo "<div class='oldtrigger'><span style='display:none;'>".$row['trigger_id']."</span>".($row['isaway']?"Away":"Home")." - ".$row['field_name']." ".$row['operater']." ".$row['value']."</div>";
	echo '<div class="onetrigger" style="overflow: auto;"> <select name="team[]" class="team"><option value="0">Home</option><option value="1" '.($row['isaway']?"selected":"").'>Away</option></select> <select id="trigger'.$i.'" name="trigger[]" class="chon">'.$conds.'</select> <select id="operator'.$i.'" name="operator[]" class="step2"><option>&gt;</option><option>&gt;=</option><option>=</option><option>&lt;</option><option>&lt;=</option><option>&lt;&gt;</option></select> <input name="number[]" type="text" size="2" maxlength="3"  class="step3" value="'.$row['value'].'"/> .</div>';
	echo '<script type="text/javascript">document.getElementById("trigger'.$i.'").value='.$row['field_id'].';document.getElementById("operator'.$i.'").value="'.$row['operater'].'";</script>';
	$i++;
}
?>


</div><br/>
<div id="addcond">Add more trigger</div><br/>
<input type="submit" value="Submit" name="submit"/>
</form>

</body>
</html>
<?php
}
} else {
	echo "<h2>Your triggers :</h2>";
	$sql="select * from f_condition,f_fields where f_condition.field_id=f_fields.field_id and user_id=$myid";
	$ret=mysql_query($sql) or die(mysql_error());
	while ($row = mysql_fetch_array($ret)) {
		echo "<div class='oldtrigger'><span style='display:none;'>".$row['trigger_id']."</span> <span class='teams'>".($row['isaway']?"Away":"Home")."</span> <span class='conditions'>".$row['field_name']."</span> <span class='operators'>".$row['operater']."</span> <span class='values'>".$row['value']."</span></div>";
		
	}
	echo "<br/><br/>";
	$sql="select * from f_trigger where user_id=$myid limit 1";
	$ret=mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($ret)) {
		echo "<div><a href='trigger.php?edit'>Edit triggers</a></div>";
		if ($row=mysql_fetch_array($ret)) {
			if (!$row['triggersm']) redirect("trigger.php?edit");
			if ($row['disable']==1) {
				echo "<div>TRIGGERS DISABLE! <a href='trigger.php?enable'>Enable trigger</a></div>";
			} else {
				echo "<div><a href='trigger.php?disable'>Disable triggers</a></div>";
			}
		}
	} else {
		redirect("trigger.php?edit");
	}
	
	
	
	
	
	
	echo "<div><a href='index.php'>Go to home page</a></div>";
	
}


?>