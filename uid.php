<?php
include_once("_sys/check_login_status.php");
if($user_ok == false){
	header("location: ../bacsyd");
    exit();
}
$sql = "SELECT avatartemp FROM _userthumbnails WHERE username='$log_username'";
$query = mysqli_query($db_connection, $sql);
$row = mysqli_fetch_row($query);
$old_dp = $row[0];
if($old_dp != ""){
	$picurl = "_USER/$log_username/$old_dp"; 
	if (file_exists($picurl)) { unlink($picurl); }
}
mysqli_query($db_connection, "UPDATE _userthumbnails SET avatartemp=NULL WHERE username='$log_username'");
?><?php
include_once("_parse/_u_enf.php");
$user_bg_pic = 'style="background-image: url(_USER/'.$u.'/'.$user_background.');background-size: cover;background-position: center center;"';
if($user_background == NULL){
		$user_bg_pic = '';
}
include_once("_parse/_ulog_enf.php");
?><?php
$sql = "SELECT state FROM _useroptions WHERE username='$log_username'";
$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$state = $row["state"];
	}
if($state != "log"){
	header("location: lock&".$log_username."");
	exit();
}
include_once("_parse/_image_bio_stuff.php");
?><?php
$isFriend = false;
$isNotAccepted = false;
$ownerBlockViewer = false;
$ownerFollow = false;
$viewerBlockOwner = false;
if($u != $log_username && $user_ok == true){
	$friend_check = "SELECT id FROM friends WHERE user1='$log_username' AND user2='$u' AND accepted='1' OR user1='$u' AND user2='$log_username' AND accepted='1'";
	if(mysqli_num_rows(mysqli_query($db_connection, $friend_check)) > 0){
        $isFriend = true;
    }
	$accepted_check = "SELECT id FROM friends WHERE user1='$log_username' AND user2='$u' AND accepted='0'";
	if(mysqli_num_rows(mysqli_query($db_connection, $accepted_check)) > 0){
        $isNotAccepted = true;
    }
	$block_check1 = "SELECT id FROM blockedusers WHERE blocker='$u' AND blockee='$log_username'";
	if(mysqli_num_rows(mysqli_query($db_connection, $block_check1)) > 0){
        $ownerBlockViewer = true;
    }
	$block_check2 = "SELECT id FROM blockedusers WHERE blocker='$log_username' AND blockee='$u'";
	if(mysqli_num_rows(mysqli_query($db_connection, $block_check2)) > 0){
        $viewerBlockOwner = true;
    }
	$follow_check = "SELECT id FROM followers WHERE user1='$log_username' AND user2='$u'";
	if(mysqli_num_rows(mysqli_query($db_connection, $follow_check)) > 0){
        $ownerFollow = true;
    }
}
?><?php 
$follow_button = '<a class="btn btn-info btn-block hand" id="followBtn_" onclick="followToggle(\'follow\',\''.$u.'\',\'followBtn\')"><b>Follow</b></a>';
$block_button = '<a class="btn btn-default btn-block hand" id="blockBtn_" '.$usertype_filter_blockbtndisble.'><b>Block</b></a>';
$friend_button = '<a class="btn btn-primary btn-block hand" id="friendBtn_" '.$usertype_filter_frndbtndisble.'><b>Friend</b></a>';	

if($isFriend == true){
	$friend_button = '<a class="btn btn-default btn-block hand" id="friendBtn_" onclick="friendToggle(\'unfriend\',\''.$u.'\',\'friendBtn\')"><b>Unfriend</b></a>';	
} else if($user_ok == true && $ownerBlockViewer == false){
	$friend_button = '<a class="btn btn-primary btn-block hand" id="friendBtn_" '.$usertype_filter_frndbtndisble.'><b>Friend</b></a>';	
}if($isNotAccepted == true){
	$friend_button = '<a class="btn btn-default btn-block hand" id="friendBtn_" disabled><b>Requested</b></a>';	
}

if($viewerBlockOwner == true){
	$block_button = '<a class="btn btn-primary btn-block hand" id="blockBtn_" onclick="blockToggle(\'unblock\',\''.$u.'\',\'blockBtn\')"><b>Unblock</b></a>';
} else if($user_ok == true && $u != $log_username){
	$block_button = '<a class="btn btn-default btn-block hand" id="blockBtn_" '.$usertype_filter_blockbtndisble.'><b>Block</b></a>';
}
if($ownerFollow == true){
	$follow_button = '<a class="btn btn-default btn-block hand" id="followBtn_" onclick="followToggle(\'unfollow\',\''.$u.'\',\'followBtn\')"><b>Following</b></a>';
} else if($user_ok == true && $u != $log_username){
	$follow_button = '<a class="btn btn-info btn-block hand" id="followBtn_" onclick="followToggle(\'follow\',\''.$u.'\',\'followBtn\')"><b>Follow</b></a>';
}
?><?php 
$photos = "";
$max = 5;
$sql = "SELECT filename FROM photos WHERE user='$u' ORDER BY RAND() LIMIT $max";
$query = mysqli_query($db_connection, $sql);
if(mysqli_num_rows($query) < 1){
	$photos = '<h7>No photos to display</h7>';
} else {
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$file = $row["filename"];
		$photos .= '<div><img class="photo_box" data-action="zoom" src="_USER/'.$u.'/'.$file.'"></div>';
    }
}
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
$privatecheck = '';
$displayPrivacy = '';
if($privacy == '1' && $u != $log_username && $isFriend == false){
	$privatecheck = '<span style="text-align:center;">'.$firstname.'\'s Account is Private</span>';
	$displayPrivacy = 'style="display:none;"';
}else if($privacy == '0' && $u != $log_username && $isFriend == false){
	$displayPrivacy = 'style="display:block;"';
}
?><?php
$i_check = "SELECT id FROM friends WHERE user1='$log_username' AND user2='$u' AND accepted='1' OR user1='$u' AND user2='$log_username' AND accepted='1'";
$i_query = mysqli_query($db_connection, $i_check);
while($row = mysqli_fetch_array($i_query, MYSQLI_ASSOC)) {
	$cht_id = $row["id"];
}
?><?php
$status_ui = "";
if($log_username == $u){
	$status_ui .= '<div id="statusform"><div class="box-body no-padding" style="margin-bottom: 3px;">';
	$status_ui .= '<textarea id="statustext" name="statustext" class="form-control textarea" onkeyup="statusMax(this,500)" placeholder="Hi '.$firstname.', What&#39;s up?"></textarea>';
	$status_ui .= '</div>';
	$status_ui .= '<div class="box-footer no-padding">';
	$status_ui .= '<span id="submitBtn"><a class="btn btn-primary pull-right" id="statusBtn" onclick="postToStatus(\'status_post\',\'a\',\''.$u.'\',\'statustext\')">Post</a></span>';
	$status_ui .= '</div></div>';	
} else if($log_username != $u && $isFriend == true && $ownerBlockViewer == false){	
	$status_ui .= '<div id="statusform"><div class="box-body no-padding" style="margin-bottom: 3px;">';
	$status_ui .= '<textarea id="statustext" name="statustext" class="form-control textarea" onkeyup="statusMax(this,500)" placeholder="Hi '.$firstname.', say something to '.$fname.'"></textarea>';
	$status_ui .= '</div>';
	$status_ui .= '<div class="box-footer no-padding">';
	$status_ui .= '<span id="submitBtn"><a class="btn btn-primary pull-right" id="statusBtn" onclick="postToStatus(\'status_post\',\'c\',\''.$u.'\',\'statustext\')">Post</a></span>';
	$status_ui .= '<a href="javascript:void(0)" onclick="OpenChat(\''.$cht_id.'\',\'bb'.$cht_id.'\',\''.$u.'\',\'msg_body_'.$cht_id.'\');" class="btn btn-primary pull-left">Send message</a>';
	$status_ui .= '</div></div>';	
}else if($log_username != $u && $isFriend == true && $ownerBlockViewer == true){
	$status_ui = ''.$fname.' has blocked you. You can no longer post on '.$fname.'\'s profile, comment on posts or send a message.';
}
?>
<!DOCTYPE html>
<html>
<head>
  <?php include_once("_ext/_def/logged-head.php");?>
  <?php include_once("_ext/_def/all-css.php");?>
  <link href="_ast/_css/rcrop.css" media="screen" rel="stylesheet" type="text/css">
</head>
<body class="hold-transition skin-blue fixed">
<?php include_once("_ext/_def/bd-load.php");?>
<?php include_once("_ext/_def/bd-load-starter.php");?>
<?php include_once("_parse/_friends_query.php");?>
<?php include_once("_parse/_friends_query_list.php");?>
<?php include_once("_parse/_followers_query.php");?>
<?php include_once("_parse/_followers_query_list.php");?>
<?php include_once("_parse/_ulog_friends_followers_query.php");?>
<?php include_once("_ext/_note/_frndreq/_friend_requests_modal.php");?>
<?php include_once("_ext/_note/_all_note_check.php");?>
<?php include_once("_ext/_def/bd-dialog-searchlayer.php");?>
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
		<?php include_once("_ext/_u/u-banner-col.php");?>
		<?php include_once("_ext/_u/u-left-col.php");?>
		<?php include_once("_ext/_u/u-mid-col.php");?>
		<?php include_once("_ext/_def/default-chat-right-col.php");?>
      </div>
    </section>
  </div>
  <?php include_once("_ext/_def/side-control.php");?>
</div>
<?php include_once("_ext/_popup/view-post-replies.php");?>
<?php include_once("_ext/_popup/change-password.php");?>
<?php include_once("_ext/_popup/change-fname.php");?>
<?php include_once("_ext/_popup/change-lname.php");?>
<?php include_once("_ext/_popup/change-email.php");?>
<?php include_once("_ext/_popup/abt-bio.php");?>
<?php include_once("_ext/_popup/abt-edu.php");?>
<?php include_once("_ext/_popup/abt-location.php");?>
<?php include_once("_ext/_popup/abt-profession.php");?>
<?php include_once("_ext/_popup/abt-contact.php");?>
<?php include_once("_ext/_popup/change-background.php");?>
<?php include_once("_ext/_popup/change-dp.php");?>


<?php include_once("_ext/_def/all-js.php");?>
<?php include_once("_ext/_u/u-js.php");?>
</body>
</html>
