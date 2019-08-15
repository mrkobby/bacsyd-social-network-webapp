<?php
	include_once("../_sys/check_login_status.php");
	if($user_ok == false){
		header("location: ../bacsyd");
		exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $log_username; ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   <link rel="stylesheet" href="../_ast/_css/_strap.css">
   <link rel="stylesheet" href="../_ast/_css/_lte.css">
   <link rel="stylesheet" href="../_ast/_css/_mtc.css">
</head>
<body class="hold-transition login-page color-anime">
<div class="login-box">
	<div class="register-logo">

	</div>
	<div class="login-box-body">
		<h4 class="login-box-msg">Error 403 - Access Forbidden!</h4>
		<p class="login-box-msg">Click back to navigate back to your previous session.</p>
		<div class="alq dj j">
			<div class="row">
				<div class="col-xs-12">
					<button class="btn btn-primary btn-block btn-flat" onclick="window.history.go(-1);" onclick="return false;">Back</button>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>