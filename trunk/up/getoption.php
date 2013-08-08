<?php
require_once "wp-config.php";
$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysql_select_db(DB_NAME);

$opt = gGet("key");
if ($opt) {
    $sql="select option_value from wp_options where option_name='$opt' limit 1";
    $ret=mysql_query($sql);
    if ($row=mysql_fetch_array($ret)) {
        echo $row["option_value"];
    } else {
        echo "not found";
    }
} else {
    echo "nothing";
}

function gGet($gp)
{
	if (isset($_GET[$gp]))
		return $_GET[$gp];
	else
		return "";
}
?>
