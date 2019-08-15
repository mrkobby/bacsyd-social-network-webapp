<?php
$sql = "SELECT username, avatar FROM _useroptions WHERE username != '$log_username' ORDER BY RAND() LIMIT 8";
$rquery = mysqli_query($db_connection, $sql);
$userlist = '';
$userDiscoverlist = '';
while ($row = mysqli_fetch_array($rquery, MYSQLI_ASSOC)) {
	$user = $row["username"];
	$ava = $row["avatar"];
	$datesql = "SELECT signup FROM _userinfo WHERE username='$user'";
	$_query = mysqli_query($db_connection, $datesql);
	while ($row2 = mysqli_fetch_array($_query, MYSQLI_ASSOC)) {
		$signupdate = strftime("%b %d", strtotime($row2["signup"]));
	}
	$sql = "SELECT firstname, lastname FROM _users WHERE username='$user' AND usertype='user'";
	$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$fn = $row["firstname"];
		$ln = $row["lastname"];
	
		$friend_button = '<button class="btn btn-flat btn-primary" style="padding:5px;font-size:10px;" id="friendBtn_" onclick="friendToggle(\'friend\',\''.$user.'\',\'friendBtn_'.$user.'\')">Friend</button>';
		$_pic = '_USER/'.$user.'/'.$ava;
		if($ava == NULL){
			$_pic = '_ast/_img/avatardefault.png';
		}
		if($user_ok == true){
			$friend_check = "SELECT id FROM friends WHERE user1='$log_username' AND user2='$user' AND accepted='1' OR user1='$user' AND user2='$log_username' AND accepted='1'";
			$accepted_check = "SELECT id FROM friends WHERE user1='$log_username' AND user2='$user' AND accepted='0' OR user1='$user' AND user2='$log_username' AND accepted='0'";
			if(mysqli_num_rows(mysqli_query($db_connection, $accepted_check)) > 0){	
				$friend_button = '<button id="friendBtn_" class="btn btn-flat btn-default" style="padding:5px;font-size:10px;">Sent!</button>';
			}
			if(mysqli_num_rows(mysqli_query($db_connection, $friend_check)) < 1){
				$userlist .= '<li><a class="hand" onclick="uid(\''.$user.'\')"><img src="'.$_pic.'" alt="'.$user.'"></a>';
				$userlist .= '<a class="users-list-name hand" onclick="uid(\''.$user.'\')" data-toggle="tooltip" title="'.$fn.' '.$ln.'">'.$fn.' '.$ln.'</a>';
				$userlist .= '<span id="friendBtn_'.$user.'">'.$friend_button.'</span>';
				$userlist .= '<span class="users-list-date"><time>'.$signupdate.'</time></span></li>';		
				
				$userDiscoverlist .= '<li><a class="hand" onclick="uid(\''.$user.'\')"><img src="'.$_pic.'" alt="'.$user.'"></a>';
				$userDiscoverlist .= '<a class="exp-users-list-name hand" onclick="uid(\''.$user.'\')" data-toggle="tooltip" title="'.$fn.' '.$ln.'">'.$fn.' '.$ln.'</a>';
				$userDiscoverlist .= '<span id="friendBtn_'.$user.'">'.$friend_button.'</span>';
				$userDiscoverlist .= '<span class="exp-users-list-date"><time>'.$signupdate.'</time></span></li>';			
			}
		}
	}
}
?>
<script>
function friendToggle(type,user,elem){
	_(elem).innerHTML = '<button class="btn btn-flat btn-default" disabled style="white-space: inherit;padding:5px;font-size:10px;"><div class="preloader pl-size-xs"><div class="spinner-layer pl-maroon"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div></button>';
	var ajax = ajaxObj("POST", "_parse/_system_friend.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "friend_request_sent"){
				_(elem).innerHTML = '<button id="friendBtn_" class="btn btn-flat btn-default" style="padding:5px;font-size:10px;">Sent!</button>';
			} else if(ajax.responseText == "unfriend_ok"){
				_(elem).innerHTML = '<button class="btn btn-flat btn-primary" style="padding:5px;font-size:10px;" id="friendBtn_" onclick="friendToggle(\'friend\',\'<?php echo $user; ?>\',\'friendBtn_<?php echo $user; ?>\')">Friend</button>';
			} else {
				alert(ajax.responseText);
				_(elem).innerHTML = '<button class="btn btn-flat btn-primary" style="padding:5px;font-size:10px;" id="friendBtn_" onclick="friendToggle(\'friend\',\'<?php echo $user; ?>\',\'friendBtn_<?php echo $user; ?>\')">Friend</button>';
			}
		}
	}
	ajax.send("type="+type+"&user="+user);
}
</script>