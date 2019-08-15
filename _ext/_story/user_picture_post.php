<?php 
include_once("../../_sys/check_login_status.php");
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php 
if (isset($_FILES["photofile"]["name"]) && $_FILES["photofile"]["tmp_name"] != ""){
	
	$type = 'a';
	$account_name = $log_username;
	$data = nl2br($_POST['imgcaption']);
	$data = str_replace("&amp;","&",$data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = mysqli_real_escape_string($db_connection, $data);
	
	$limit = 5;
	$offset = 0;
	
	$fileName = $_FILES["photofile"]["name"];
    $fileTmpLoc = $_FILES["photofile"]["tmp_name"];
	$fileType = $_FILES["photofile"]["type"];
	$fileSize = $_FILES["photofile"]["size"];
	$fileErrorMsg = $_FILES["photofile"]["error"];
	$kaboom = explode(".", $fileName);
	$fileExt = end($kaboom);
	list($width, $height) = getimagesize($fileTmpLoc);
	if($width < 10 || $height < 10){
		echo '<div class="box box-header with-border"><h6 class="box-title" style="font-size: 12px;">Image file has no dimensions or the file size is probably too big. Choose a file with size below 3MB and try again. | <a class="hand" onclick="loadPosts()">Okay</a></h6></div>';
        exit();	
	}
	$db_file_name =  "pt".rand(100000000,999999999).".".$fileExt;
	if($fileSize > 5048576) {
		echo '<div class="box box-header with-border"><h6 class="box-title" style="font-size: 12px;">Your image file was larger than 5mb. | <a class="hand" onclick="loadPosts()">Okay</a></h6></div>';
		exit();	
	} else if (!preg_match("/\.(gif|jpg|png)$/i", $fileName) ) {
		echo '<div class="box box-header with-border"><h6 class="box-title" style="font-size: 12px;">Your image file was not jpg, gif or png type. | <a class="hand" onclick="loadPosts()">Okay</a></h6></div>';
		exit();
	} else if ($fileErrorMsg == 1) {
		echo '<div class="box box-header with-border"><h6 class="box-title" style="font-size: 12px;">An unknown error occurred. | <a class="hand" onclick="loadPosts()">Okay</a></h6></div>';
		exit();
	}
	$moveResult = move_uploaded_file($fileTmpLoc, "../../_USER/$log_username/$db_file_name");
	if ($moveResult != true) {
		echo '<div class="box box-header with-border"><h6 class="box-title" style="font-size: 12px;">File upload failed. | <a class="hand" onclick="loadPosts()">Okay</a></h6></div>';
		exit();
	}
	include_once("../../_sys/image_resize.php");
	$target_file = "../../_USER/$log_username/$db_file_name";
	$resized_file = "../../_USER/$log_username/$db_file_name";
	$wmax = 600;
	$hmax = 600;
	img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);
	
	$sql = "INSERT INTO story(account_name, author, type, data, postdate) 
			VALUES('$account_name','$log_username','$type','$data',now())";
	$query = mysqli_query($db_connection, $sql);
	$id = mysqli_insert_id($db_connection);
	mysqli_query($db_connection, "UPDATE story SET osid='$id' WHERE id='$id' LIMIT 1");
	mysqli_query($db_connection, "UPDATE story SET image='$db_file_name' WHERE id='$id' LIMIT 1");
	$sql = "SELECT COUNT(id) FROM story WHERE author='$log_username' AND type='a'";
    $query = mysqli_query($db_connection, $sql); 
	$row = mysqli_fetch_row($query);
	if ($row[0] > 19) { 
		$sql = "SELECT id FROM story WHERE author='$log_username' AND type='a' ORDER BY id ASC";
    	$query = mysqli_query($db_connection, $sql); 
		$row = mysqli_fetch_row($query);
		$oldest = $row[0];
		mysqli_query($db_connection, "DELETE FROM story WHERE id='$oldest'");
		$sql = "SELECT image FROM story WHERE id='$oldest'";
		$_query = mysqli_query($db_connection, $sql);
		$row = mysqli_fetch_row($_query);
		$pic = $row[0];
		if($pic != ""){
			$picurl = "_USER/$log_username/$pic"; 
			if (file_exists($picurl)) { unlink($picurl); }
		}
	}
}
?><?php include_once("user_post_loader.php");?>