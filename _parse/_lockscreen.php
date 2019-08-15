<?php 
include_once("../_sys/check_login_status.php");
if($user_ok == false){
	header("location: ../");
    exit();
}
mysqli_query($db_connection, "UPDATE _useroptions SET state='lock' WHERE username='$log_username'");
if(isset($_SESSION['username'])){
	header("location: ../lock&".$log_username."");
	exit();
} else {
	header("location: ../_sys/_error_msg.php?msg=Error:_Logout_Failed");
} 
?>