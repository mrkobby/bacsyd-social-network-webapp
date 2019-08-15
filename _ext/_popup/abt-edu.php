<div class="popup" id="changeEdu" pd-popup="changeEdu">
	<div class="popup-inner">
		<div id="changeEduDiv" style="display: none; z-index:99999; text-align: center;position: absolute;background: rgba(60, 57, 57, 0.85);width: 100%;height: 100%;font-size: 22px;color: #fff;left:0px;top:0px;line-height: 100px;">Please wait...</div>
		<div class="box-header">
			<i class="fa fa-book"></i>
			<h4 class="box-title">Edit education</h4>
		</div>
		<div class="box-body">
			<div class="box box-primary">
				<div class="box-body no-padding" style="margin-bottom: 5px;">
					<form role="form" method="post" id="editEdu" onSubmit="return false;">
						<input type="text" class="form-control" name="educationupdate" id="educationupdate"  
						placeholder="Add university or high school" maxLength="50" />
					</form>			
				</div>
				<div class="box-footer no-padding">
				    <a href="javascript:void(0)" onclick="updateEdu()" class="btn btn-primary pull-right">Save</a>
					<a pd-popup-close="changeEdu" href="javascript:void(0)" class="btn btn-default pull-left">Cancel</a>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
function updateEdu(){
	var sch = _("educationupdate").value;
	var u = "<?php echo $u;?>";
	var log_u = "<?php echo $log_username;?>";
	if(sch != ""){
		document.getElementById("changeEduDiv").style.display = 'block';
		var ajax = ajaxObj("POST", "_parse/_all_edits.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "update_failed"){
					Alert.render("Education update was unsuccessful");
					document.getElementById("changeEduDiv").style.display = 'none';
				}else {
					document.getElementById("changeEduDiv").style.display = 'none';
					if(u == log_u){
						$(".edutext").html(ajax.responseText);
					}
					document.getElementById("educationupdate").value = "";
					$("#changeEdu").hide(0);
				}
	        }
        }
		ajax.send("action=sch_update&sch="+encodeURIComponent(sch));
	}else{
		return false;
	}
}
</script>