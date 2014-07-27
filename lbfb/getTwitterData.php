<?php
ob_start();
require("twitter/twitteroauth.php");
require 'config/twconfig.php';
require 'config/functions.php';
session_start();

if (!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])) {
    // We've got everything we need
    $twitteroauth = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
// Let's request the access token
    $access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);
// Save it in a session var
    $_SESSION['access_token'] = $access_token;
// Let's get the user's info
    $user_info = $twitteroauth->get('account/verify_credentials');
// Print user's info
    echo '<pre>';
    print_r($user_info);
    echo '</pre><br/>';
    if (isset($user_info->error)) {
        // Something's wrong, go back to square 1  
        header('Location: login-twitter.php');
    } else {
        $uid = $user_info->id;
        $username = $user_info->name;
        $user = new User();
        $userdata = $user->checkUser($uid, 'twitter', $username,$user_info->screen_name);
        if(!empty($userdata)){
            session_start();
            $_SESSION['user_id'] = $userdata['user_id'];
			$_SESSION['oauth_id'] = $uid;
            $_SESSION['user_name'] = $username;
            $_SESSION['oauth_provider'] = 'twitter';
			if (!$user_info->following) {
				echo "Following...".$user_info->screen_name."<br/>";
				//$tofollow=$twitteroauth->post("friendships/create",array('screen_name' => $user_info->screen_name,'follow'=>true));
				$ourservice = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, AccessToken, AccessTokenS);
				//$tofollow=$twitteroauth->post("friendships/create",array('screen_name' => 'footygoat'));
				//print_r($ourservice->get('account/verify_credentials'));
				$tofollow=$ourservice->post("friendships/create",array('screen_name' => $user_info->screen_name));
				//logFollow($user_info->screen_name,makestring($tofollow));
				//print_r($tofollow);
				//exit(0);
			}
            header("Location: home.php");
			
        }
    }
} else {
    // Something's missing, go back to square 1
    header('Location: login-twitter.php');
}
function logFollow($user,$text) {
	$sql = "insert into f_logs (l_act,l_des,l_date) value ('follow_".$user."','$text',NOW())";
	mysql_query($sql) or die(mysql_error());
}
function makestring($array)
{
	$outval = "";
	foreach($array as $key=>$value) {
		if(is_array($value)) {
			$outval .= "$key\n";
			$outval .= makestring($value);
		}
		else {
			$outval .= "$key: $value\n";
		}
	}
	return $outval;
}
?>
