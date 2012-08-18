<?php
	error_reporting(0);
	session_start();

	include_once("dbconfig.php");
	if (isset($_POST['email']) && isset($_POST['news'])) {
		$sql="select * from f_users where user_email='".$_POST['email']."'";
		$result = mysql_query($sql);
		if (mysql_num_rows($result)) {
			echo "This email was used.";
		} else {
			$sql = "update f_users set user_email='".$_POST['email']."',user_newsletter=".$_POST['news']." where user_id=".$_SESSION['user_id'];
			$result = mysql_query($sql);
			if ($result) echo "SUCCESSFULLY"; 
			//else echo "FAIL";
			else echo $sql;
			if ($newsletter==1)  {
				require_once('aweber_api/aweber_api.php');

				$consumerKey    = 'AklC43NyFSOKqrJBAp4WDSCd'; # put your credentials here
				$consumerSecret = 'ODsK8tkqL26rzEw9AOtVSuTaLelU7C2g7OMFF8FF'; # put your credentials here
				$accessKey      = 'AgJ1XCVOD9uOdLTi8337nwpV'; # put your credentials here
				$accessSecret   = 'llRDzI4C59okacg6hqu0cs7gaTr3OAtUFA4w87rr'; # put your credentials here
				$account_id     = '632603'; # put the Account id here
				$list_id        = '2239314'; # put the List id here

				$aweber = new AWeberAPI($consumerKey, $consumerSecret);

				try {
					$account = $aweber->getAccount($accessKey, $accessSecret);
					$listURL = "/accounts/{$account_id}/lists/{$list_id}";
					$list = $account->loadFromUrl($listURL);

					# create a subscriber
					$params = array(
						'email' => $email,
						'ip_address' => $_SERVER['REMOTE_ADDR'],
						'ad_tracking' => 'update',
						'last_followup_message_number_sent' => 1,
						'misc_notes' => 'footygoat',
						'name' => $user_id
					);
					$subscribers = $list->subscribers;
					$new_subscriber = $subscribers->create($params);

					# success!
					//print "$new_subscriber->email was added to the $list->name list!";

				} catch(AWeberAPIException $exc) {
					print "<h3>AWeberAPIException:</h3>";
					print " <li> Type: $exc->type              <br>";
					print " <li> Msg : $exc->message           <br>";
					print " <li> Docs: $exc->documentation_url <br>";
					print "<hr>";
					exit(1);
				}
			}
		}
	} else echo "MISS";
?>
