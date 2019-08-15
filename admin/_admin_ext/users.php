<?php
$userlist = ""; 
$sql = "SELECT * FROM _users ORDER BY id DESC LIMIT 100";
$query = mysqli_query($db_connection, $sql);
while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$userid = $row["id"];
	$u = $row["username"];
	$fname = $row["firstname"];
	$lname = $row["lastname"];
	$email = $row["email"];
	$usertype = $row["usertype"];
	$sql = "SELECT avatar,background FROM _useroptions WHERE username='$u'";
	$photoquery = mysqli_query($db_connection, $sql);
		while ($row = mysqli_fetch_array($photoquery, MYSQLI_ASSOC)) {
			$avatar = $row["avatar"];
			$background = $row["background"];
			
			$profile_pic = '<img class="profile-user-img img-responsive img-circle" style="margin: 0 0;" src="../_USER/'.$u.'/'.$avatar.'" alt="'.$u.'">';
			$background_pic = 'Background: Yes';
			if($avatar == NULL){
				$profile_pic = '<img class="profile-user-img img-responsive img-circle" style="margin: 0 0;" src="../_ast/_img/avatardefault.png" alt="'.$u.'">';
			}if($background == NULL){
				$background_pic = 'Background: No';
			}
			
			$sql = "SELECT COUNT(id) FROM friends WHERE user1='$u' AND accepted='1' OR user2='$u' AND accepted='1'";
			$query1 = mysqli_query($db_connection, $sql);
			$frndcount = mysqli_fetch_row($query1);
			$friend_count = $frndcount[0];
			
			$sql = "SELECT COUNT(id) FROM followers WHERE user2='$u'";
			$query2 = mysqli_query($db_connection, $sql);
			$query_count = mysqli_fetch_row($query2);
			$follower_count = $query_count[0];
			
			$sql = "SELECT COUNT(id) FROM followers WHERE user1='$u'";
			$query3 = mysqli_query($db_connection, $sql);
			$_count = mysqli_fetch_row($query3);
			$following_count = $_count[0];
		}
	$aasql = "SELECT activation FROM _usersecurity WHERE username='$u'";
	$aaquery = mysqli_query($db_connection, $aasql);
		while ($row = mysqli_fetch_array($aaquery, MYSQLI_ASSOC)) {
			$activation = $row["activation"];
		}
	$userlist .= '<div id="user_'.$userid.'" class="col-md-3 col-sm-6 col-xs-12">';
	$userlist .= '<div class="box box-primary">';
	$userlist .= 	'<div class="box-body box-profile" style="font-size: 12px;">';
	$userlist .= 		''.$profile_pic.'';
	$userlist .= 		'<h3 class="profile-username" style="font-size: 14px;">'.$fname.' '.$lname.'</h3>';
	$userlist .= 		'<p class="text-muted" style="font-size: 12px;">@'.$u.' &nbsp; | &nbsp; '.$email.' &nbsp; | &nbsp; '.$usertype.'</p>';
	$userlist .= 		'<p style="font-size: 12px;">'.$background_pic.'  &nbsp; | &nbsp; Activated: '.$activation.'</p>';
	$userlist .= 		'<p><div class="form-group"><label class="control-sidebar-subheading checkbox_container" style="font-size: 12px;"><input type="checkbox" class="pull-right"><span class="checkmark"></span>Turn user to page</label></div></p>';
	$userlist .= 		'<div class="row">';
	$userlist .= 		'<div class="col-xs-4 text-center right-border"><span>Friends<br /> '.$friend_count.'</span></div>';
	$userlist .= 		'<div class="col-xs-4 text-center right-border"><span>Followers<br /> '.$follower_count.'</span></div>';
	$userlist .= 		'<div class="col-xs-4 text-center"><span>Following<br /> '.$following_count.'</span></div>';
	$userlist .= 		'</div><br />';
	$userlist .= 	'<span id="db_'.$userid.'"><a onclick="return false;" onmousedown="deleteUser(\''.$userid.'\',\'user_'.$userid.'\');" class="btn btn-primary btn-block">';
	$userlist .= 	'<b>Delete account</b></a>';
	$userlist .= 	'</div>';
	$userlist .= '</div>';
	$userlist .= '</div>';
}									
?><?php
$sql = "SELECT COUNT(id) FROM _users";
$query = mysqli_query($db_connection, $sql);
$row = mysqli_fetch_row($query);
$usercount = $row[0];
?>
<script>
function deleteUser(userid,userbox){
	Confirm.render("Are you sure you want to delete this user completely?");
	Confirm.yes = function(){
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverlay').style.display = "none";
		document.getElementById("relax").style.display = "block";
		var ajax = ajaxObj("POST", "_admin_ext/_delete_user.php");
		ajax.onreadystatechange = function() {
			if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "delete_ok"){
					_(userbox).style.display = 'none';
					document.getElementById("relax").style.display = "none";
				} else {
					Alert.render(ajax.responseText);
				}
			}
		}
		ajax.send("action=delete_user&userid="+userid);
	}
	Confirm.no = function(){
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverlay').style.display = "none";
	}
}
</script>