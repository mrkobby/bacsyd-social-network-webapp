<div class="popup" id="changeLocation" pd-popup="changeLocation">
	<div class="popup-inner">
	<div id="changeLocationDiv" style="display: none; z-index:99999; text-align: center;position: absolute;background: rgba(60, 57, 57, 0.85);width: 100%;height: 100%;font-size: 22px;color: #fff;left:0px;top:0px;line-height: 100px;">Please wait...</div>
		<div class="box-header">
			<i class="fa fa-map-marker"></i>
			<h4 class="box-title">Edit location</h4>
		</div>
		<div class="box-body">
			<div class="box box-primary">
				<div class="box-body no-padding" style="margin-bottom: 5px;">
					<form role="form" method="post" id="editLocation" onSubmit="return false;">
						<input type="text" class="form-control" placeholder="Where do you live?" 
						name="locationupdate" id="locationupdate" maxLength="30" />
					</form>			
				</div>
				<div class="box-footer no-padding">
				    <a href="javascript:void(0)" onclick="updateLoc()" class="btn btn-primary pull-right">Save</a>
					<a pd-popup-close="changeLocation" href="javascript:void(0)" class="btn btn-default pull-left">Cancel</a>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
function updateLoc(){
	var loc = _("locationupdate").value;
	var u = "<?php echo $u;?>";
	var log_u = "<?php echo $log_username;?>";
	if(loc != ""){
		document.getElementById("changeLocationDiv").style.display = 'block';
		var ajax = ajaxObj("POST", "_parse/_all_edits.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "update_failed"){
					Alert.render("Location update was unsuccessful");
					document.getElementById("changeLocationDiv").style.display = 'none';
				}else {
					document.getElementById("changeLocationDiv").style.display = 'none';
					if(u == log_u){
						$(".locationtext").html(ajax.responseText);
					}
					document.getElementById("locationupdate").value = "";
					$("#changeLocation").hide(0);
				}
	        }
        }
		ajax.send("action=loc_update&loc="+encodeURIComponent(loc));
	}else{
		return false;
	}
}
</script>