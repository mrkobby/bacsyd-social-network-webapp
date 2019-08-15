<?php 
include_once("../../_sys/check_login_status.php");
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php
if (isset($_GET['acc']) && $_GET['sid'] && $_GET['user']){
	$account_name = preg_replace('#[^a-z0-9]#i', '', $_GET['acc']);
	$u = preg_replace('#[^a-z0-9]#i', '', $_GET['user']);
	$statusid = preg_replace('#[^0-9]#', '', $_GET['sid']);
} else {
	exit();
}
?><?php	
$statuslist = "";
$replyform = "";
$avatar = "";
$poststring = "";
$share = "";
$datafont = "";
$sql = "SELECT * FROM story WHERE id='$statusid' ORDER BY postdate DESC LIMIT 100";
$query = mysqli_query($db_connection, $sql);
$statusnumrows = mysqli_num_rows($query);
while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$statusid = $row["id"];
	$statusosid = $row["osid"];
	$account_name = $row["account_name"];
	$author = $row["author"];
	$postdate = strftime("%b %d, %Y at %I:%M %p", strtotime($row["postdate"]) + 60 * 60 * 7);
	$data = $row['data'];
	$data_passed = mysqli_real_escape_string($db_connection, $data);
	$datacaption = $row['datacaption'];
	$postpic = $row['image'];
	$statusDeleteButton = '';
	if($account_name == $log_username ){
		$statusDeleteButton = '<span id="sdb_'.$statusid.'"><a class="hand" onclick="return false;" onmousedown="deleteStatus(\''.$statusid.'\',\'status_'.$statusid.'\');" title="DELETE ENTIRE STORY"><span class="fa fa-trash cg close margin-10"></span></a></span>';
	}
	if((strlen($data)) < 11){
		$datafont = 'style="font-size:25px"';
	}else if((strlen($data)) > 11 && (strlen($data)) < 51){
		$datafont = 'style="font-size:20px"';
	}else if((strlen($data)) > 51 && (strlen($data)) < 100){
		$datafont = 'style="font-size:16px"';
	}else{
		$datafont = 'style="font-size:14px"';
	}
	$mysql = "SELECT type FROM story WHERE id='$statusid'";
	$_query = mysqli_query($db_connection, $mysql);
	while ($row = mysqli_fetch_array($_query, MYSQLI_ASSOC)) {
		$type = $row["type"];
		
		if($type == 'a' || $type == 'c'){
			$sql = "SELECT avatar FROM _useroptions WHERE username='$author'";
			$ava_query = mysqli_query($db_connection, $sql);
			while ($row = mysqli_fetch_array($ava_query, MYSQLI_ASSOC)) {$picture = $row["avatar"];}
			$sql = "SELECT avatar FROM _useroptions WHERE username='$log_username'";
			$_query = mysqli_query($db_connection, $sql);
			while ($row = mysqli_fetch_array($_query, MYSQLI_ASSOC)) {$log_picture = $row["avatar"];}
			$image = '<img class="img-circle" src="_USER/'.$author.'/'.$picture.'" alt="'.$author.'">';
			if($picture == NULL){$image = '<img class="img-circle" src="_ast/_img/avatardefault.png">';}
			$reply_image = '<img class="img-circle img-sm" src="_USER/'.$log_username.'/'.$log_picture.'" alt="'.$author.'">';
			if($log_picture == NULL){$reply_image = '<img class="img-circle img-sm" src="_ast/_img/avatardefault.png">';}
			
			$isLiked = false;
			if($user_ok == true){
				$like_check = "SELECT id FROM storylikes WHERE storyid='$statusid' AND username='$log_username'";
				if(mysqli_num_rows(mysqli_query($db_connection, $like_check)) > 0){$isLiked = true;}
				$story_likes = mysqli_query($db_connection, "SELECT * FROM storylikes WHERE storyid ='$statusid'");
				$likenumrows = mysqli_num_rows($story_likes);
			}
			if($user_ok == true && $isLiked == false){
				$like_button = '<a class="link-black text-sm hand" id="likeBtn'.$statusid.'" onclick="likeToggle(\'like\',\''.$author.'\',\''.$statusid.'\',\'likeBtn_'.$statusid.'\')"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>';
			} else if($user_ok == true && $isLiked == true){
				$like_button = '<a class="link-black text-sm hand like" id="likeBtn'.$statusid.'" onclick="likeToggle(\'unlike\',\''.$author.'\',\''.$statusid.'\',\'likeBtn_'.$statusid.'\')"><i class="fa fa-thumbs-up margin-r-5"></i></a>';
			}
			$sql = "SELECT firstname, lastname FROM _users WHERE username='$author'";
			$nm_query = mysqli_query($db_connection, $sql);
			while ($row = mysqli_fetch_array($nm_query, MYSQLI_ASSOC)) {
				$ftnm = $row["firstname"];
				$ltnm = $row["lastname"];
			}
			$status_replies = "";
			$query_replies = mysqli_query($db_connection, "SELECT * FROM story WHERE osid='$statusid' AND type='b' ORDER BY postdate DESC");
			$replynumrows = mysqli_num_rows($query_replies);
			if($replynumrows > 0){
				while ($row2 = mysqli_fetch_array($query_replies, MYSQLI_ASSOC)) {
					$statusreplyid = $row2["id"];
					$replyauthor = $row2["author"];
					$replydata = $row2["data"];
					$replydata = nl2br($replydata);
					$replydata = str_replace("&amp;","&",$replydata);
					$replydata = stripslashes($replydata);
					$replypostdate = strftime("%b %d at %I:%M %p", strtotime($row2["postdate"]) + 60 * 60 * 7);
					$replyDeleteButton = '';
					if($replyauthor == $log_username){
						$replyDeleteButton = '<span id="srdb_'.$statusid.'"><a class="hand" onclick="return false;" onmousedown="deleteReply(\''.$statusreplyid.'\',\'reply_'.$statusreplyid.'\',\'reply2_'.$statusreplyid.'\');" title="DELETE THIS COMMENT"><span class="fa fa-trash cg close margin-10"></span></a></span>';
					}
					$sql = "SELECT avatar FROM _useroptions WHERE username='$replyauthor'";
					$ava_query = mysqli_query($db_connection, $sql);
					while ($row = mysqli_fetch_array($ava_query, MYSQLI_ASSOC)) {$picture2 = $row["avatar"];}
					$image3 = '<img class="img-circle img-sm" src="_USER/'.$replyauthor.'/'.$picture2.'" alt="'.$replyauthor.'">';
					if($picture2 == NULL){$image3 = '<img class="img-circle img-sm" src="_ast/_img/avatardefault.png">';}
					$sql = "SELECT firstname, lastname FROM _users WHERE username='$replyauthor'";
					$r_query = mysqli_query($db_connection, $sql);
					while ($row = mysqli_fetch_array($r_query, MYSQLI_ASSOC)) {
						$ftname = $row["firstname"];
						$ltname = $row["lastname"];
					}
					$status_replies .= '<div id="reply2_'.$statusreplyid.'" class="box-footer box-comments"><div class="box-comment">'.$image3.'<div class="comment-text">';
					$status_replies .= '<span class="username"><a class="hand" onclick="uid(\''.$replyauthor.'\')">'.$ftname.' '.$ltname.'</a><span class="text-muted pull-right"><time>'.$replypostdate.'</time></span></span>';
					$status_replies .= ''.$replydata.''.$replyDeleteButton.'</div></div></div>';
				}
			}
			$posted_image = '<img class="img-responsive" src="_USER/'.$author.'/'.$postpic.'" alt="'.$author.'">';
			if($postpic == NULL){
				$posted_image = '';
			}
			$share .= ' <li id="share_'.$statusid.'" class="input-group-btn"><a href="javascript:void(0)" type="button" class="link-black text-sm dropdown-toggle" data-toggle="dropdown">';
            $share .= 'Share <span class="fa fa-caret-down"></span></a>';
            $share .= '<ul class="dropdown-menu">';
		 /* $share .= '<li><a href="javascript:void(0)" onclick="OpenShareCaption(\''.$statusid.'\',\''.$author.'\',\''.$data.'\',\''.$postdate.'\',\'sh_'.$statusid.'\',\''.$postpic.'\');">Add caption and share</a></li>'; */
            $share .= '<li><a href="javascript:void(0)">Copy link</a></li>';
            $share .= '<li class="divider"></li>';
            $share .= '<li id="sh_'.$statusid.'"><a href="javascript:void(0)" id="shareBtn'.$statusid.'" onclick="sharePost(\''.$statusid.'\',\''.$author.'\',\''.$data.'\',\''.$postdate.'\',\'sh_'.$statusid.'\',\''.$postpic.'\',\'\')">Just Share</a></li></ul></li>';
			
		    $statuslist .= '<div id="status_'.$statusid.'" class="box box-widget" style="border-top: 0px solid;"><div class="box-header with-border"><span class="box-title pull-right" style="margin: auto auto auto 5px;"><a onclick="CloseViewPost()" href="javascript:void(0)" class="btn btn-primary" style="padding: 5px;"style="padding: 5px;"><i class="fa fa-times"></i></a></span>';
		    $statuslist .= '<div class="user-block">'.$image.'<span class="username"><a class="hand" onclick="uid(\''.$author.'\')">'.$ftnm.' '.$ltnm.'</a></span><span class="description"><time>'.$postdate.'</time></span></div></div>';
		    $statuslist .= '<div class="box-body"><p '.$datafont.'>'.$data.'</p><div class="any" data-grid="images">'.$posted_image.'</div><ul class="list-inline"> <li class="border-right"><span id="lk2_'.$statusid.'">'.$like_button.'</span>';
		    $statuslist .= ''.$share.'';
		    $statuslist .= '<li class="pull-right"><a class="hand link-black text-sm" href="javascript:void(0)" onclick="OpenViewPost(\''.$account_name.'\',\''.$statusid.'\',\''.$account_name.'\',\'post_'.$statusid.'\');"><i class="fa fa-comments-o margin-r-5"></i> Comments ( <span id="rp2_'.$statusid.'">'.$replynumrows.'</span> )</a></li>';
		    $statuslist .= '<li class="pull-right border-right"><span href="" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i><span id="lknum2_'.$statusid.'">'.$likenumrows.'</span></span></ul></div>';		    
			$statuslist .= '<div id="statusreply2_'.$statusid.'">'.$status_replies.'</div>';		    
						
			$replyform .= '<div class="box-footer no-padding">'.$reply_image.'<div class="img-push">';
			$replyform .= '<form role="form" class="form-horizontal" onSubmit="return false;"><div class="form-group margin-bottom-none">';
			$replyform .= '<div class="col-xs-9" style="padding-right: 0px;"><input id="replytext2_'.$statusid.'" onkeyup="statusMax(this,250)" type="text" class="form-control input-sm" placeholder="Reply to this post"></div>';
			$replyform .= '<div class="col-xs-3" style="padding-left: 3px;padding-right: 0px;width:auto;">';
			$replyform .= '<button type="submit" style="padding-top: 4px;padding-bottom: 4px;font-size:12px;" id="replyBtn2_'.$statusid.'" onclick="replyToStatus('.$statusid.',\''.$u.'\',\'replytext2_'.$statusid.'\',this)" class="btn btn-link btn-flat">';
			$replyform .= 'Reply</button></div></div></form></div></div></div>';
			
				
		
		}else if($type == 'x'){
			$sql = "SELECT avatar FROM _useroptions WHERE username='$account_name'";
			$avatar_query = mysqli_query($db_connection, $sql);
				while ($row = mysqli_fetch_array($avatar_query, MYSQLI_ASSOC)) {$pic = $row["avatar"];}
			$image1 = '<img class="img-circle" src="_USER/'.$account_name.'/'.$pic.'" alt="'.$account_name.'">';
				if($pic == NULL){$image1 = '<img class="img-circle" src="_ast/_img/avatardefault.png">';}
			
			$sql = "SELECT avatar FROM _useroptions WHERE username='$author'";
			$ava_query = mysqli_query($db_connection, $sql);
				while ($row = mysqli_fetch_array($ava_query, MYSQLI_ASSOC)) {$picture = $row["avatar"];}
			$sql = "SELECT avatar FROM _useroptions WHERE username='$log_username'";
			$_query = mysqli_query($db_connection, $sql);
				while ($row = mysqli_fetch_array($_query, MYSQLI_ASSOC)) {$log_picture = $row["avatar"];}
			$image = '<img class="img-circle" src="_USER/'.$author.'/'.$picture.'" alt="'.$author.'">';
				if($picture == NULL){$image = '<img class="img-circle" src="_ast/_img/avatardefault.png">';}
			$reply_image = '<img class="img-circle img-sm" src="_USER/'.$log_username.'/'.$log_picture.'" alt="'.$author.'">';
				if($log_picture == NULL){$reply_image = '<img class="img-circle img-sm" src="_ast/_img/avatardefault.png">';}

			$isLiked = false;
			if($user_ok == true){
				$like_check = "SELECT id FROM storylikes WHERE storyid='$statusid' AND username='$log_username'";
				if(mysqli_num_rows(mysqli_query($db_connection, $like_check)) > 0){$isLiked = true;}
				$story_likes = mysqli_query($db_connection, "SELECT * FROM storylikes WHERE storyid ='$statusid'");
				$likenumrows = mysqli_num_rows($story_likes);
			}
			if($user_ok == true && $isLiked == false){
				$like_button = '<a class="link-black text-sm hand" id="likeBtn'.$statusid.'" onclick="likeToggle(\'like\',\''.$author.'\',\''.$statusid.'\',\'likeBtn_'.$statusid.'\')"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>';
			} else if($user_ok == true && $isLiked == true){
				$like_button = '<a class="link-black text-sm hand like" id="likeBtn'.$statusid.'" onclick="likeToggle(\'unlike\',\''.$author.'\',\''.$statusid.'\',\'likeBtn_'.$statusid.'\')"><i class="fa fa-thumbs-up margin-r-5"></i></a>';
			}
			$sql = "SELECT firstname, lastname FROM _users WHERE username='$account_name'";
			$nm_query = mysqli_query($db_connection, $sql);
			while ($row = mysqli_fetch_array($nm_query, MYSQLI_ASSOC)) {
				$ftnam = $row["firstname"];
				$ltnam = $row["lastname"];
			}
			$sql = "SELECT firstname, lastname FROM _users WHERE username='$author'";
			$ath_query = mysqli_query($db_connection, $sql);
			while ($row = mysqli_fetch_array($ath_query, MYSQLI_ASSOC)) {
				$ftnm = $row["firstname"];
				$ltnm = $row["lastname"];
			}
			$imgsql = "SELECT image FROM story WHERE author='$author'";
			$img_query = mysqli_query($db_connection, $imgsql);
			while ($row3 = mysqli_fetch_array($img_query, MYSQLI_ASSOC)) {
				$sharepic = $row3["image"];
			}
			$date = "Post not available";
			$msql = "SELECT * FROM story WHERE id='$statusosid' AND type='a'";
			$ids_query = mysqli_query($db_connection, $msql);
			while ($row = mysqli_fetch_array($ids_query, MYSQLI_ASSOC)) {
				$osid = $row["id"];
				$dsql = mysqli_query($db_connection, "SELECT postdate FROM story WHERE id='$osid'");
				$dt_query = mysqli_num_rows($dsql);
				if($dt_query > 0){
					$dateR = strftime("%b %d, %Y at %I:%M %p", strtotime($row["postdate"]) + 60 * 60 * 7);
					$date = '<time>'.$dateR.'</time>';
				}else if($dt_query < 1){
					$date = "Post not available";
				}
			}
			$status_replies = "";
			$query_replies = mysqli_query($db_connection, "SELECT * FROM story WHERE osid='$statusid' AND type='b' ORDER BY postdate DESC");
			$replynumrows = mysqli_num_rows($query_replies);
			if($replynumrows > 0){
				while ($row2 = mysqli_fetch_array($query_replies, MYSQLI_ASSOC)) {
					$statusreplyid = $row2["id"];
					$replyauthor = $row2["author"];
					$replydata = $row2["data"];
					$replydata = nl2br($replydata);
					$replydata = str_replace("&amp;","&",$replydata);
					$replydata = stripslashes($replydata);
					$replypostdate = strftime("%b %d at %I:%M %p", strtotime($row2["postdate"]) + 60 * 60 * 7);
					$replyDeleteButton = '';
					if($replyauthor == $log_username){
						$replyDeleteButton = '<span id="srdb_'.$statusid.'"><a class="hand" onclick="return false;" onmousedown="deleteReply(\''.$statusreplyid.'\',\'reply_'.$statusreplyid.'\',\'reply2_'.$statusreplyid.'\');" title="DELETE THIS COMMENT"><span class="fa fa-trash cg close margin-10"></span></a></span>';
					}
					$sql = "SELECT avatar FROM _useroptions WHERE username='$replyauthor'";
					$ava_query = mysqli_query($db_connection, $sql);
					while ($row = mysqli_fetch_array($ava_query, MYSQLI_ASSOC)) {$picture2 = $row["avatar"];}
					$image3 = '<img class="img-circle img-sm" src="_USER/'.$replyauthor.'/'.$picture2.'" alt="'.$replyauthor.'">';
					if($picture2 == NULL){$image3 = '<img class="img-circle img-sm" src="_ast/_img/avatardefault.png">';}
					$sql = "SELECT firstname, lastname FROM _users WHERE username='$replyauthor'";
					$r_query = mysqli_query($db_connection, $sql);
					while ($row = mysqli_fetch_array($r_query, MYSQLI_ASSOC)) {
						$ftname = $row["firstname"];
						$ltname = $row["lastname"];
					}
					$status_replies .= '<div id="reply2_'.$statusreplyid.'" class="box-footer box-comments"><div class="box-comment">'.$image3.'<div class="comment-text">';
					$status_replies .= '<span class="username"><a class="hand" onclick="uid(\''.$replyauthor.'\')">'.$ftname.' '.$ltname.'</a><span class="text-muted pull-right"><time>'.$replypostdate.'</time></span></span>';
					$status_replies .= ''.$replydata.''.$replyDeleteButton.'</div></div></div>';
				}
			}
			$posted_image = '<img class="img-responsive" src="_USER/'.$author.'/'.$sharepic.'" style="color: #bfbfbf;" alt="Image not available">';
			if($sharepic == NULL){
				$posted_image = '';
			}
			$statuslist .= '<div id="status_'.$statusid.'" class="box box-widget" style="border-top: 0px solid;"><div class="box-header with-border">';	
			$statuslist .= '<span class="box-title pull-right" style="margin: auto auto auto 5px;"><a onclick="CloseViewPost()" href="javascript:void(0)" class="btn btn-primary" style="padding: 5px;"><i class="fa fa-times"></i></a></span>';	
			$statuslist .= '<div class="user-block">'.$image1.'<span class="username"><a class="hand" onclick="uid(\''.$account_name.'\')">'.$ftnam.' '.$ltnam.'';	
			$statuslist .= '</a> &nbsp;shared <a class="hand" onclick="uid(\''.$author.'\')">'.$ftnm.' '.$ltnm.'\'s</a> post</span><span class="description"><time>'.$postdate.'</time></span></div></div>';	
			
			$statuslist .= '<div class="box-body"><p>'.$datacaption.'</p><div class="box-header with-border" style="margin-left:30px;"><div class="user-block">'.$image.'';
		    $statuslist .= '<span class="username"><a class="hand" onclick="uid(\''.$author.'\')">'.$ftnm.' '.$ltnm.'</a></span><span class="description">'.$date.'</span></div></div>';
		    $statuslist .= '<div class="box-body" style="margin-left:30px;"><p '.$datafont.'>'.$data.'</p><div class="any" data-grid="images">'.$posted_image.'</div></div><ul class="list-inline"> <li class="border-right"><span id="lk2_'.$statusid.'">'.$like_button.'</span>';
		    $statuslist .= '<li class="pull-right"><a class="hand link-black text-sm" href = "javascript:void(0)" onclick="OpenViewPost(\''.$account_name.'\',\''.$statusid.'\',\''.$account_name.'\',\'post_'.$statusid.'\');"><i class="fa fa-comments-o margin-r-5"></i> Comments ( <span id="rp2_'.$statusid.'">'.$replynumrows.'</span> )</a></li>';
		    $statuslist .= '<li class="pull-right border-right"><span href="" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i><span id="lknum2_'.$statusid.'">'.$likenumrows.'</span></span></ul></div>';		    
			$statuslist .= '<div id="statusreply2_'.$statusid.'">'.$status_replies.'</div>';		    
						
			$replyform .= '<div class="box-footer no-padding">'.$reply_image.'<div class="img-push">';
			$replyform .= '<form role="form" class="form-horizontal" onSubmit="return false;"><div class="form-group margin-bottom-none">';
			$replyform .= '<div class="col-xs-9" style="padding-right: 0px;"><input id="replytext2_'.$statusid.'" onkeyup="statusMax(this,250)" type="text" class="form-control input-sm" placeholder="Reply to this post"></div>';
			$replyform .= '<div class="col-xs-3" style="padding-left: 3px;padding-right: 0px;width:auto;">';
			$replyform .= '<button type="submit" style="padding-top: 4px;padding-bottom: 4px;font-size:12px;" id="replyBtn_'.$statusid.'" onclick="replyToStatus('.$statusid.',\''.$u.'\',\'replytext2_'.$statusid.'\',this)" class="btn btn-link btn-flat">';
			$replyform .= 'Reply</button></div></div></form></div></div></div>';
			
		}else if($type == 'p'){
			$sql = "SELECT avatar FROM _useroptions WHERE username='$author'";
			$ava_query = mysqli_query($db_connection, $sql);
			while ($row = mysqli_fetch_array($ava_query, MYSQLI_ASSOC)) {$picture = $row["avatar"];}
			$sql = "SELECT avatar FROM _useroptions WHERE username='$log_username'";
			$_query = mysqli_query($db_connection, $sql);
			while ($row = mysqli_fetch_array($_query, MYSQLI_ASSOC)) {$log_picture = $row["avatar"];}
			$image = '<img class="img-circle" src="_USER/'.$author.'/'.$picture.'" alt="'.$author.'">';
			if($picture == NULL){$image = '<img class="img-circle" src="_ast/_img/avatardefault.png">';}
			$reply_image = '<img class="img-circle img-sm" src="_USER/'.$log_username.'/'.$log_picture.'" alt="'.$author.'">';
			if($log_picture == NULL){$reply_image = '<img class="img-circle img-sm" src="_ast/_img/avatardefault.png">';}

			$isLiked = false;
			if($user_ok == true){
				$like_check = "SELECT id FROM storylikes WHERE storyid='$statusid' AND username='$log_username'";
				if(mysqli_num_rows(mysqli_query($db_connection, $like_check)) > 0){$isLiked = true;}
				$story_likes = mysqli_query($db_connection, "SELECT * FROM storylikes WHERE storyid ='$statusid'");
				$likenumrows = mysqli_num_rows($story_likes);
			}
			if($user_ok == true && $isLiked == false){
				$like_button = '<a class="link-black text-sm hand" id="likeBtn'.$statusid.'" onclick="likeToggle(\'like\',\''.$author.'\',\''.$statusid.'\',\'likeBtn_'.$statusid.'\')"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>';
			} else if($user_ok == true && $isLiked == true){
				$like_button = '<a class="link-black text-sm hand like" id="likeBtn'.$statusid.'" onclick="likeToggle(\'unlike\',\''.$author.'\',\''.$statusid.'\',\'likeBtn_'.$statusid.'\')"><i class="fa fa-thumbs-up margin-r-5"></i></a>';
			}
			$sql = "SELECT firstname, lastname FROM _users WHERE username='$author'";
			$nm_query = mysqli_query($db_connection, $sql);
			while ($row = mysqli_fetch_array($nm_query, MYSQLI_ASSOC)) {
				$ftnm = $row["firstname"];
				$ltnm = $row["lastname"];
			}
			$status_replies = "";
			$query_replies = mysqli_query($db_connection, "SELECT * FROM story WHERE osid='$statusid' AND type='b' ORDER BY postdate DESC");
			$replynumrows = mysqli_num_rows($query_replies);
			if($replynumrows > 0){
				while ($row2 = mysqli_fetch_array($query_replies, MYSQLI_ASSOC)) {
					$statusreplyid = $row2["id"];
					$replyauthor = $row2["author"];
					$replydata = $row2["data"];
					$replydata = nl2br($replydata);
					$replydata = str_replace("&amp;","&",$replydata);
					$replydata = stripslashes($replydata);
					$replypostdate = strftime("%b %d at %I:%M %p", strtotime($row2["postdate"]) + 60 * 60 * 7);
					$replyDeleteButton = '';
					if($replyauthor == $log_username){
						$replyDeleteButton = '<span id="srdb_'.$statusid.'"><a class="hand" onclick="return false;" onmousedown="deleteReply(\''.$statusreplyid.'\',\'reply_'.$statusreplyid.'\',\'reply2_'.$statusreplyid.'\');" title="DELETE THIS COMMENT"><span class="fa fa-trash cg close margin-10"></span></a></span>';
					}
					$sql = "SELECT avatar FROM _useroptions WHERE username='$replyauthor'";
					$ava_query = mysqli_query($db_connection, $sql);
					while ($row = mysqli_fetch_array($ava_query, MYSQLI_ASSOC)) {$picture2 = $row["avatar"];}
					$image3 = '<img class="img-circle img-sm" src="_USER/'.$replyauthor.'/'.$picture2.'" alt="'.$replyauthor.'">';
					if($picture2 == NULL){$image3 = '<img class="img-circle img-sm" src="_ast/_img/avatardefault.png">';}
					$sql = "SELECT firstname, lastname FROM _users WHERE username='$replyauthor'";
					$r_query = mysqli_query($db_connection, $sql);
					while ($row = mysqli_fetch_array($r_query, MYSQLI_ASSOC)) {
						$ftname = $row["firstname"];
						$ltname = $row["lastname"];
					}
					$status_replies .= '<div id="reply2_'.$statusreplyid.'" class="box-footer box-comments"><div class="box-comment">'.$image3.'<div class="comment-text">';
					$status_replies .= '<span class="username"><a class="hand" onclick="uid(\''.$replyauthor.'\')">'.$ftname.' '.$ltname.'</a><span class="text-muted pull-right"><time>'.$replypostdate.'</time></span></span>';
					$status_replies .= ''.$replydata.''.$replyDeleteButton.'</div></div></div>';
				}
			}
			$posted_image = '<img class="img-responsive" src="_USER/'.$author.'/'.$postpic.'" alt="'.$author.'">';
			if($postpic == NULL){
				$posted_image = '<div class="preloader pl-size-xs"><div class="spinner-layer pl-red"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
			}
		    $statuslist .= '<div id="status_'.$statusid.'" class="box box-widget" style="border-top: 0px solid;"><div class="box-header with-border"><span class="box-title pull-right" style="margin: auto auto auto 5px;"><a onclick="CloseViewPost()" href="javascript:void(0)" class="btn btn-primary" style="padding: 5px;"><i class="fa fa-times"></i></a></span>';
		    $statuslist .= '<div class="user-block">'.$image.'<span class="username"><a class="hand" onclick="uid(\''.$author.'\')">'.$ftnm.' '.$ltnm.'';
			$statuslist .= '</a>  &nbsp;added this picture to <a class="hand" onclick="photos(\''.$author.'\')"><b>'.$account_name.' gallery</b></a></span><span class="description"><time>'.$postdate.'</time></span></div></div>';			
			$statuslist .= '<div class="box-body"><p '.$datafont.'>'.$data.'</p><div class="any" data-grid="images">'.$posted_image.'</div><ul class="list-inline"> <li class="border-right"><span id="lk2_'.$statusid.'">'.$like_button.'</span>';
		    $statuslist .= '<li class="pull-right"><a class="hand link-black text-sm" href = "javascript:void(0)" onclick="OpenViewPost(\''.$account_name.'\',\''.$statusid.'\',\''.$account_name.'\',\'post_'.$statusid.'\');"><i class="fa fa-comments-o margin-r-5"></i> Comments ( <span id="rp2_'.$statusid.'">'.$replynumrows.'</span> )</a></li>';
		    $statuslist .= '<li class="pull-right border-right"><span href="" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i><span id="lknum2_'.$statusid.'">'.$likenumrows.'</span></span></ul></div>';		    
		    $statuslist .= '<div id="statusreply2_'.$statusid.'">'.$status_replies.'</div>';		    
						
			$replyform .= '<div class="box-footer no-padding">'.$reply_image.'<div class="img-push">';
			$replyform .= '<form role="form" class="form-horizontal" onSubmit="return false;"><div class="form-group margin-bottom-none">';
			$replyform .= '<div class="col-xs-9" style="padding-right: 0px;"><input id="replytext2_'.$statusid.'" onkeyup="statusMax(this,250)" type="text" class="form-control input-sm" placeholder="Reply to this post"></div>';
			$replyform .= '<div class="col-xs-3" style="padding-left: 3px;padding-right: 0px;width:auto;">';
			$replyform .= '<button type="submit" style="padding-top: 4px;padding-bottom: 4px;font-size:12px;" id="replyBtn_'.$statusid.'" onclick="replyToStatus('.$statusid.',\''.$log_username.'\',\'replytext2_'.$statusid.'\',this)" class="btn btn-link btn-flat">';
			$replyform .= 'Reply</button></div></div></form></div></div></div>';
		}
	}	
}
$poststring .= "$statuslist|$replyform|||";
$poststring = trim($poststring, "|||");		
echo $poststring;
?>