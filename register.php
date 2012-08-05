<?php 
if (isset($_POST['user_id'])) {
include_once("dbconfig.php");
$err_str="";
$err_cnt=0;
$len;
$user_id=trim($_POST['user_id']);
$len=strlen($user_id);
$email=trim($_POST['email']);
$newsletter = isset($_POST['newsletter'])?1:0;
$twitter = trim($_POST['twitter']);

if($len>20){
	$err_str=$err_str."User ID is too long!<br/>";
	$err_cnt++;
}else if ($len<3){
	$err_str=$err_str."User ID is too short!<br/>";
	$err_cnt++;
}
if (!is_valid_user_name($user_id)){
	$err_str=$err_str."User ID only contains NUMBERs / LETTERs/ - / _ / . / <br/>";
	$err_cnt++;
}

if (strcmp($_POST['password'],$_POST['rptpassword'])!=0){
	$err_str=$err_str."Passwords does not match!<br/>";
	$err_cnt++;
}
if (strlen($_POST['password'])<6){
	$err_cnt++;
	$err_str=$err_str."Password should be longer than 6!<br/>";
}

$len=strlen($_POST['email']);
if ($len>100){
	$err_str=$err_str."Email too long!<br/>";
	$err_cnt++;
}
if (!is_valid_email($_POST['email'])) {
	$err_str=$err_str."Email is invalid !<br/>";
	$err_cnt++;
}
if ($err_cnt>0){
	echo $err_str."<br/>";
	echo $user_id."<br/>";
	echo $email."<br/>";
	echo $newsletter."<br/>";
	echo $twitter."<br/>";
	//redirect("?",6);
	exit(0);
	
}
$password=MD5($_POST['password']);
$email=mysql_real_escape_string(htmlspecialchars ($email));
$sql="SELECT user_id FROM f_users WHERE user_name = '".$user_id."' or user_email = '".$email."'";
$result=mysql_query($sql);
$rows_cnt=mysql_num_rows($result);
mysql_free_result($result);
if ($rows_cnt){
	print "<script language='javascript'>\n";
	print "alert('User or Email Existed!\\n');";
	print "history.go(-1);";
	echo "</script>";
	exit(0);
}


$sql="INSERT INTO `f_users`("
."user_name,user_password,user_email,user_active,user_alert,user_reg_date,user_newsletter,user_twitter)"
."VALUES('".$user_id."','".$password."','".$email."',1,1,NOW(),$newsletter,'$twitter')";
//echo $sql;
mysql_query($sql) or die(mysql_error());

echo "WELCOME";
echo "<br><a href='index.php'>Go to Home page</a>";
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
			'ad_tracking' => 'register',
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
//header("Location: index.php");
} else {
	require_once("maincore.php");
if ($MEMBER) {
	echo "<a href='logout.php'>Please logout first</a>";
	exit(0);
}
?>
<html>
<head>
<title>Footygoat: Register Page</title>
<style media="screen" type="text/css">
.require {
	color:#F00;
}
.hint {
	color:#666;
	font-style:italic;
	font-size:11px;
}
</style>
</head>
<body>
<form action="register.php" method="post">
	<br><br>
	<center><table>
		<tr><td colspan="2">PLEASE FILL INFORMATIONS</td></tr>
		<tr><td width=25%>User name:<span class="require">*</span></td>
			<td width=75%><input name="user_id" size="25" type="text"></td>
		</tr>
		<tr><td>Password:<span class="require">*</span></td>
			<td><input name="password" size="20" type="password"></td>
		</tr>
		<tr><td>Repeat password:<span class="require">*</span></td>
			<td><input name="rptpassword" size="20" type="password"></td>
		</tr>
		<tr><td>Email:<span class="require">*</span></td>
			<td><input name="email" size="30" type="text"></td>
		</tr>
		<tr><td>Newsletter</td>
			<td><input name="newsletter" type="checkbox" checked><span class='hint'>Check if you want receive newsletters from us</span></td>
		</tr>
		<tr><td>Twitter:</td>
			<td><input name="twitter" size="20" type="text"></td>
		</tr>
		<tr><td></td>
			<td><input value="Submit" name="submit" type="submit">
				&nbsp; &nbsp;
				<input value="Reset" name="reset" type="reset"></td>
		</tr>
		<tr><td colspan=2> (<span class="require">*</span>) required field.</td>
		</tr>
	</table></center>
	<br><br>
</form>
</body>
</html>
<?php
}
function check_all_in($chuoi, $abc) {
	$le = strlen($chuoi);
	for ($i=0; $i<$le; $i++) {
		if (strpos($abc,$chuoi[$i])==false) 
			return false;
		
	}
	return true;
}
function is_valid_user_name($ausername) {
	$abc = " _-.";
	for ($i=0; $i<=9; $i++) $abc.=chr($i+48);
	for ($i=65; $i<=90; $i++) $abc.=chr($i).chr($i+32);
	//echo $ausername.":".$abc."<br/>";
	return check_all_in($ausername,$abc);		
}
function is_valid_email($aemail) {
	if (!strpos($aemail,"@")) return false;
	if (!strpos($aemail,".")) return false;
	if (strpos($aemail," ")) return false;
	return true;
}
/*
function redirect($location, $delaytime = 0) {
    if ($delaytime>0) {    
        header( "refresh: $delaytime; url='".str_replace("&amp;", "&", $location)."'" );
    } else {
        header("Location: ".str_replace("&amp;", "&", $location));
    }    
}
*/
?>
