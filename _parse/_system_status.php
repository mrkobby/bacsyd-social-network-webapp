<?php
include_once("../_sys/check_login_status.php");
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php 
if (isset($_POST['action']) && $_POST['action'] == "delete_status"){
	if(!isset($_POST['statusid']) || $_POST['statusid'] == ""){
		mysqli_close($db_connection);
		echo "status id is missing";
		exit();
	}
	$statusid = preg_replace('#[^0-9]#', '', $_POST['statusid']);
	$query = mysqli_query($db_connection, "SELECT account_name, author FROM story WHERE id='$statusid'");
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$account_name = $row["account_name"]; 
		$author = $row["author"];
	}
    if ($author == $log_username || $account_name == $log_username) {
		$sql = "SELECT image FROM story WHERE id='$statusid' AND type='a'";
		$_query = mysqli_query($db_connection, $sql);
		$row = mysqli_fetch_row($_query);
		$pic = $row[0];
		if($pic != ""){
			$picurl = "../_USER/$log_username/$pic"; 
			if (file_exists($picurl)) { unlink($picurl); }
		}
		mysqli_query($db_connection, "DELETE FROM story WHERE id='$statusid'");
		mysqli_query($db_connection, "DELETE FROM story WHERE osid='$statusid' AND type='b'");
		mysqli_query($db_connection, "DELETE FROM storylikes WHERE storyid='$statusid'");	
		mysqli_close($db_connection);
	    echo "delete_ok";
		exit();
	}else{
		exit();
	}
}
?><?php 
if (isset($_POST['action']) && $_POST['action'] == "delete_reply"){
	if(!isset($_POST['replyid']) || $_POST['replyid'] == ""){
		mysqli_close($db_connection);
		exit();
	}
	$replyid = preg_replace('#[^0-9]#', '', $_POST['replyid']);
	$query = mysqli_query($db_connection, "SELECT osid, account_name, author FROM story WHERE id='$replyid'");
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$osid = $row["osid"];
		$account_name = $row["account_name"];
		$author = $row["author"];
	}
    if ($author == $log_username || $account_name == $log_username) {
		mysqli_query($db_connection, "DELETE FROM story WHERE id='$replyid'");
		mysqli_close($db_connection);
	    echo "delete_ok";
		exit();
	}else{
		exit();
	}
}
?>