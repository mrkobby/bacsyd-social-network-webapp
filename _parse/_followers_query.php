<?php
$followersList = '';
$total_followers = '';
$followers_num = '0';
$followers_num_only = '0';
$hide_search = 'style="display:;"';
$follower = ''.$u.'\'s';
if($u === $log_username ){
	$follower = 'Your';
}
$sql = "SELECT COUNT(id) FROM followers WHERE user2='$u'";
$query = mysqli_query($db_connection, $sql);
$query_count = mysqli_fetch_row($query);
$follower_count = $query_count[0];
if($follower_count < 1 && $u == $log_username){
	$followersList = '';
} else if($u != $log_username && $follower_count < 1){
	$followersList = '';
	$hide_search = 'style="display:none;"';
} else {
	$max = 1000;
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
	$sql = "SELECT username, avatar FROM _useroptions WHERE $orLogic";
	$query = mysqli_query($db_connection, $sql);
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
			$followersList .= '<a class="hand" onclick="uid(\''.$follower_username.'\')"><li class="item fa-1x"><div class="product-img cu" style="border:1px solid #000;">';
			$followersList .= '<a class="hand" onclick="uid(\''.$follower_username.'\')"><img class="img" src="'.$follower_pic.'" alt="'.$follower_username.'"></a></div>';
			$followersList .= '<div class="product-info-name"><a class="hand" onclick="uid(\''.$follower_username.'\')" class="product-title">'.$fnme.' '.$lnme.' | @'.$follower_username.'</a><a class="hand" onclick="uid(\''.$follower_username.'\')">';
			$followersList .= '<span class="product-description">'.$followerstatus.'</span></a></div></li></a>';

			
			$total_followers = '<b>You have a total of '.$follower_count.' followers.</b>';	
			if($u != $log_username){
			$total_followers = '<b>'.$u.' has a total of '.$follower_count.' followers.</b>';
			$hide_search = 'style="display:none;"';
			}
		}
	}
}
$followers_num = ''.$follower_count.'';
$followers_num_only = $follower_count;
?>

<div class="modal fade" id="flwModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
				<button type="button" onClick="_cps()" class="pull-right close fa-1x" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h6 class="modal-title" id="defaultModalLabel"><?php echo $person; ?> Followers</h6>
            </div>
			<span id="followers">
				<div class="modal-body" style="padding:0px;">
					<div>
						<form method="get">
							<div class="input-group" <?php echo $hide_search; ?>>
								<span class="input-group-addon">@</span>
								<input type="text" onKeyUp="yy(this.value)" autocomplete="off" name="ww" id="ww" class="form-control" placeholder="Search username">
								<div class="input-group-btn">
									<button type="button" onClick="_cps()" class="btn btn-flat btn-primary"><i class="fa fa-times"></i></button>
								</div>
							</div>
						</form>
					</div>
					<div class="uq">
						<div>		
							<ul id="content" class="products-list product-list-in-box">
								<?php echo $followersList; ?>	
							</ul>
							<ul id="find" style="display:none;" class="products-list product-list-in-box"></ul>
						</div>
					</div>
				</div>
				<div class="text-center" style="padding:5px;">
					<h6 class="text-center">
						<?php echo $total_followers; ?>
					</h6>
				</div>
			</span>   
        </div>
    </div>
</div>
<script>
$(function(){
  $('#ww').keypress(function(e){
    if(e.which == 35){
		return false;
    } else {
      return true;
    }
  });
});
function _cps() {
	$('#ww').val("");
	document.getElementById("find").style.display="none";
	document.getElementById("content").style.display="block";
 };
function yy(str){
var f = document.getElementById("ww").value;
var u = "<?php echo $u ?>";
var xmlhttp1;
if (str.length==0) {
    document.getElementById("find").innerHTML="";
    document.getElementById("find").style.border="0px";
	document.getElementById("find").style.display="block";
	document.getElementById("content").style.display="block";
    return;
  }
if (window.XMLHttpRequest){xmlhttp1=new XMLHttpRequest();
  }else{xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");}
xmlhttp1.onreadystatechange=function(){
  if (xmlhttp1.readyState==4 && xmlhttp1.status==200){
    document.getElementById("find").innerHTML=xmlhttp1.responseText;
	document.getElementById("find").style.display="block";
	document.getElementById("content").style.display="none";
    }
  }
xmlhttp1.open("GET","_ext/_search/call_follower_search_ajax.php?f="+encodeURIComponent(f)+'&u='+u,true);
xmlhttp1.send();	
}
</script>