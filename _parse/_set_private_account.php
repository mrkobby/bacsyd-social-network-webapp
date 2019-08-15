<?php
include_once("../_sys/check_login_status.php");
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php
if (isset($_POST['type'])){
	if($_POST['type'] == "check"){
		$sql = "UPDATE _useroptions SET privacy='1' WHERE username='$log_username'";
		$query = mysqli_query($db_connection, $sql);
		echo "check_ok";
		exit();
	} else if($_POST['type'] == "uncheck"){
		$sql = "UPDATE _useroptions SET privacy='0' WHERE username='$log_username'";
		$query = mysqli_query($db_connection, $sql);
		echo "uncheck_ok";
		exit();
	}
}
?>