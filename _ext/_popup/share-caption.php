<div class="popup" id="shareCaption" pd-popup="shareCaption">
	<div class="popup-inner">
		<div id="shareCaptionDiv" style="display: none; z-index:99999; text-align: center;position: absolute;background: rgba(60, 57, 57, 0.85);width: 100%;height: 100%;font-size: 22px;color: #fff;left:0px;top:0px;line-height: 100px;">Please wait...</div>
		<div class="box-body">
			<?php echo $share_ui;?>
		</div>
	</div>
</div>
<script>
function OpenShareCaption(id,user,data,date,account,pic){
	$("#shareCaption").fadeIn(200);
	$("#shareBtn").click(function(){
		var sharetext = document.getElementById("sharetext").value;
		if(sharetext == "" || !sharetext.replace(/\s/g, '').length){
			return false;
		}else{
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState==4&&xmlhttp.status==200){
					document.getElementById('statuslogs').innerHTML = xmlhttp.responseText;
					Hint.render("Post shared!");
				}
			}
			xmlhttp.open('GET','_ext/_story/user_share_post.php?id='+id+'&user='+user+'&data='+encodeURIComponent(data)+'&date='+date+'&account='+account+'&pic='+pic+'&sharetext='+encodeURIComponent(sharetext), true);
			xmlhttp.send();
			document.getElementById("sharetext").value = "";
			$("#shareCaption").fadeOut(200);
		}
	});
}
function closeShareCaption(){
	document.getElementById("sharetext").value = "";
	$("#shareCaption").fadeOut(200);
}
</script>