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
		$("#condboard").append('<div class="onetrigger" style="overflow: auto;"> <select name="team[]" class="team"><option value="0">Home</option><option value="1">Away</option></select><select name="trigger[]" class="chon">'+toption+'</select> <select name="operator[]" class="step2"><option>=</option><option>&gt;</option><option>&lt;</option><option>&le;</option><option>&ge;</option><option>&ne;</option></select> <input name="number[]" type="text" size="2" maxlength="3"  class="step3"/> .</div>');
		//alert(toption);==?
	});
	/*
	$(".onetrigger").hover(
	function(){
		$(this).append('<span class="listtodo">Delete</span>');
		//alert("OK");
	},
	function (){
		$(this).find("span:last").remove();
		//$("#addcond").html("Out");
	}
	);
	*/
	/*
	$("span").click(function(){
		alert($(this).text());
	});
	$(".onetrigger:last").live({
		mouseover:function(){
			$(this).append('<span>Add trigger</span>');
		},
		mouseout:function(){
			$(this).find("span:last").remove();
		}
	});
	$(".onetrigger").live({
		mouseover:function(){
			$(this).append('<span>Delete</span>');
		},
		mouseout:function(){
			$(this).find("span:last").remove();
		}
	});
	*/
	$(".todo").live("click",function(){
		alert($(this).text());
	});
	$(".onetrigger").live({
		mouseenter:function(){
			$(this).append('<span class="todo">Delete this trigger</span> ');
		},
		mouseleave:function(){
			$(this).find("span.todo").remove();
		}
	});
	
});
</script>
</head>
<body>
<h2>Set your own triggers </h2>
<form name="input" action="?" method="post">
<div id="condboard">

</div>
<div id="addcond">Add more trigger</div><br/>
<input type="submit" value="Submit" name="submit"/>
</form>

</body>
</html>
<?php
}
?>