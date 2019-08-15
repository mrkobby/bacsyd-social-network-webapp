<?php 
include_once("../../_sys/check_login_status.php");
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php 
if (isset($_GET['id']) && isset($_GET['user'])){
/* 	if(strlen($_GET['data']) < 1){
		mysqli_close($db_connection);
	    echo "data_empty";
	    exit();
	} */
	$id = $_GET['id'];
	$user = preg_replace('#[^a-z0-9]#i', '', $_GET['user']);
	$date = $_GET['date'];
	$sharedpic = $_GET['pic'];
	$sharetext = $_GET['sharetext'];
	$data = nl2br($_GET['data']);
	$data = str_replace("&amp;","&",$data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = mysqli_real_escape_string($db_connection, $data);
	
	$limit = 5;
	$offset = 0;
	
	$sql = "SELECT COUNT(id) FROM _users WHERE username='$user'";
	$query = mysqli_query($db_connection, $sql);
	$row = mysqli_fetch_row($query);
	if($row[0] < 1){
		mysqli_close($db_connection);
		echo '<div class="box box-header with-border"><h6 class="box-title" style="font-size: 12px;">Account does not exist</h6></div>';
		exit();
	}
	$sql = "INSERT INTO story(osid, account_name, author, type, data, datacaption, image,postdate) 
			VALUES('$id','$log_username','$user','x','$data','$sharetext','$sharedpic',now())";
	$query = mysqli_query($db_connection, $sql);
	$oid = mysqli_insert_id($db_connection);
	/* mysqli_query($db_connection, "UPDATE story SET osid='$id' WHERE id='$oid'"); */
	$osql = "SELECT COUNT(id) FROM story WHERE author='$log_username' AND type='x'";
    $oquery = mysqli_query($db_connection, $osql); 
	$row = mysqli_fetch_row($oquery);
	if ($row[0] > 9) { 
		$sql = "SELECT id FROM story WHERE author='$log_username' AND type='x' ORDER BY id ASC";
    	$query = mysqli_query($db_connection, $sql); 
		$row = mysqli_fetch_row($query);
		$oldest = $row[0];
		mysqli_query($db_connection, "DELETE FROM story WHERE osid='$oldest'");
	}
	$app = 'status_share';
	$note = $log_username;		
	if($user != $log_username){
		mysqli_query($db_connection, "INSERT INTO alerts(story_id, username, initiator, app, note, date_time) VALUES('$oid','$user','$log_username','$app','$note',now())");
	}
}
?><?php include_once("user_post_loader.php");?>