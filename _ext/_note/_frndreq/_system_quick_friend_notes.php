<?php
include_once("../../../_sys/check_login_status.php");
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php
$frnd_note = '<i class="fa fa-group"></i><span class="label label-danger"></span>';
if($user_ok == true) {
	$sql = "SELECT notecheck FROM _userinfo WHERE username='$log_username'";
	$query = mysqli_query($db_connection, $sql);
	$row = mysqli_fetch_row($query);
	$lastnotecheck = $row[0];
	$sql = "SELECT COUNT(id) FROM friends WHERE user2='$log_username' AND datemade > '$lastnotecheck' AND accepted = '0'";
	$query = mysqli_query($db_connection,$sql);
	$numrows = mysqli_num_rows($query);
	$query_count = mysqli_fetch_row($query);
	$note_count1 = $query_count[0];
	$mynotenum = $note_count1;
	if($numrows > 0 && $mynotenum > 0) {
		$frnd_note = '<i class="fa fa-group"></i><span class="label label-danger">'.$mynotenum.'</span>';
	}
}
echo $frnd_note;
?>