<?php 
include_once("../../_sys/check_login_status.php");
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php 
if (isset($_GET['action']) && $_GET['action'] == "status_post"){
	
	$type = preg_replace('#[^a-z]#', '', $_GET['type']);
	$account_name = preg_replace('#[^a-z0-9]#i', '', $_GET['user']);
	$data = nl2br($_GET['data']);
	$data = str_replace("&amp;","&",$data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = mysqli_real_escape_string($db_connection, $data);
	
	$limit = 5;
	$offset = 0;
	
	/* if($data < 1){
		mysqli_close($db_connection);
		echo '<div class="box box-header with-border"><h6 class="box-title" style="font-size: 12px;">#, &, \', + are special symbols, which are not allowed</h6></div>';
	    exit();
	} */
	if($type != "a" && $type != "c"){
		mysqli_close($db_connection);
		echo '<div class="box box-header with-border"><h6 class="box-title" style="font-size: 12px;">Undefined post type.</h6></div>';
	    exit();
	}
	

	$sql = "SELECT COUNT(id) FROM _users WHERE username='$account_name'";
	$query = mysqli_query($db_connection, $sql);
	$row = mysqli_fetch_row($query);
	if($row[0] < 1){
		mysqli_close($db_connection);
		echo '<div class="box box-header with-border"><h6 class="box-title" style="font-size: 12px;">Account does not exist</h6></div>';
		exit();
	}
	$sql = "INSERT INTO story(account_name, author, type, data, postdate) 
			VALUES('$account_name','$log_username','$type','$data',now())";
	$query = mysqli_query($db_connection, $sql);
	$id = mysqli_insert_id($db_connection);
	mysqli_query($db_connection, "UPDATE story SET osid='$id' WHERE id='$id' LIMIT 1");
	$sql = "SELECT COUNT(id) FROM story WHERE author='$log_username' AND type='a'";
    $query = mysqli_query($db_connection, $sql); 
	$row = mysqli_fetch_row($query);
	if ($row[0] > 29) { 
		$sql = "SELECT id FROM story WHERE author='$log_username' AND type='a' ORDER BY id ASC";
    	$query = mysqli_query($db_connection, $sql); 
		$row = mysqli_fetch_row($query);
		$oldest = $row[0];
		mysqli_query($db_connection, "DELETE FROM story WHERE osid='$oldest'");
		$sql = "SELECT image FROM story WHERE id='$oldest'";
		$_query = mysqli_query($db_connection, $sql);
		$row = mysqli_fetch_row($_query);
		$pic = $row[0];
		if($pic != ""){
			$picurl = "_USER/$log_username/$pic"; 
			if (file_exists($picurl)) { unlink($picurl); }
		}
	}
}
?><?php include_once("user_post_loader.php");?>