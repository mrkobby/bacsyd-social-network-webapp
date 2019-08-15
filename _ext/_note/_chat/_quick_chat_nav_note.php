<?php
include_once("../../../_sys/check_login_status.php");
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php
$chat_nav_note_num = '';
$note_check = "SELECT COUNT(id) FROM chats WHERE user2='$log_username' AND seen='0'";
	$note_query = mysqli_query($db_connection, $note_check);
	$count_query = mysqli_fetch_row($note_query);
	$note_count = $count_query[0];
	if($note_count > 0 ){
		$chat_nav_note_num = $note_count;
	}
echo $chat_nav_note_num;
?>