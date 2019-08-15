<?php
include_once("../_sys/check_login_status.php");
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php
if (isset($_POST['type']) && isset($_POST['user'])){
	$user = preg_replace('#[^a-z0-9]#i', '', $_POST['user']);
	$sql = "SELECT COUNT(id) FROM _users WHERE username='$user'";
	$query = mysqli_query($db_connection, $sql);
	$exist_count = mysqli_fetch_row($query);
	if($exist_count[0] < 1){
		mysqli_close($db_connection);
		echo "$user does not exist.";
		exit();
	}
	$frndstring = "";
	if($_POST['type'] == "friend"){
		$sql = "SELECT COUNT(id) FROM friends WHERE user1='$user' AND accepted='1' OR user2='$user' AND accepted='1'";
		$query = mysqli_query($db_connection, $sql);
		$friend_count = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(id) FROM blockedusers WHERE blocker='$user' AND blockee='$log_username'";
		$query = mysqli_query($db_connection, $sql);
		$blockcount1 = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(id) FROM blockedusers WHERE blocker='$log_username' AND blockee='$user'";
		$query = mysqli_query($db_connection, $sql);
		$blockcount2 = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(id) FROM friends WHERE user1='$log_username' AND user2='$user' AND accepted='1'";
		$query = mysqli_query($db_connection, $sql);
		$row_count1 = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(id) FROM friends WHERE user1='$user' AND user2='$log_username' AND accepted='1'";
		$query = mysqli_query($db_connection, $sql);
		$row_count2 = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(id) FROM friends WHERE user1='$log_username' AND user2='$user' AND accepted='0'";
		$query = mysqli_query($db_connection, $sql);
		$row_count3 = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(id) FROM friends WHERE user1='$user' AND user2='$log_username' AND accepted='0'";
		$query = mysqli_query($db_connection, $sql);
		$row_count4 = mysqli_fetch_row($query);
	    if($friend_count[0] > 1000){
            mysqli_close($db_connection);
	        echo "Sorry, $user currently has the maximum number of friends, and cannot accept more.";
	        exit();
        } else if($blockcount1[0] > 0){
            mysqli_close($db_connection);
	        echo "Oops! @$user has blocked you, request failed.";
	        exit();
        } else if($blockcount2[0] > 0){
            mysqli_close($db_connection);
	        echo "You must first unblock @$user.";
	        exit();
        } else if ($row_count1[0] > 0 || $row_count2[0] > 0) {
		    mysqli_close($db_connection);
	        echo "You're already friends with @$user.";
	        exit();
	    } else if ($row_count3[0] > 0) {
		    mysqli_close($db_connection);
	        echo "You have a pending friend request already sent to @$user.";
	        exit();
	    } else if ($row_count4[0] > 0) {
		    mysqli_close($db_connection);
	        echo "@$user has already requested to be friends with you. Check your notifications.";
	        exit();
	    } else {
	        $sql = "INSERT INTO friends(user1, user2, datemade) VALUES('$log_username','$user',now())";
		    $query = mysqli_query($db_connection, $sql);
			$sql = "SELECT id FROM followers WHERE user1='$log_username' AND user2='$user'";
			$query = mysqli_query($db_connection, $sql);
			$numrows = mysqli_num_rows($query);
			if ($numrows < 1) {
				$sql = "INSERT INTO followers(user1, user2, date_made) VALUES('$log_username','$user',now())";
				$query = mysqli_query($db_connection, $sql);
				mysqli_close($db_connection);
				$frndstring .= "friend_request_sent|||";
				$frndstring = trim($frndstring, "|||");		
				echo $frndstring;
				exit();
			} else {
				$sql = "UPDATE followers SET user1='$log_username',user2='$user' WHERE user1='$log_username' AND user2='$user'";
				$query = mysqli_query($db_connection, $sql);
				mysqli_close($db_connection);
				$frndstring .= "friend_request_sent|||";
				$frndstring = trim($frndstring, "|||");		
				echo $frndstring;
				exit();
			}
		}
	} else if($_POST['type'] == "unfriend"){
		$sql = "SELECT COUNT(id) FROM friends WHERE user1='$log_username' AND user2='$user' AND accepted='1'";
		$query = mysqli_query($db_connection, $sql);
		$row_count1 = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(id) FROM friends WHERE user1='$user' AND user2='$log_username' AND accepted='1'";
		$query = mysqli_query($db_connection, $sql);
		$row_count2 = mysqli_fetch_row($query);
	    if ($row_count1[0] > 0) {
			$sql9 = "SELECT id FROM friends WHERE user1='$log_username' AND user2='$user' AND accepted='1' LIMIT 1";
			$query9 = mysqli_query($db_connection, $sql9);
			while ($row = mysqli_fetch_array($query9, MYSQLI_ASSOC)) {
				$frndship_id = $row["id"];
			}	
	        $sql = "DELETE FROM friends WHERE user1='$log_username' AND user2='$user' AND accepted='1'";
			$query = mysqli_query($db_connection, $sql);
			mysqli_query($db_connection, "DELETE FROM chats WHERE chatid='$frndship_id'");
			mysqli_close($db_connection);
			$frndstring .= "unfriend_ok|$frndship_id|||";
			$frndstring = trim($frndstring, "|||");		
			echo $frndstring;
	        exit();
	    } else if ($row_count2[0] > 0) {
			$sql8 = "SELECT id FROM friends WHERE user1='$user' AND user2='$log_username' AND accepted='1' LIMIT 1";
			$query8 = mysqli_query($db_connection, $sql8);
			while ($row = mysqli_fetch_array($query8, MYSQLI_ASSOC)) {
				$frndship_id = $row["id"];
			}	
			$sql = "DELETE FROM friends WHERE user1='$user' AND user2='$log_username' AND accepted='1'";
			$query = mysqli_query($db_connection, $sql);
			mysqli_query($db_connection, "DELETE FROM chats WHERE chatid='$frndship_id'");
			mysqli_close($db_connection);
	        $frndstring .= "unfriend_ok|$frndship_id|||";
			$frndstring = trim($frndstring, "|||");		
			echo $frndstring;
	        exit();
	    } else {
			mysqli_close($db_connection);
	        echo "You are not friends with $user, therefore we cannot unfriend.";
	        exit();
		}
	}
}
?><?php
if (isset($_POST['action']) && isset($_POST['reqid']) && isset($_POST['user1'])){
	$reqid = preg_replace('#[^0-9]#', '', $_POST['reqid']);
	$user = preg_replace('#[^a-z0-9]#i', '', $_POST['user1']);
	$sql = "SELECT COUNT(id) FROM _users WHERE username='$user'";
	$query = mysqli_query($db_connection, $sql);
	$exist_count = mysqli_fetch_row($query);
	if($exist_count[0] < 1){
		mysqli_close($db_connection);
		echo "$user does not exist.";
		exit();
	}
	if($_POST['action'] == "accept"){
		$sql = "SELECT COUNT(id) FROM friends WHERE user1='$log_username' AND user2='$user' AND accepted='1'";
		$query = mysqli_query($db_connection, $sql);
		$row_count1 = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(id) FROM friends WHERE user1='$user' AND user2='$log_username' AND accepted='1'";
		$query = mysqli_query($db_connection, $sql);
		$row_count2 = mysqli_fetch_row($query);
	    if ($row_count1[0] > 0 || $row_count2[0] > 0) {
		    mysqli_close($db_connection);
	        echo "You are already friends with $user.";
	        exit();
	    } else {
			$sql = "UPDATE friends SET accepted='1' WHERE id='$reqid' AND user1='$user' AND user2='$log_username'";
			$query = mysqli_query($db_connection, $sql);
			$sql = "SELECT id FROM followers WHERE user1='$log_username' AND user2='$user'";
			$query = mysqli_query($db_connection, $sql);
			$numrows = mysqli_num_rows($query);
			if ($numrows > 0) {
				$sql = "UPDATE followers SET user1='$log_username', user2='$user' WHERE user2='$user' AND user1='$log_username'";
				$query = mysqli_query($db_connection, $sql);
			}else {
				$sql = "INSERT INTO followers(user1, user2, date_made) VALUES('$log_username','$user',now())";
				$query = mysqli_query($db_connection, $sql);
			}
			mysqli_close($db_connection);
	        echo "accept_ok";
	        exit();
		}
	} else if($_POST['action'] == "reject"){
		mysqli_query($db_connection, "DELETE FROM friends WHERE id='$reqid' AND user1='$user' AND user2='$log_username' AND accepted='0'");
		mysqli_close($db_connection);
		echo "reject_ok";
		exit();
	}
}
?>