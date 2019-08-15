<?php 
include_once("../../_sys/check_login_status.php");
if($user_ok == false){
    exit();
}
?><?php
include_once("../../_sys/db_connection.php");
$f = $_REQUEST["f"];
$input = preg_quote($f, '~');
$u = $_REQUEST["u"];
$searchList = "";

$sql = "SELECT COUNT(id) FROM friends WHERE user1='$u' AND accepted='1' OR user2='$u' AND accepted='1'";
$query = mysqli_query($db_connection, $sql);
$query_count = mysqli_fetch_row($query);
$friend_count = $query_count[0];
if($u == $log_username){
	$max = 1000;
	$all_friends = array();
	$sql = "SELECT user1 FROM friends WHERE user2='$u' AND accepted='1'";
	$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		array_push($all_friends, $row["user1"]);
	}
	$sql = "SELECT user2 FROM friends WHERE user1='$u' AND accepted='1'";
	$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		array_push($all_friends, $row["user2"]);
	}
	$friendArrayCount = count($all_friends);
	if($friendArrayCount > $max){
		array_splice($all_friends, $max);
	}
	$result = preg_grep('~' . $input . '~', $all_friends);
	$orLogic = '';
	foreach($result as $key => $m){
			$orLogic .= "username LIKE '".$m."' OR ";
	}
	$orLogic = chop($orLogic, "OR ");
	$sql = "SELECT username, avatar FROM _useroptions WHERE $orLogic";
	$frnd_query = mysqli_query($db_connection, $sql);
	if ($frnd_query == TRUE){
		while($row = mysqli_fetch_array($frnd_query, MYSQLI_ASSOC)) {
			$friend_uname = $row["username"];
			$friend_avatar = $row["avatar"];
			
			$sql = "SELECT firstname, lastname FROM _users WHERE username='$friend_uname'";
			$query = mysqli_query($db_connection, $sql);
			while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				$fn = $row["firstname"];
				$ln = $row["lastname"];
				if($friend_avatar != ""){
					$friend_pic = '_USER/'.$friend_uname.'/'.$friend_avatar.'';
				} else {
					$friend_pic = '_ast/_img/avatardefault.png';
				}
				$sql = "SELECT * FROM _useroptions WHERE username='$friend_uname'";
				$useroptions_query = mysqli_query($db_connection, $sql);
				$numrows = mysqli_num_rows($useroptions_query);
				while ($row = mysqli_fetch_array($useroptions_query, MYSQLI_ASSOC)) {
					$friendstatus = $row["userstatus"];
				}		
				$searchList .= '<a class="hand" onclick="uid(\''.$friend_uname.'\')"><li class="item fa-1x"><div class="product-img cu" style="border:1px solid #000;">';
				$searchList .= '<a onclick="uid(\''.$friend_uname.'\')"><img class="img" src="'.$friend_pic.'" alt="'.$friend_uname.'"></a></div>';
				$searchList .= '<div class="product-info-name"><a class="hand" onclick="uid(\''.$friend_uname.'\')" class="product-title">'.$fn.' '.$ln.' | @'.$friend_uname.'</a><a class="hand" onclick="uid(\''.$friend_uname.'\')">';
				$searchList .= '<span class="product-description">'.$friendstatus.'</span></a></div></li></a>';
			}
		}
	}else{
		exit();
	}
}
echo $searchList;
?>