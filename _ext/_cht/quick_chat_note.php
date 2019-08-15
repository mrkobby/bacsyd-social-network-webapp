<?php
include_once("../_includes/check_login_status.php");
if($user_ok == false){
	header("location: ../index.php");
    exit();
}
$bubble = 'style="display:;opacity:1;"';
$msg = '<span class="fa fa-envelope fa-fw"></span>';
$note_check = "SELECT COUNT(id) FROM chats WHERE user2='$log_username' AND seen='0'";
	$note_query = mysqli_query($db_connection, $note_check);
	$count_query = mysqli_fetch_row($note_query);
	$note_count = $count_query[0];
	if($note_count > 0 ){
		$msg = '<span class="fa fa-envelope fa-fw"></span><div '.$bubble.' class="bell"><span class="badge bg-red">'.$note_count.'</span></div>';
	}
echo $msg;
?>