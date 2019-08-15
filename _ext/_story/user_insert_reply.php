<?php 
include_once("../../_sys/check_login_status.php");
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php 
if (isset($_GET['action']) && $_GET['action'] == "status_reply"){
	if(strlen($_GET['data']) < 1){
		mysqli_close($db_connection);
		echo '<div class="box box-header with-border"><h6 class="box-title" style="font-size: 12px;">data_not_appropriate</h6></div>';
	    exit();
	}
	if(isset($_GET["user"])){
		$u =  $_GET['user']; 
	}
	$osid = preg_replace('#[^0-9]#', '', $_GET['sid']);
	$account_name = preg_replace('#[^a-z0-9]#i', '', $_GET['user']);
	$data = nl2br($_GET['data']);
	$data = str_replace("&amp;","&",$data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = mysqli_real_escape_string($db_connection, $data);
	
	$sql = "SELECT COUNT(id) FROM _users WHERE username='$account_name'";
	$query = mysqli_query($db_connection, $sql);
	$row = mysqli_fetch_row($query);
	if($row[0] < 1){
		mysqli_close($db_connection);
		echo '<div class="box box-header with-border"><h6 class="box-title" style="font-size: 12px;">Account does not exist</h6></div>';
		exit();
	}
	$sql = "INSERT INTO story(osid, account_name, author, type, data, postdate)
	        VALUES('$osid','$account_name','$log_username','b','$data',now())";
	$query = mysqli_query($db_connection, $sql);
	$id = mysqli_insert_id($db_connection);
	$osql = "SELECT author FROM story WHERE osid='$osid' AND author!='$log_username' GROUP BY author";
	$oquery = mysqli_query($db_connection, $osql);
	while ($row = mysqli_fetch_array($oquery, MYSQLI_ASSOC)) {
		$participant = $row["author"];
		$app = "status_reply";
		$nsql2 = "SELECT author FROM story WHERE id='$osid' LIMIT 1";
		$nquery2 = mysqli_query($db_connection, $nsql2);
		while ($row = mysqli_fetch_array($nquery2, MYSQLI_ASSOC)) {
			$note = $row["author"];
			mysqli_query($db_connection, "INSERT INTO alerts(story_id,username, initiator, app, note, date_time) 
						 VALUES('$osid','$participant','$log_username','$app','$note',now())");
		}
	}
}
?><?php	
$author = "";
$replyauthor = "";
$picture2 = "";
$replystring = "";
	$status_replies = "";
	$query_replies = mysqli_query($db_connection, "SELECT * FROM story WHERE osid='$osid' AND type='b'");
	$replynumrows = mysqli_num_rows($query_replies);
    if($replynumrows > 0){
        $rpysql = "SELECT * FROM story WHERE osid='$osid' AND type='b' ORDER BY postdate DESC LIMIT 2";
		$replyquery = mysqli_query($db_connection, $rpysql);
		while ($row2 = mysqli_fetch_array($replyquery, MYSQLI_ASSOC)) {
			$statusreplyid = $row2["id"];
			$replyauthor = $row2["author"];
			$replydata = $row2["data"];
			$replydata = nl2br($replydata);
			$replydata = str_replace("&amp;","&",$replydata);
			$replydata = stripslashes($replydata);
			$replypostdate = strftime("%b %d at %I:%M %p", strtotime($row2["postdate"]) + 60 * 60 * 7);
			$replyDeleteButton = '';
			if($replyauthor == $log_username || $account_name == $log_username ){
				$replyDeleteButton = '<span id="srdb_'.$osid.'"><a class="hand" onclick="return false;" onmousedown="deleteReply(\''.$statusreplyid.'\',\'reply_'.$statusreplyid.'\');" title="DELETE THIS COMMENT"><span class="fa fa-trash cg close margin-10"></span></a></span>';
			}
			$sql = "SELECT avatar FROM _useroptions WHERE username='$replyauthor'";
			$ava_query = mysqli_query($db_connection, $sql);
			while ($row = mysqli_fetch_array($ava_query, MYSQLI_ASSOC)) {$picture2 = $row["avatar"];}
			$image3 = '<img class="img-circle img-sm" src="_USER/'.$replyauthor.'/'.$picture2.'" alt="'.$replyauthor.'">';
			if($picture2 == NULL){$image3 = '<img class="img-circle img-sm" src="_ast/_img/avatardefault.png">';}
			$sql = "SELECT firstname, lastname FROM _users WHERE username='$replyauthor'";
			$query = mysqli_query($db_connection, $sql);
			while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				$ftname = $row["firstname"];
				$ltname = $row["lastname"];
			}
			$status_replies .= '<div id="reply_'.$statusreplyid.'" class="box-footer box-comments"><div class="box-comment">'.$image3.'<div class="comment-text">';
			$status_replies .= '<span class="username"><a class="hand" onclick="uid(\''.$replyauthor.'\')">'.$ftname.' '.$ltname.'</a><span class="text-muted pull-right"><time>'.$replypostdate.'</time></span></span>';
			$status_replies .= ''.$replydata.'</div></div></div>';
        }
	}
$replystring .= "$status_replies|$replynumrows|||";
$replystring = trim($replystring, "|||");		
echo $replystring;
?>