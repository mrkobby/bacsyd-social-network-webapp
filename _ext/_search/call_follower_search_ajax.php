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
$findList = "";

$sql = "SELECT COUNT(id) FROM followers WHERE user2='$u'";
$query = mysqli_query($db_connection, $sql);
$query_count = mysqli_fetch_row($query);
$follower_count = $query_count[0];
if($u == $log_username){
	$max = 1000;
	$all_followers = array();
	$sql = "SELECT user1 FROM followers WHERE user2='$u' LIMIT $max";
	$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		array_push($all_followers, $row["user1"]);
	}
	$friendArrayCount = count($all_followers);
	if($friendArrayCount > $max){
		array_splice($all_followers, $max);
	}
	$result = preg_grep('~' . $input . '~', $all_followers);
	$orLogic = '';
	foreach($result as $key => $m){
			$orLogic .= "username LIKE '".$m."' OR ";
	}
	$orLogic = chop($orLogic, "OR ");
	$sql = "SELECT username, avatar FROM _useroptions WHERE $orLogic";
	$query = mysqli_query($db_connection, $sql);
	if ($query == TRUE){
		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$follower_username = $row["username"];
			$follower_avatar = $row["avatar"];
			$fllw_sql = "SELECT firstname, lastname FROM _users WHERE username='$follower_username'";
			$fllw_query = mysqli_query($db_connection, $fllw_sql);
			while ($row = mysqli_fetch_array($fllw_query, MYSQLI_ASSOC)) {
				$fnme = $row["firstname"];
				$lnme = $row["lastname"];
				if($follower_avatar != ""){
					$follower_pic = '_USER/'.$follower_username.'/'.$follower_avatar.'';
				} else {
					$follower_pic = '_ast/_img/avatardefault.png';
				}
				$sql = "SELECT * FROM _useroptions WHERE username='$follower_username'";
				$useroptions_query = mysqli_query($db_connection, $sql);
				$numrows = mysqli_num_rows($useroptions_query);
				while ($row = mysqli_fetch_array($useroptions_query, MYSQLI_ASSOC)) {
					$followerstatus = $row["userstatus"];
				}		
				$findList .= '<a class="hand" onclick="uid(\''.$follower_username.'\')"><li class="item fa-1x"><div class="product-img cu" style="border:1px solid #000;">';
				$findList .= '<a class="hand" onclick="uid(\''.$follower_username.'\')"><img class="img" src="'.$follower_pic.'" alt="'.$follower_username.'"></a></div>';
				$findList .= '<div class="product-info-name"><a class="hand" onclick="uid(\''.$follower_username.'\')" class="product-title">'.$fnme.' '.$lnme.' | @'.$follower_username.'</a><a class="hand" onclick="uid(\''.$follower_username.'\')">';
				$findList .= '<span class="product-description">'.$followerstatus.'</span></a></div></li></a>';
			}
		}
	}else{
		exit();
	}
}
echo $findList;
?>