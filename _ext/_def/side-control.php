<?php 
if($privacy == '1'){
	$privatecheck = '<label class="control-sidebar-subheading checkbox_container"><input onclick="privacyToggle(\'uncheck\',\'privacyCheckBox\')" type="checkbox" class="pull-right" checked><span class="checkmark"></span>Private account</label>';
}else if($privacy == '0'){
	$privatecheck = '<label class="control-sidebar-subheading checkbox_container"><input onclick="privacyToggle(\'check\',\'privacyCheckBox\')" type="checkbox" class="pull-right"><span class="checkmark"></span>Private account</label>';
}
?>
<aside class="control-sidebar control-sidebar-dark">
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-user"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading" style="margin: 5px 0px 5px 0px;text-align: center;">Security Settings</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)" pd-popup-open="changePass">
              <i class="menu-icon fa fa-lock bg-red"></i>
              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Change password</h4>
                <p>•••••</p>
              </div>
            </a>
          </li>
        </ul>
		<h3 class="control-sidebar-heading" style="margin: 20px 0px 5px 0px;text-align: center;">General Settings</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)" pd-popup-open="changeFname">
              <i class="menu-icon fa fa-user bg-blue"></i>
              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Edit firstname</h4>
                <p><span class="fnametext"><?php echo $firstname; ?></span></p>
              </div>
            </a>
          </li>
		  <li>
            <a href="javascript:void(0)" pd-popup-open="changeLname">
              <i class="menu-icon fa fa-user bg-green"></i>
              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Edit lastname</h4>
                <p> <span class="lnametext"><?php echo $lastname; ?></span></p>
              </div>
            </a>
          </li><li>
            <a href="javascript:void(0)" pd-popup-open="changeEmail">
              <i class="menu-icon fa fa-envelope bg-yellow"></i>
              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Change email</h4>
                <p> <span class="emailtext"><?php echo $email; ?></span></p>
              </div>
            </a>
          </li>
        </ul>
      </div>
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading" style="margin: 5px 0px 10px 0px;text-align: center;">Account Settings</h3>
          <div class="form-group" id="privacyCheckBox">
			<?php echo $privatecheck;?>
          </div>
		  <div class="form-group">
			 <label class="control-sidebar-subheading checkbox_container">
			  <input type="checkbox" class="pull-right" checked disabled>
			  <span class="checkmark"></span>
              Show me as online
            </label>
          </div>
          <div class="form-group">
		    <label class="control-sidebar-subheading checkbox_container">
			  <input type="checkbox" class="pull-right" checked disabled>
			  <span class="checkmark"></span>
              Turn off notifications
            </label>
          </div>
        </form>
      </div>
    </div>
  </aside>
  <div class="control-sidebar-bg"></div>
  
<script type="text/javascript">
function privacyToggle(type,elem){
	_(elem).innerHTML = '<label class="control-sidebar-subheading checkbox_container"><input type="checkbox" class="pull-right" disabled><span class="checkmark"></span>Private account</label>';
	var ajax = ajaxObj("POST", "_parse/_set_private_account.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "check_ok"){
				_(elem).innerHTML = '<label class="control-sidebar-subheading checkbox_container"><input onclick="privacyToggle(\'uncheck\',\'privacyCheckBox\')" type="checkbox" class="pull-right" checked><span class="checkmark"></span>Private account</label>';
			} else if(ajax.responseText == "uncheck_ok"){
				_(elem).innerHTML = '<label class="control-sidebar-subheading checkbox_container"><input onclick="privacyToggle(\'check\',\'privacyCheckBox\')" type="checkbox" class="pull-right"><span class="checkmark"></span>Private account</label>';
			} else {
				return false;
			}
		}
	}
	ajax.send("type="+type);
}
</script>