<?php
$u = "";
$user_background = "";
if(isset($_GET["u"])){
	$u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
} else {
    header("location: ../bacsyd");
    exit();	
}
$sql = "SELECT * FROM _users WHERE username='$u'";
$user_query = mysqli_query($db_connection, $sql);
$numrows = mysqli_num_rows($user_query);
if($numrows < 1 ){
	header("location: _sys/_error_msg.php?msg=That user does not exist");
    exit();	
}
	while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
		$user_profile_id = $row["id"];
		$uname = $row["username"];
		$fname = $row["firstname"];
		$lname = $row["lastname"];
		$user_email = $row["email"];
	}
$sql = "SELECT * FROM _useroptions WHERE username='$u'";
$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$user_avatar = $row["avatar"];
		$user_status = $row["userstatus"];
		$user_background = $row["background"];
		$user_privacy = $row["privacy"];
	}
$sql = "SELECT * FROM _userinfo WHERE username='$u'";
$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$user_gender = $row["gender"];
		$user_signup = $row["signup"];
		$user_member = strftime("%b %d, %Y", strtotime($user_signup));
		$user_lastlogin = $row["lastlogin"];
		$user_joindate = strftime("%b %d, %Y", strtotime($user_signup));
		$user_lastsession = strftime("%b %d, %Y", strtotime($user_lastlogin));
		$stat = $row["status"];
	}
$sql = "SELECT * FROM _userdetails WHERE username='$u'";
$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$user_education = $row["education"];
		$user_location = $row["location"];
		$user_hometown = $row["hometown"];
		$user_profession = $row["profession"];
		$user_mobile = $row["mobile"];
	}
$sql = "SELECT * FROM _userbasic WHERE username='$u'";
$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$user_nickname = $row["nickname"];
		$user_relationship = $row["relationship"];
		$user_country = $row["country"];
	}
?>