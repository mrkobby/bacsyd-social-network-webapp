<?php
include_once("../_sys/check_login_status.php");
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php
if (isset($_POST['action']) && $_POST['action'] == "get_ffnum"){
	$fllwsql = "SELECT COUNT(id) FROM followers WHERE user1='$log_username'";
	$fllwquery = mysqli_query($db_connection, $fllwsql);
	$fllw_count = mysqli_fetch_row($fllwquery);
	$follow_count = $fllw_count[0];	
	if($follow_count < 3){
		mysqli_close($db_connection);
		echo "get_failed";
		exit();
	}else{
		echo $follow_count;
		exit();
	}

}
?>