<div class="popup" id="changeDp" pd-popup="changeDp">
	<div class="popup-inner-dp">
	<div id="dpPostDiv" style="display: none; z-index:99999; text-align: center;position: absolute;background: rgba(60, 57, 57, 0.85);width: 100%;height: 100%;font-size: 22px;color: #fff;left:0px;top:0px;line-height: 180px;">PLease wait...</div>
		<div class="box-header">
			<i class="fa fa-user pull-left"></i>
			<h4 class="box-title pull-left">Change profile picture</h4>
		</div>
		<div class="box-body">
			<div class="box box-primary">
				<form id="uploadDp" action="_parse/upload_dp.php" method="post">
					<div class="box-body no-padding" style="margin-bottom: 5px;">
						<div class="input-group" style="margin:25px auto;">
							<label id="dpBtn" for="avatarfile" class="btn btn-primary btn-block" style="width: 100%;"><span id="fileCaptionDp">Select picture &nbsp;</span><span class="fa fa-photo"></span></label>
							<input name="avatar" id="avatarfile" style="width:0%;visibility:hidden;display: none;" type="file" accept="image/*"  required />
						</div>
					</div>
					<div id="btnsFirst" class="box-footer no-padding">
						<input type="submit" value="Next" class="btn btn-primary pull-right"></input>
						<a id="dpCancel" pd-popup-close="changeDp" href="#" class="btn btn-default pull-left" style="margin-right: 5px;">Cancel</a>
						<a href="javascript:void(0)" onmousedown="deleteAvatar()" class="btn btn-danger pull-left" style="margin-right: 40px;color:#fff;">Remove</a>
					</div>
				</form>
				<form>
					<div id="btnsSecond" class="box-footer no-padding" style="display:none;margin:10px;">
						<a id="btnSave"  onclick="uploadDpThumb()" class="btn btn-primary pull-right">Save</a>
						<a id="discardDp" href="javascript:void(0)" class="btn btn-default pull-left">Discard</a>
					</div>
					<input type="hidden" id="x" name="x" /><input type="hidden" id="y" name="y" /><input type="hidden" id="w" name="w" /><input type="hidden" id="h" name="h" />
					<div class="box-body no-padding" style="margin-bottom: 5px;">
						<div class="row" style="margin:auto;width:100%;">
							<div class="col-xs-12" id="targetThumbDpLayer"></div>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
</div>

<script src="_ast/_js/_query.js"></script>
<script type="text/javascript">
$(document).ready(function (e) {
	$("#avatarfile").change(function(){
		$("#fileCaptionDp").hide(200);
		$("#dpBtn").removeClass('btn-primary').addClass('color-raven');
	});
	$("#uploadDp").on('submit',(function(e) {
		document.getElementById("dpPostDiv").style.display = 'block';
		e.preventDefault();
		$.ajax({
        	url: "_parse/upload_dp.php",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data){
			   $("#targetThumbDpLayer").html(data);
			   $('#uploadDp').fadeOut(0);
			   $('#btnsSecond').fadeIn(200);
			   document.getElementById("dpPostDiv").style.display = 'none';
		    },
		  	error: function() {} 	        
	   });
	}));
	$('#discardDp').on('click', function(e)  {
		$("#targetThumbDpLayer").html("");
		$('#uploadDp').fadeIn(200);
		$('#btnsSecond').fadeOut(10);
        $('#changeDp').fadeOut(10);
		document.getElementById("avatarfile").value = "";
		$("#fileCaptionDp").show(200);
		$("#dpBtn").removeClass('color-raven').addClass('btn-primary');
    });
	$('#dpCancel').on('click', function(e)  {
		document.getElementById("avatarfile").value = "";
		$("#fileCaptionDp").show(200);
		$("#dpBtn").removeClass('color-raven').addClass('btn-primary');
    });
});
function uploadDpThumb(){
	var x = document.getElementById("x").value;
	var y = document.getElementById("y").value;
	var w = document.getElementById("w").value;
	var h = document.getElementById("h").value;
	if(x == "" || y == "" ){
		return false;
	}else {
		document.getElementById("dpPostDiv").style.display = 'block';
		var ajax = ajaxObj("POST", "_parse/upload_dp.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
				var u = "<?php echo $u;?>";
				var log_u = "<?php echo $log_username;?>";
				if(u == log_u){
					document.getElementById('targetDpLayer').innerHTML = ajax.responseText;
					$(".targetDpLayer").html(ajax.responseText);
				}
				$('#uploadDp').fadeIn(200);
				$('#btnsSecond').fadeOut(100);
				$('#changeDp').fadeOut(100);
				$("#targetThumbDpLayer").html("");
				document.getElementById("avatarfile").value = "";
				$("#fileCaptionDp").show(200);
				$("#dpBtn").removeClass('color-raven').addClass('btn-primary');
				document.getElementById("dpPostDiv").style.display = 'none';
	        }
        }
		ajax.send("action=dp_update&x="+x+"&y="+y+"&w="+w+"&h="+h);
	}
}
function deleteAvatar(){
	Confirm.render("Are you sure you want to remove your profile picture?");
	Confirm.yes = function(){
		var u = "<?php echo $u;?>";
		var log_u = "<?php echo $log_username;?>";
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverlay').style.display = "none";
		var ajax = ajaxObj("POST", "_parse/upload_dp.php");
		ajax.onreadystatechange = function() {
			if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "remove_ok"){
					if(u == log_u){
						$("#targetDpLayer").html('<img src="_ast/_img/avatardefault.png" class="img-circle hand" alt="User">');
						$(".targetDpLayer").html('<img src="_ast/_img/avatardefault.png" class="img-circle hand" alt="User">');
					}
					$('#uploadDp').fadeIn(200);
					$('#btnsSecond').fadeOut(100);
					$('#changeDp').fadeOut(100);
					$("#targetThumbDpLayer").html("");
				   document.getElementById("avatarfile").value = "";
				} else {
					Alert.render(ajax.responseText);
				}
			}
		}
		ajax.send("action=delete_dp");
	}
	Confirm.no = function(){
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverlay').style.display = "none";
	}
}
</script>	