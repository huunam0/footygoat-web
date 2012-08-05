<?php session_start();
unset($_SESSION['user_id']);
session_destroy();
echo "You're out";
?>
