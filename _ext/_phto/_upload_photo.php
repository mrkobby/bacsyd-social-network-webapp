<?php
include_once("../../_sys/check_login_status.php");
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php
if (isset($_FILES["photo"]["name"]) && isset($_POST["gallery"])){
	$sql = "SELECT COUNT(id) FROM photos WHERE user='$log_username'";
	$query = mysqli_query($db_connection, $sql);
	$row = mysqli_fetch_row($query);
	if($row[0] > 49){
		echo "Only 50 pictures allowed. Refresh the page and delete old photos";
        exit();	
	}
	$gallery = preg_replace('#[^a-z 0-9,]#i', '', $_POST["gallery"]);
	$fileName = $_FILES["photo"]["name"];
    $fileTmpLoc = $_FILES["photo"]["tmp_name"];
	$fileType = $_FILES["photo"]["type"];
	$fileSize = $_FILES["photo"]["size"];
	$fileErrorMsg = $_FILES["photo"]["error"];
	$kaboom = explode(".", $fileName);
	$fileExt = end($kaboom);
	$db_file_name = date("DMjGisY")."".rand(1000,9999).".".$fileExt;
	list($width, $height) = getimagesize($fileTmpLoc);
	if($width < 10 || $height < 10){
		echo "That image has no dimensions or the file size is probably too big. Choose a file with size below 5MB and try again. Or just refresh the page";
        exit();	
	}
	if($fileSize > 5048576) {
		echo "Your image file is larger than 5mb. Try another image or just refresh the page";
		exit();	
	} else if (!preg_match("/\.(gif|jpg|png)$/i", $fileName) ) {
		echo "Your image file was not jpg, gif or png type. Try another image or just refresh the page";
		exit();
	} else if ($fileErrorMsg == 1) {
		echo "An unknown error occurred. Try again or just refresh the page";
		exit();
	}
	$moveResult = move_uploaded_file($fileTmpLoc, "../../_USER/$log_username/$db_file_name");
	if ($moveResult != true) {
		echo "File upload failed";
		exit();
	}
	include_once("../../_sys/image_resize.php");
	$wmax = 800;
	$hmax = 600;
	if($width > $wmax || $height > $hmax){
		$target_file = "../../_USER/$log_username/$db_file_name";
	    $resized_file = "../../_USER/$log_username/$db_file_name";
		img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);
	}
	$picture_post = "INSERT INTO story(account_name, author, type, image, postdate) VALUES ('$gallery','$log_username','p','$db_file_name',now())";
	$picture_post_query = mysqli_query($db_connection, $picture_post);
	$id = mysqli_insert_id($db_connection);
	mysqli_query($db_connection, "UPDATE story SET osid='$id' WHERE id='$id'");
	
	$sql = "INSERT INTO photos(user, gallery, filename, postid, uploaddate) VALUES ('$log_username','$gallery','$db_file_name','$id',now())";
	$query = mysqli_query($db_connection, $sql);
	
	if(isset($_POST["caption"]) > 0){
		$caption = nl2br($_POST['caption']);
		$caption = mysqli_real_escape_string($db_connection, $caption);
		mysqli_query($db_connection, "UPDATE photos SET description='$caption' WHERE postid='$id'");
		mysqli_query($db_connection, "UPDATE story SET data='$caption' WHERE id='$id'");
	}
}
?><?php
$gallery_list = "";
$sql = "SELECT DISTINCT gallery FROM photos WHERE user='$log_username'";
$query = mysqli_query($db_connection, $sql);
if(mysqli_num_rows($query) < 1){
	$gallery_list = '<h7 style="color:rgb(10, 85, 128);">No galleries/ photos to display.</h7>';
} else {
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$gallery = $row["gallery"];
		$countquery = mysqli_query($db_connection, "SELECT COUNT(id) FROM photos WHERE user='$log_username' AND gallery='$gallery'");
		$countrow = mysqli_fetch_row($countquery);
		$count = $countrow[0];
		$filequery = mysqli_query($db_connection, "SELECT filename FROM photos WHERE user='$log_username' AND gallery='$gallery' ORDER BY RAND()");
		$filerow = mysqli_fetch_row($filequery);
		$file = $filerow[0];
		
		$gallery_list .= '<div class="col-sm-4 portfolio-item" onclick="showGallery(\''.$gallery.'\',\''.$log_username.'\')">';
		$gallery_list .=   '<a class="portfolio-link hand">';
		$gallery_list .=     ' <div class="caption">';
		$gallery_list .=   		'<div class="caption-content">';
		$gallery_list .=   		'<b>'.$gallery.'</b> ('.$count.')';
		$gallery_list .= 	'</div></div>';
		$gallery_list .= '<img src="_USER/'.$log_username.'/'.$file.'" alt="cover photo">';
		$gallery_list .= '</a>';
		$gallery_list .= '</div>';
    }
}
echo $gallery_list;
?>