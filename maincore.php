<?php
error_reporting(-1);
$thispage = $_SERVER["PHP_SELF"];
session_start();
if (isset($_COOKIE['your_id'])) {
	$puser = $_COOKIE['your_id'];
	$sql = "SELECT * FROM f_users where user_id='$puser' ";
	$result = mysql_query($sql);
	if (mysql_num_rows($result)) {
		$row = mysql_fetch_array($result);
		if ($row['user_active']) {
			$_SESSION['user_id']=$row['user_id'];
			$_SESSION['user_name']=$row['user_name'];
			$_SESSION['user_right']="mem";
			$_SESSION['user_email']=$row['user_email'];
			setcookie("your_id",$row['user_id'],time()+86400);
		}
	} else {
		session_unset();
		unset($_COOKIE['your_id']);
		setcookie('your_id', '', time() - 3600);
	}
}
 
$MEMBER=false;
$ADMIN=false;
$myid=0;
$myname="";
$myemail="";
if (isset($_SESSION['user_id'])) {
	$myid = $_SESSION['user_id'];
	$MEMBER = true;
	if (isset($_SESSION['user_right'])) {
		if ($_SESSION['user_right']=="admin") {
			$ADMIN = true;
		}
	}
}
if (isset($_SESSION['user_email'])) {
	$myemail=$_SESSION['user_email'];
}
if (isset($_SESSION['user_name'])){
	$myname=$_SESSION['user_name'];
}
include_once("configs.php");
//date_default_timezone_set("Asia/Ho_Chi_Minh");
function redirect($location, $delaytime = 0) {
    if ($delaytime>0) {    
        header( "refresh: $delaytime; url='".str_replace("&amp;", "&", $location)."'" );
    } else {
        header("Location: ".str_replace("&amp;", "&", $location));
    }    
}

?>
