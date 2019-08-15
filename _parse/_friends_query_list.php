<?php 
$frndsList = '';
$sql = "SELECT COUNT(id) FROM friends WHERE user1='$u' AND accepted='1' OR user2='$u' AND accepted='1'";
$query = mysqli_query($db_connection, $sql);
$query_count = mysqli_fetch_row($query);
$friend_count = $query_count[0];
if($friend_count < 1){
	$frndsList = '<span> No friends yet </span>';
} else {
	$max = 8;
	$all_friends = array();
	$sql = "SELECT user1 FROM friends WHERE user2='$u' AND accepted='1' ORDER BY RAND() LIMIT $max";
	$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		array_push($all_friends, $row["user1"]);
	}
	$sql = "SELECT user2 FROM friends WHERE user1='$u' AND accepted='1' ORDER BY RAND() LIMIT $max";
	$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		array_push($all_friends, $row["user2"]);
	}
	$friendArrayCount = count($all_friends);
	if($friendArrayCount > $max){
		array_splice($all_friends, $max);
	}
	$orLogic = '';
	foreach($all_friends as $key => $user){
			$orLogic .= "username='$user' OR ";
	}
	$orLogic = chop($orLogic, "OR ");
	$frnd_sql = "SELECT username, avatar FROM _useroptions WHERE $orLogic ORDER BY RAND()";
	$frnd_query = mysqli_query($db_connection, $frnd_sql);
	while($row = mysqli_fetch_array($frnd_query, MYSQLI_ASSOC)) {
		$friend_username = $row["username"];
		$friend_avatar = $row["avatar"];
		$datesql = "SELECT datemade FROM friends WHERE user1='$u' AND user2='$friend_username' OR user2='$u' AND user1='$friend_username'";
		$_query = mysqli_query($db_connection, $datesql);
		while ($row2 = mysqli_fetch_array($_query, MYSQLI_ASSOC)) {
			$buddydate = strftime("%b %d", strtotime($row2["datemade"]));
		}
		$sql = "SELECT firstname, lastname FROM _users WHERE username='$friend_username'";
		$query = mysqli_query($db_connection, $sql);
		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$fnm = $row["firstname"];
			$lnm = $row["lastname"];
			if($friend_avatar != ""){
				$_pic = '_USER/'.$friend_username.'/'.$friend_avatar.'';
			} else {
				$_pic = '_ast/_img/avatardefault.png';
			}		
			$frndsList .= '<li><a class="hand" onclick="uid(\''.$friend_username.'\')"><img src="'.$_pic.'" alt="'.$friend_username.'"></a>';
			$frndsList .= '<a class="users-list-name hand" onclick="uid(\''.$friend_username.'\')" data-toggle="tooltip" title="'.$fnm.' '.$lnm.'"><span>'.$friend_username.'</span></a>';
			$frndsList .= '<span class="users-list-date">'.$buddydate.'</span></li>';
			}
		}
	}					
?>