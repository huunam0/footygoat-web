<?php
session_start();
if (isset($_POST['setvalue'])) //submit set
{
	if (isset($_POST['s_name'])&&isset($_POST['s_value']))
	{
		$_SESSION[$_POST['s_name']]=$_POST['s_value'];
	}
}
if (isset($_POST['getvalue'])) //submit get
{
	if (isset($_POST['s_name']))
	{
		echo $_POST['s_name']."<br>";
		echo $_SESSION[$_POST['s_name']];
		echo $_COOKIE[$_POST['s_name']];
	}
}
?>

	<html>
<body>

<form action="session.php" method="post">
Name:
<input type="text" name="s_name"/><br>
Value:
<input type="text" name="s_value"/><br>
<input type="submit" name="getvalue" value="Get" /> 
<input type="submit" name="setvalue" value="Set" />
</form>

</body>
</html>


