<div class="popup" id="changeLname" pd-popup="changeLname">
	<div class="popup-inner">
	<div id="changeLnameDiv" style="display: none; z-index:99999; text-align: center;position: absolute;background: rgba(60, 57, 57, 0.85);width: 100%;height: 100%;font-size: 22px;color: #fff;left:0px;top:0px;line-height: 100px;">Please wait...</div>
		<div class="box-header">
			<i class="fa fa-user"></i>
			<h4 class="box-title">Change lastname</h4>
		</div>
		<div class="box-body">
			<div class="box box-primary">
				<div class="box-body no-padding" style="margin-bottom: 5px;">
					<form role="form" method="post" id="editLname" onSubmit="return false;">
						<input type="text" class="form-control" name="lnameupdate" id="lnameupdate"
						placeholder="Edit lastname" onkeyup="preventNumL('lnameupdate')" maxlength="20" />
					</form>			
				</div>
				<div class="box-footer no-padding">
				    <a href="javascript:void(0)" onclick="updateLname()" class="btn btn-primary pull-right">Save</a>
					<a pd-popup-close="changeLname" href="javascript:void(0)" class="btn btn-default pull-left">Cancel</a>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
function preventNumL(elem){
	var tf = _(elem);
	var rx = new RegExp;
	if(elem == "lnameupdate"){
		rx = /[^a-z'-]/gi;
	}
	tf.value = tf.value.replace(rx, "");
}
function updateLname(){
	var ln = _("lnameupdate").value;
	var u = "<?php echo $u;?>";
	var log_u = "<?php echo $log_username;?>";
	if(ln != ""){
		document.getElementById("changeLnameDiv").style.display = 'block';
		var ajax = ajaxObj("POST", "_parse/_all_edits.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "update_failed"){
					Alert.render("Lastname update was unsuccessful");
					document.getElementById("changeLnameDiv").style.display = 'none';
				}else {
					document.getElementById("changeLnameDiv").style.display = 'none';
					if(u == log_u){
						$(".ulnametext").html(ajax.responseText);
					}
					$(".lnametext").html(ajax.responseText);
					document.getElementById("lnameupdate").value = "";
					$("#changeLname").hide(0);
				}
	        }
        }
		ajax.send("action=ln_update&ln="+encodeURIComponent(ln));
	}else{
		return false;
	}
}
</script>