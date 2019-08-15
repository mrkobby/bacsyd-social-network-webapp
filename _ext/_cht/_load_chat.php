<?php 
include_once("../../_sys/check_login_status.php");
if($user_ok == false){
    exit();
}
?><?php 
 if(isset($_GET["chatid"])){
	$chatid = preg_replace('#[^0-9]#', '', $_GET['chatid']);	
	mysqli_query($db_connection, "UPDATE chats SET seen='1' WHERE chatid='$chatid' AND user2='$log_username'");	  
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
		$chatlist .= '<span style="display:none;" class="direct-chat-timestamp pull-left chattime"><time>'.$timesent.'</time> &nbsp;'.$seen_eye.'</span></div>';
		$chatlist .= '<img class="direct-chat-img" src="'.$_pic1.'" alt="'.$user1.'">';
		$chatlist .= '<div class="direct-chat-text" style="text-align:right;">'.$data.'</div></div>';        	
	}else{
		$chatlist .= '<div class="direct-chat-msg msg_a"><div class="direct-chat-info clearfix">';
		$chatlist .= '<span style="display:none;" class="direct-chat-timestamp pull-right chattime"><time>'.$timesent.'</time></span></div>';
		$chatlist .= '<img class="direct-chat-img" src="'.$_pic1.'" alt="'.$user1.'">';
		$chatlist .= '<div class="direct-chat-text">'.$data.'</div></div>';
	}
}
echo $chatlist;
?>
