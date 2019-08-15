<?php
include_once("../_sys/check_login_status.php");
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php
if (isset($_POST['type']) && isset($_POST['user2'])){
	$user2 = preg_replace('#[^a-z0-9]#i', '', $_POST['user2']);
	$sql = "SELECT COUNT(id) FROM _users WHERE username='$user2'";
	$query = mysqli_query($db_connection, $sql);
	$exist_count = mysqli_fetch_row($query);
	if($exist_count[0] < 1){
		mysqli_close($db_connection);
		echo "$user does not exist.";
		exit();
	}
	$sql = "SELECT id FROM followers WHERE user1='$log_username' AND user2='$user2'";
	$query = mysqli_query($db_connection, $sql);
	$numrows = mysqli_num_rows($query);
	$sql = "SELECT COUNT(id) FROM blockedusers WHERE blocker='$user2' AND blockee='$log_username'";
	$query = mysqli_query($db_connection, $sql);
	$blockcount1 = mysqli_fetch_row($query);
	if($_POST['type'] == "follow"){
	    if ($numrows > 0) {
			mysqli_close($db_connection);
	        echo "You already follow this user.";
	        exit();
	    } else if($blockcount1[0] > 0){
            mysqli_close($db_connection);
	        echo "Oops! @$user2 has blocked you, following failed.";
	        exit();
        }else {		
			$sql = "INSERT INTO followers(user1, user2, date_made) VALUES('$log_username','$user2',now())";
			$query = mysqli_query($db_connection, $sql);
			mysqli_close($db_connection);
	        echo "follow_ok";
	        exit();
		}
	} else if($_POST['type'] == "unfollow"){
	    if ($numrows == 0) {
		    mysqli_close($db_connection);
	        echo "You can't unfollow someone you're not following.";
	        exit();
	    } else {
			$sql = "DELETE FROM followers WHERE user1='$log_username' AND user2='$user2'";
			$query = mysqli_query($db_connection, $sql);
			mysqli_close($db_connection);
	        echo "unfollow_ok";
	        exit();
		}
	}
}
?>