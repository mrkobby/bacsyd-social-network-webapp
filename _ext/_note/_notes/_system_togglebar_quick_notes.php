<?php
include_once("../../../_sys/check_login_status.php");
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php
$note_label = '<span class="label label-danger" style="position: absolute;left: 30px;top: 5px;"></span>';
$sql = "SELECT notecheck FROM _userinfo WHERE username='$log_username'";
$query = mysqli_query($db_connection, $sql);
$row = mysqli_fetch_row($query);
$lastnotecheck = $row[0];

$sql = "SELECT COUNT(id) FROM alerts WHERE username LIKE BINARY '$log_username' AND date_time > '$lastnotecheck'";
$query = mysqli_query($db_connection, $sql);
$query_count = mysqli_fetch_row($query);
$note_count2 = $query_count[0];
$mynotenum = $note_count2;
	if($mynotenum > 0) {
		$note_label = '<span class="label label-danger" data-toggle="offcanvas" style="position: absolute;left: 30px;top: 5px;">'.$mynotenum.'</span>';
	}
echo $note_label;
?>