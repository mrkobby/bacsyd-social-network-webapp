<?php
include_once("../../../_sys/check_login_status.php");
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php
$chatList = '';
$msgBox = '';
$ownerBlockViewer = false;
$sql = "SELECT COUNT(id) FROM friends WHERE user1='$log_username' AND accepted='1' OR user2='$log_username' AND accepted='1'";
$query = mysqli_query($db_connection, $sql);
$query_count = mysqli_fetch_row($query);
$friend_count = $query_count[0];
if($friend_count < 1){
	$chatList = '<span> </span>';
} else {
	$max = 50;
	$all_friends = array();
	$sql = "SELECT user1 FROM friends WHERE user2='$log_username' AND accepted='1' ORDER BY RAND() LIMIT $max";
	$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		array_push($all_friends, $row["user1"]);
	}
	$sql = "SELECT user2 FROM friends WHERE user1='$log_username' AND accepted='1' ORDER BY RAND() LIMIT $max";
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
	$sql = "SELECT username, avatar FROM _useroptions WHERE $orLogic ORDER BY lastchat DESC";
	$query = mysqli_query($db_connection, $sql);
	while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$friend_username = $row["username"];
		$friend_avatar = $row["avatar"];
		if($friend_avatar != ""){
			$_pic = '_USER/'.$friend_username.'/'.$friend_avatar.'';
		} else {
			$_pic = '_ast/_img/avatardefault.png';
		}
		$ch_sql = "SELECT firstname, lastname FROM _users WHERE username='$friend_username'";
		$ch_query = mysqli_query($db_connection, $ch_sql);
			while ($row = mysqli_fetch_array($ch_query, MYSQLI_ASSOC)) {
				$ftname = $row["firstname"];
				$ltname = $row["lastname"];
			}			
		$sqli = "SELECT lastlogin, status FROM _userinfo WHERE username='$friend_username'";
		$queryi = mysqli_query($db_connection, $sqli);
			while ($row2 = mysqli_fetch_array($queryi, MYSQLI_ASSOC)) {
				$last_log = strftime("%b %d, %I:%M %p", strtotime($row2["lastlogin"]) + 60 * 60 * 7);
				$stat_check = $row2["status"];
			}
		if($stat_check == "online"){
			$status = '<i class="fa fa-circle text-success" style="font-size: 10px;margin-left:10px;"></i>';
			$status_text = 'online';
		}else{
			$status = '<i class="fa fa-circle" style="font-size: 10px;margin-left:10px; color: #e1e1e1;"></i>';
			$status_text = 'Not available now';
		}
		$id_check = "SELECT id FROM friends WHERE user1='$log_username' AND user2='$friend_username' AND accepted='1' OR user1='$friend_username' AND user2='$log_username' AND accepted='1'";
		$id_query = mysqli_query($db_connection, $id_check);
		while($row = mysqli_fetch_array($id_query, MYSQLI_ASSOC)) {
			$chat_id = $row["id"];
		}
		$note_check = "SELECT COUNT(id) FROM chats WHERE user1='$friend_username' AND user2='$log_username' AND seen='0'";
		$note_query = mysqli_query($db_connection, $note_check);
		$count_query = mysqli_fetch_row($note_query);
		$note_count = $count_query[0];
		$note_bubble = '';
		$note_mobile = '';
		if($note_count > 0 ){
			$note_bubble = '<span id="bb'.$chat_id.'" class="pull right"><span class="label label-primary pull-right" style="margin-right:10px;">'.$note_count.'</span></span>';
			$note_mobile = '<span id="bbm'.$chat_id.'" class="pull right"><span class="label label-primary pull-right" style="margin-right:10px;">'.$note_count.'</span></span>';
		}
		
		$chatList .= '<li id="ct_'.$chat_id.'" class="item fa-1x hand" onclick="OpenChat(\''.$chat_id.'\',\'bb'.$chat_id.'\',\''.$friend_username.'\',\'msg_body_'.$chat_id.'\');">';
		$chatList .= '<div class="product-img cu" style="border:1px solid black;"><a href="javascript:void(0)"><img class="img" src="'.$_pic.'" alt="'.$friend_username.'"></a></div>';
		$chatList .= '<div class="product-info-name"><a href="javascript:void(0)" class="product-title">'.$ftname.' '.$ltname.'</a>';
		$chatList .= ''.$status.''.$note_bubble.'';
		$chatList .= '<a href="javascript:void(0)"><span class="product-description">'.$status_text.'</span>';		
		$chatList .= '<small class="product-description"><time>'.$last_log.'</time></small></span></a></div></li>';					
	}
}
echo $chatList;
?>