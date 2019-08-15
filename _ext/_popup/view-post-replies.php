<div class="popup" id="viewPost">
	<div class="popup-inner" style="text-align:justify;">
		<div class="box-body" style="border-top:0px solid;">
			<div class="box-primary">
				<div class="scrollPost">
					<div class="box-body no-padding" style="margin-bottom: 5px;">
						<div id="postlog"> 
							<div style="text-align:center;margin: 5px;"> 
								<div class="preloader pl-size-xs"><div class="spinner-layer pl-blue"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>
							</div>			
						</div>
					</div>
				</div>
				<div id="replyForm"></div>
			</div>
		</div>
	</div>
</div>
<script>
function OpenViewPost(acc,sid,user,postbox){
	if(acc == "" || sid == "" || user == ""){
		return false;
	}
	var xmlhttp7 = new XMLHttpRequest();
	xmlhttp7.onreadystatechange = function(){
		if(xmlhttp7.readyState==4&&xmlhttp7.status==200){
			var rstr = xmlhttp7.responseText.split("|||");
				for (var i = 0; i < rstr.length; i++){
					var string = rstr[i].split("|");		
				}		
				var statuslog = string[0];
				var replybox = string[1];
			document.getElementById('postlog').innerHTML = statuslog;
			document.getElementById('replyForm').innerHTML = replybox;
		}
	}
	xmlhttp7.open('GET','_ext/_story/user_load_post_replies.php?acc='+acc+'&sid='+sid+'&user='+user, true);
	xmlhttp7.send();
	$("#viewPost").fadeIn(10);
}
function CloseViewPost(){
	$("#viewPost").fadeOut(100);
	document.getElementById('postlog').innerHTML = '<div style="text-align:center;margin: 5px;"> <div class="preloader pl-size-xs"><div class="spinner-layer pl-blue"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div></div>';
	document.getElementById('replyForm').innerHTML = "";
}
</script>