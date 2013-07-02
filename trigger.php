<?php
include_once("maincore.php");
include_once("dbconfig.php");
include_once("header.php");
if (!$MEMBER) {
	echo "You must login to use this function.";
	exit();
}
if (isset($_GET['enable'])) {
	mysql_query("update f_trigger set disable=0 where user_id=$myid and numero=".intval($_GET['enable'])) or die("Cannot enable your triggers");
	redirect($thispage);
}
if (isset($_GET['disable'])) {
	mysql_query("update f_trigger set disable=1 where user_id=$myid and numero=".intval($_GET['disable'])) or die("Cannot disable your triggers");
	redirect($thispage);
}
if (isset($_GET['delete'])) {
	$n=intval($_GET['delete']);
	mysql_query("delete from f_trigger where user_id=$myid and numero=".$n or die("Cannot delete your triggers");
	mysql_query("delete from f_condition where user_id=$myid and numero=".$n or die("Cannot delete your triggers' conditions");
	redirect($thispage);
}
if (isset($_GET['view'])) {
	
	$trig = intval($_GET['view']);
	echo '<script type="text/javascript" src="trigger.js"></script>';
	echo '</head>';
	echo '<body>';
	echo '<h2>View your own triggers </h2>';
	$sql="select * from f_trigger where user_id=$myid and numero=$trig limit 1";
	$ret=mysql_query($sql) or die("Cannot found your trigger(s)");
	if($row = mysql_fetch_array($ret)) {
		echo "<h3>N° $trig - ".$row['notes']."</h3><br/>";
	}
	
	echo '<form name="input" action="?edit" method="post">';
	echo '<div id="condboard">';
	
	$sql="select * from f_condition,f_fields where f_condition.field_id=f_fields.field_id and user_id=$myid and numero=$trig";
	$ret=mysql_query($sql);
	$i=1;
	echo "<table class='thuong'>";
	while ($row = mysql_fetch_array($ret)) {
		echo "<tr><td>$i</td><td>".($row['isaway']?"Away":"Home")."</td><td>".$row['field_name']."</td><td>".$row['operater']."</td><td>".$row['value'].' </td></tr>';
		$i++;
	}
	echo "</table>";
	echo "</div>";
	echo "<div style='margin:15px;'><a href='$thispage'>Go to trigger page</a></div>";
}
else if (isset($_GET['add'])) {
	if (isset($_POST['submit'])) {
		$sql="select numero from f_trigger where user_id=$myid order by numero";
		$ret=mysql_query($sql);
		$i=1;
		while ($row = mysql_fetch_array($ret)) {
			if ($row['numero']!=$i) break;
			$i++;
		}
		if ($i<=$global['max_triggers']) {
			$notes=mysql_real_escape_string($_POST['tnotes']);
			$sql="insert into f_trigger (user_id, numero,triggers,notes,disable,moment) value ($myid,$i,'','$notes',1,NOW())";
			$ret=mysql_query($sql);
			echo "SUCCESSFULLY. Now, you may edit your trigger";
			redirect($thispage."?edit=$i",3);
		} else {
			echo "Cannot add more trigger";
			redirect($thispage,5);
		}
	} else {
		echo '</head>';
		echo '<body>';
		echo '<h2>Add new trigger </h2>';
		echo '<form name="input" action="?add" method="post">';
		echo "Enter name of this trigger: <input name='tnotes' type='text' suze='30'/> <input type='submit' value='Submit' name='submit'/>";
		echo "</form>";
	}
}
else if (isset($_GET['edit'])) {
	$trig=intval($_GET['edit']);
if (isset($_POST['submit'])) {
	$nb = count($_POST['trigger']);
	$sql="";
	for ($i=0;$i<$nb; $i++) {
		if (strlen($_POST['number'][$i])) {
			if ($sql) $sql.=",";
			$sql.="($myid,$trig,".$_POST['team'][$i].",".$_POST['trigger'][$i].",'".$_POST['operator'][$i]."',".$_POST['number'][$i].")";
		}
	}
	if ($sql) {
		$sql="insert into f_condition (`user_id`,`numero`,`isaway`,`field_id`,`operater`,`value`) Value ".$sql;
	}
	$sql2="delete from f_condition where user_id=".$myid." and numero=$trig";
	$ret=mysql_query($sql2) or die(mysql_error());
	if ($sql)
		$ret=mysql_query($sql) or die(mysql_error());
	echo "<h2>Your triggers are saved:</h2>";
	$sql="select * from f_condition,f_fields where f_condition.field_id=f_fields.field_id and user_id=$myid and numero=$trig";
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
	mysql_query("update f_trigger set triggers='' where user_id=$myid and numero=$trig");
	$sql="insert into f_trigger (user_id,numero,triggers) VALUE ($myid,$trig,'".$triggersm."') ON DUPLICATE KEY UPDATE triggers='".$triggersm."' ;";
	mysql_query($sql);
	redirect($thispage."?view=$trig");
}
else {
	$sql="select * from f_fields order by field_order";
	$ret = mysql_query($sql);
	$conds="";
	if ($ret)
	while ($row=mysql_fetch_array($ret)) {
		$conds.="<option value='".$row['field_id']."'>".$row['field_name']."</option>";
	}
	echo '<script type="text/javascript">var toption="'.$conds.'";</script>';
	echo '<script type="text/javascript" src="trigger.js"></script>';
	echo '</head>';
	echo '<body>';
	echo '<h2>Edit your own triggers </h2>';
	$sql="select * from f_trigger where user_id=$myid and numero=$trig limit 1";
	$ret=mysql_query($sql) or die("Cannot found your trigger(s)");
	if($row = mysql_fetch_array($ret)) {
		echo "<h3>N° $trig - ".$row['notes']."</h3><br/>";
	}
	echo '<form name="input" action="?edit='.$trig.'" method="post">';
	echo '<div id="condboard">';
	$sql="select * from f_condition,f_fields where f_condition.field_id=f_fields.field_id and user_id=$myid and numero=$trig";
	$ret=mysql_query($sql);
	$i=1;
	while ($row = mysql_fetch_array($ret)) {
		echo '<div class="onetrigger" style="overflow: auto;"> <select name="team[]" class="team"><option value="0">Home</option><option value="1" '.($row['isaway']?"selected":"").'>Away</option></select> <select id="trigger'.$i.'" name="trigger[]" class="chon">'.$conds.'</select> <select id="operator'.$i.'" name="operator[]" class="step2"><option>&gt;</option><option>&gt;=</option><option>=</option><option>&lt;</option><option>&lt;=</option><option>&lt;&gt;</option></select> <input name="number[]" type="text" size="2" maxlength="3"  class="step3" value="'.$row['value'].'"/> .</div>';
		echo '<script type="text/javascript">document.getElementById("trigger'.$i.'").value='.$row['field_id'].';document.getElementById("operator'.$i.'").value="'.$row['operater'].'";</script>';
		$i++;
	}
?>


</div><br/>
<div id="addcond" class='button'>Add more trigger</div><br/><br/>
<input type="submit" value="Submit" name="submit"/>
</form>

</body>
</html>
<?php
}
}
/*
else {
	echo "<h2>Your triggers :</h2><br/>";
	$sql="select * from f_condition,f_fields where f_condition.field_id=f_fields.field_id and user_id=$myid";
	$ret=mysql_query($sql) or die(mysql_error());
	while ($row = mysql_fetch_array($ret)) {
		echo "<div class='oldtrigger'><span style='display:none;'>".$row['trigger_id']."</span> <span class='teams'>".($row['isaway']?"Away":"Home")."</span> <span class='conditions'>".$row['field_name']."</span> <span class='operators'>".$row['operater']."</span> <span class='values'>".$row['value']."</span></div>";
		
	}
	echo "<br/><br/>";
	$sql="select * from f_trigger where user_id=$myid limit 1";
	$ret=mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($ret)) {
		echo "<div><a href='trigger.php?edit' class='button'>Edit triggers</a></div>";
		if ($row=mysql_fetch_array($ret)) {
			if (!$row['triggersm']) redirect("trigger.php?edit");
			if ($row['disable']==1) {
				echo "<div>TRIGGERS DISABLE! <a href='trigger.php?enable' class='button'>Enable trigger</a></div>";
			} else {
				echo "<div><a href='trigger.php?disable' class='button'>Disable triggers</a></div>";
			}
		}
	} else {
		redirect("trigger.php?edit");
	}
	
	
	
	
	
	
	echo "<div><a href='index.php'>Go to home page</a></div>";
	
}
*/
else {
	$sql="select * from f_trigger where user_id=$myid order by numero";
	$ret=mysql_query($sql) or die(mysql_error());
	if ($quantity=mysql_num_rows($ret)) {
		echo "<h1>You have $quantity trigger(s)</h1>";
		echo "<table class='thuong'><tr><td>N°</td><td>Trigger's name</td><td>Status</td><td>Functions</td></tr>";
		while ($row=mysql_fetch_array($ret)) {
			echo "<tr style='height:40px;'><td>".$row['numero']."</td><td>".$row['notes']."</td><td>".($row['disable']==1?"<span class='redalert'>Disable</span>":"Enable")."</td><td><a class='button' href='?delete=".$row['numero']."' title='Delete this trigger'>Delete</a> <a class='button' href='?edit=".$row['numero']."' title='Edit this trigger'>Edit</a> <a class='button' href='?view=".$row['numero']."' title='View this trigger'>View</a> ";
			if ($row['disable']==1) {
				echo "<a class='button' href='?enable=".$row['numero']."' title='Enable this trigger'>Enable</a>";
			} else {
				echo "<a class='button' href='?disable=".$row['numero']."' title='Disable this trigger'>Disable</a>";
			}
			echo "</td></tr>";
		}
		echo "</table>";
		 
	} else {
		echo "You don't have any trigger. Create one.";
	}
	if ($quantity<$global['max_triggers']) {
		echo "<div style='margin:15px;'><a href='?add' title='Add more one trigger'>Add</a></div>";
	}
}


?>
</body>
</html>