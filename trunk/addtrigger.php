<?php
	error_reporting(0);
	include_once("dbconfig.php");
	if (isset($_POST['id'])) {
		if (isset($_POST['value'])) {
			list($tr_mask, $tr_type, $tr_user, $tr_field) = split("_",$_POST['id']);
			if (isset($tr_mask) && isset($tr_type) && isset($tr_user) && isset($tr_field)) { //cap nhat
				if ($tr_mask=="trig") { //check triger 
					$field="";
					if ($tr_type=="oper") $field="operater";
					else if ($tr_type=="home") $field="hvalue";
					else if ($tr_type=="away") $field="avalue";
					if ($field) {
						//kiem tra ton tai
						$value=$_POST['value'];
						/*
						$sql = "SELECT * FROM f_trigger WHERE user_id=$tr_user and field_id=$tr_field and operater!=''";
						$result = mysql_query($sql);
						if (mysql_num_rows($result)>0) { //da co
							$sql="UPDATE f_trigger SET $field='$value' where user_id=$tr_user and field_id=$tr_field";
						} else { //chua co
							$sql="INSERT INTO f_trigger (groupid,user_id,field_id,$field) VALUE (1,$tr_user,$tr_field,'$value')";
						}
						*/
						if ($value==" ") $sql  = "delete from f_trigger where groupid=1 and user_id=$tr_user and field_id=$tr_field" ;
						else $sql="INSERT INTO f_trigger (groupid,user_id,field_id,$field) VALUE (1,$tr_user,$tr_field,'$value') ON DUPLICATE KEY UPDATE $field='$value'";
						$result = mysql_query($sql);
						//echo $sql;
						echo $value;
						exit(0);
					}
				}
			} 
		}
	}
	
	//echo $_POST['value'];
	echo isset($_POST['old'])?$_POST['old']:"";
?>
