<?php
//error_reporting(0);
	session_start();
	include_once("dbconfig.php");
	$puser = $_POST['user_id'];
	$ppass = $_POST['password'];
	ini_set("session.cookie_lifetime","7*24*60*60");
	$sql = "SELECT * FROM f_users where user_name='$puser' and user_password='".md5($ppass)."'";
	$result = mysql_query($sql);
	if (mysql_num_rows($result)) {
		$row = mysql_fetch_array($result);
		if ($row['user_active']) {
			$_SESSION['user_id']=$row['user_id'];
			$_SESSION['user_name']=$row['user_name'];
			$_SESSION['user_right']="mem";
			$_SESSION['user_email']=$row['user_email'];
			echo "Welcome";
			setcookie("your_id",$row['user_id'],time()+86400);
		}
		else echo "User inactived.";
	}
	else echo "Wrong Username or Password.";
?>