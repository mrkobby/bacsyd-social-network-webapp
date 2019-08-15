<?php
$isFriend = false;
$ownerBlockViewer = false;
$viewerBlockOwner = false;
if($account_name != $log_username && $user_ok == true){
	$friend_check = "SELECT id FROM friends WHERE user1='$log_username' AND user2='$account_name' AND accepted='1' OR user1='$account_name' AND user2='$log_username' AND accepted='1'";
	if(mysqli_num_rows(mysqli_query($db_connection, $friend_check)) > 0){
        $isFriend = true;
    }
	$block_check1 = "SELECT id FROM blockedusers WHERE blocker='$account_name' AND blockee='$log_username'";
	if(mysqli_num_rows(mysqli_query($db_connection, $block_check1)) > 0){
        $ownerBlockViewer = true;
    }
	$block_check2 = "SELECT id FROM blockedusers WHERE blocker='$log_username' AND blockee='$account_name'";
	if(mysqli_num_rows(mysqli_query($db_connection, $block_check2)) > 0){
        $viewerBlockOwner = true;
    }
}
?><?php	
$statuslist = "";
$share = "";
$avatar = "";
$datafont = "";
$sql = "SELECT * FROM story WHERE account_name='$account_name' AND type='a' OR account_name='$account_name' AND type='c' OR account_name='$account_name' AND type='x' OR author='$account_name' AND type='p' ORDER BY postdate DESC LIMIT 50";
$query = mysqli_query($db_connection, $sql);
$statusnumrows = mysqli_num_rows($query);
while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$statusid = $row["id"];
	$statusosid = $row["osid"];
	$account_name = $row["account_name"];
	$author = $row["author"];
	$postdate = strftime("%b %d, %Y at %I:%M %p", strtotime($row["postdate"]) + 60 * 60 * 7);
	$data = $row['data'];
	$data = html_entity_decode($data);
	$data_passed = mysqli_real_escape_string($db_connection, $data);
	$datacaption = $row['datacaption'];
	$postpic = $row['image'];
	$statusDeleteButton = '';
	$statusDeleteButton2 = '';
	if($account_name == $log_username){
		$statusDeleteButton = '<span id="sdb_'.$statusid.'"><a class="hand" onclick="return false;" onmousedown="deleteStatus(\''.$statusid.'\',\'status_'.$statusid.'\');" title="DELETE ENTIRE STORY"><span class="fa fa-trash cg close margin-10"></span></a></span>';
	}
	if($author == $log_username){
		$statusDeleteButton2 = '<span id="sdb_'.$statusid.'"><a class="hand" onclick="return false;" onmousedown="deleteStatus(\''.$statusid.'\',\'status_'.$statusid.'\');" title="DELETE ENTIRE STORY"><span class="fa fa-trash cg close margin-10"></span></a></span>';
	}
	if((strlen($data)) < 19){
		$datafont = 'style="font-size:25px"';
	}else if((strlen($data)) < 51){
		$datafont = 'style="font-size:20px"';
	}else if((strlen($data)) < 100){
		$datafont = 'style="font-size:16px"';
	}else{
		$datafont = 'style="font-size:14px"';
	}
	$mysql = "SELECT type FROM story WHERE id='$statusid'";
	$_query = mysqli_query($db_connection, $mysql);
	while ($row = mysqli_fetch_array($_query, MYSQLI_ASSOC)) {
		$type = $row["type"];
		
		if($type == 'a'  || $type == 'c'){
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
			$query_replies = mysqli_query($db_connection, "SELECT * FROM story WHERE osid='$statusid' AND type='b'");
			$replynumrows = mysqli_num_rows($query_replies);
			if($replynumrows > 0){
				$rpysql = "SELECT * FROM story WHERE osid='$statusid' AND type='b' ORDER BY postdate DESC LIMIT 2";
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
					if($replyauthor == $log_username){
						$replyDeleteButton = '<span id="srdb_'.$statusid.'"><a class="hand" onclick="return false;" onmousedown="deleteReply(\''.$statusreplyid.'\',\'reply_'.$statusreplyid.'\');" title="DELETE THIS COMMENT"><span class="fa fa-trash cg close margin-10"></span></a></span>';
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
					$status_replies .= '<div id="reply_'.$statusreplyid.'" class="box-footer box-comments"><div class="box-comment">'.$image3.'<div class="comment-text">';
					$status_replies .= '<span class="username"><a class="hand" onclick="uid(\''.$replyauthor.'\')">'.$ftname.' '.$ltname.'</a><span class="text-muted pull-right"><time>'.$replypostdate.'</time></span></span>';
					$status_replies .= ''.$replydata.''.$replyDeleteButton.'</div></div></div>';
				}
			}
			$posted_image = '<img class="img-responsive" data-action="zoom" src="_USER/'.$author.'/'.$postpic.'" alt="'.$author.'">';
			if($postpic == NULL){
				$posted_image = '';
			}

		    $statuslist .= '<div id="status_'.$statusid.'" class="box box-widget"><div class="box-header with-border"><div class="user-block">'.$statusDeleteButton.''.$image.'';
		    $statuslist .= '<span class="username"><a class="hand" onclick="uid(\''.$author.'\')">'.$ftnm.' '.$ltnm.'</a></span><span class="description"><time>'.$postdate.'</time></span></div></div>';
		    $statuslist .= '<div class="box-body"><p '.$datafont.'>'.$data.'</p><div class="any" data-grid="images">'.$posted_image.'</div><ul class="list-inline"> <li class="border-right"><span id="lk_'.$statusid.'">'.$like_button.'</span>';
		    		
			$statuslist .= ' <li id="share_'.$statusid.'" class="input-group-btn"><a id="shr_'.$statusid.'" href="javascript:void(0)" type="button" class="link-black text-sm dropdown-toggle" data-toggle="dropdown">';
            $statuslist .= 'Share <span class="fa fa-caret-down"></span></a>';
            $statuslist .= '<ul class="dropdown-menu" id="sharedrop_'.$statusid.'">';
            $statuslist .= '<li><a href="javascript:void(0)">Copy link</a></li>';
            $statuslist .= '<li class="divider"></li>';
            $statuslist .= '<li id="sh_'.$statusid.'"><a href="javascript:void(0)" id="shareBtn'.$statusid.'" onclick="sharePost(\''.$statusid.'\',\''.$author.'\',\''.$data.'\',\''.$postdate.'\',\'sh_'.$statusid.'\',\''.$postpic.'\',\'\')">Just Share</a></li></ul></li>';

			$statuslist .= '<li class="pull-right"><a class="hand link-black text-sm" href="javascript:void(0)" onclick="OpenViewPost(\''.$account_name.'\',\''.$statusid.'\',\''.$account_name.'\',\'post_'.$statusid.'\');"><i class="fa fa-comments-o margin-r-5"></i> Comments ( <span id="rp_'.$statusid.'">'.$replynumrows.'</span> )</a></li>';
		    $statuslist .= '<li class="pull-right border-right"><span href="" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i><span id="lknum_'.$statusid.'"> '.$likenumrows.'</span></span></ul></div>';		    
			$statuslist .= '<div id="statusreply_'.$statusid.'">'.$status_replies.'</div><div class="box-footer">'.$reply_image.'<div class="img-push">';
			$statuslist .= '<form role="form" class="form-horizontal" onSubmit="return false;"><div class="form-group margin-bottom-none">';
			$statuslist .= '<div class="col-xs-9" style="padding-right: 0px;"><input id="replytext_'.$statusid.'" onkeyup="statusMax(this,250)" type="text" class="form-control input-sm" placeholder="Reply to this post"></div>';
			$statuslist .= '<div class="col-xs-3" style="padding-left: 3px;padding-right: 0px;width:auto;">';
			$statuslist .= '<button type="submit" style="padding-top: 4px;padding-bottom: 4px;font-size:12px;" id="replyBtn_'.$statusid.'" onclick="replyToStatus('.$statusid.',\''.$log_username.'\',\'replytext_'.$statusid.'\',this)" class="btn btn-link btn-flat">';
			$statuslist .= 'Reply</button></div></div></form></div></div></div>';
			
				
		
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
			$imgsql = "SELECT image FROM story WHERE id='$statusid'";
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
			$query_replies = mysqli_query($db_connection, "SELECT * FROM story WHERE osid='$statusid' AND type='b'");
			$replynumrows = mysqli_num_rows($query_replies);
			if($replynumrows > 0){
				$rpysql = "SELECT * FROM story WHERE osid='$statusid' AND type='b' ORDER BY postdate DESC LIMIT 2";
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
					if($replyauthor == $log_username){
						$replyDeleteButton = '<span id="srdb_'.$statusid.'"><a class="hand" onclick="return false;" onmousedown="deleteReply(\''.$statusreplyid.'\',\'reply_'.$statusreplyid.'\');" title="DELETE THIS COMMENT"><span class="fa fa-trash cg close margin-10"></span></a></span>';
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
					$status_replies .= '<div id="reply_'.$statusreplyid.'" class="box-footer box-comments"><div class="box-comment">'.$image3.'<div class="comment-text">';
					$status_replies .= '<span class="username"><a class="hand" onclick="uid(\''.$replyauthor.'\')">'.$ftname.' '.$ltname.'</a><span class="text-muted pull-right"><time>'.$replypostdate.'</time></span></span>';
					$status_replies .= ''.$replydata.''.$replyDeleteButton.'</div></div></div>';
				}
			}
			$posted_image = '<img class="img-responsive" data-action="zoom" src="_USER/'.$author.'/'.$sharepic.'" style="color: #bfbfbf;" alt="Image not available">';
			if($sharepic == NULL){
				$posted_image = '';
			}
			$statuslist .= '<div id="status_'.$statusid.'" class="box box-widget"><div class="box-header with-border"><div class="user-block">'.$statusDeleteButton.''.$image1.'';	
			$statuslist .= '<span class="username"><a class="hand" onclick="uid(\''.$account_name.'\')">'.$ftnam.' '.$ltnam.'';	
			$statuslist .= '</a> &nbsp;shared <a class="hand" onclick="uid(\''.$author.'\')">'.$ftnm.' '.$ltnm.'\'s</a> post</span><span class="description"><time>'.$postdate.'</time></span></div></div>';	
			
			$statuslist .= '<div class="box-body"><p>'.$datacaption.'</p><div class="box-header with-border" style="margin-left:30px;"><div class="user-block">'.$image.'';
		    $statuslist .= '<span class="username"><a class="hand" onclick="uid(\''.$author.'\')">'.$ftnm.' '.$ltnm.'</a></span><span class="description">'.$date.'</span></div></div>';
		    $statuslist .= '<div class="box-body" style="margin-left:30px;"><p '.$datafont.'>'.$data.'</p><div class="any" data-grid="images">'.$posted_image.'</div></div><ul class="list-inline"> <li class="border-right"><span id="lk_'.$statusid.'">'.$like_button.'</span>';
		    $statuslist .= '<li class="pull-right"><a class="hand link-black text-sm" href="javascript:void(0)" onclick="OpenViewPost(\''.$account_name.'\',\''.$statusid.'\',\''.$account_name.'\',\'post_'.$statusid.'\');"><i class="fa fa-comments-o margin-r-5"></i> Comments ( <span id="rp_'.$statusid.'">'.$replynumrows.'</span> )</a></li>';
		    $statuslist .= '<li class="pull-right border-right"><span href="" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i><span id="lknum_'.$statusid.'"> '.$likenumrows.'</span></span></ul></div>';		    
			$statuslist .= '<div id="statusreply_'.$statusid.'">'.$status_replies.'</div><div class="box-footer">'.$reply_image.'<div class="img-push">';
			$statuslist .= '<form role="form" class="form-horizontal" onSubmit="return false;"><div class="form-group margin-bottom-none">';
			$statuslist .= '<div class="col-xs-9" style="padding-right: 0px;"><input id="replytext_'.$statusid.'" onkeyup="statusMax(this,250)" type="text" class="form-control input-sm" placeholder="Reply to this post"></div>';
			$statuslist .= '<div class="col-xs-3" style="padding-left: 3px;padding-right: 0px;width:auto;">';
			$statuslist .= '<button type="submit" style="padding-top: 4px;padding-bottom: 4px;font-size:12px;" id="replyBtn_'.$statusid.'" onclick="replyToStatus('.$statusid.',\''.$log_username.'\',\'replytext_'.$statusid.'\',this)" class="btn btn-link btn-flat">';
			$statuslist .= 'Reply</button></div></div></form></div></div></div>';
			
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
			$query_replies = mysqli_query($db_connection, "SELECT * FROM story WHERE osid='$statusid' AND type='b'");
			$replynumrows = mysqli_num_rows($query_replies);
			if($replynumrows > 0){
				$rpysql = "SELECT * FROM story WHERE osid='$statusid' AND type='b' ORDER BY postdate DESC LIMIT 2";
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
					if($replyauthor == $log_username){
						$replyDeleteButton = '<span id="srdb_'.$statusid.'"><a class="hand" onclick="return false;" onmousedown="deleteReply(\''.$statusreplyid.'\',\'reply_'.$statusreplyid.'\');" title="DELETE THIS COMMENT"><span class="fa fa-trash cg close margin-10"></span></a></span>';
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
					$status_replies .= '<div id="reply_'.$statusreplyid.'" class="box-footer box-comments"><div class="box-comment">'.$image3.'<div class="comment-text">';
					$status_replies .= '<span class="username"><a class="hand" onclick="uid(\''.$replyauthor.'\')">'.$ftname.' '.$ltname.'</a><span class="text-muted pull-right"><time>'.$replypostdate.'</time></span></span>';
					$status_replies .= ''.$replydata.''.$replyDeleteButton.'</div></div></div>';
				}
			}
			$posted_image = '<img class="img-responsive" data-action="zoom" src="_USER/'.$author.'/'.$postpic.'" alt="'.$author.'">';
			if($postpic == NULL){
				$posted_image = '<div class="preloader pl-size-xs"><div class="spinner-layer pl-red"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
			}
		    $statuslist .= '<div id="status_'.$statusid.'" class="box box-widget"><div class="box-header with-border"><div class="user-block">'.$statusDeleteButton2.''.$image.'';
		    $statuslist .= '<span class="username"><a class="hand" onclick="uid(\''.$author.'\')">'.$ftnm.' '.$ltnm.'';
		    $statuslist .= '</a>  &nbsp;added this picture to <a class="hand" onclick="photos(\''.$author.'\')"><b>'.$account_name.' gallery</b></a></span><span class="description"><time>'.$postdate.'</time></span></div></div>';	
		    $statuslist .= '<div class="box-body"><p '.$datafont.'>'.$data.'</p><div class="any" data-grid="images">'.$posted_image.'</div><ul class="list-inline"> <li class="border-right"><span id="lk_'.$statusid.'">'.$like_button.'</span>';
		    $statuslist .= '<li class="pull-right"><a class="hand link-black text-sm" href="javascript:void(0)" onclick="OpenViewPost(\''.$account_name.'\',\''.$statusid.'\',\''.$account_name.'\',\'post_'.$statusid.'\');"><i class="fa fa-comments-o margin-r-5"></i> Comments ( <span id="rp_'.$statusid.'">'.$replynumrows.'</span> )</a></li>';
		    $statuslist .= '<li class="pull-right border-right"><span href="" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i><span id="lknum_'.$statusid.'"> '.$likenumrows.'</span></span></ul></div>';		    
			$statuslist .= '<div id="statusreply_'.$statusid.'">'.$status_replies.'</div><div class="box-footer">'.$reply_image.'<div class="img-push">';
			$statuslist .= '<form role="form" class="form-horizontal" onSubmit="return false;"><div class="form-group margin-bottom-none">';
			$statuslist .= '<div class="col-xs-9" style="padding-right: 0px;"><input id="replytext_'.$statusid.'" onkeyup="statusMax(this,250)" type="text" class="form-control input-sm" placeholder="Reply to this post"></div>';
			$statuslist .= '<div class="col-xs-3" style="padding-left: 3px;padding-right: 0px;width:auto;">';
			$statuslist .= '<button type="submit" style="padding-top: 4px;padding-bottom: 4px;font-size:12px;" id="replyBtn_'.$statusid.'" onclick="replyToStatus('.$statusid.',\''.$log_username.'\',\'replytext_'.$statusid.'\',this)" class="btn btn-link btn-flat">';
			$statuslist .= 'Reply</button></div></div></form></div></div></div>';
		}
	}	
}
echo $statuslist;
?>