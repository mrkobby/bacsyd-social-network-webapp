<?php
if (isset($_GET['id']) && isset($_GET['u']) && isset($_GET['e']) && isset($_GET['p'])) {
	$message = "";
    include_once("_sys/db_connection.php");
    $id = preg_replace('#[^0-9]#i', '', $_GET['id']); 
	$u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
	$e = mysqli_real_escape_string($db_connection, $_GET['e']);
	$p = mysqli_real_escape_string($db_connection, $_GET['p']);
	if($id == "" || strlen($u) < 3 || strlen($e) < 5 || strlen($p) == ""){
		header("location: _sys/_error_msg.php?msg=activation_string_length_issues");
    	exit(); 
	}
	$sql = "SELECT * FROM _users WHERE id='$id' AND username='$u' AND email='$e' AND password='$p' LIMIT 1";
    $query = mysqli_query($db_connection, $sql);
	$numrows = mysqli_num_rows($query);
	if($numrows == 0){
		header("location: _sys/_error_msg.php?msg=Your credentials are not matching anything in our system");
    	exit();
	}
	$sql = "UPDATE _usersecurity SET activation='1' WHERE id='$id' LIMIT 1";
    $query = mysqli_query($db_connection, $sql);
	
	$checksql = "SELECT * FROM _usersecurity WHERE id='$id' AND activation='1' LIMIT 1";
    $checkquery = mysqli_query($db_connection, $checksql);
	$numrows = mysqli_num_rows($checkquery);
    if($numrows == 0){
		header("location: _sys/_error_msg.php?msg=activation_failure");
    	exit();
    } else if($numrows == 1) {
		header("location: _sys/_error_msg.php?msg=Account activation was successful!");
    	exit();
    }
} else {
	header("location: _sys/_error_msg.php?msg=missing_GET_variables");
    exit(); 
}
?>