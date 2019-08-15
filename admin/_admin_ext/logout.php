<?php
session_start();
$_SESSION = array();
session_destroy();
if(isset($_SESSION['vid'])){
	header("location: ../../_sys/_error_msg.php?msg=Error:_Logout_Failed");
} else {
	header("location: ../login");
	exit();
} 
?>