<?php 
include_once("../../_sys/check_login_status.php");
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php
if(isset($_GET['offset']) && isset($_GET['limit'])){
	$limit = $_GET['limit'];
	$offset = $_GET['offset'];
}
?><?php include_once("user_post_loader.php");?>