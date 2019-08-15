<div class="popup" id="changeBio" pd-popup="changeBio">
	<div class="popup-inner">
	<div id="chngBioDiv" style="display: none; z-index:99999; text-align: center;position: absolute;background: rgba(60, 57, 57, 0.85);width: 100%;height: 100%;font-size: 22px;color: #fff;left:0px;top:0px;line-height: 100px;">Please wait...</div>
		<div class="box-header">
			<i class="fa fa-file-text-o"></i>
			<h4 class="box-title">Edit bio</h4>
		</div>
		<div class="box-body">
			<div class="box box-primary">
				<form role="form" method="post" id="editBio" onSubmit="return false;">
					<div class="box-body no-padding" style="margin-bottom: 5px;">
						<input type="text" class="form-control" placeholder="Write something about yourself"
						name="statusupdate" id="statusupdate" 
						onKeyUp="textCounter(this.form.statusupdate,this.form.countDisplay);"
						onKeyDown="textCounter(this.form.statusupdate,this.form.countDisplay);"/>		
					</div>
					<div class="box-footer no-padding">
						<a href="javascript:void(0)" onclick="updatestatus()" class="btn btn-primary pull-right">Save</a>
						<a pd-popup-close="changeBio" id="bioCancel" href="javascript:void(0)" class="btn btn-default pull-left">Cancel</a>
						<input class="btn btn-link btn-flat pull-left" readonly name="countDisplay" value="150" style="width: 20%;text-decoration:none;" />
					</div>
				</form>	
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
function updatestatus(){
	var s = _("statusupdate").value;
	var u = "<?php echo $u;?>";
	var log_u = "<?php echo $log_username;?>";
	if(s != ""){
		document.getElementById("chngBioDiv").style.display = 'block';
		var ajax = ajaxObj("POST", "_parse/_all_edits.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "update_failed"){
					Alert.render("Bio update was unsuccessful");
					document.getElementById("chngBioDiv").style.display = 'none';
				}else {
					document.getElementById("chngBioDiv").style.display = 'none';
					if(u == log_u){
						$(".biotext").html(ajax.responseText);
					}
					document.getElementById("statusupdate").value = "";
					$("#changeBio").hide(0);
				}
	        }
        }
		ajax.send("action=status_update&s="+encodeURIComponent(s));
	}else{
		return false;
	}
}
$('#bioCancel').on('click', function(e)  {
	document.getElementById("statusupdate").value = "";
});
var maxAmount = 150;
function textCounter(textField, showCountField) {
    if (textField.value.length > maxAmount) {
        textField.value = textField.value.substring(0, maxAmount);
	} else { 
        showCountField.value = maxAmount - textField.value.length;
	}
}	
</script>