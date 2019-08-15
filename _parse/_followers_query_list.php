<?php 
$fllwsList = '';
$sql = "SELECT COUNT(id) FROM followers WHERE user2='$u'";
$query = mysqli_query($db_connection, $sql);
$query_count = mysqli_fetch_row($query);
$follower_count = $query_count[0];
if($follower_count < 1){
	$fllwsList = '<span> No followers yet </span>';
} else {
	$max = 8;
	$all_followers = array();
	$sql = "SELECT user1 FROM followers WHERE user2='$u' ORDER BY RAND() LIMIT $max";
	$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		array_push($all_followers, $row["user1"]);
	}
	$followerArrayCount = count($all_followers);
	if($followerArrayCount > $max){
		array_splice($all_followers, $max);
	}
	$orLogic = '';
	foreach($all_followers as $key => $user){
			$orLogic .= "username='$user' OR ";
	}
	$orLogic = chop($orLogic, "OR ");
	$fllw_sql = "SELECT username, avatar FROM _useroptions WHERE $orLogic";
	$fllw_query = mysqli_query($db_connection, $fllw_sql);
	while($row = mysqli_fetch_array($fllw_query, MYSQLI_ASSOC)) {
		$follower_username = $row["username"];
		$follower_avatar = $row["avatar"];	
		$datesql = "SELECT date_made FROM followers WHERE user2='$u' AND user1='$follower_username' LIMIT 1";
		$f_query = mysqli_query($db_connection, $datesql);
		while ($row2 = mysqli_fetch_array($f_query, MYSQLI_ASSOC)) {
			$followdate = strftime("%b %d", strtotime($row2["date_made"]));
		}
		$sql = "SELECT firstname, lastname FROM _users WHERE username='$follower_username'";
		$query = mysqli_query($db_connection, $sql);
		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$fnm = $row["firstname"];
			$lnm = $row["lastname"];
			if($follower_avatar != ""){
				$follower_pic = '_USER/'.$follower_username.'/'.$follower_avatar.'';
			} else {
				$follower_pic = '_ast/_img/avatardefault.png';
			}	
			$fllwsList .= '<li><a class="hand" onclick="uid(\''.$follower_username.'\')"><img src="'.$follower_pic.'" alt="'.$follower_username.'"></a>';
			$fllwsList .= '<a class="users-list-name hand" onclick="uid(\''.$follower_username.'\')" data-toggle="tooltip" title="'.$fnm.' '.$lnm.'"><span>'.$follower_username.'</span></a>';
			$fllwsList .= '<span class="users-list-date">'.$followdate.'</span></li>';
		}
	}
}														
?>