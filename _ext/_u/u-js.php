<script>
$(document).ready(function(e){
	var user = "<?php echo $u ?>";
	var xmlhttp2 = new XMLHttpRequest();
	xmlhttp2.onreadystatechange = function(){
		if(xmlhttp2.readyState==4&&xmlhttp2.status==200){
			document.getElementById('profilelogs').innerHTML = xmlhttp2.responseText;
		}
	}	
	xmlhttp2.open('GET','_ext/_story/profile_load_status.php?user='+user, true);
	xmlhttp2.send();

})
function statusMax(field, maxlimit) {
	if (field.value.length > maxlimit){
		Alert.render(maxlimit+" maximum character limit reached");
		field.value = field.value.substring(0, maxlimit);
	}
}	
function postToStatus(action,type,user,ta){
	var data = _(ta).value;
	if(data == "" || !data.replace(/\s/g, '').length){
		return false;
	}
	text = data.replace(/\r?\n/g, '<br />');
	_(ta).value = "";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState==4&&xmlhttp.status==200){
			document.getElementById('profilelogs').innerHTML = xmlhttp.responseText;
			document.getElementById('profilelogs').load('_ext/_story/profile_load_status.php');
		}
	}
	xmlhttp.open('GET','_ext/_story/profile_insert_status.php?action='+action+'&type='+type+'&user='+user+'&data='+encodeURIComponent(text), true);
	xmlhttp.send();
}
function sharePost(id,user,data,date,account,pic,sharetext){
	var user = "<?php echo $u;?>"
	var log_user = "<?php echo $log_username;?>"
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState==4&&xmlhttp.status==200){
			if(user == log_user){
				document.getElementById('profilelogs').innerHTML = xmlhttp.responseText;
			}
			Hint.render("Post shared!");
		}
	}
	xmlhttp.open('GET','_ext/_story/user_share_post.php?id='+id+'&user='+user+'&data='+encodeURIComponent(data)+'&date='+date+'&account='+account+'&pic='+pic+'&sharetext='+encodeURIComponent(sharetext), true);
	xmlhttp.send();
}
function replyToStatus(sid,user,ta,btn){
	var data = _(ta).value;
	if(data == "" || !data.replace(/\s/g, '').length){
		return false;
	}
	text = data.replace(/\r?\n/g, '<br />');
	_(ta).value = "";
	var xmlhttp3 = new XMLHttpRequest();
	xmlhttp3.onreadystatechange = function(){
		if(xmlhttp3.readyState==4&&xmlhttp3.status==200){
			var rstring = xmlhttp3.responseText.split("|||");
				for (var i = 0; i < rstring.length; i++){
					var string = rstring[i].split("|");		
				}		
				var strpy = string[0];
				var rpnum = string[1];
			document.getElementById('statusreply_'+sid).innerHTML = strpy;
			document.getElementById('rp_'+sid).innerHTML = rpnum;
			document.getElementById('statusreply2_'+sid).innerHTML = strpy;
			document.getElementById('rp2_'+sid).innerHTML = rpnum;
		}
	}	
	xmlhttp3.open('GET','_ext/_story/user_insert_reply.php?action=status_reply&sid='+sid+'&user='+user+'&data='+encodeURIComponent(text), true);
	xmlhttp3.send();
}
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
			document.getElementById('lk2_'+storyid).innerHTML = lkbtn;
			document.getElementById('lknum2_'+storyid).innerHTML = lknum;
		}
	}
	xmlhttp5.open('GET','_parse/_system_like.php?type='+type+'&storyid='+storyid+'&author='+author, true);
	xmlhttp5.send();
}	
function deleteStatus(statusid,statusbox){
	Confirm.render("Are you sure you want to delete this post and its comments?");
	Confirm.yes = function(){
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverlay').style.display = "none";
		var ajax = ajaxObj("POST", "_parse/_system_status.php");
		ajax.onreadystatechange = function() {
			if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "delete_ok"){
					_(statusbox).style.display = 'none';
					_("replytext_"+statusid).style.display = 'none';
					_("replyBtn_"+statusid).style.display = 'none';
				} else {
					Alert.render(ajax.responseText);
				}
			}
		}
		ajax.send("action=delete_status&statusid="+statusid);
	}
	Confirm.no = function(){
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverlay').style.display = "none";
	}
}
function deleteReply(replyid,replybox,replybox2){
	Confirm.render("Are you sure you want to delete this reply?");
	Confirm.yes = function(){
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverlay').style.display = "none";
		var ajax = ajaxObj("POST", "_parse/_system_status.php");
		ajax.onreadystatechange = function() {
			if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "delete_ok"){
					_(replybox).style.display = 'none';
					_(replybox2).style.display = 'none';
				} else {
					Alert.render(ajax.responseText);
				}
			}
		}
		ajax.send("action=delete_reply&replyid="+replyid);
	}
	Confirm.no = function(){
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverlay').style.display = "none";
	}
}
function friendToggle(type,user,elem){
	_(elem).innerHTML = '<a class="btn btn-default btn-block" style="white-space: inherit;" disabled><div class="preloader pl-size-xs"><div class="spinner-layer pl-maroon"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div></a>';
	var ajax = ajaxObj("POST", "_parse/_system_friend.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			var lstring = ajax.responseText.split("|||");
				for (var i = 0; i < lstring.length; i++){
					var string = lstring[i].split("|");		
				}		
				var freturn = string[0];
				var sreturn = string[1];
			if(freturn == "friend_request_sent"){
				_(elem).innerHTML = '<a class="btn btn-default btn-block" disabled><b>Requested</b></a>';
				_('followBtn').innerHTML = '<a class="btn btn-default btn-block hand" id="followBtn_" onclick="followToggle(\'unfollow\',\'<?php echo $u; ?>\',\'followBtn\')"><b>Following</b></a>';
			} else if(freturn == "unfriend_ok"){
				_(elem).innerHTML = '<a class="btn btn-primary btn-block hand" id="friendBtn_" onclick="friendToggle(\'friend\',\'<?php echo $u; ?>\',\'friendBtn\')"><b>Friend</b></a>';
				document.getElementById('ct_'+sreturn).style.display = 'none';
			} else {
				Alert.render(ajax.responseText);
				_(elem).innerHTML = '<a class="btn btn-primary btn-block hand" id="friendBtn_" onclick="friendToggle(\'friend\',\'<?php echo $u; ?>\',\'friendBtn\')"><b>Friend</b></a>';
				
			}
		}
	}
	ajax.send("type="+type+"&user="+user);
}
function followToggle(type,user2,elem){
	_(elem).innerHTML = '<a class="btn btn-default btn-block" style="white-space: inherit;" disabled><div class="preloader pl-size-xs"><div class="spinner-layer pl-maroon"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div></a>';
	var ajax = ajaxObj("POST", "_parse/_system_follow.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "follow_ok"){
				_(elem).innerHTML = '<a class="btn btn-default btn-block hand" id="followBtn_" onclick="followToggle(\'unfollow\',\'<?php echo $u; ?>\',\'followBtn\')"><b>Following</b></a>';
				ff.play();
			} else if(ajax.responseText == "unfollow_ok"){
				_(elem).innerHTML = '<a class="btn btn-info btn-block hand" id="followBtn_" onclick="followToggle(\'follow\',\'<?php echo $u; ?>\',\'followBtn\')"><b>Follow</b></a>';
			} else {
				Alert.render(ajax.responseText);
				_(elem).innerHTML = '<a class="btn btn-info btn-block hand" id="followBtn_" onclick="followToggle(\'follow\',\'<?php echo $u; ?>\',\'followBtn\')"><b>Follow</b></a>';
			}
		}
	}
	ajax.send("type="+type+"&user2="+user2);
}
function blockToggle(type,blockee,elem){
	if(type == "block"){
		Confirm.render("Do you really want to block <?php echo $fname; ?> <?php echo $lname; ?>? This will restrict any form of conversation/ communication. Press 'Yes' if you still want to proceed.");
	}else if(type == "unblock"){
		Confirm.render("Do you really want to "+type+" <?php echo $fname; ?> <?php echo $lname; ?>?");
	}	
	Confirm.yes = function(){
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverlay').style.display = "none";
		_(elem).innerHTML = '<a class="btn btn-default btn-block" style="white-space: inherit;" disabled><div class="preloader pl-size-xs"><div class="spinner-layer pl-maroon"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div></a>';
		var ajax = ajaxObj("POST", "_parse/_system_block.php");
		ajax.onreadystatechange = function() {
			if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "blocked_ok"){
					_(elem).innerHTML = '<a class="btn btn-primary btn-block hand" id="blockBtn_" onclick="blockToggle(\'unblock\',\'<?php echo $u; ?>\',\'blockBtn\')"><b>Unblock</b></a>';
					_('followBtn').innerHTML = '<a class="btn btn-info btn-block hand" id="followBtn_" onclick="followToggle(\'follow\',\'<?php echo $u; ?>\',\'followBtn\')"><b>Follow</b></a>';
				} else if(ajax.responseText == "unblocked_ok"){
					_(elem).innerHTML = '<a class="hand" onclick="blockToggle(\'block\',\'<?php echo $u; ?>\',\'blockBtn\')"><span class="fa fa-exclamation-circle"></span>&nbsp; Block User</a>';
					_(elem).innerHTML = '<a class="btn btn-default btn-block hand" id="blockBtn_" onclick="blockToggle(\'block\',\'<?php echo $u; ?>\',\'blockBtn\')"><b>Block</b></a>';
				} else {
					alert(ajax.responseText);
					_(elem).innerHTML = '<a class="btn btn-default btn-block hand" id="blockBtn_" onclick="blockToggle(\'block\',\'<?php echo $u; ?>\',\'blockBtn\')"><b>Block</b></a>';
					window.location = "uid&<?php echo $u; ?>";
				}
			}
		}
		ajax.send("type="+type+"&blockee="+blockee);
	}
	Confirm.no = function(){
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverlay').style.display = "none";
	}
}
</script>