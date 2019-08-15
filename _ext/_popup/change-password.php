<div class="popup" id="changePass" pd-popup="changePass">
	<div class="popup-inner">
	<div id="changePassDiv" style="display: none; z-index:99999; text-align: center;position: absolute;background: rgba(60, 57, 57, 0.85);width: 100%;height: 100%;font-size: 22px;color: #fff;left:0px;top:0px;line-height: 100px;">Please wait...</div>
		<div class="box-header">
			<i class="fa fa-lock"></i>
			<h4 class="box-title">Change password</h4>
		</div>
		<div class="box-body">
			<div class="box box-primary">
				<div class="box-body no-padding" style="margin-bottom: 5px;">
					<form role="form" method="post" id="editPass" onSubmit="return false;">
						<div class="form-group has-feedback">
							<input type="password" class="form-control" name="oldpass" id="oldpass" placeholder="Old password" onpaste="return false"/>
							<a class="fa fa-eye-slash hand form-control-feedback"></a>
						</div>
						<div class="form-group input-group">
							<input type="password" class="form-control" name="newpass1" id="newpass1" placeholder="New password" onpaste="return false"/>		
							<span class="input-group-btn">
								<button id="toggleBtn" class="btn btn-primary btn-flat" onclick="togglePassword()"><i class="fa fa-eye"></i></button>
						    </span>
						</div>
						<div class="form-group has-feedback">
							<input type="password" class="form-control" name="newpass2" id="newpass2" placeholder="Re-type new password" onpaste="return false"/>
							<a class="fa fa-eye-slash hand form-control-feedback"></a>
						</div>
					</form>			
				</div>
				<div class="box-footer no-padding">
				    <a href="javascript:void(0)" onclick="updatePassword()" class="btn btn-primary pull-right">Save</a>
					<a pd-popup-close="changePass" id="cancelPassBtn" href="javascript:void(0)" class="btn btn-default pull-left">Cancel</a>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(e){
	$("#cancelPassBtn").click(function(){
		document.getElementById("oldpass").value = "";
		document.getElementById("newpass1").value = "";
		document.getElementById("newpass2").value = "";
	});
})
function togglePassword() {
	var npass = document.getElementById('newpass1');
	var toggleBtn = document.getElementById('toggleBtn');
	if(npass.type == "password"){
		npass.type = "text";
		toggleBtn.innerHTML = '<i class="fa fa-eye-slash"></i>';
	} else {
		npass.type = "password";
		toggleBtn.innerHTML = '<i class="fa fa-eye"></i>';
	}
}
function updatePassword(){
	Confirm.render("You will need to re-login after changing of your password. Do you want to proceed?");
	Confirm.yes = function(){
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverlay').style.display = "none";
		var op = _("oldpass").value;
		var np1 = _("newpass1").value;
		var np2 = _("newpass2").value;
		if(op == "" || np1 == "" || np2 == ""){
			Alert.render('Please enter passwords');
		} else if(np1 != np2){
			Alert.render('Your new passwords do not match');
		} else {
			document.getElementById("changePassDiv").style.display = 'block';
			var ajax = ajaxObj("POST", "_parse/_all_edits.php");
			ajax.onreadystatechange = function() {
				if(ajaxReturn(ajax) == true) {
					if(ajax.responseText != "security_success"){
						Alert.render(ajax.responseText);
						document.getElementById("changePassDiv").style.display = 'none';
					} else {
						document.getElementById("changePassDiv").style.display = 'none';
						$("#changePass").fadeOut(100);
						Hint.render("Password changed");
						window.location = "home&<?php echo $log_username ?>";
					}
				}
			}
			ajax.send("action=pass_update&op="+encodeURIComponent(op)+"&np1="+encodeURIComponent(np1)+"&np2="+encodeURIComponent(np2));
		}
	}
	Confirm.no = function(){
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverlay').style.display = "none";
		document.getElementById("oldpass").value = "";
		document.getElementById("newpass1").value = "";
		document.getElementById("newpass2").value = "";
		$("#changePass").fadeOut(100);
	}
}
</script>