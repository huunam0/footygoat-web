<?php

//Always place this code at the top of the Page
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirection to login page twitter or facebook
    header("location: index.php");
}
 {
	echo '<h1>Welcome</h1>';
	echo 'id : ' . $_SESSION['user_id'];
	echo '<br/>Name : ' . $_SESSION['user_name'];
	echo '<br/>Email : ' . $_SESSION['user_email'];
	if (!$_SESSION['user_email']) echo "<i>You should add your email.</i>";
	echo '<br/>You are login with : ' . $_SESSION['oauth_provider'];
	echo '<br/>Logout from <a href="logout.php?logout">' . $_SESSION['oauth_provider'] . '</a>';
	header("location: ../index.php");
}
?>
