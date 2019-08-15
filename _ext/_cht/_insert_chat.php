<?php 
include_once("../../_sys/check_login_status.php");
if($user_ok == false){
    exit();
}
?><?php 
if (isset($_GET['action']) && $_GET['action'] == "chat_post"){
	/* if(strlen($_GET['data']) < 1){
		mysqli_close($db_connection);
	    echo "";
	    exit();
	} */
	$user2 = preg_replace('#[^a-z0-9]#i', '', $_GET['user']);
	$data = htmlspecialchars($_GET['data']);
	$data = mysqli_real_escape_string($db_connection, $data);
	$chatid = preg_replace('#[^0-9]#', '', $_GET['chatid']);

	$sql = "SELECT COUNT(id) FROM _users WHERE username='$user2'";
	$query = mysqli_query($db_connection, $sql);
	$row = mysqli_fetch_row($query);
	if($row[0] < 1){
		mysqli_close($db_connection);
		echo "$account_no_exist";
		exit();
	}
	$sql = "INSERT INTO chats(chatid, user1, user2, data, timesent) 
			VALUES('$chatid','$log_username','$user2','$data',now())";
	$query = mysqli_query($db_connection, $sql);
	$id = mysqli_insert_id($db_connection);
	$chat_sql = "UPDATE _useroptions SET lastchat=now() WHERE username='$log_username'";
	$chat_query = mysqli_query($db_connection, $chat_sql);
	
	$dsql = "SELECT COUNT(id) FROM chats WHERE chatid='$chatid'";
    $dquery = mysqli_query($db_connection, $dsql); 
	$row = mysqli_fetch_row($dquery);
	if ($row[0] > 19) { 
		$sql = "SELECT id FROM chats WHERE chatid='$chatid' ORDER BY id ASC";
    	$query = mysqli_query($db_connection, $sql); 
		$row = mysqli_fetch_row($query);
		$oldest = $row[0];
		mysqli_query($db_connection, "DELETE FROM chats WHERE id='$oldest'");
	}
}
?><?php
$chatlist = "";
$seen_eye = "";
$sql = "SELECT * FROM chats WHERE chatid='$chatid' ORDER BY timesent ASC LIMIT 100";
$query = mysqli_query($db_connection, $sql);
while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$user1 = $row["user1"];
	$user2 = $row["user2"];
	$timesent = strftime("%b %d %I:%M %p", strtotime($row["timesent"]) + 60 * 60 * 7);
	$data = $row['data'];
	$seen = $row['seen'];
	
	if($seen == '0'){
		$seen_eye = '';
	}else{
		$seen_eye = '<i class="fa fa-eye"></i>';
	}
	$sql1 = "SELECT avatar FROM _useroptions WHERE username='$user1'";
	$query1 = mysqli_query($db_connection, $sql1);
	while($row2 = mysqli_fetch_array($query1, MYSQLI_ASSOC)) {
		$user1_avatar = $row2["avatar"];
		if($user1_avatar != ""){
			$_pic1 = '_USER/'.$user1.'/'.$user1_avatar.'';
		} else {
			$_pic1 = '_ast/_img/avatardefault.png';
		}
	}
	if($user1 == $log_username){
		$chatlist .= '<div class="direct-chat-msg cright msg_b"><div class="direct-chat-info clearfix">';
		$chatlist .= '<span class="direct-chat-timestamp pull-left chattime"><time>'.$timesent.'</time> &nbsp;'.$seen_eye.'</span></div>';
		$chatlist .= '<img class="direct-chat-img" src="'.$_pic1.'" alt="'.$user1.'">';
		$chatlist .= '<div class="direct-chat-text" style="text-align:right;">'.$data.'</div></div>';        	
	}else{
		$chatlist .= '<div class="direct-chat-msg msg_a"><div class="direct-chat-info clearfix">';
		$chatlist .= '<span class="direct-chat-timestamp pull-right chattime"><time>'.$timesent.'</time></span></div>';
		$chatlist .= '<img class="direct-chat-img" src="'.$_pic1.'" alt="'.$user1.'">';
		$chatlist .= '<div class="direct-chat-text">'.$data.'</div></div>';
	}
}
echo $chatlist;
?>