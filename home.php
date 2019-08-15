<?php
include_once("_sys/check_login_status.php");
if($user_ok == false){
	header("location: ../bacsyd");
    exit();
}
?><?php
include_once("_parse/_ulog_enf.php");
include_once("_parse/_u_enf.php");
if($u != $log_username){
	header("location: ../bacsyd");
    exit();
}
if($state != "log"){
	header("location: lock&".$log_username."");
	exit();
}
include_once("_parse/_image_bio_stuff.php");
?><?php 
$photos = "";
$max = 5;
$sql = "SELECT filename FROM photos WHERE user='$u' ORDER BY RAND() LIMIT $max";
$query = mysqli_query($db_connection, $sql);
if(mysqli_num_rows($query) < 1){
	$gallery_list = '<h7 style="color:rgb(188, 83, 83);">You have not uploaded any photos yet.</h7>';
} else {
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$file = $row["filename"];
		$photos .= '<div><img class="photo_box" data-action="zoom" src="_USER/'.$u.'/'.$file.'"></div>';
    }
}
?><?php
$alert1 = 'style="display:none;"';
$alert2 = 'style="display:;"';
if($avatar == '' || $bg_pic == '' || $status == "Hi there! I'm new on bacsyd." || $education == '' || $location == '' || $hometown == '' || $profession == '' || $photos == ""){
	$alert1 = 'style="display:;"';
	$alert2 = 'style="display:none;"';
}
?><?php
$raven_tog = '';
$sql = "SELECT * FROM _usersecurity WHERE username='$log_username'";
$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$x_answer = $row["xanswer"];
		$y_answer = $row["yanswer"];
		if($x_answer != "" || $y_answer != ""){
			$raven_tog = '';
		}else{
			$raven_tog = '<div style="display:;opacity:1;"  class="bell"><span class="badge bg-red">1</span></div>';
		}
	}
?><?php
$status_ui = "";
$share_ui = "";
if($log_username == $u){
	$status_ui .= '<div id="statusform"><div class="box-body no-padding" style="margin-bottom: 3px;">';
	$status_ui .= '<div id="statusPostDiv" style="display: none;text-align: center;position: absolute;background: rgba(60, 57, 57, 0.85);width: 100%;height: 100%;font-size: 22px;color: #fff;left:0px;top:0px;line-height: 80px;">Posting...</div>';
	$status_ui .= '<textarea id="statustext" name="statustext" class="form-control textarea" onkeyup="statusMax(this,500)" placeholder="Hi '.$firstname.', What&#39;s up?"></textarea>';
	$status_ui .= '</div>';
	$status_ui .= '<div class="box-footer no-padding">';
	$status_ui .= '<span id="submitBtn"><a class="btn btn-primary pull-right" id="statusBtn" onclick="submitStatus(\'status_post\',\'a\',\''.$u.'\',\'statustext\')">Post</a></span>';
	$status_ui .= '<a id="statusCloseBtn" pd-popup-close="hmPost" href="javascript:void(0)" class="btn btn-default pull-left">Cancel</a>';
	$status_ui .= '<a id="phtfile" class="btn btn-primary pull-left fileBtn" style="width: auto;margin-left:5px;"><span class="fileCaption">Post photo &nbsp;</span><span class="fa fa-camera"></span></a>';
	$status_ui .= '</div></div>';	
	
	$status_ui .= '<form id="pictureform" style="display:none;" action="_ext/_story/user_insert_status.php" method="post">';
	$status_ui .= '<div id="picturePostDiv" style="display: none;text-align: center;position: absolute;background: rgba(60, 57, 57, 0.85);width: 100%;height: 100%;font-size: 22px;color: #fff;left:0px;top:0px;line-height: 80px;">Posting...</div>';
	$status_ui .= '<div class="box-body no-padding" style="margin-bottom: 3px;">';
	$status_ui .= '<input id="imgcaption" name="imgcaption" class="form-control" onkeyup="statusMax(this,250)" placeholder="Add caption to photo (optional)"></input>';
	$status_ui .= '</div>';
	$status_ui .= '<div class="box-footer no-padding">';
	$status_ui .= '<input type="submit" value="Post" class="btn btn-primary pull-right" id="pictureBtn"></input>';
	$status_ui .= '<a id="returnToTextBtn" href="javascript:void(0)" style="width: auto;" class="btn btn-default pull-left">Back</a>';
	$status_ui .= '<label for="photofile" class="btn btn-info pull-left fileBtn" style="width: auto;margin-left:10px;"><span class="fileCaption">Select photo &nbsp;</span><span class="fa fa-camera"></span></label>';
	$status_ui .= '<input name="photofile" id="photofile" style="width:0%;visibility:hidden;display: none;" type="file" accept="image/*" required />';
	$status_ui .= '</div></form>';	
	
	$share_ui .= '<div class="box-body no-padding" style="margin-bottom: 3px;">';
	$share_ui .= '<textarea id="sharetext" name="sharetext" class="form-control textarea" onkeyup="statusMax(this,500)" placeholder="Start typing..."></textarea>';
	$share_ui .= '</div>';
	$share_ui .= '<div class="box-footer no-padding">';
	$share_ui .= '<a class="btn btn-primary pull-right" id="shareBtn">Share post</a>';
	$share_ui .= '<a id="shareCloseBtn" onclick="closeShareCaption()" pd-popup-close="hmPost" href="javascript:void(0)" class="btn btn-default pull-left">Cancel</a>';
	$share_ui .= '</div>';	
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
<?php include_once("_parse/random_users_query.php");?>
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
		<?php include_once("_ext/_hm/hm-left-col.php");?>
		<?php include_once("_ext/_hm/hm-mid-col.php");?>
		<?php include_once("_ext/_def/default-chat-right-col.php");?>
      </div>
    </section>
  </div>
  <?php include_once("_ext/_def/side-control.php");?>
</div>
<?php include_once("_ext/_popup/hm-post.php");?>
<?php include_once("_ext/_popup/share-caption.php");?>
<?php include_once("_ext/_popup/view-post-replies.php");?>
<?php include_once("_ext/_popup/change-password.php");?>
<?php include_once("_ext/_popup/change-fname.php");?>
<?php include_once("_ext/_popup/change-lname.php");?>
<?php include_once("_ext/_popup/change-email.php");?>
<?php include_once("_ext/_popup/_activation-hint.php");?>
<?php include_once("_ext/_popup/_follow-prompt.php");?>

<?php include_once("_ext/_def/all-js.php");?>
<script>
function loadMorePosts(){
	var flag = 5;
	$("#loadmorebtn").click(function(){
		if(true){
			document.getElementById('loadmorebtn').innerHTML = '<span style="font-size:10px;">loading...</span>';
			$.ajax({
				type: "GET",
				url: "_ext/_story/user_load_status.php",
				data:{
					'offset': flag,
					'limit': 5
				},
				success: function(data){
					$('#statuslogs').append(data);
					flag += 5;
					document.getElementById('loadmorebtn').innerHTML = '<button class="btn btn-primary" style="padding: 5px;font-size: 10px;">Load more</button>';
				}
			});
		}
	});
}
$(document).ready(function(e){
	var flag = 0;
	$.ajax({
		type: "GET",
		url: "_ext/_story/user_load_status.php",
		data:{
			'offset': 0,
			'limit': 5
		},
		success: function(data){
			$('#statuslogs').append(data);
			flag += 5;
		}
	});
	$("#loadmorebtn").click(function(){
		if(true){
			document.getElementById('loadmorebtn').innerHTML = '<span style="font-size:10px;">loading...</span>';
			$.ajax({
				type: "GET",
				url: "_ext/_story/user_load_status.php",
				data:{
					'offset': flag,
					'limit': 5
				},
				success: function(data){
					$('#statuslogs').append(data);
					flag += 5;
					document.getElementById('loadmorebtn').innerHTML = '<button class="btn btn-primary" style="padding: 5px;font-size: 10px;">Load more</button>';
				}
			});
		}
	});
});


/* $(document).ready(function(e){
	var activate = "<?php echo $activation;?>";
	var fllwprompt = "<?php echo $follow_count;?>";
	if(fllwprompt < 3){
		$("#followPrompt").fadeIn(100);
	}
	if(activate == 0){
		setTimeout(function(){
			$("#activationHint").fadeIn(500);
		}, 2000);
	}
	$("#changeAddress").click(function(){
		$("#activationHint").fadeOut(0);
		$("#changeEmail").fadeIn(0);
	});
}); */
function loadPosts(){
	var flag = 0;
	$.ajax({
		type: "GET",
		url: "_ext/_story/user_load_status.php",
		data:{
			'offset': 0,
			'limit': 5
		},
		success: function(data){
			$('#statuslogs').load(data);
			flag += 5;
		}
	});
	$("#loadmorebtn").click(function(){
		if(true){
			document.getElementById('loadmorebtn').innerHTML = '<span style="font-size:10px;">loading...</span>';
			$.ajax({
				type: "GET",
				url: "_ext/_story/user_load_status.php",
				data:{
					'offset': flag,
					'limit': 5
				},
				success: function(data){
					$('#statuslogs').append(data);
					flag += 5;
					document.getElementById('loadmorebtn').innerHTML = '<button class="btn btn-primary" style="padding: 5px;font-size: 10px;">Load more</button>';
				}
			});
		}
	});
}
function followPromptDone(){
	document.getElementById("ffPromptDiv").style.display = 'block';
	var ajax = ajaxObj("POST", "_parse/_get_followers_num.php");
	ajax.onreadystatechange = function() {
	 if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "get_failed"){
				document.getElementById("ffPromptDiv").style.display = 'none';
				Alert.render("Follow 3 or more pages to proceed");
			}else {
				if(ajax.responseText < 3){
					Alert.render("Follow 3 or more pages");
					document.getElementById("ffPromptDiv").style.display = 'none';
				}else if(ajax.responseText > 2){
					document.getElementById("ffPromptDiv").style.display = 'none';
					loadPosts();
					$("#followPrompt").fadeOut(100);
				}
			}
		}
	}
	ajax.send("action=get_ffnum");
}
</script>
</body>
</html>
