<?php
include_once("../_sys/check_login_status.php");
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php
if (isset($_POST["show"]) && $_POST["show"] == "galpics"){
	$picstring = "";
	$gallery = preg_replace('#[^a-z 0-9,]#i', '', $_POST["gallery"]);
	$user = preg_replace('#[^a-z0-9]#i', '', $_POST["user"]);
	$sql = "SELECT * FROM photos WHERE user='$user' AND gallery='$gallery' ORDER BY uploaddate ASC";
	$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$id = $row["id"];
		$filename = $row["filename"];
		//$description = $row["description"];
		$uploaddate = $row["uploaddate"];
		$picstring .= "$id|$filename|$uploaddate|||";
    }
	mysqli_close($db_connection);
	$picstring = trim($picstring, "|||");
	echo $picstring;
	exit();
}
?><?php 
if (isset($_POST["delete"]) && $_POST["id"] != ""){
	$id = preg_replace('#[^0-9]#', '', $_POST["id"]);
	$query = mysqli_query($db_connection, "SELECT user, filename, postid FROM photos WHERE id='$id'");
	$row = mysqli_fetch_row($query);
    $user = $row[0];
	$filename = $row[1];
	$postid = $row[2];
	if($user == $log_username){
		$picurl = "../_USER/$log_username/$filename"; 
	    if (file_exists($picurl)) {
			unlink($picurl);
			$sql = "DELETE FROM photos WHERE id='$id'";
	        $query = mysqli_query($db_connection, $sql);
			mysqli_query($db_connection, "DELETE FROM story WHERE id='$postid'");
			mysqli_query($db_connection, "DELETE FROM story WHERE osid='$postid' AND type='b'");
			mysqli_query($db_connection, "DELETE FROM storylikes WHERE storyid='$postid'");
		}
	}
	mysqli_close($db_connection);
	echo "deleted_ok";
	exit();
}
?>