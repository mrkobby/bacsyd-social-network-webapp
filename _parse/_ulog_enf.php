<?php
$u = "";
$user_background = "";
if(isset($_GET["u"])){
	$u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
} else {
    header("location: ../bacsyd");
    exit();	
}
$sql = "SELECT * FROM _users WHERE username='$log_username'";
$user_query = mysqli_query($db_connection, $sql);
$numrows = mysqli_num_rows($user_query);
if($numrows < 1 ){
	header("location: _sys/_error_msg.php?msg=That user does not exist");
    exit();	
}
	while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
		$profile_id = $row["id"];
		$username = $row["username"];
		$firstname = $row["firstname"];
		$lastname = $row["lastname"];
		$email = $row["email"];
	}
$sql = "SELECT * FROM _useroptions WHERE username='$log_username'";
$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$avatar = $row["avatar"];
		$status = $row["userstatus"];
		$background = $row["background"];
		$privacy = $row["privacy"];
		$state = $row["state"];
	}
$sql = "SELECT * FROM _userinfo WHERE username='$log_username'";
$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$gender = $row["gender"];
		$ip = $row["ip"];
		$signup = $row["signup"];
		$member = strftime("%b %d, %Y", strtotime($signup));
		$lastlogin = $row["lastlogin"];
		$joindate = strftime("%b %d, %Y", strtotime($signup));
		$lastsession = strftime("%b %d, %Y", strtotime($lastlogin));
		$stat = $row["status"];
	}
$sql = "SELECT * FROM _userdetails WHERE username='$log_username'";
$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$education = $row["education"];
		$location = $row["location"];
		$hometown = $row["hometown"];
		$profession = $row["profession"];
		$mobile = $row["mobile"];
	}
$sql = "SELECT * FROM _userbasic WHERE username='$log_username'";
$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$nickname = $row["nickname"];
		$relationship = $row["relationship"];
		$country = $row["country"];
	}
?>