<?php
include_once("admin_check_status.php");
if($id_ok != true) {
	exit();
}
?><?php 
if (isset($_POST['action']) && $_POST['action'] == "delete_user"){
	if(!isset($_POST['userid']) || $_POST['userid'] == ""){
		mysqli_close($db_connection);
		echo "user id is missing";
		exit();
	}
	$userid = preg_replace('#[^0-9]#', '', $_POST['userid']);
	$query = mysqli_query($db_connection, "SELECT username FROM _users WHERE id='$userid' LIMIT 1");
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$u = $row["username"]; 
	}
	$userFolder = "../../_USER/$u";
	  if(is_dir($userFolder)) {
		deleteUserDir($userFolder);
      }
	mysqli_query($db_connection, "DELETE FROM _users WHERE username='$u'");
	mysqli_query($db_connection, "DELETE FROM _userthumbnails WHERE username='$u'");
	mysqli_query($db_connection, "DELETE FROM _useroptions WHERE username='$u'");
	mysqli_query($db_connection, "DELETE FROM _userinfo WHERE username='$u'");
	mysqli_query($db_connection, "DELETE FROM _userdetails WHERE username='$u'");
	mysqli_query($db_connection, "DELETE FROM _userbasic WHERE username='$u'");
	mysqli_query($db_connection, "DELETE FROM _usersecurity WHERE username='$u'");
	mysqli_query($db_connection, "DELETE FROM storylikes WHERE username='$u' OR author='$u'");	
	mysqli_query($db_connection, "DELETE FROM story WHERE author='$u' OR account_name='$u'");
	mysqli_query($db_connection, "DELETE FROM photos WHERE user='$u'");
	mysqli_query($db_connection, "DELETE FROM friends WHERE user1='$u' OR user2='$u'");
	mysqli_query($db_connection, "DELETE FROM followers WHERE user1='$u' OR user2='$u'");	
	mysqli_query($db_connection, "DELETE FROM blockedusers WHERE blocker='$u' OR blockee='$u'");
	mysqli_query($db_connection, "DELETE FROM alerts WHERE username='$u' OR initiator='$u'");
	mysqli_query($db_connection, "DELETE FROM chats WHERE user1='$u' OR user2='$u'");
	
	mysqli_close($db_connection);
	echo "delete_ok";
	exit();
}
?><?php 
function deleteUserDir($dirPath){
	if(!is_dir($dirPath)){
		return unlink($dirPath);
	}
	foreach(scandir($dirPath) as $item){
		if($item == '.' || $item == '..'){
			continue;
		}
		if(!deleteUserDir($dirPath . DIRECTORY_SEPARATOR . $item)){
			return false;
		}
	}
	return rmdir($dirPath);
}
?>