<?php
$message = "No message";
if(isset($_GET["msg"])){
	$msg = preg_replace('#[^a-z 0-9.:_()]#i', '', $_GET['msg']);
}
if($msg == "activation_failure"){
	$message = '<h2>Activation Error</h2> Sorry there seems to have been an issue activating your account at this time. We have already notified ourselves of this issue and we will contact you via email when we have identified the issue.';
} else if($msg == "missing_GET_variables"){
	$message = '<h2>Activation Error</h2> Unable to get some variables. Please try again';
} else {
	$message = $msg;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Bacsyd</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link href="../_ast/_img/bacsyd_icon.png" rel="icon" /> 
  <link rel="stylesheet" href="../_ast/_css/_strap.css">
  <link rel="stylesheet" href="../_ast/_css/_fa.css">
  <link rel="stylesheet" href="../_ast/_css/_ics.css">
  <link rel="stylesheet" href="../_ast/_css/_lte.css">
  <link rel="stylesheet" href="../_ast/_css/_mtc.css">
  <link rel="stylesheet" href="../_ast/_css/_skin.css">
</head>
<body class="hold-transition login-page color-anime">
<div class="login-box">
	<div class="register-logo">
		<span class="hand" onclick="window.location = 'http://www.bacsyd.com';"><img style="width:130px;" src="../_ast/_img/new_bacsyd.png"></span>
	</div>
	<div class="login-box-body">
		<h4 class="login-box-msg"><div><?php echo $message; ?></div></h4>
		<div class="alq dj j">
			<div class="row">
				<div class="col-xs-12">
					<button class="btn btn-primary btn-block btn-flat" onclick="window.location = 'http://www.bacsyd.com';" onclick="return false;">Ok</button>
				</div>
				<br><br><span id="status"></span>
			</div>
		</div>
  </div>
</div>
<script src="../_ast/_js/_main.js"></script>
</body>
</html>