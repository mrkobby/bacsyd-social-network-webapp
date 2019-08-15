<?php
$chatList = '';
$chatListMobile = '';
$chatform = '';
$msgBox = '';
$ownerBlockViewer = false;
$sql = "SELECT COUNT(id) FROM friends WHERE user1='$log_username' AND accepted='1' OR user2='$log_username' AND accepted='1'";
$query = mysqli_query($db_connection, $sql);
$query_count = mysqli_fetch_row($query);
$friend_count = $query_count[0];
if($friend_count < 1){
	$chatList = '<span> </span>';
} else {
	$max = 50;
	$all_friends = array();
	$sql = "SELECT user1 FROM friends WHERE user2='$log_username' AND accepted='1' ORDER BY RAND() LIMIT $max";
	$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		array_push($all_friends, $row["user1"]);
	}
	$sql = "SELECT user2 FROM friends WHERE user1='$log_username' AND accepted='1' ORDER BY RAND() LIMIT $max";
	$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		array_push($all_friends, $row["user2"]);
	}
	$friendArrayCount = count($all_friends);
	if($friendArrayCount > $max){
		array_splice($all_friends, $max);
	}
	$orLogic = '';
	foreach($all_friends as $key => $user){
			$orLogic .= "username='$user' OR ";
	}
	$orLogic = chop($orLogic, "OR ");
	$sql = "SELECT username, avatar FROM _useroptions WHERE $orLogic ORDER BY lastchat DESC";
	$query = mysqli_query($db_connection, $sql);
	while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$friend_username = $row["username"];
		$friend_avatar = $row["avatar"];
		if($friend_avatar != ""){
			$_pic = '_USER/'.$friend_username.'/'.$friend_avatar.'';
		} else {
			$_pic = '_ast/_img/avatardefault.png';
		}
		$ch_sql = "SELECT firstname, lastname FROM _users WHERE username='$friend_username'";
		$ch_query = mysqli_query($db_connection, $ch_sql);
			while ($row = mysqli_fetch_array($ch_query, MYSQLI_ASSOC)) {
				$ftname = $row["firstname"];
				$ltname = $row["lastname"];
			}			
		$sqli = "SELECT lastlogin, status FROM _userinfo WHERE username='$friend_username'";
		$queryi = mysqli_query($db_connection, $sqli);
			while ($row2 = mysqli_fetch_array($queryi, MYSQLI_ASSOC)) {
				$last_log = strftime("%b %d, %I:%M %p", strtotime($row2["lastlogin"]) + 60 * 60 * 7);
				$stat_check = $row2["status"];
			}
		if($stat_check == "online"){
			$status = '<i class="fa fa-circle text-success" style="font-size: 10px;margin-left:10px;"></i>';
			$status_text = 'online';
		}else{
			$status = '<i class="fa fa-circle" style="font-size: 10px;margin-left:10px; color: #e1e1e1;"></i>';
			$status_text = 'Not available now';
		}
		$id_check = "SELECT id FROM friends WHERE user1='$log_username' AND user2='$friend_username' AND accepted='1' OR user1='$friend_username' AND user2='$log_username' AND accepted='1'";
		$id_query = mysqli_query($db_connection, $id_check);
		while($row = mysqli_fetch_array($id_query, MYSQLI_ASSOC)) {
			$chat_id = $row["id"];
		}
		$note_check = "SELECT COUNT(id) FROM chats WHERE user1='$friend_username' AND user2='$log_username' AND seen='0'";
		$note_query = mysqli_query($db_connection, $note_check);
		$count_query = mysqli_fetch_row($note_query);
		$note_count = $count_query[0];
		$note_bubble = '';
		$note_mobile = '';
		if($note_count > 0 ){
			$note_bubble = '<span id="bb'.$chat_id.'" class="pull right"><span class="label label-primary pull-right" style="margin-right:10px;">'.$note_count.'</span></span>';
			$note_mobile = '<span id="bbm'.$chat_id.'" class="pull right"><span class="label label-primary pull-right" style="margin-right:10px;">'.$note_count.'</span></span>';
		}
		
		$chatList .= '<li id="ct_'.$chat_id.'" class="item fa-1x hand" onclick="OpenChat(\''.$chat_id.'\',\'bb'.$chat_id.'\',\''.$friend_username.'\',\'msg_body_'.$chat_id.'\');">';
		$chatList .= '<div class="product-img cu" style="border:1px solid black;"><a href="javascript:void(0)"><img class="img" src="'.$_pic.'" alt="'.$friend_username.'"></a></div>';
		$chatList .= '<div class="product-info-name"><a href="javascript:void(0)" class="product-title">'.$ftname.' '.$ltname.'</a>';
		$chatList .= ''.$status.''.$note_bubble.'';
		$chatList .= '<a href="javascript:void(0)"><span class="product-description">'.$status_text.'</span>';		
		$chatList .= '<small class="product-description"><time>'.$last_log.'</time></small></span></a></div></li>';		
		

		$chatListMobile .= '<li id="ctM_'.$chat_id.'" class="hand" onclick="OpenChat(\''.$chat_id.'\',\'bbm'.$chat_id.'\',\''.$friend_username.'\',\'msg_body_'.$chat_id.'\');">';
		$chatListMobile .= '<a href="javascript:void(0)"><img class="contacts-list-img" src="'.$_pic.'" alt="'.$friend_username.'">';		
		$chatListMobile .= '<div class="contacts-list-info"><span><a class="contacts-list-name">'.$ftname.' '.$ltname.' '.$note_mobile.'</a>';		
		$chatListMobile .= '<small class="contacts-list-date pull-right"><time>'.$last_log.'</time></small></span>';		
		$chatListMobile .= '<span class="contacts-list-msg">'.$status_text.'</span></div></a></li>';		
		
		
		$block_check1 = "SELECT id FROM blockedusers WHERE blocker='$friend_username' AND blockee='$log_username'";
		if(mysqli_num_rows(mysqli_query($db_connection, $block_check1)) > 0){
			$ownerBlockViewer = true;
			$_textarea = '<span style="color:red;">You have been blocked. Check '.$ftname.'\'s profile to confirm this.</span>';
		}else{
			$_textarea = '<input type="text" placeholder="Type Message ..." class="form-control" id="chat_text_'.$chat_id.'" name="chat_text_'.$chat_id.'" onkeyup="chatMax(this,200)"></input>';
		}
		$chatform .= '<div class="box-footer" id="form_'.$chat_id.'"><form action="javascript:void(0)" method="post">';
		$chatform .= '<div class="input-group"><input type="text" name="message" placeholder="Type Message ..." class="form-control">';
		$chatform .= '<span class="input-group-btn"><button type="submit" class="btn btn-primary btn-flat">Send</button>';
		$chatform .= '</span></div></form></div>';
		
		$msgBox .= '<div class="popup" id="chat_'.$chat_id.'"><div class="popup-inner" style="text-align: justify;width:auto;">';
		$msgBox .= '<div class="box-body" style="padding:0px;">';
		$msgBox .= '<div id="msg_box_'.$chat_id.'" class="box box-primary direct-chat direct-chat-primary">';
		$msgBox .= '<div class="box-header with-border">';
		$msgBox .= '<button type="button" onclick="CloseChat(\''.$chat_id.'\')" class="btn btn-primary pull-right" style="margin-right:10px;margin-left: 10px;">Close</button>';
		$msgBox .= '<a class="hand" onclick="uid(\''.$friend_username.'\')"><img class="direct-chat-img pull-left" src="'.$_pic.'" style="width:35px;height:35px;border:1px solid black;" alt="'.$friend_username.'">';
		$msgBox .= '<span class="box-title pull-left" style="margin-left:5px;font-size:14px;">'.$ftname.' '.$ltname.'</span></a><br>';
		$msgBox .= '<span class="contacts-list-msg pull-left" style="margin-left:5px;"><small>'.$status_text.'</small></span></div>';
		$msgBox .= '<div class="box-body"><div id="msg_body_'.$chat_id.'" class="direct-chat-messages scrollChat">';
		$msgBox .= '<div style="text-align:center;margin: 5px;"><div class="preloader pl-size-xs"><div class="spinner-layer pl-blue"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div></div>';
		$msgBox .= '</div></div>';
		$msgBox .= '<div class="box-footer"><div class="input-group">';
		$msgBox .= ''.$_textarea.'';
		$msgBox .= '<span class="input-group-btn">';
		$msgBox .= '<button id="chtBtn_'.$chat_id.'" class="btn btn-primary btn-flat" onclick="submitChat(\'chat_post\',\''.$friend_username.'\',\'chat_text_'.$chat_id.'\',\''.$chat_id.'\',\'msg_body_'.$chat_id.'\')"><i class="fa fa-send"></i></button>';
		$msgBox .= '</span></div></div></div></div></div></div>';
		
		}
	}
?>		
<div class="col-md-3 col-sm-12 col-xs-12 mobile-no-show" style="position: fixed;right: 0px;width: 20%;">
	<div class=""><!--<div class="chat-bg-gradient">-->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Chats</h3>
				<div class="box-tools pull-right"></div>
			</div>
			<div class="right-most-fixed"><!--<div class="right-most-fixed chat-bg-gradient">-->
				<div class="box-body no-padding">
					<ul id="chat_note" class="products-list product-list-in-box">
						<?php echo $chatList;?>
					 </ul>
				</div>
			</div>
			<div class="box-footer text-center chat-bg-gradient"></div>
		</div>		
	</div>
</div>

<?php echo $msgBox;?>
<script src="_ast/_js/_query.js"></script>
<script type="text/javascript">
function OpenChat(chatid,bubble,user,chatbody){
	var xmlhttp2 = new XMLHttpRequest();
	xmlhttp2.onreadystatechange = function(){
		if(xmlhttp2.readyState==4&&xmlhttp2.status==200){
			document.getElementById('msg_body_'+chatid).innerHTML = xmlhttp2.responseText;
			_(bubble).style.display = "none";
		}
	}	
	xmlhttp2.open('GET','_ext/_cht/_load_chat.php?chatid='+chatid, true);
	xmlhttp2.send();	
	$("#chat_"+chatid).fadeIn(200);
	setTimeout(function(){$('.chattime').slideDown(300);}, 500);
	setTimeout(function(){$('#msg_body_'+chatid).animate({scrollTop: $('#msg_body_'+chatid).get(0).scrollHeight}, 1000);}, 800);
}
function CloseChat(chatid){
	$("#chat_"+chatid).fadeOut(200);
}
function submitChat(action,user,ta,chatid,chatbody){
	var data = _(ta).value;
	if(data == ""){
		return false;
	}
	_(ta).value = "";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState==4&&xmlhttp.status==200){
			document.getElementById('msg_body_'+chatid).innerHTML = xmlhttp.responseText;
			$('#msg_body_'+chatid).animate({scrollTop: $('#msg_body_'+chatid).get(0).scrollHeight}, 500);
			setTimeout(function(){$('.chattime').slideDown(300);}, 200);
		}
	}
	xmlhttp.open('GET','_ext/_cht/_insert_chat.php?action='+action+'&user='+user+'&data='+encodeURIComponent(data)+'&chatid='+chatid, true);
	xmlhttp.send();
}
function chatMax(field, maxlimit) {
	if (field.value.length > maxlimit){
		field.value = field.value.substring(0, maxlimit);
	}
}
</script>