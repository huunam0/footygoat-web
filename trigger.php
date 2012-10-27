<?php
if (isset($_POST['submit'])) {
	print_r($_POST['trigger']);
	echo "<br/>";
	print_r($_POST['operator']);
	echo "<br/>";
	print_r($_POST['number']);
}
else {
	include_once("maincore.php");
	include_once("header.php");
	include_once("dbconfig.php");
	$sql="select * from f_fields";
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
	$(".step3").hide()
	$(".step2").hide();
	
	$(".chon").change(function(){
		if ($(this).val())
			$(this).parent().find(".step2").show().val("");
		else
			$(this).parent().find(".step2").hide();
	});
	$(".step2").change(function(){
		if ($(this).val())
			$(this).parent().find(".step3").show().val("");
		else
			$(this).parent().find(".step3").hide();
	});
	$("#addcond").click(function(){
		$("#condboard").append('<div><select name="team[]" class="team"><option value="0">Home</option><option value="1">Away</option></select><select name="trigger[]" class="chon">'+toption+'</select><select name="operator[]" class="step2"><option>=</option><option>&gt;</option><option>&lt;</option><option>&le;</option><option>&ge;</option><option>&ne;</option></select><input name="number[]" type="text" size="2" maxlength="3"  class="step3"/></div>');
		//alert(toption);==?
	});
});
</script>
</head>
<body>
<form name="input" action="?" method="post">
<div id="condboard">
</div>

<input type="submit" value="Submit" name="submit"/>
</form>
<button id="addcond">Add Trigger</button><br/>
</body>
</html>
<?php
}
?>