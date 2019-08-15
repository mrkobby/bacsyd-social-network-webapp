<div class="popup" id="hmPost" pd-popup="hmPost">
	<div class="popup-inner">
		<div class="box-body">
			<?php echo $status_ui;?>
		</div>
	</div>
</div>
<script src="_ast/_js/_query.js"></script>
<script>
function statusMax(field, maxlimit) {
	if (field.value.length > maxlimit){
		Alert.render(maxlimit+" maximum character limit reached");
		field.value = field.value.substring(0, maxlimit);
	}
}	
$(document).ready(function(e){
	$("#photofile").change(function(){
		$(".fileCaption").hide(200);
		$(".fileBtn").removeClass('btn-info').addClass('color-raven');	
		document.getElementById("imgcaption").focus();
	});
	$("#phtfile").click(function(){
		$("#statusform").slideUp(100);
		document.getElementById("statustext").value = "";
		$("#pictureform").show(200);
	});
	$("#statusCloseBtn").click(function(){
		document.getElementById("photofile").value = "";
		$(".fileCaption").show(200);
		$(".fileBtn").removeClass('color-raven').addClass('btn-info');
	});
	$("#returnToTextBtn").click(function(){
		document.getElementById("photofile").value = "";
		document.getElementById("imgcaption").value = "";
		$(".fileCaption").fadeIn(500);
		$(".fileBtn").removeClass('color-raven').addClass('btn-info');
		$("#statusform").show(200);
		$("#pictureform").hide(100);
	});
})
$("#pictureform").on('submit',(function(e) {
	_("picturePostDiv").style.display = 'block';
	e.preventDefault();
	$.ajax({
       	url: "_ext/_story/user_picture_post.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
    	cache: false,
		processData:false,
		success: function(data){
			$("#statuslogs").html(data);
			loadMorePosts();
			document.getElementById("photofile").value = "";
			$(".fileCaption").show(200);
			$(".fileBtn").removeClass('color-raven').addClass('btn-info');
			$("#statusform").show(100);
			$("#pictureform").hide(100);
			$("#hmPost").fadeOut(200);
			_("picturePostDiv").style.display = 'none';
			document.getElementById("imgcaption").value = "";
		},
		  error: function() {} 	        
	});
}));
function submitStatus(action,type,user,ta){
	var data = _(ta).value;
	if(data == "" || !data.replace(/\s/g, '').length){
		return false;
	}
	text = data.replace(/\r?\n/g, '<br />');
	_(ta).value = "";
	_("statusPostDiv").style.display = 'block';
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState==4&&xmlhttp.status==200){
			_("statusPostDiv").style.display = 'none';
			$("#hmPost").fadeOut(200);
			document.getElementById('statuslogs').innerHTML = xmlhttp.responseText;
			loadMorePosts();
		}
	}
	xmlhttp.open('GET','_ext/_story/user_insert_status.php?action='+action+'&type='+type+'&user='+user+'&data='+encodeURIComponent(text), true);
	xmlhttp.send();
}
function sharePost(id,user,data,date,account,pic,sharetext){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState==4&&xmlhttp.status==200){
			document.getElementById('statuslogs').innerHTML = xmlhttp.responseText;
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
</script>