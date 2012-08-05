<?php


function autofollows($tuser,$userpass) {
	$ch = curl_init("http://twitter.com/friendships/create/" . $tuser . ".json");
	curl_setopt($ch, CURLOPT_USERPWD, $userpass);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,"follow=true");					
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$apiresponse = curl_exec($ch);

	if ($apiresponse) {
		$response = json_decode($apiresponse);
		
		if ($response != null) {
			if (property_exists($response,"following")) {
				if ($response->following === true) {
					//echo "Now following " . $response->screen_name . "\n";
					return true;
				} else {
					//echo "Couldn't follow " . $response->screen_name . "\n";
					
				}
			} else {
				//echo "Follow limit exceeded, skipped " . $from_user . "\n";
			}
		}
		
	}

	curl_close($ch);
	return false;
}						
				
?>