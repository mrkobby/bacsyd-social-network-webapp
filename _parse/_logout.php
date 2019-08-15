<?php 
include_once("../_sys/check_login_status.php");
if($user_ok == false){
    exit();
}
$sql = "UPDATE _userinfo SET status='offline' WHERE username='$log_username'";
$query = mysqli_query($db_connection, $sql);
?><?php
session_start();
$_SESSION = array();
if(isset($_COOKIE["id"]) && isset($_COOKIE["user"]) && isset($_COOKIE["pass"])) {
	setcookie("id", '', strtotime( '-5 days' ), '/');
    setcookie("user", '', strtotime( '-5 days' ), '/');
	setcookie("pass", '', strtotime( '-5 days' ), '/');
}
session_destroy();
if(isset($_SESSION['username'])){
	header("location: ../_sys/_error_msg.php?msg=Error:_Logout_Failed");
} else {
	header("location: ../");
	exit();
} 
?>