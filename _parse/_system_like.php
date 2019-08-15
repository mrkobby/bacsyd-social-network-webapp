<?php
include_once("../_sys/check_login_status.php");
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php
if (isset($_GET['type']) && isset($_GET['storyid']) && isset($_GET['author'])){
	$storyid = preg_replace('#[^0-9]#', '', $_GET['storyid']);
	$author = preg_replace('#[^a-z0-9]#i', '', $_GET['author']);
	$sql = "SELECT COUNT(id) FROM _users WHERE username='$log_username'";
	$query = mysqli_query($db_connection, $sql);
	$exist_count = mysqli_fetch_row($query);
	if($exist_count[0] < 1){
		mysqli_close($db_connection);
		echo "$user does not exist.";
		exit();
	}
	$likestring = "";
	$story_likes = mysqli_query($db_connection, "SELECT * FROM storylikes WHERE storyid ='$storyid'");
	$likenumrows = mysqli_num_rows($story_likes);
	if($_GET['type'] == "like"){
		$sql = "SELECT COUNT(id) FROM storylikes WHERE storyid='$storyid' AND username='$log_username'";
		$query = mysqli_query($db_connection, $sql);
		$like_count = mysqli_fetch_row($query);
	    if($like_count[0] > 1){
            mysqli_close($db_connection);
	        echo "A post cannot be liked more than once";
	        exit();
		} else if($storyid == 0){
			mysqli_close($db_connection);
	        echo "Story id not found";
	        exit();
        } else if($like_count[0] < 1){
	        $sql = "INSERT INTO storylikes(author, storyid, username) VALUES('$author','$storyid','$log_username')";
		    $query = mysqli_query($db_connection, $sql);
			$likenumrows = $likenumrows + 1;
			mysqli_close($db_connection);
			$like_button = '<a class="link-black text-sm hand like active" id="likeBtn'.$storyid.'" onclick="likeToggle(\'unlike\',\''.$author.'\',\''.$storyid.'\',\'likeBtn_'.$storyid.'\')"><i class="fa fa-thumbs-up margin-r-5"></i></a>';
	        $likestring .= "$like_button|$likenumrows|||";
			$likestring = trim($likestring, "|||");	
			echo $likestring;
			exit();
		}else {
			mysqli_close($db_connection);
	        echo "";
			exit();
		}
	} else if($_GET['type'] == "unlike"){
		$sql = "SELECT COUNT(id) FROM storylikes WHERE storyid='$storyid' AND username='$log_username'";
		$query = mysqli_query($db_connection, $sql);
		$row_count = mysqli_fetch_row($query);
		if($storyid == 0){
			mysqli_close($db_connection);
	        echo "Post Id not found";
	        exit();
	    } else if ($row_count[0] > 0) {
	        $sql = "DELETE FROM storylikes WHERE storyid='$storyid' AND username='$log_username'";
			$query = mysqli_query($db_connection, $sql);
			$likenumrows = $likenumrows - 1;
			mysqli_close($db_connection);
			$like_button = '<a class="link-black text-sm hand" id="likeBtn'.$storyid.'" onclick="likeToggle(\'like\',\''.$author.'\',\''.$storyid.'\',\'likeBtn_'.$storyid.'\')"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>';
	        $likestring .= "$like_button|$likenumrows|||";
			$likestring = trim($likestring, "|||");		
			echo $likestring;
			exit();
	    } else {
			mysqli_close($db_connection);
	        echo "";
			exit();
		}
	}
}
?>
<script>
function likeToggle(type,author,storyid,elem){
	var xmlhttp5 = new XMLHttpRequest();
	xmlhttp5.onreadystatechange = function(){
		if(xmlhttp5.readyState==4&&xmlhttp5.status==200){
			var lstring = xmlhttp5.responseText.split("|||");
				for (var i = 0; i < lstring.length; i++){
					var string = lstring[i].split("|");		
				}		
				var lkbtn = string[0];
				var lknum = string[1];
			document.getElementById('lk_'+storyid).innerHTML = lkbtn;
			document.getElementById('lknum_'+storyid).innerHTML = lknum;
		}
	}
	xmlhttp5.open('GET','_system_like.php?type='+type+'&storyid='+storyid+'&author='+author, true);
	xmlhttp5.send();
}	
</script>