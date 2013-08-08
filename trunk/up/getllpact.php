<?php
require_once "wp-config.php";
$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysql_select_db(DB_NAME);
define('APP_ID', '259354657479923');
define('APP_SECRET', '4b44387d94052ce5a11885b61367286a');
define('APP_PAGE', '308602152532791');
$pagename = "FootyGoat.com";
require 'livefootystats/lbfb/facebook/facebook.php';
$homeurl = "http://www.footygoat.com/getllpact.php";
$fbPermissions = 'publish_stream,manage_pages,publish_actions,status_update';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array('appId' => APP_ID, 'secret' => APP_SECRET));

// Get User ID
$user = $facebook->getUser();
//Lists all the applications and pages
if ($user) {
    //print_r($user);
    $pageACT = "";
    try {
        // Proceed knowing you have a logged in user who's authenticated.
        $pages_list = $facebook->api('/me/accounts');
        //print_r($pages_list);
        $nbpages = count($pages_list);
        $v = 0;
        for ($i = 0; $i < $nbpages; $i++) {
            if ($pages_list['data']['$i']['name'] == $pname) {
                $v = $i;
                break;
            }
        }
        $pageACT = $pages_list['data'][$v]['access_token'];
    }
    catch (FacebookApiException $e) {
        $pageACT = "";
        error_log($e);
    }
        if ($pageACT) {
                //echo $pageACT."<br/>";
        } else {
            echo "NULL<br/>"; 
            exit(0);
        }
    $longACT = "";
    try {
        $graph_url = "https://graph.facebook.com/oauth/access_token?";
        $graph_url .= "client_id=" . APP_ID;
        $graph_url .= "&client_secret=" . APP_SECRET;
        $graph_url .= "&grant_type=fb_exchange_token";
        $graph_url .= "&fb_exchange_token=" . $pageACT;
        //echo $graph_url;
        $response = @file_get_contents($graph_url);
        $params = null;
        parse_str($response, $params);
        $new_token = $params['access_token'];
        $longACT = $new_token;
    }
    catch (exception $e1) {
        $longACT = "";
        error_log($e1);
    }

    if ($longACT) {
        echo "Page token is saved into dabatase. Please re-access this url in 60 days.";
        add_g_option("fb-page-act",$longACT);
		add_g_option("fb-page-act-date","Date ".date("Y-m-d h:i:s"));
        //echo $longACT;
    } else {
        echo "Error -1";
    }
} else {
    $loginUrl = $facebook->getLoginUrl(array('redirect_uri' => $homeurl, 'scope' =>
            $fbPermissions));
    echo '<a href="' . $loginUrl . '">Please login via Facebook</a>';
}
function add_g_option($gname,$gvalue) {
    mysql_query("insert into wp_options (option_name,option_value) value ('$gname','$gvalue') on duplicate key update option_value='$gvalue'");
}
?>
