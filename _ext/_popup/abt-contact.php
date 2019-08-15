<div class="popup" id="changeContact" pd-popup="changeContact">
	<div class="popup-inner">
		<div id="changeContactDiv" style="display: none; z-index:99999; text-align: center;position: absolute;background: rgba(60, 57, 57, 0.85);width: 100%;height: 100%;font-size: 22px;color: #fff;left:0px;top:0px;line-height: 100px;">Please wait...</div>
		<div class="box-header">
			<i class="fa fa-mobile"></i>
			<h4 class="box-title">Edit contact</h4>
		</div>
		<div class="box-body">
			<div class="box box-primary">
				<div class="box-body no-padding" style="margin-bottom: 5px;">
					<form role="form" method="post" id="editContact" onSubmit="return false;">
						<input type="text" class="form-control" name="contactupdate" id="contactupdate"
						placeholder="(000)-000-0000" onkeyup="preventTextSym('contactupdate')" maxLength="10" />
					</form>			
				</div>
				<div class="box-footer no-padding">
				    <a href="javascript:void(0)" onclick="updateNum()" class="btn btn-primary pull-right">Save</a>
					<a pd-popup-close="changeContact" href="javascript:void(0)" class="btn btn-default pull-left">Cancel</a>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
function preventTextSym(elem){
	var tf = _(elem);
	var rx = new RegExp;
	if(elem == "contactupdate"){
		rx = /[^0-9]/gi;
	}
	tf.value = tf.value.replace(rx, "");
}
function updateNum(){
	var num = _("contactupdate").value;
	var u = "<?php echo $u;?>";
	var log_u = "<?php echo $log_username;?>";
	if(num != ""){
		document.getElementById("changeContactDiv").style.display = 'block';
		var ajax = ajaxObj("POST", "_parse/_all_edits.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "update_failed"){
					Alert.render("Location update was unsuccessful");
					document.getElementById("changeContactDiv").style.display = 'none';
				}else {
					document.getElementById("changeContactDiv").style.display = 'none';
					if(u == log_u){
						$(".mobiletext").html(ajax.responseText);
					}
					document.getElementById("contactupdate").value = "";
					$("#changeContact").hide(0);
				}
	        }
        }
		ajax.send("action=num_update&num="+encodeURIComponent(num));
	}else{
		return false;
	}
}
</script>