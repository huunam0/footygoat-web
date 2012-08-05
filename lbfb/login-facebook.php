<?php
error_reporting(0);
require 'facebook/facebook.php';
require 'config/fbconfig.php';
require 'config/functions.php';
$facebook = new Facebook(array(
            'appId' => APP_ID,
            'secret' => APP_SECRET,
            'cookie' => true
        ));

$session = $facebook->getSession();

if (!empty($session)) {
    # Active session, let's try getting the user id (getUser()) and user info (api->('/me'))
    try {
        $uid = $facebook->getUser();
        $user = $facebook->api('/me');
    } catch (Exception $e) {
      print $e;
    }

    if (!empty($user)) {
        # User info ok? Let's print it (Here we will be adding the login and registering routines)
        echo '<pre>';
        print_r($user);
        echo '</pre><br/>';
        $username = $user['name'];
        $user = new User();
        $userdata = $user->checkUser($uid, 'facebook', $username);
        if(!empty($userdata)){
            session_start();
            $_SESSION['user_id'] = $userdata['user_id'];
			$_SESSION['oauth_id'] = $uid;
            $_SESSION['user_name'] = $username;
            $_SESSION['oauth_provider'] = 'facebook';
			$_SESSION['email'] = $userdata['user_email'];
            header("Location: home.php");
        } 
    } else {
        # For testing purposes, if there was an error, let's kill the script
        die("There was an error.");
    }
} else {
    # There's no active session, let's generate one
    $login_url = $facebook->getLoginUrl();
    header("Location: " . $login_url);
}
?>
