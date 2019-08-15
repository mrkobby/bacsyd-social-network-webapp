<?php
$friendList = '';
$total_friends = '';
$friends_num = '0';
$friends_num_only = '0';
$hide_search = 'style="display:;"';
$person = ''.$fname.'\'s';
if($u === $log_username ){
	$person = 'Your';
}
$sql = "SELECT COUNT(id) FROM friends WHERE user1='$u' AND accepted='1' OR user2='$u' AND accepted='1'";
$query = mysqli_query($db_connection, $sql);
$query_ct = mysqli_fetch_row($query);
$friend_ct = $query_ct[0];
if($friend_ct < 1){
	$friendList = '';
	$hide_search = 'style="display:none;"';
} else {
	$max = 1000;
	$all_friends = array();
	$sql = "SELECT user1 FROM friends WHERE user2='$u' AND accepted='1' ORDER BY RAND() LIMIT $max";
	$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		array_push($all_friends, $row["user1"]);
	}
	$sql = "SELECT user2 FROM friends WHERE user1='$u' AND accepted='1' ORDER BY RAND() LIMIT $max";
	$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		array_push($all_friends, $row["user2"]);
	}
	$friendArrayCount = count($all_friends);
	if($friendArrayCount > $max){
		array_splice($all_friends, $max);
	}
	$orLogic = '';
	foreach($all_friends as $key => $user){
			$orLogic .= "username='$user' OR ";
	}
	$orLogic = chop($orLogic, "OR ");
	$frnd_sql = "SELECT username, avatar FROM _useroptions WHERE $orLogic";
	$frnd_query = mysqli_query($db_connection, $frnd_sql);
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
			$friendList .= '<a class="hand" onclick="uid(\''.$friend_uname.'\')"><li class="item fa-1x"><div class="product-img cu" style="border:1px solid #000;">';
			$friendList .= '<a class="hand" onclick="uid(\''.$friend_uname.'\')"><img class="img" src="'.$friend_pic.'" alt="'.$friend_uname.'"></a></div>';
			$friendList .= '<div class="product-info-name"><a class="hand" onclick="uid(\''.$friend_uname.'\')" class="product-title">'.$fn.' '.$ln.' | @'.$friend_uname.'</a><a class="hand" onclick="uid(\''.$friend_uname.'\')">';
			$friendList .= '<span class="product-description">'.$friendstatus.'</span></a></div></li></a>';
			
			$total_friends = '<b>You have a total of '.$friend_ct.' friends.</b>';	
			if($u != $log_username){
			$total_friends = '<b>'.$u.' has a total of '.$friend_ct.' friends.</b>';
			$hide_search = 'style="display:none;"';
			}
		}
	}
}
$friends_num = ''.$friend_ct.'';
$friends_num_only = $friend_ct;
?>
<div class="modal fade" id="frndModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
				<button type="button" onClick="_cls()" class="pull-right close fa-1x" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h6 class="modal-title" id="defaultModalLabel"><?php echo $person; ?> Friends</h6>
            </div>
			<span <?php echo $displayPrivacy; ?> id="friends">
				<div class="modal-body" style="padding:0px;">
					<div>
						<form method="get">
							<div class="input-group" <?php echo $hide_search; ?>>
								<span class="input-group-addon">@</span>
								<input type="text" onKeyUp="fy(this.value)" autocomplete="off" name="qq" id="qq"  class="form-control" placeholder="Search">
								<div class="input-group-btn">
									<button type="button" onClick="_cls()" class="btn btn-flat btn-primary"><i class="fa fa-times"></i></button>
								</div>
							</div>
						</form>
					</div>
					<div class="uq">
						<div>
							<ul id="list" class="products-list product-list-in-box">
								<?php echo $friendList; ?>
							</ul>
							<ul id="search" style="display:none;" class="products-list product-list-in-box"></ul>
						</div>
					</div>
				</div>
				<div class="text-center" style="padding: 5px;">
					<h6 class="text-center">
						<?php echo $total_friends; ?>
					</h6>
				</div>
			</span>
			<?php echo $privatecheck; ?>      
        </div>
    </div>
</div>
<script>
$(function(){
  $('#qq').keypress(function(e){
    if(e.which == 35){
		return false;
    } else {
      return true;
    }
  });
});
function _cls() {
	$('#qq').val("");
	document.getElementById("search").style.display="none";
	document.getElementById("list").style.display="block";
 };
function fy(str){
var f = document.getElementById("qq").value;
var u = "<?php echo $u ?>";
var xmlhttp1;
if (str.length==0) {
    document.getElementById("search").innerHTML="";
    document.getElementById("search").style.border="0px";
	document.getElementById("search").style.display="block";
	document.getElementById("list").style.display="block";
    return;
  }
if (window.XMLHttpRequest){xmlhttp1=new XMLHttpRequest();
  }else{xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");}
xmlhttp1.onreadystatechange=function(){
  if (xmlhttp1.readyState==4 && xmlhttp1.status==200){
    document.getElementById("search").innerHTML=xmlhttp1.responseText;
	document.getElementById("search").style.display="block";
	document.getElementById("list").style.display="none";
    }
  }
xmlhttp1.open("GET","_ext/_search/call_friend_search_ajax.php?f="+encodeURIComponent(f)+'&u='+u,true);
xmlhttp1.send();	
}
</script>