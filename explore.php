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
	header("location: explore&".$log_username."");
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
		<?php include_once("_ext/_exp/exp-left-col.php");?>
		<?php include_once("_ext/_exp/exp-mid-col.php");?>
		<?php include_once("_ext/_def/default-chat-right-col.php");?>
      </div>
    </section>
  </div>
  <?php include_once("_ext/_def/side-control.php");?>
</div>
<?php include_once("_ext/_popup/share-caption.php");?>
<?php include_once("_ext/_popup/view-post-replies.php");?>
<?php include_once("_ext/_popup/change-password.php");?>
<?php include_once("_ext/_popup/change-fname.php");?>
<?php include_once("_ext/_popup/change-lname.php");?>
<?php include_once("_ext/_popup/change-email.php");?>

<?php include_once("_ext/_def/all-js.php");?>
<script>
$(document).ready(function(e){
	var flag = 0;
	$.ajax({
		type: "GET",
		url: "_ext/_story/explore_load_status.php",
		data:{
			'offset': 0,
			'limit': 5
		},
		success: function(data){
			$('#explogs').append(data);
			flag += 5;
		}
	});
	$("#loadmorebtn").click(function(){
		if(true){
			document.getElementById('loadmorebtn').innerHTML = '<span style="font-size:10px;">loading...</span>';
			$.ajax({
				type: "GET",
				url: "_ext/_story/explore_load_status.php",
				data:{
					'offset': flag,
					'limit': 5
				},
				success: function(data){
					$('#explogs').append(data);
					flag += 5;
					document.getElementById('loadmorebtn').innerHTML = '<button class="btn btn-primary" style="padding: 5px;font-size: 10px;">Load more</button>';
				}
			});
		}
	});
});
function loadMorePosts(){
	var flag = 5;
	$("#loadmorebtn").click(function(){
		if(true){
			document.getElementById('loadmorebtn').innerHTML = '<span style="font-size:10px;">loading...</span>';
			$.ajax({
				type: "GET",
				url: "_ext/_story/explore_load_status.php",
				data:{
					'offset': flag,
					'limit': 5
				},
				success: function(data){
					$('#explogs').append(data);
					flag += 5;
					document.getElementById('loadmorebtn').innerHTML = '<button class="btn btn-primary" style="padding: 5px;font-size: 10px;">Load more</button>';
				}
			});
		}
	});
}
function likeToggle(type,author,storyid,elem){
	var xmlhttp5 = new XMLHttpRequest();
	xmlhttp5.onreadystatechange = function(){
		if(xmlhttp5.readyState==4&&xmlhttp5.status==200){
			var lstring = xmlhttp5.responseText.split("|||");
				for (var i = 0; i < lstring.length; i++){
					var string = lstring[i].split("|");		
				}		
				var lkbtn = string[0];
				var lknum = string[1];
			document.getElementById('lk_'+storyid).innerHTML = lkbtn;
			document.getElementById('lknum_'+storyid).innerHTML = lknum;
			document.getElementById('lk2_'+storyid).innerHTML = lkbtn;
			document.getElementById('lknum2_'+storyid).innerHTML = lknum;
		}
	}
	xmlhttp5.open('GET','_parse/_system_like.php?type='+type+'&storyid='+storyid+'&author='+author, true);
	xmlhttp5.send();
}	
</script>
</body>
</html>
