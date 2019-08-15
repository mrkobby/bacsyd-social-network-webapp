<?php
$db_connection = mysqli_connect("localhost","root","","bacsyd");
if (mysqli_connect_errno()){
		echo mysqli_connect_error();
		exit();
}/* else{
	echo "Successful connected to database!";
} */
?>