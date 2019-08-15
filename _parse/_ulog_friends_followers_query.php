<?php
$ulog_friendsList = '';
$ulog_total_friends = '';
$ulog_friends_num = '0';
$ulog_friends_num_only = '0';
$sql = "SELECT COUNT(id) FROM friends WHERE user1='$log_username' AND accepted='1' OR user2='$log_username' AND accepted='1'";
$query = mysqli_query($db_connection, $sql);
$query_count = mysqli_fetch_row($query);
$ulog_friend_count = $query_count[0];
if($ulog_friend_count < 1 && $u == $log_username){
	$ulog_friendsList = '';
} else if($u != $log_username && $ulog_friend_count < 1){
	$ulog_friendsList = '';
} else {
	$max = 1000;
	$ulog_all_friends = array();
	$sql = "SELECT user1 FROM friends WHERE user2='$log_username' AND accepted='1' ORDER BY RAND() LIMIT $max";
	$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		array_push($ulog_all_friends, $row["user1"]);
	}
	$sql = "SELECT user2 FROM friends WHERE user1='$log_username' AND accepted='1' ORDER BY RAND() LIMIT $max";
	$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		array_push($ulog_all_friends, $row["user2"]);
	}
	$friendArrayCount = count($ulog_all_friends);
	if($friendArrayCount > $max){
		array_splice($ulog_all_friends, $max);
	}
	$orLogic = '';
	foreach($ulog_all_friends as $key => $user){
			$orLogic .= "username='$user' OR ";
	}
	$orLogic = chop($orLogic, "OR ");
	$fn_sql = "SELECT username, avatar FROM _useroptions WHERE $orLogic";
	$fn_query = mysqli_query($db_connection, $fn_sql);
	while($row = mysqli_fetch_array($fn_query, MYSQLI_ASSOC)) {
		$friend_username = $row["username"];
		$friend_avatar = $row["avatar"];
		
		$sql = "SELECT firstname, lastname FROM _users WHERE username='$friend_username'";
		$query = mysqli_query($db_connection, $sql);
		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$fnme = $row["firstname"];
			$lnme = $row["lastname"];
			if($friend_avatar != ""){
				$friend_pic = '_USER/'.$friend_username.'/'.$friend_avatar.'';
			} else {
				$friend_pic = '_ast/_img/avatardefault.png';
			}
			$sql = "SELECT * FROM _useroptions WHERE username='$friend_username'";
			$useroptions_query = mysqli_query($db_connection, $sql);
			$numrows = mysqli_num_rows($useroptions_query);
			while ($row = mysqli_fetch_array($useroptions_query, MYSQLI_ASSOC)) {
				$friendstatus = $row["userstatus"];
			}		
			$ulog_friendsList .= '<a class="hand" onclick="uid(\''.$friend_username.'\')"><li class="item fa-1x"><div class="product-img cu" style="border:1px solid black;">';
			$ulog_friendsList .= '<a class="hand" onclick="uid(\''.$friend_username.'\')"><img class="img" src="'.$friend_pic.'" alt="'.$friend_username.'"></a></div>';
			$ulog_friendsList .= '<div class="product-info-name"><a class="hand" onclick="uid(\''.$friend_username.'\')" class="product-title">'.$fnme.' '.$lnme.' | @'.$friend_username.'</a><a class="hand" onclick="uid(\''.$friend_username.'\')">';
			$ulog_friendsList .= '<span class="product-description">'.$friendstatus.'</span></a></div></li></a>';
			
			$ulog_total_friends = '<b>You have a total of '.$ulog_friend_count.' friends.</b>';	
			}
		}
	}
$ulog_friends_num = ''.$ulog_friend_count.'';
$ulog_friends_num_only = $ulog_friend_count;

?><?php
$ulog_followersList = '';
$ulog_total_followers = '';
$ulog_followers_num = '0';
$ulog_followers_num_only = '0';
$sql = "SELECT COUNT(id) FROM followers WHERE user2='$log_username'";
$query = mysqli_query($db_connection, $sql);
$query_count = mysqli_fetch_row($query);
$ulog_follower_count = $query_count[0];
if($ulog_follower_count < 1 && $u == $log_username){
	$ulog_followersList = '';
} else if($u != $log_username && $ulog_follower_count < 1){
	$ulog_followersList = '';
	$hide_search = 'style="display:none;"';
} else {
	$max = 1000;
	$all_followers = array();
	$sql = "SELECT user1 FROM followers WHERE user2='$log_username' ORDER BY RAND() LIMIT $max";
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
	$fll_sql = "SELECT username, avatar FROM _useroptions WHERE $orLogic";
	$fll_query = mysqli_query($db_connection, $fll_sql);
	while($row = mysqli_fetch_array($fll_query, MYSQLI_ASSOC)) {
		$follower_username = $row["username"];
		$follower_avatar = $row["avatar"];
		
		$sql = "SELECT firstname, lastname FROM _users WHERE username='$follower_username'";
		$query = mysqli_query($db_connection, $sql);
		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
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
			$ulog_followersList .= '<a class="hand" onclick="uid(\''.$follower_username.'\')"><li class="item fa-1x"><div class="product-img cu" style="border:1px solid black;">';
			$ulog_followersList .= '<a class="hand" onclick="uid(\''.$follower_username.'\')"><img class="img" src="'.$follower_pic.'" alt="'.$follower_username.'"></a></div>';
			$ulog_followersList .= '<div class="product-info-name"><a class="hand" onclick="uid(\''.$follower_username.'\')" class="product-title">'.$fnme.' '.$lnme.' | @'.$follower_username.'</a><a class="hand" onclick="uid(\''.$follower_username.'\')">';
			$ulog_followersList .= '<span class="product-description">'.$followerstatus.'</span></a></div></li></a>';
		
			$ulog_total_followers = '<b>You have a total of '.$ulog_follower_count.' followers.</b>';	
		}
	}
}
$ulog_followers_num = ''.$ulog_follower_count.'';
$ulog_followers_num_only = $ulog_follower_count;

?>
<div class="modal fade" id="ulogflwModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
				<button type="button" onClick="log__cps()" class="pull-right close fa-1x" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h6 class="modal-title" id="defaultModalLabel">Your followers</h6>
            </div>
			<span id="followers">
				<div class="modal-body" style="padding:0px;">
					<div>
						<form method="get">
							<div class="input-group">
								<input type="text" onKeyUp="log_yy(this.value)" autocomplete="off" name="log_ww" id="log_ww" class="form-control" placeholder="Search">
								<div class="input-group-btn">
									<button type="button" onClick="log__cps()" class="btn btn-flat btn-primary"><i class="fa fa-times"></i></button>
								</div>
							</div>
						</form>
					</div>
					<div class="uq">
						<ul id="log_content" class="products-list product-list-in-box">
							<?php echo $ulog_followersList; ?>	
						</ul>
						<ul id="log_find" style="display:none;" class="products-list product-list-in-box"></ul>
					</div>
				</div>
				<div class="text-center" style="padding: 5px;">
					<span class="text-center">
						<h6><?php echo $ulog_total_followers;?></h6>
					</span>
				</div>
			</span>   
        </div>
    </div>
</div>
<div class="modal fade" id="ulogfrndModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
				<button type="button" onClick="log__cls()" class="pull-right close fa-1x" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h6 class="modal-title" id="defaultModalLabel">Your friends</h6>
            </div>
			<span id="friends">
				<div class="modal-body" style="padding:0px;">
					<div>
						<form method="get">
							<div class="input-group">
								<span class="input-group-addon">@</span>
								<input type="text" onKeyUp="log_fy(this.value)" autocomplete="off" name="log_qq" id="log_qq"  class="form-control" placeholder="Search">
								<div class="input-group-btn">
									<button type="button" onClick="log__cls()" class="btn btn-flat btn-primary"><i class="fa fa-times"></i></button>
								</div>
							</div>
						</form>
					</div>
					<div class="uq">
						<ul id="log_list" class="products-list product-list-in-box">
							<?php echo $ulog_friendsList; ?>	
						</ul>
						<ul id="log_search" style="display:none;" class="products-list product-list-in-box"></ul>
					</div>
				</div>
				<div class="text-center" style="padding: 5px;">
					<span class="text-center">
						<h6><?php echo $ulog_total_friends; ?></h6>
					</span>
				</div>
			</span>
        </div>
    </div>
</div>
<script>
$(function(){
  $('#log_qq').keypress(function(e){
    if(e.which == 35){
		return false;
    } else {
      return true;
    }
  });
});
function log__cls() {
	$('#log_qq').val("");
	document.getElementById("log_search").style.display="none";
	document.getElementById("log_list").style.display="block";
 };
function log_fy(str){
var f = document.getElementById("log_qq").value;
var u = "<?php echo $log_username;?>";
var xmlhttp1;
if (str.length==0) {
    document.getElementById("log_search").innerHTML="";
    document.getElementById("log_search").style.border="0px";
	document.getElementById("log_search").style.display="block";
	document.getElementById("log_list").style.display="block";
    return;
  }
if (window.XMLHttpRequest){xmlhttp1=new XMLHttpRequest();
  }else{xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");}
xmlhttp1.onreadystatechange=function(){
  if (xmlhttp1.readyState==4 && xmlhttp1.status==200){
    document.getElementById("log_search").innerHTML=xmlhttp1.responseText;
	document.getElementById("log_search").style.display="block";
	document.getElementById("log_list").style.display="none";
    }
  }
xmlhttp1.open("GET","_ext/_search/call_friend_search_ajax.php?f="+encodeURIComponent(f)+'&u='+u,true);
xmlhttp1.send();	
}
</script>
<script>
$(function(){
  $('#log_ww').keypress(function(e){
    if(e.which == 35){
		return false;
    } else {
      return true;
    }
  });
});
function log__cps() {
	$('#log_ww').val("");
	document.getElementById("log_find").style.display="none";
	document.getElementById("log_content").style.display="block";
 };
function log_yy(str){
var f = document.getElementById("log_ww").value;
var u = "<?php echo $log_username;?>";
var xmlhttp1;
if (str.length==0) {
    document.getElementById("log_find").innerHTML="";
    document.getElementById("log_find").style.border="0px";
	document.getElementById("log_find").style.display="block";
	document.getElementById("log_content").style.display="block";
    return;
  }
if (window.XMLHttpRequest){xmlhttp1=new XMLHttpRequest();
  }else{xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");}
xmlhttp1.onreadystatechange=function(){
  if (xmlhttp1.readyState==4 && xmlhttp1.status==200){
    document.getElementById("log_find").innerHTML=xmlhttp1.responseText;
	document.getElementById("log_find").style.display="block";
	document.getElementById("log_content").style.display="none";
    }
  }
xmlhttp1.open("GET","_ext/_search/call_follower_search_ajax.php?f="+encodeURIComponent(f)+'&u='+u,true);
xmlhttp1.send();	
}
</script>