<?php
include_once("_sys/check_login_status.php");
if($user_ok == false){
	header("location: ../bacsyd");
    exit();
}
?><?php
include_once("_parse/_u_enf.php");
include_once("_parse/_ulog_enf.php");
if($state != "log"){
	header("location: lock&".$log_username."");
	exit();
}
include_once("_parse/_image_bio_stuff.php");
?><?php
$uid_visibility = '';
if($u == $log_username && $user_ok == true){
	$uid_visibility = 'style="display:none;"';
}
$edit_profile = '';
if($u != $log_username){
	$edit_profile = 'style="display:none;"';
}
?><?php
$photo_form = "";
$isOwner = "no";
if($u == $log_username && $user_ok == true){
	$isOwner = "yes";	
	$photo_form .= '<form id="photoform" action="_ext/_phto/_upload_photo.php" method="post">';
	$photo_form .= '<div class="box-body no-padding" style="margin-bottom: 3px;">';
	$photo_form .=  '<select id="choose_gallery" style="margin-bottom:15px;" class="form-control inputBox" name="gallery" required></div>';
	$photo_form .=  '<option value="" style="color:rgb(91, 91, 91);">choose gallery:</option>';
	$photo_form .=  '<option value="Selfie"> Selfies </option>';
	$photo_form .=  '<option value="Family"> Family </option>';
	$photo_form .=  '<option value="Pets"> Pets</option>';
	$photo_form .=  '<option value="Friends"> Friends </option>';
	$photo_form .=  '<option value="Memes"> Memes </option>';
	$photo_form .=  '<option value="Vacation"> Vacation </option>';
	$photo_form .=  '<option value="Other"> Other </option>';
	$photo_form .=  '</select>';
	$photo_form .= '</div>';
	$photo_form .= '<div style="margin-bottom: 15px;">';
	$photo_form .= '<input id="caption" name="caption" class="form-control" onkeyup="statusMax(this,250)" placeholder="Add caption to photo (optional)"></input>';
	$photo_form .= '</div>';
	$photo_form .= '<div class="box-footer no-padding">';
	$photo_form .= '<input type="submit" value="Add" class="btn btn-primary pull-right sumbitBtn"></input>';
	$photo_form .= '<a id="photoCancelBtn" pd-popup-close="addPhoto" style="width: auto;" class="btn btn-default pull-left">Cancel</a>';
	$photo_form .= '<label for="choose_photo" class="btn btn-info pull-left fileBtn" style="width: auto;margin-left:10px;"><span class="fileCaption">Select photo &nbsp;</span><span class="fa fa-camera"></span></label>';
	$photo_form .= '<input name="photo" id="choose_photo" style="width:0%;visibility:hidden;display: none;" type="file" accept="image/*" required />';
	$photo_form .= '</div></form>';	
}
$gallery_list = "";
$sql = "SELECT DISTINCT gallery FROM photos WHERE user='$u' ORDER BY RAND()";
$query = mysqli_query($db_connection, $sql);
if(mysqli_num_rows($query) < 1){
	$gallery_list = '<h7 style="color:rgb(10, 85, 128);">No galleries/ photos to display.</h7>';
} else {
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$gallery = $row["gallery"];
		$countquery = mysqli_query($db_connection, "SELECT COUNT(id) FROM photos WHERE user='$u' AND gallery='$gallery'");
		$countrow = mysqli_fetch_row($countquery);
		$count = $countrow[0];
		$filequery = mysqli_query($db_connection, "SELECT filename FROM photos WHERE user='$u' AND gallery='$gallery' ORDER BY RAND()");
		$filerow = mysqli_fetch_row($filequery);
		$file = $filerow[0];
		
		$gallery_list .= '<div class="col-sm-4 portfolio-item" onclick="showGallery(\''.$gallery.'\',\''.$u.'\')">';
		$gallery_list .=   '<a class="portfolio-link hand">';
		$gallery_list .=     ' <div class="caption">';
		$gallery_list .=   		'<div class="caption-content">';
		$gallery_list .=   		'<b>'.$gallery.'</b> ('.$count.')';
		$gallery_list .= 	'</div></div>';
		$gallery_list .= '<img src="_USER/'.$u.'/'.$file.'" alt="cover photo">';
		$gallery_list .= '</a>';
		$gallery_list .= '</div>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <?php include_once("_ext/_def/logged-head.php");?>
  <?php include_once("_ext/_def/all-css.php");?>
</head>
<body class="hold-transition skin-blue fixed">
<?php include_once("_ext/_def/bd-load.php");?>
<?php include_once("_ext/_def/bd-load-starter.php");?>
<?php include_once("_parse/_ulog_friends_followers_query.php");?>
<?php include_once("_ext/_note/_frndreq/_friend_requests_modal.php");?>
<?php include_once("_ext/_note/_all_note_check.php");?>
<?php include_once("_ext/_def/bd-dialog-searchlayer.php");?>
<div id="deletePhoto" style="display: none;opacity: .8;position: fixed;font-size: 22px;color: #fff;top: 0px;left: 0px;background: #363636;width: 100%;height: 100%;z-index: 99999;line-height: 400px;text-align: center;">Deleting...</div>
<div class="wrapper">
  <header class="main-header">
	<?php include_once("_ext/_def/hd-lg.php");?>
    <nav class="navbar navbar-static-top">
      <?php include_once("_ext/_def/default-top-searchbox.php");?>
	  <div class="mobile-no-show" id="livesearch"></div>
	  <div class="mobile-only-show" id="livesearchMobile"></div>
	  <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
			<?php include_once("_ext/_def/hd-nav-search.php");?>
			<?php include_once("_ext/_def/hd-nav-chat.php");?>
			<?php include_once("_ext/_def/hd-nav-msg.php");?>
			<?php include_once("_ext/_def/hd-nav-note.php");?>
			<?php include_once("_ext/_def/hd-nav-user.php");?>
	    </ul>
      </div>
    </nav>
  </header>
 <?php include_once("_ext/_def/side-bar.php");?>
  <div class="content-wrapper">
	<section class="content">
      <div class="row">
		<?php include_once("_ext/_phto/phto-left-col.php");?>
		<?php include_once("_ext/_def/default-chat-right-col.php");?>
      </div>
    </section>
  </div>
  <?php include_once("_ext/_def/side-control.php");?>
</div>
<?php include_once("_ext/_popup/change-password.php");?>
<?php include_once("_ext/_popup/change-fname.php");?>
<?php include_once("_ext/_popup/change-lname.php");?>
<?php include_once("_ext/_popup/change-email.php");?>

<?php include_once("_ext/_def/all-js.php");?>
<?php include_once("_ext/_popup/photo-add.php");?>
</body>
</html>
