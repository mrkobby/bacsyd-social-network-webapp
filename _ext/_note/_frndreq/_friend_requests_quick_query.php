<?php
include_once("../../../_sys/check_login_status.php");
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php
$friend_requests = "";
$sql = "SELECT * FROM friends WHERE user2='$log_username' AND accepted='0' ORDER BY datemade DESC";
$query = mysqli_query($db_connection, $sql);
$numrows = mysqli_num_rows($query);
if($numrows < 1){
	$friend_requests = '';
} else {
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$reqID = $row["id"];
		$user1 = $row["user1"];
		$datemade = strftime("%b %d, %Y <br> %I:%M %p", strtotime($row["datemade"]));
		$thumbquery = mysqli_query($db_connection, "SELECT avatar FROM _useroptions WHERE username='$user1'");
		$thumbrow = mysqli_fetch_row($thumbquery);
		$user1avatar = $thumbrow[0];
		$user1pic = '_USER/'.$user1.'/'.$user1avatar.'';
		if($user1avatar == NULL){
			$user1pic = '_ast/_img/avatardefault.png';
		}
		$nsql = "SELECT firstname, lastname FROM _users WHERE username='$user1'";
		$nquery = mysqli_query($db_connection, $nsql);
		while ($row = mysqli_fetch_array($nquery, MYSQLI_ASSOC)) {
			$fnme = $row["firstname"];
			$lnme = $row["lastname"];
			
			$friend_requests .= '<a id="friendreq_'.$reqID.'" class="hand" href="uid&'.$user1.'"><li class="item fa-1x"><div class="product-img cu" style="border:1px solid black;">';
			$friend_requests .= '<a href="uid&'.$user1.'"><img style="width:50px;height:50px;" class="img" src="'.$user1pic.'" alt="'.$user1.'"></a></div>';
			$friend_requests .= '<div style="margin-left:60px;" class="product-info-name"><a href="uid&'.$user1.'" class="product-title" style="font-size:12px;">'.$fnme.' '.$lnme.'</a>';
			$friend_requests .= '<span class="pull-right" id="user_info_'.$reqID.'" style="padding:5px;"> ';
			$friend_requests .= '<button style="padding:10px;font-size:12px;" class="btn btn-flat btn-primary" onclick="friendReqHandler(\'accept\',\''.$reqID.'\',\''.$user1.'\',\'user_info_'.$reqID.'\')">Accept</button> &nbsp;';
			$friend_requests .= '<button style="padding:10px;font-size:12px;" class="btn btn-flat btn-info" onclick="friendReqHandler(\'reject\',\''.$reqID.'\',\''.$user1.'\',\'user_info_'.$reqID.'\')">Reject</button>';		
			$friend_requests .= '</span><a href="uid&'.$user1.'"><span style="overflow: visible;text-overflow: inherit;" class="product-description">';
			$friend_requests .= '<time>'.$datemade.'</time>';
			$friend_requests .= '</span></a></div></li></a>';
		}
	}
}
echo $friend_requests;
?>