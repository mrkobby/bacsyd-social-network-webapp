<div class="popup" id="changeEmail" pd-popup="changeEmail">
	<div class="popup-inner">
		<div id="changeEmailDiv" style="display: none; z-index:99999; text-align: center;position: absolute;background: rgba(60, 57, 57, 0.85);width: 100%;height: 100%;font-size: 22px;color: #fff;left:0px;top:0px;line-height: 100px;">Please wait...</div>
		<div class="box-header">
			<i class="fa fa-envelope"></i>
			<h4 class="box-title">Change email</h4>
			<h6 class="text-muted">Current email address: <span class="emailtext"><?php echo $email;?></span></h6>
		</div>
		<div class="box-body">
			<div class="box box-primary">
				<div class="box-body no-padding" style="margin-bottom: 5px;">
					<form role="form" method="post" id="editEmail" onSubmit="return false;">
						<input type="text" class="form-control" placeholder="Enter new email address" 
						name="emailupdate" id="emailupdate" onkeyup="restrictEmail('emailupdate')" />
					</form>			
				</div>
				<div class="box-footer no-padding" id="emaileditfooter">
				    <a href="javascript:void(0)" onclick="updateEmail()" class="btn btn-primary pull-right">Save</a>
					<a pd-popup-close="changeEmail" href="javascript:void(0)" class="btn btn-default pull-left">Cancel</a>
				</div>
				<span id="emailfooterloader" style="display:none;"><div class="preloader pl-size-xs"><div class="spinner-layer pl-red"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div></span>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
function restrictEmail(elem){
	var tf = _(elem);
	var rx = new RegExp;
	if(elem == "emailupdate"){
		rx = /[' "]/gi;
	}
	tf.value = tf.value.replace(rx, "");
}
function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}
function updateEmail(){
	var e = _("emailupdate").value;
	var u = "<?php echo $u;?>";
	var log_u = "<?php echo $log_username;?>";
	if(e == ""){
		return false;
	}else if(!validateEmail(e)){
		Alert.render("Your email is invalid");
	}else {
		document.getElementById("changeEmailDiv").style.display = 'block';
		_("emaileditfooter").style.display = "none";
		_("emailfooterloader").style.display = "block";
		var ajax = ajaxObj("POST", "_parse/_all_edits.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "update_failed"){
					Alert.render("Email update was unsuccessful");
					_("emaileditfooter").style.display = "block";
					_("emailfooterloader").style.display = "none";
					document.getElementById("changeEmailDiv").style.display = 'none';
				}else if(ajax.responseText == "same_email"){
					Alert.render("Email already exists");
					_("emaileditfooter").style.display = "block";
					_("emailfooterloader").style.display = "none";
					document.getElementById("changeEmailDiv").style.display = 'none';
				}else {
					document.getElementById("changeEmailDiv").style.display = 'none';
					if(u == log_u){
						$(".emailtext").html(ajax.responseText);
					}
					document.getElementById("emailupdate").value = "";
					$("#changeEmail").hide(0);
					_("emaileditfooter").style.display = "block";
					_("emailfooterloader").style.display = "none";
				}
	        }
        }
		ajax.send("action=e_update&e="+e);
	}
}
</script>