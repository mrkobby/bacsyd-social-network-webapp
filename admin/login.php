<?php 
include_once("_admin_ext/admin_check_status.php");
if($id_ok == true){
	header("location: user.php?vid=".$_SESSION["vid"]);
    exit();
}
?><?php
if(isset($_POST["vid"])){
	include_once("_admin_ext/admin_db_connection.php");
	$vid = preg_replace('#[^a-z0-9]#i', '', md5($_POST['vid']));
	$pass = md5($_POST['pass']);
	
	if($vid == "" || $pass == ""){
		echo "signin_failed";
        exit();
	} else {
		$wsql = "SELECT id, vid, password FROM admin WHERE vid='$vid' LIMIT 1";
        $wquery = mysqli_query($db_connection, $wsql);
        $row = mysqli_fetch_row($wquery);
		$v_id = $row[0];
		$v_vid = $row[1];
        $v_pass_str = $row[2];
		if($pass != $v_pass_str){
			echo "signin_failed";
            exit();
		} else {
			$_SESSION['id'] = $v_id;
			$_SESSION['vid'] = $v_vid;
			$_SESSION['pass'] = $v_pass_str;
			echo $v_vid;
		    exit();
		}
	}
	exit();
}
mysqli_query($db_connection, "UPDATE _userinfo SET status='offline' WHERE lastlogin < DATE_ADD(NOW(),INTERVAL -1 DAY)");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Bacsyd - ADMIN</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php include_once("_admin_ext/all-css.php");?>
</head>
<body class="hold-transition skin-blue fixed color-anime">
<div class="login-box">
	<div class="register-logo">
		<span class="hand" onclick="window.location = '../';"><img style="width:130px;" src="../_ast/_img/new_bacsyd.png"></span>
	</div>
	<div class="login-box-body">
		<p class="carousel headline slide" id="headline">
			<div id="intro" class="carousel-inner slide" style="text-align: center;">
				<div class="item active">
					<span>Sign in to start your session</span>
				</div>	
			</div>
		</p>
		<form role="form" id="login" class="text-center" onSubmit="return false;">
			<div class="form-group has-feedback">
				<input type="password" style="border:1px solid black;" class="form-control" placeholder="ID" id="vid" onfocus="emptyElement('status')" onkeyup="restrict('vid')" onpaste="return false" />
				<span class="fa fa-user form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<input type="password" style="border:1px solid black;" class="form-control" placeholder="Password" id="password-in" onfocus="emptyElement('status')" placeholder="Password" onpaste="return false" />
				<span class="fa fa-lock form-control-feedback"></span>
			</div>
			<div class="row" id="loginbtn">
				<div class="col-xs-12">
					<button type="submit" class="btn btn-primary btn-block btn-flat" onclick="login()">Login</button>
				</div>
			</div>
			<span id="status"></span>
		</form>
	</div>
</div>

<script src="../_ast/_js/_query.js"></script>
<script src="../_ast/_js/_scroll.js"></script>
<script src="../_ast/_js/_nscroll.js"></script>
<script src="../_ast/_js/_script.js"></script>
<script src="../_ast/_js/_ajax.js"></script>
<script src="../_ast/_js/_main.js"></script>
<script src="../_ast/_js/_autoscroll.js"></script>
<script type="text/javascript">
function restrict(elem){
	var tf = _(elem);
	var rx = new RegExp;
	if(elem == "vid"){
		rx = /[^0-9mtc]/gi;
	}
	tf.value = tf.value.replace(rx, "");
}
function emptyElement(x){
	_(x).innerHTML = "";
	_("loginbtn").style.display = "block";
	_("vid").style.borderColor = "black";
	_("password-in").style.borderColor = "black";
}
function showButton(){
	_("loginbtn").style.display = "block";
	_("status").innerHTML = "";
}
function login(){
	var vid = _("vid").value;
	var pass = _("password-in").value;
	if(vid == ""){
		_("status").innerHTML = '<div class="alert bg-primary"><button type="button" onclick="showButton()" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please fill out all of the form data</div>';
		_("loginbtn").style.display = "none";
		_("vid").style.borderColor = "red";
	} else if(pass == ""){
		_("status").innerHTML = '<div class="alert bg-primary"><button type="button" onclick="showButton()" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please fill out all of the form data</div>';
		_("loginbtn").style.display = "none";
		_("password-in").style.borderColor = "red";
	}else {
		_("loginbtn").style.display = "none";
		_("status").innerHTML = '<div class="preloader pl-size-xs"><div class="spinner-layer pl-red"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
		var ajax = ajaxObj("POST", "login.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText == "signin_failed"){
					_("status").innerHTML = '<div class="alert bg-maroon"><button type="button" onclick="showButton()" class="close" data-dismiss="alert" aria-hidden="true">×</button>Login unsuccessful</div>';
					_("loginbtn").style.display = "none";
				} else {
					window.location = "user.php?vid="+ajax.responseText;
				}
	        }
        }
        ajax.send("vid="+vid+"&pass="+pass);
	}
}
</script>
</body>
</html>
