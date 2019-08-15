<?php 
include_once("../../_sys/check_login_status.php");
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php
if(isset($_GET["user"])){
	$account_name =  $_GET['user']; 	
}
?><?php include_once("profile_post_loader.php");?>