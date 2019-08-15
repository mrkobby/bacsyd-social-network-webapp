<?php 
include_once("admin_check_status.php");
if($id_ok == false){
	header("location: ../login.php");
    exit();
}
?><?php
include_once("admin_check_status.php");
$s1=$_REQUEST["n"];
$select_query = "SELECT * FROM _users WHERE username LIKE '%".$s1."%' OR firstname LIKE '%".$s1."%' OR lastname LIKE '%".$s1."%'";
$user_query = mysqli_query($db_connection, $select_query) or die (mysqli_error());
$s="";

while($row = mysqli_fetch_array($user_query)){
	$userid = $row["id"];
	$firstname = $row["firstname"];
	$lastname = $row["lastname"];
	$username = $row["username"];
	$email = $row["email"];
	$usertype = $row["usertype"];
	$sql = "SELECT avatar,background FROM _useroptions WHERE username='$username'";
	$ava_query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($ava_query)) {
		$picture = $row["avatar"];
		$background = $row["background"];
	}
	$profile_pic = '<img class="profile-user-img img-responsive img-circle" src="../_USER/'.$username.'/'.$picture.'" alt="'.$username.'">';
	$background_pic = 'Background: Yes';
	if($picture == NULL){
		$profile_pic = '<img class="profile-user-img img-responsive img-circle" src="../_ast/_img/avatardefault.png" alt="'.$username.'">';
	}if($background == NULL){
		$background_pic = 'Background: No';
	}
	
	$sql = "SELECT COUNT(id) FROM friends WHERE user1='$username' AND accepted='1' OR user2='$username' AND accepted='1'";
	$query1 = mysqli_query($db_connection, $sql);
	$frndcount = mysqli_fetch_row($query1);
	$friend_count = $frndcount[0];
	
	$sql = "SELECT COUNT(id) FROM followers WHERE user2='$username'";
	$query2 = mysqli_query($db_connection, $sql);
	$query_count = mysqli_fetch_row($query2);
	$follower_count = $query_count[0];
			
	$sql = "SELECT COUNT(id) FROM followers WHERE user1='$username'";
	$query3 = mysqli_query($db_connection, $sql);
	$_count = mysqli_fetch_row($query3);
	$following_count = $_count[0];
	
	$aasql = "SELECT activation FROM _usersecurity WHERE username='$username'";
	$aaquery = mysqli_query($db_connection, $aasql);
	while ($row = mysqli_fetch_array($aaquery, MYSQLI_ASSOC)) {
		$activation = $row["activation"];
	}
	
	$s .= '<div id="user_'.$userid.'" class="col-md-3 col-sm-6 col-xs-12">';
	$s .= '<div class="box box-primary">';
	$s .= 	'<div class="box-body box-profile" style="font-size: 12px;">';
	$s .= 		''.$profile_pic.'';
	$s .= 		'<h3 class="profile-username" style="font-size: 14px;">'.$firstname.' '.$lastname.'</h3>';
	$s .= 		'<p class="text-muted" style="font-size: 12px;">@'.$username.' &nbsp; | &nbsp; '.$email.' &nbsp; | &nbsp; '.$usertype.'</p>';
	$s .= 		'<p style="font-size: 12px;">'.$background_pic.'  &nbsp; | &nbsp; Activated: '.$activation.'</p>';
	$s .= 		'<p><div class="form-group"><label class="control-sidebar-subheading checkbox_container" style="font-size: 12px;"><input type="checkbox" class="pull-right"><span class="checkmark"></span>Turn user to page</label></div></p>';
	$s .= 		'<div class="row">';
	$s .= 		'<div class="col-xs-4 text-center right-border"><span>Friends<br /> '.$friend_count.'</span></div>';
	$s .= 		'<div class="col-xs-4 text-center right-border"><span>Followers<br /> '.$follower_count.'</span></div>';
	$s .= 		'<div class="col-xs-4 text-center"><span>Following<br /> '.$following_count.'</span></div>';
	$s .= 		'</div><br />';
	$s .= 	'<span id="db_'.$userid.'"><a onclick="return false;" onmousedown="deleteUser(\''.$userid.'\',\'user_'.$userid.'\');" class="btn btn-primary btn-block">';
	$s .= 	'<b>Delete account</b></a>';
	$s .= 	'</div>';
	$s .= '</div>';
	$s .= '</div>';
}
echo $s;
?>