<?php
session_start();
include_once("admin_db_connection.php");
$id_ok = false;
$v_id = "";
$v_vid = "";
$v_password = "";

function evalLoggedVid($db_connection,$id,$vid,$pass){
	$sql = "SELECT * FROM admin WHERE id='$id' AND vid='$vid' AND password='$pass'";
    $query = mysqli_query($db_connection, $sql);
    $numrows = mysqli_num_rows($query);
	if($numrows > 0){
		return true;
	}
}
if(isset($_SESSION["id"]) && isset($_SESSION["vid"]) && isset($_SESSION["pass"])) {
	$v_id = preg_replace('#[^0-9]#', '', $_SESSION['id']);
	$v_vid = preg_replace('#[^a-z0-9]#i', '', $_SESSION['vid']);
	$v_password = preg_replace('#[^a-z0-9]#i', '', $_SESSION['pass']);
	
	$id_ok = evalLoggedVid($db_connection,$v_id,$v_vid,$v_password);
}
?>