<?php
error_reporting(0);
if ($MEMBER){
	echo "<a href=logout.php>Logout first</a>";
	exit(1);
}
if (isset($_POST['submit'])) {
	include_once("dbconfig.php");
	$puser = $_POST['user_id'];
	$ppass = $_POST['password'];
	session_destroy();
	session_start();
	$sql = "SELECT * FROM f_users where user_name='$puser' and user_password='".md5($ppass)."'";
	$result = mysql_query($sql);
	if (mysql_num_rows($result)) {
		$row = mysql_fetch_array($result);
		$_SESSION['user_id']=$row['user_id'];
		$_SESSION['user_name']=$row['user_name'];
		$_SESSION['user_right']="mem";
		$_SESSION['user_email']=$row['user_email'];
		echo "Welcome";
		echo "<script language='javascript'>\n";
		echo "history.go(-2);\n";
		echo "</script>";
	} else {
		echo "Wrong account";
	}
} else {
?>
<form action='loginpage.php' method='post'>
	<center>
	<table  algin=center>
	<tr><td>Username: </td><td ><input name="user_id" type="text" size=20></td></tr>
	<tr><td>Password: </td><td><input name="password" type="password" size=20></td></tr>
	<tr><td></td><td><input name="submit" type="submit" size=10 value="Login"></td></tr>
	<tr><td><a href="lbfb/index.php?login&oauth_provider=twitter"><img src="lbfb/images/tw_login.png"></a></td><td><a href="lbfb/index.php?login&oauth_provider=facebook"><img src="lbfb/images/fb_login.png"></a></td></tr>
	</table>
	<center>
</form>
<?php
}
?>