<?php

require 'dbconfig.php';

class User {

    function checkUser($uid, $oauth_provider, $username, $twitter="") 
	{
        //$query = mysql_query("SELECT * FROM `l_users` WHERE oauth_uid = '$uid' and oauth_provider = '$oauth_provider'") or die(mysql_error());
		$query = mysql_query("SELECT * FROM `f_users` WHERE user_ref = '$oauth_provider.$uid'") or die(mysql_error());
        $result = mysql_fetch_array($query);
        if (!empty($result)) {
            # User is already present
        } else {
            #user not present. Insert a new Record
			$sql="INSERT INTO `f_users`("
			."user_name,user_password,user_email,user_active,user_alert,user_reg_date,user_newsletter,user_twitter,user_ref)"
			."VALUES('".$username."','d41d8cd98f00b204e9800998ecf8427e','',1,1,NOW(),0,'".$twitter."','".$oauth_provider.".".$uid."')";
            $query = mysql_query($sql) or die(mysql_error());
			//$query = mysql_query("INSERT INTO `f_users` (oauth_provider, oauth_uid, username) VALUES ('$oauth_provider', $uid, '$username')") or die(mysql_error());
			//$query = mysql_query("INSERT INTO `f_users` (oauth_provider, oauth_uid, username) VALUES ('$oauth_provider', $uid, '$username')") or die(mysql_error());
            //$query = mysql_query("SELECT * FROM `l_users` WHERE oauth_uid = '$uid' and oauth_provider = '$oauth_provider'");
			$query = mysql_query("SELECT * FROM `f_users` WHERE user_ref = '$oauth_provider.$uid'") or die(mysql_error());
            $result = mysql_fetch_array($query);
            return $result;
        }
        return $result;
    }

    

}

?>
