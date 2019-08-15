<?php
$friend_requests = "";
$showreqbox = "";
$sql = "SELECT * FROM friends WHERE user2='$log_username' AND accepted='0' ORDER BY datemade DESC";
$query = mysqli_query($db_connection, $sql);
$numrows = mysqli_num_rows($query);
if($numrows < 1){
	$friend_requests = '';
	$showreqbox = 'style="display:none;"';
} else {
	$showreqbox = 'style="display:block;"';
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$reqID = $row["id"];
		$user1 = $row["user1"];
		$datemade = strftime("%b %d at %I:%M %p", strtotime($row["datemade"]) + 60 * 60 * 7);
		$thumbquery = mysqli_query($db_connection, "SELECT avatar FROM _useroptions WHERE username='$user1'");
		$thumbrow = mysqli_fetch_row($thumbquery);
		$user1avatar = $thumbrow[0];
		$user1pic = '_USER/'.$user1.'/'.$user1avatar.'" alt="'.$user1.'';
		if($user1avatar == NULL){
			$user1pic = '_ast/_img/avatardefault.png';
		}
		$bsql = "SELECT firstname, lastname FROM _users WHERE username='$user1'";
		$bquery = mysqli_query($db_connection, $bsql);
		while ($row = mysqli_fetch_array($bquery, MYSQLI_ASSOC)) {
			$fnme = $row["firstname"];
			$lnme = $row["lastname"];
			
			$friend_requests .= '<a id="friendreq2_'.$reqID.'" class="hand" href="uid&'.$user1.'"><li class="item fa-1x"><div class="product-img cu" style="border:1px solid black;">';
			$friend_requests .= '<a href="uid&'.$user1.'"><img style="width:50px;height:50px;" class="img" src="'.$user1pic.'" alt="'.$user1.'"></a></div>';
			$friend_requests .= '<div style="margin-left:60px;" class="product-info-name"><a href="uid&'.$user1.'" class="product-title">'.$fnme.' '.$lnme.'</a>';
			$friend_requests .= '<span class="pull-right" id="user_info2_'.$reqID.'" style="padding:5px;"> ';
			$friend_requests .= '<button style="padding:10px;font-size:12px;" class="btn btn-flat btn-primary" onclick="friendReqHandler2(\'accept\',\''.$reqID.'\',\''.$user1.'\',\'user_info2_'.$reqID.'\')">Accept</button> &nbsp;';
			$friend_requests .= '<button style="padding:10px;font-size:12px;" class="btn btn-flat btn-info" onclick="friendReqHandler2(\'reject\',\''.$reqID.'\',\''.$user1.'\',\'user_info2_'.$reqID.'\')">Reject</button>';		
			$friend_requests .= '</span><a href="uid&'.$user1.'"><span style="overflow: visible;text-overflow: inherit;" class="product-description">';
			$friend_requests .= '<time>'.$datemade.'</time>';
			$friend_requests .= '</span></a></div></li></a>';
		}
	}
}
?><?php
$notification_list = "";
$noteDeleteButton = "";
$sql = "SELECT * FROM alerts WHERE username LIKE BINARY '$log_username' ORDER BY date_time DESC";
$query = mysqli_query($db_connection, $sql);
$numrows = mysqli_num_rows($query);
if($numrows < 1){
	$notification_list = '<div class="box box-widget text-center"><span style="font-size:14px;">You do not have any notifications now</span></div>';
} else {
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$noteid = $row["id"];
		$postid = $row["story_id"];
		$user_nm = $row["username"];
		$initiator = $row["initiator"];
		$app = $row["app"];
		$note = $row["note"];
		$_time = strftime("%b %d at %I:%M %p", strtotime($row["date_time"]) + 60 * 60 * 7);
		
		$sql = "SELECT avatar FROM _useroptions WHERE username='$initiator'";
		$ava_query = mysqli_query($db_connection, $sql);
		$numrows = mysqli_num_rows($ava_query);
		while ($row = mysqli_fetch_array($ava_query, MYSQLI_ASSOC)) {
		$picture1 = $row["avatar"];
		}
		$image1 = '<img class="img-circle" src="_USER/'.$initiator.'/'.$picture1.'" alt="'.$initiator.'">';
		if($picture1 == NULL){
			$image1 = '<img class="img-circle" src="_ast/_img/avatardefault.png">';
		}
		$nsql = "SELECT firstname, lastname FROM _users WHERE username='$initiator'";
		$nquery = mysqli_query($db_connection, $nsql);
		while ($row = mysqli_fetch_array($nquery, MYSQLI_ASSOC)) {
			$frtname = $row["firstname"];
			$lstname = $row["lastname"];
		}
		$nsql2 = "SELECT firstname, lastname FROM _users WHERE username='$note'";
		$nquery2 = mysqli_query($db_connection, $nsql2);
		while ($row = mysqli_fetch_array($nquery2, MYSQLI_ASSOC)) {
			$ftname = $row["firstname"];
			$ltname = $row["lastname"];
		}
		$fullnm = "";
		if($note == $log_username){
			$fullnm = "your";
		}else{
			$fullnm = ''.$ftname.' '.$ltname.'\'s'; 
		}
		if($u == $log_username ){
			$noteDeleteButton = '<span id="dt_'.$noteid.'"><button type="button" onmousedown="deleteNote(\''.$noteid.'\',\'delete_'.$noteid.'\');" class="btn btn-box-tool"><i class="fa fa-trash"></i></button></span>';
		}
		if($app == "status_reply"){
			$notification_list .= '<div id="delete_'.$noteid.'" class="box box-header" style="margin-bottom:5px;" ><div class="user-block">'.$image1.'';
			$notification_list .= '<span class="username"><a class="hand" onclick="uid(\''.$initiator.'\')">'.$frtname.' '.$lstname.'</a> added a comment to '.$fullnm.' post</span><span class="description">'.$_time.' &nbsp;';
			$notification_list .= ' | &nbsp; <a class="hand" onclick="OpenViewPost(\''.$note.'\',\''.$postid.'\',\''.$initiator.'\',\'post_'.$postid.'\');" style="text-decoration:none;">Tap to view</a> &nbsp; | &nbsp;';
			$notification_list .= ''.$noteDeleteButton.'</span> </div></div>';
		}else if($app == "status_post"){
			$notification_list .= '<div id="delete_'.$noteid.'" class="box box-header" style="margin-bottom:5px;" ><div class="user-block">'.$image1.'';
			$notification_list .= '<span class="username"><a class="hand" onclick="uid(\''.$initiator.'\')">'.$frtname.' '.$lstname.'</a> posted on your profile</span><span class="description">'.$_time.' &nbsp;';
			$notification_list .= ' | &nbsp; <a class="hand" <a onclick="window.location = \'uid&'.$note.'#status_'.$postid.'\';" style="text-decoration:none;">Tap to view</a> &nbsp; | &nbsp;';
			$notification_list .= ''.$noteDeleteButton.'</span> </div></div>';
		}else if($app == "status_share"){
			$notification_list .= '<div id="delete_'.$noteid.'" class="box box-header" style="margin-bottom:5px;" ><div class="user-block">'.$image1.'';
			$notification_list .= '<span class="username"><a class="hand" onclick="uid(\''.$initiator.'\')">'.$frtname.' '.$lstname.'</a> shared on your post</span><span class="description">'.$_time.' &nbsp;';
			$notification_list .= ' | &nbsp; <a class="hand" <a onclick="OpenViewPost(\''.$note.'\',\''.$postid.'\',\''.$initiator.'\',\'post_'.$postid.'\');" style="text-decoration:none;">Tap to view</a> &nbsp; | &nbsp;';
			$notification_list .= ''.$noteDeleteButton.'</span> </div></div>';
		}
	}
}
?><?php
$note_label = '<small class="label pull-right bg-primary"></small>';
$note_label_tog = '<span class="label label-danger" style="position: absolute;left: 30px;top: 5px;"></span>';
$sql = "SELECT notecheck FROM _userinfo WHERE username='$log_username'";
$query = mysqli_query($db_connection, $sql);
$row = mysqli_fetch_row($query);
$lastnotecheck = $row[0];

$sql = "SELECT COUNT(id) FROM alerts WHERE username LIKE BINARY '$log_username' AND date_time > '$lastnotecheck'";
$query = mysqli_query($db_connection, $sql);
$query_count = mysqli_fetch_row($query);
$note_count2 = $query_count[0];
$mynotenum = $note_count2;
if($mynotenum > 0) {
	$note_label = '<small class="label pull-right bg-primary">'.$mynotenum.'</small>';
	$note_label_tog = '<span class="label label-danger" data-toggle="offcanvas" style="position: absolute;left: 30px;top: 5px;">'.$mynotenum.'</span>';
}
?><?php
$chat_nav_note_num = '';
$note_check = "SELECT COUNT(id) FROM chats WHERE user2='$log_username' AND seen='0'";
$note_query = mysqli_query($db_connection, $note_check);
$count_query = mysqli_fetch_row($note_query);
$note_count = $count_query[0];
if($note_count > 0 ){
	$chat_nav_note_num = $note_count;
}
?><?php
$frnd_note = '<i class="fa fa-group"></i><span class="label label-danger"></span>';
if($user_ok == true) {
	$sql = "SELECT notecheck FROM _userinfo WHERE username='$log_username'";
	$query = mysqli_query($db_connection, $sql);
	$row = mysqli_fetch_row($query);
	$lastnotecheck = $row[0];
	$sql = "SELECT COUNT(id) FROM friends WHERE user2='$log_username' AND datemade > '$lastnotecheck' AND accepted = '0'";
	$query = mysqli_query($db_connection,$sql);
	$numrows = mysqli_num_rows($query);
	$query_count = mysqli_fetch_row($query);
	$note_count1 = $query_count[0];
	$mynotenum = $note_count1;
	if($numrows > 0 && $mynotenum > 0) {
		$frnd_note = '<i class="fa fa-group"></i><span class="label label-danger">'.$mynotenum.'</span>';
	}
}
?> 
<script>
function friendReqHandler2(action,reqid,user1,elem){
	_(elem).innerHTML = '<div class="preloader pl-size-xs" style="margin: 5px;"><div class="spinner-layer pl-red"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
	var ajax = ajaxObj("POST", "_parse/_system_friend.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "accept_ok"){
				_(elem).innerHTML = "<span style='color:green;font-size: 12px;'>Request Accepted</span><br/><span style='font-size: 12px;'>You are now friends</span>";
			}else if(ajax.responseText == "reject_ok"){
				_(elem).innerHTML = "<span style='color:rgb(192, 41, 41);font-size: 12px;'>Request Rejected</span>";
			}else {
				_(elem).innerHTML = ajax.responseText;
			}
		}
	}
	ajax.send("action="+action+"&reqid="+reqid+"&user1="+user1);
}	
function deleteNote(noteid,notebox){
	Confirm.render("Are you sure you want to delete this notification?");
	Confirm.yes = function(){
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverlay').style.display = "none";
		var ajax = ajaxObj("POST", "_ext/_note/note_deletion_system.php");
		ajax.onreadystatechange = function() {
			if(ajaxReturn(ajax) == true) {
				if(ajax.responseText != "delete_ok"){
					Alert.render(ajax.responseText);
				}else{
					_("delete_"+noteid).style.display = 'none';
				}
			}
		}
		ajax.send("action=delete_note&noteid="+noteid);
	}
	Confirm.no = function(){
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverlay').style.display = "none";
	}
}
</script>