<?php
mysqli_query($db_connection, "UPDATE _userinfo SET status='online' WHERE username='$log_username' LIMIT 1");
$ysql = "SELECT * FROM _usersecurity WHERE username='$log_username' LIMIT 1";
$yquery = mysqli_query($db_connection, $ysql);
	while ($row = mysqli_fetch_array($yquery, MYSQLI_ASSOC)) {
		$xanswer = $row["xanswer"];
		$yanswer = $row["yanswer"];
		$activation = $row["activation"];
	}
if($xanswer == "" || $yanswer == ""){
	header("location: secure&".$log_username."");
	exit();
}
$ysql = "SELECT usertype FROM _users WHERE username='$u' LIMIT 1";
$yquery = mysqli_query($db_connection, $ysql);
	while ($row = mysqli_fetch_array($yquery, MYSQLI_ASSOC)) {
		$usertype = $row["usertype"];
	}
$usertype_filter = '';
$usertype_filter_srkout = '';
$page_check = '';
$usertype_filter_frndbtndisble = 'onclick="friendToggle(\'friend\',\''.$u.'\',\'friendBtn\')" ';
$usertype_filter_blockbtndisble = 'onclick="blockToggle(\'block\',\''.$u.'\',\'blockBtn\')" ';
if($usertype == "page"){
	$usertype_filter = 'style="display:none;"';
	$usertype_filter_srkout = 'style="text-decoration: line-through"';
	$usertype_filter_frndbtndisble = 'disabled';
	$usertype_filter_blockbtndisble = 'disabled';
	$page_check = '&nbsp; <span class="glyphicon glyphicon-ok-sign" style="font-size: 14px;"></span>';
}
$fllwsql = "SELECT COUNT(id) FROM followers WHERE user1='$log_username'";
$fllwquery = mysqli_query($db_connection, $fllwsql);
$fllw_count = mysqli_fetch_row($fllwquery);
$follow_count = $fllw_count[0];	
	
$sidebar_profile_pic = '<img class="img-circle" src="_USER/'.$log_username.'/'.$avatar.'" alt="'.$log_username.'">';
$profile_logo = '<img src="_USER/'.$log_username.'/'.$avatar.'" class="user-image" alt="'.$log_username.'">';
$profile_logo_dropdown = '<img src="_USER/'.$log_username.'/'.$avatar.'" class="img-circle hand" alt="'.$log_username.'">';
$uid_profile_pic = '<img src="_USER/'.$u.'/'.$user_avatar.'" class="img-circle" alt="'.$u.'">';

$profileLogo = '<img class="img-circle" src="_USER/'.$log_username.'/'.$avatar.'" alt="'.$log_username.'">';
	if($avatar == NULL){
		$sidebar_profile_pic = '<img src="_ast/_img/avatardefault.png" class="img-circle" alt="'.$log_username.'">';
		$profile_logo = '<img src="_ast/_img/avatardefault.png" class="user-image" alt="'.$log_username.'">';
		$profile_logo_dropdown = '<img src="_ast/_img/avatardefault.png" class="img-circle hand" alt="'.$log_username.'">';
	}
	if($user_avatar == NULL){
		$uid_profile_pic = '<img src="_ast/_img/avatardefault.png" class="img-circle" alt="'.$u.'">';
	}
$bg_pic = 'style="background-image: url(_USER/'.$log_username.'/'.$background.');background-size: contain;"';
	if($background == NULL){
		$bg_pic = '';
	}
	if($stat == "online"){
	$status_check = '<a><i class="fa fa-circle text-success"></i> Online</a>';
	}else{
		$status_check = '<a><i class="fa fa-circle text-warning"></i> Offline</a>';
	}
?>