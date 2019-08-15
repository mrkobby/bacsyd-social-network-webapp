<?php
include_once("../_sys/check_login_status.php");

$fileName = $_FILES["userBackground"]["name"];
$fileTmpLoc = $_FILES['userBackground']['tmp_name'];
$fileType = $_FILES["userBackground"]["type"];
$fileSize = $_FILES["userBackground"]["size"];
$fileErrorMsg = $_FILES["userBackground"]["error"];

$kaboom = explode(".", $fileName);
	$fileExt = end($kaboom);
	/* list($width, $height) = getimagesize($fileTmpLoc); */
	
	$db_file_name = "bg".rand(100000000000,999999999999).".".$fileExt;
	if($fileSize > 5048576) {
		echo '<div class="widget-user-header bg-primary">Your image file was larger than 5mb. Try another picture</div>';
		exit();	
	} else if (!preg_match("/\.(gif|jpg|png)$/i", $fileName) ) {
		echo '<div class="widget-user-header bg-primary">Your image file was not jpg, gif or png type. Try again</div>';
		exit();
	} else if ($fileErrorMsg == 1) {
		echo '<div class="widget-user-header bg-primary">An unknown error occurred. Try again</div>';
		exit();
	}
	$sql = "SELECT background FROM _useroptions WHERE username='$log_username'";
	$query = mysqli_query($db_connection, $sql);
	$row = mysqli_fetch_row($query);
	$background = $row[0];
	if($background != ""){
		$picurl = "../_USER/$log_username/$background"; 
	    if (file_exists($picurl)) { unlink($picurl); }
	}
	$moveResult = move_uploaded_file($fileTmpLoc, "../_USER/$log_username/$db_file_name");
	if ($moveResult != true) {
		echo '<div class="widget-user-header bg-primary">File upload failed. Try again</div>';
		exit();
	}
	include_once("../_sys/image_resize.php");
	$target_file = "../_USER/$log_username/$db_file_name";
	$resized_file = "../_USER/$log_username/$db_file_name";
	
	$sql = "UPDATE _useroptions SET background='$db_file_name', editdate=now() WHERE username='$log_username'";
	$query = mysqli_query($db_connection, $sql);
	mysqli_close($db_connection);

if($moveResult) {
$targetDisplay = "_USER/$log_username/$db_file_name";
?>
<div class="widget-user-header" style="background-image: url(<?php echo $targetDisplay;?>);background-size: cover;background-position: center center;"></div>
<?php
}
?>