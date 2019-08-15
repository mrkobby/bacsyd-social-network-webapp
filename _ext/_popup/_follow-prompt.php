<?php
$sql = "SELECT username, avatar FROM _useroptions WHERE username != '$log_username' LIMIT 6";
$rquery = mysqli_query($db_connection, $sql);
$pagelist = '';
while ($row = mysqli_fetch_array($rquery, MYSQLI_ASSOC)) {
	$user = $row["username"];
	$ava = $row["avatar"];
	$datesql = "SELECT signup FROM _userinfo WHERE username='$user'";
	$_query = mysqli_query($db_connection, $datesql);
	while ($row2 = mysqli_fetch_array($_query, MYSQLI_ASSOC)) {
		$signupdate = strftime("%b %d", strtotime($row2["signup"]));
	}
	$sql = "SELECT firstname, lastname FROM _users WHERE username='$user' AND usertype='page'";
	$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$fn = $row["firstname"];
		$ln = $row["lastname"];
		
		$ownerFllw = false;
		$fllw_check = "SELECT id FROM followers WHERE user1='$log_username' AND user2='$user'";
		if(mysqli_num_rows(mysqli_query($db_connection, $fllw_check)) > 0){
			$ownerFllw = true;
		}
		$ff_button = '<a class="btn btn-info btn-flat hand" id="followBtn_'.$user.'" onclick="followTog(\'follow\',\''.$user.'\',\'folwBtn_'.$user.'\')"><b>Follow</b></a>';
		if($ownerFllw == true){
			$ff_button = '<a class="btn btn-primary btn-block hand" id="followBtn_'.$user.'" onclick="followTog(\'unfollow\',\''.$user.'\',\'folwBtn_'.$user.'\')"><b>Following</b></a>';
		} else if($user_ok == true && $user != $log_username){
			$ff_button = '<a class="btn btn-info btn-block hand" id="followBtn_'.$user.'" onclick="followTog(\'follow\',\''.$user.'\',\'folwBtn_'.$user.'\')"><b>Follow</b></a>';
		}
		$_pic = '_USER/'.$user.'/'.$ava;
		if($ava == NULL){
			$_pic = '_ast/_img/avatardefault.png';
		}
		if($user_ok == true){
			$follow_check = "SELECT id FROM followers WHERE user1='$log_username'";
			if(mysqli_num_rows(mysqli_query($db_connection, $follow_check)) < 5){
				$pagelist .= '<div id="follow_'.$user.'" class="box box-header" style="margin-bottom:5px;" ><div class="user-block"><img class="img-circle" src="'.$_pic.'" alt="'.$user.'">';
				$pagelist .= '<span class="pull-right" id="folwBtn_'.$user.'">'.$ff_button.'</span><span class="username"><a class="hand">'.$fn.' '.$ln.'</a>';
				$pagelist .= '</span><span class="description">'.$signupdate.' &nbsp;</span></div></div>';
			}
		}
	}
}
?>
<div class="popup" id="followPrompt" pd-popup="followPrompt">
	<div class="popup-inner">
	<div id="ffPromptDiv" style="display: none; z-index:99999; text-align: center;position: absolute;background: rgba(60, 57, 57, 0.85);width: 100%;height: 100%;font-size: 22px;color: #fff;left:0px;top:0px;line-height: 100px;">Please wait...</div>
		<div class="box-body">
			<div class="box box-primary" style="border-top:0px solid;text-align:justify;box-shadow: 0 0px 0px;">
				<?php echo $pagelist;?>
			</div>
			<br>
			<div class="box-footer no-padding">
				<a href="javascript:void(0)" onclick="followPromptDone()" class="btn btn-primary pull-right">Done</a>
			</div>
		</div>
	</div>
</div>
<script>
function followTog(type,user2,elem){
	_(elem).innerHTML = '<a class="btn btn-default btn-block" style="white-space: inherit;" disabled><div class="preloader pl-size-xs"><div class="spinner-layer pl-maroon"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div></a>';
	var ajax = ajaxObj("POST", "_parse/_system_follow.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "follow_ok"){
				_(elem).innerHTML = '<a class="btn btn-primary btn-block hand" id="followBtn_'+user2+'" onclick="followTog(\'unfollow\',\''+user2+'\',\'folwBtn_'+user2+'\')"><b>Following</b></a>';
				ff.play();
			} else if(ajax.responseText == "unfollow_ok"){
				_(elem).innerHTML = '<a class="btn btn-info btn-block hand" id="followBtn_'+user2+'" onclick="followTog(\'follow\',\''+user2+'\',\'folwBtn_'+user2+'\')"><b>Follow</b></a>';
			} else {
				Alert.render(ajax.responseText);
				_(elem).innerHTML = '<a class="btn btn-info btn-block hand" id="followBtn_'+user2+'" onclick="followTog(\'follow\',\''+user2+'\',\'folwBtn_'+user2+'\')"><b>Follow</b></a>';
			}
		}
	}
	ajax.send("type="+type+"&user2="+user2);
}
</script>