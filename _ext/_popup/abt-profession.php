<div class="popup" id="changeProfession" pd-popup="changeProfession">
	<div class="popup-inner">
		<div id="changeProfessionDiv" style="display: none; z-index:99999; text-align: center;position: absolute;background: rgba(60, 57, 57, 0.85);width: 100%;height: 100%;font-size: 22px;color: #fff;left:0px;top:0px;line-height: 100px;">Please wait...</div>
		<div class="box-header">
			<i class="fa fa-briefcase"></i>
			<h4 class="box-title">Edit profession</h4>
		</div>
		<div class="box-body">
			<div class="box box-primary">
				<div class="box-body no-padding" style="margin-bottom: 5px;">
					<form role="form" method="post" id="editProfession" onSubmit="return false;">
						<input type="text" class="form-control" name="professionupdate" id="professionupdate"
						placeholder="What job or skill have you mastered?" maxLength="30" />
					</form>			
				</div>
				<div class="box-footer no-padding">
				    <a href="javascript:void(0)" onclick="updatePs()" class="btn btn-primary pull-right">Save</a>
					<a pd-popup-close="changeProfession" href="javascript:void(0)" class="btn btn-default pull-left">Cancel</a>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
function updatePs(){
	var ps = _("professionupdate").value;
	var u = "<?php echo $u;?>";
	var log_u = "<?php echo $log_username;?>";
	if(ps != ""){
		document.getElementById("changeProfessionDiv").style.display = 'block';
		var ajax = ajaxObj("POST", "_parse/_all_edits.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "update_failed"){
					Alert.render("Profession update was unsuccessful");
					document.getElementById("changeProfessionDiv").style.display = 'none';
				}else {
					document.getElementById("changeProfessionDiv").style.display = 'none';
					if(u == log_u){
						$(".professiontext").html(ajax.responseText);
					}
					document.getElementById("professionupdate").value = "";
					$("#changeProfession").hide(0);
				}
	        }
        }
		ajax.send("action=ps_update&ps="+encodeURIComponent(ps));
	}else{
		return false;
	}
}
</script>