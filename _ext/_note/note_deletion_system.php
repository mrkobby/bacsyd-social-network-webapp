<?php
include_once("../../_sys/check_login_status.php");
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php 
if (isset($_POST['action']) && $_POST['action'] == "delete_note"){
	if(!isset($_POST['noteid']) || $_POST['noteid'] == ""){
		mysqli_close($db_connection);
		exit();
	}
	$noteid = preg_replace('#[^0-9]#', '', $_POST['noteid']);
	$query = mysqli_query($db_connection, "SELECT * FROM alerts WHERE id='$noteid'");
	mysqli_query($db_connection, "DELETE FROM alerts WHERE id='$noteid'");
	mysqli_close($db_connection);
	echo "delete_ok";
	exit();

}
?>