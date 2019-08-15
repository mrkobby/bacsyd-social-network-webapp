<div class="popup" id="changeFname" pd-popup="changeFname">
	<div class="popup-inner">
	<div id="changeFnameDiv" style="display: none; z-index:99999; text-align: center;position: absolute;background: rgba(60, 57, 57, 0.85);width: 100%;height: 100%;font-size: 22px;color: #fff;left:0px;top:0px;line-height: 100px;">Please wait...</div>
		<div class="box-header">
			<i class="fa fa-user"></i>
			<h4 class="box-title">Change firstname</h4>
		</div>
		<div class="box-body">
			<div class="box box-primary">
				<div class="box-body no-padding" style="margin-bottom: 5px;">
					<form role="form" method="post" id="editFname" onSubmit="return false;">
						<input type="text" class="form-control" placeholder="Edit lastname"
						name="fnameupdate" id="fnameupdate" onkeyup="preventNumF('fnameupdate')" maxlength="20" />
					</form>			
				</div>
				<div class="box-footer no-padding">
				    <a href="javascript:void(0)" onclick="updateFname()" class="btn btn-primary pull-right">Save</a>
					<a pd-popup-close="changeFname" href="javascript:void(0)" class="btn btn-default pull-left">Cancel</a>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
function preventNumF(elem){
	var tf = _(elem);
	var rx = new RegExp;
	if(elem == "fnameupdate"){
		rx = /[^a-z'-]/gi;
	}
	tf.value = tf.value.replace(rx, "");
}
function updateFname(){
	var fn = _("fnameupdate").value;
	var u = "<?php echo $u;?>";
	var log_u = "<?php echo $log_username;?>";
	if(fn != ""){
		document.getElementById("changeFnameDiv").style.display = 'block';
		var ajax = ajaxObj("POST", "_parse/_all_edits.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "update_failed"){
					Alert.render("Firstname update was unsuccessful");
					document.getElementById("changeFnameDiv").style.display = 'none';
				}else {
					document.getElementById("changeFnameDiv").style.display = 'none';
					if(u == log_u){
						$(".ufnametext").html(ajax.responseText);
					}
					$(".fnametext").html(ajax.responseText);
					document.getElementById("fnameupdate").value = "";
					$("#changeFname").hide(0);
				}
	        }
        }
		ajax.send("action=fn_update&fn="+encodeURIComponent(fn));
	}else{
		return false;
	}
}
</script>