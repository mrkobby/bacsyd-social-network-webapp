<?php
include_once("_sys/check_login_status.php");
if($user_ok == true){
	header("location: home&".$_SESSION["username"]);
    exit();
}
?><?php
if(isset($_POST["e"])){
	$e = mysqli_real_escape_string($db_connection, $_POST['e']);
	$sql = "SELECT id, username FROM _users WHERE BINARY email = BINARY '$e'";
	$query = mysqli_query($db_connection, $sql);
	$numrows = mysqli_num_rows($query);
	if($numrows > 0){
		echo $e;
		exit();
    } else {
        echo "email_failed";
		exit();
    }
	exit();
}
?><?php
if(isset($_POST['uname']) && isset($_POST['email'])){
	$uname = preg_replace('#[^a-z0-9-]#i', '', $_POST['uname']);
	$mail = mysqli_real_escape_string($db_connection, $_POST['email']);
	$qstring = "";
	$sql = "SELECT id, username FROM _users WHERE BINARY email = BINARY '$mail' AND BINARY username = BINARY '$uname' LIMIT 1";
	$query = mysqli_query($db_connection, $sql);
	$numrows = mysqli_num_rows($query);
	if($numrows > 0){
		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$uid = $row["id"];
			$username = $row["username"];
			
			$osql = "SELECT * FROM _usersecurity WHERE id='$uid' AND username='$username' LIMIT 1";
			$oquery = mysqli_query($db_connection, $osql);
			while ($row = mysqli_fetch_array($oquery, MYSQLI_ASSOC)) {
				$xquestion = $row["xquestion"];
				$xanswer = $row["xanswer"];
				$yanswer = $row["yanswer"];
				$yquestion = $row["yquestion"];
				
				if($xquestion == "" || $xanswer == "" || $yanswer == "" || $yquestion == ""){
					$qstring .= "no_security|$xquestion|$yquestion|||";
					$qstring = trim($qstring, "|||");
					echo $qstring;
					exit();
				}else{
					$qstring .= "success|$xquestion|$yquestion|||";
					$qstring = trim($qstring, "|||");
					echo $qstring;
					exit();
				}
			}
		}
    } else {
		echo "not_exist";
		exit();
    }
	exit();
}
?><?php
if(isset($_POST['xa']) && isset($_POST['username'])){
	$xa = $_POST['xa'];
	$ya = $_POST['ya'];
	$user = preg_replace('#[^a-z0-9-]#i', '', $_POST['username']);
	$sql = "SELECT * FROM _usersecurity WHERE BINARY username = BINARY '$user'";
	$query = mysqli_query($db_connection, $sql);
	$numrows = mysqli_num_rows($query);
	if($numrows > 0){
		$xtrue = false;
		$ytrue = false;
		$x_check = "SELECT id FROM _usersecurity WHERE xanswer='$xa' AND username='$user'";
		if(mysqli_num_rows(mysqli_query($db_connection, $x_check)) > 0){
			$xtrue = true;
		}
		$y_check = "SELECT id FROM _usersecurity WHERE yanswer='$ya' AND username='$user'";
		if(mysqli_num_rows(mysqli_query($db_connection, $y_check)) > 0){
			$ytrue = true;
		}			
		if($xtrue == true && $ytrue == true){
			 echo "success";
			 exit();
		}else{
			echo "question_failed";
			exit();
		}
	}
}

?><?php
if(isset($_POST["np1"]) && isset($_POST["username"])){
	$np1 = $_POST['np1'];
	$np2 = $_POST['np2'];
	$username = $_POST['username'];
	if($np1 == "" || $np2 == ""){
		echo "Please fill all password fields";
		exit();
	} else if ($np1 != $np2) {
        echo "Your passwords do not match";
        exit(); 
    } else if (strlen($np1) < 6) {
        echo "Password is too short. Try 6 or more characters";
        exit(); 
    } else {
		$np_hash = md5($np1);
		$sql = "UPDATE _users SET password='$np_hash' WHERE username='$username'";
		$query = mysqli_query($db_connection, $sql);	
		echo "reset_success";
		exit();
	}
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="You can reset your password with security questions provided by R A V E N, or an email can be send to you with your username and a link to reset your password." />
  <meta name="keywords" content="Bacsyd,bacsyd,forgot password,Bacsydreset,reset password,www.bacsyd.com,the bacsyd,bacsydsocial,bacsyd social,kwabena aboagye dougan,bacsyd.com" />
  <title>Bacsyd</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php include_once("_ext/_def/all-css.php");?>
</head>
<body class="hold-transition skin-blue fixed color-anime">
<div id="relax" style="display: none;opacity: .8;position: fixed;font-size: 22px;color: #fff;top: 0px;left: 0px;background: #363636;width: 100%;height: 100%;z-index: 99999;line-height: 400px;text-align: center;">Please wait...</div>
<?php include_once("_ext/_def/bd-load.php");?>
<?php include_once("_ext/_def/bd-load-starter.php");?>
<div class="login-box">
	<div class="register-logo">
		<span class="hand" onclick="bacsydhome()" style="font-weight: bold;color: #01496e;"><img style="width:130px;" src="_ast/_img/new_bacsyd.png"></span>
	</div>
	<div class="login-box-body">
		<p id="steps" class="login-box-msg"><b>Step 1: Enter your email address that you used to register.<!-- We'll send you an email with your username and a link to reset your password.--></b></p>
		
		<div id="forgotpassform">
			<form role="form" class="text-center" onSubmit="return false;">
				<div class="form-group has-feedback">
					<input type="text" style="border:1px solid black;" class="form-control" placeholder="Email" id="email" onfocus="emptyElement('status','emailpassbtn')" onkeyup="restrict('email')">
					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<button type="submit" id="emailpassbtn" class="btn btn-primary btn-block btn-flat" onclick="emailpass()">Next</button>
						<span id="status"></span>
					</div>
					<br><br><br>
					<div class="col-xs-12 text-center">
						<?php include_once("_ext/_strt/_strt-up-btm.php");?>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

<script src="_ast/_js/_query.js"></script>
<script src="_ast/_js/_strap.js"></script>
<script src="_ast/_js/_scroll.js"></script>
<script src="_ast/_js/_nscroll.js"></script>
<script src="_ast/_js/_ajax.js"></script>
<script src="_ast/_js/_main.js"></script>
<script src="_ast/_js/_autoscroll.js"></script>
<script type="text/javascript">
function restrict(elem){
	var tf = _(elem);
	var rx = new RegExp;
	if(elem == "email"){
		rx = /[' "]/gi;
	} else if(elem == "uname"){
		rx = /[^a-z0-9]/gi;
	}
	tf.value = tf.value.replace(rx, "");
}
function emptyElement(x,y){
	_(x).innerHTML = "";
	_(y).style.display = "block";
}
function showButton(button){
	_(button).style.display = "block";
}
function emailpass(){
	var e = _("email").value;
	if(e == ""){
		_("status").innerHTML = '<div class="alert bg-primary"><button type="button" onclick="showButton(\'emailpassbtn\')" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please enter email address</div>';
		_("emailpassbtn").style.display = "none";
	} else {
		_("emailpassbtn").style.display = "none";
		_("status").innerHTML = '<div class="preloader pl-size-xs"><div class="spinner-layer pl-black"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
		var ajax = ajaxObj("POST", "reset.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "email_failed"){
					_("status").innerHTML = '<div class="alert bg-maroon"><button type="button" onclick="showButton(\'emailpassbtn\')" class="close" data-dismiss="alert" aria-hidden="true">×</button>Sorry, this email address is not in our database</div>';
					_("emailpassbtn").style.display = "none";
				} else {
					var email = ajax.responseText;
					window.scrollTo(0,0);
					_("steps").innerHTML = "<b>Step 2: Enter your username</b>";
					_("forgotpassform").innerHTML = '<form role="form" class="text-center" onSubmit="return false;">'+
													'<div id="unameinput" class="form-group has-feedback">'+
													'<input type="text" style="border:1px solid black;" class="form-control" onkeyup="restrict(\'uname\')" onfocus="emptyElement(\'status2\',\'unamepassbtn\')" placeholder="Username" id="uname">'+
													'<span class="glyphicon glyphicon-user form-control-feedback"></span>'+
													'</div>'+
													'<div class="row">'+
													'<div class="col-xs-12" id="unamepassbtn">'+
													'<div class="pull-left" style="width:28%;" onclick="reset()"><button type="button" class="btn btn-info btn-block">Cancel</button></div>'+
													'<div class="pull-right" style="width:68%;"><button type="submit" class="btn btn-primary btn-block btn-flat" onclick="unamepass(\''+email+'\')">Next</button></div>'+
													'</div><span id="status2"></span>'+
													'</div></form>';
				}
	        }
        }
        ajax.send("e="+e);
	}
}
function unamepass(email){
	var uname = _("uname").value;
	if(uname == "" || email == ""){
		_("status2").innerHTML = '<div class="alert bg-primary"><button type="button" onclick="showButton(\'unamepassbtn\')" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please enter your username</div>';
		_("unamepassbtn").style.display = "none";
	} else {
		_("unamepassbtn").style.display = "none";
		_("status2").innerHTML = '<div class="preloader pl-size-xs"><div class="spinner-layer pl-black"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
		var ajax = ajaxObj("POST", "reset.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "not_exist"){
					_("status2").innerHTML = '<div class="alert bg-maroon"><button type="button" onclick="showButton(\'unamepassbtn\')" class="close" data-dismiss="alert" aria-hidden="true">×</button>Sorry, username does not match email</div>';
					_("unamepassbtn").style.display = "none";
				}else{	
					var qstring = ajax.responseText.split("|||");
					for (var i = 0; i < qstring.length; i++){
						var string = qstring[i].split("|");		
					}
					var text = string[0];
					if(text == "no_security"){
						_("steps").style.display = "none";
						_("forgotpassform").innerHTML = 'Sorry, we cannot proceed from here. You did not set-up any password recovery security questions for your account. '+
													'There might be another way recovery your password. Contact developer for more info. '+
													'<br><br> <b>Mobile: +233-54-911-2267 <br />Tel: +233-20-901-3836 </b><br><br><br>'+
													'<button type="submit" class="btn btn-primary btn-block btn-flat" onclick="bacsydhome()">Okay</button>';
					}else{
						var xquestion = string[1];
						var yquestion = string[2];
						window.scrollTo(0,0);
						_("steps").innerHTML = "<b>Step 3: Answer security questions</b>";
						_("forgotpassform").innerHTML = '<form role="form" class="text-center" onSubmit="return false;">'+
														'<div class="fa-1x" style="color:#000;padding:5px;">'+xquestion+'</div>'+
														'<div class="form-group has-feedback">'+
														'<input type="text" style="border:1px solid black;" onfocus="emptyElement(\'status3\',\'questionpassbtn\')" class="form-control" placeholder="Answer" id="xanswer">'+
														'</div>'+
														'<div class="fa-1x" style="color:#000;padding:5px;">'+yquestion+'</div>'+
														'<div class="form-group has-feedback">'+
														'<input type="text" style="border:1px solid black;" onfocus="emptyElement(\'status3\',\'questionpassbtn\')" class="form-control" placeholder="Answer" id="yanswer">'+
														'</div>'+
														'<div class="row">'+
														'<div class="col-xs-12" id="questionpassbtn">'+
														'<div class="pull-left" style="width:28%;" onclick="reset()"><button type="button" class="btn btn-info btn-block">Cancel</button></div>'+
														'<div class="pull-right" style="width:68%;"><button type="submit" class="btn btn-primary btn-block btn-flat" onclick="questionpass(\''+uname+'\',\''+xquestion+'\',\''+yquestion+'\')">Almost Done</button></div>'+
														'</div><span id="status3"></span>'+
														'</div></form>';
					}
				}	
	        }
        }
        ajax.send("uname="+uname+"&email="+email);
	}
}
function questionpass(username,qx,qy,qz){
	var xa = _("xanswer").value;
	var ya = _("yanswer").value;
	if(xa == "" || ya == "" || username == ""){
		_("status3").innerHTML = '<div class="alert bg-primary"><button type="button" onclick="showButton(\'questionpassbtn\')" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please fill out all of the form data</div>';
		_("questionpassbtn").style.display = "none";
	} else {
		_("questionpassbtn").style.display = "none";
		_("status3").innerHTML = '<div class="preloader pl-size-xs"><div class="spinner-layer pl-black"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
		_("relax").style.display = "block";
		var ajax = ajaxObj("POST", "reset.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "question_failed"){
					_("status3").innerHTML = '<div class="alert bg-maroon"><button type="button" onclick="showButton(\'questionpassbtn\')" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Sorry, incorrect answer(s)</b></div>';
					_("questionpassbtn").style.display = "none";
					_("relax").style.display = "none";
				} else {
					window.scrollTo(0,0);
					_("relax").style.display = "none";
					_("steps").innerHTML = "You can now reset your password</b>";
					_("forgotpassform").innerHTML = '<form role="form" class="text-center" onSubmit="return false;">'+
													'<div class="form-group has-feedback">'+
													'<input type="password" style="border:1px solid black;" onfocus="emptyElement(\'status5\',\'resetpassbtn\')" class="form-control" placeholder="New Password" id="pass1" onpaste="return false"/>'+
													'<span class="glyphicon glyphicon-lock form-control-feedback"></span>'+
													'</div>'+
													'<div class="form-group has-feedback">'+
													'<input type="password" style="border:1px solid black;" onfocus="emptyElement(\'status5\',\'resetpassbtn\')" class="form-control" placeholder="Re-type New Password" id="pass2" onpaste="return false"/>'+
													'<span class="glyphicon glyphicon-lock form-control-feedback"></span>'+
													'</div>'+
													'<div class="row">'+
													'<div class="col-xs-12" id="resetpassbtn">'+
													'<div class="pull-left" style="width:28%;" onclick="reset()"><button type="button" class="btn btn-info btn-block">Cancel</button></div>'+
													'<div class="pull-right" style="width:68%;"><button type="submit" class="btn btn-success btn-block btn-flat" onclick="resetpass(\''+username+'\')">Finish</button></div>'+
													'</div><span id="status5"></span>'+
													'</div></form>';
				}
	        }
        }
        ajax.send("xa="+encodeURIComponent(xa)+"&ya="+encodeURIComponent(ya)+"&username="+username);
	}
}
 function resetpass(username){
	var np1 = _("pass1").value;
	var np2 = _("pass2").value;
	var status = _("status5");
	if(np1 == "" || np2 == ""){
		status.innerHTML = '<div class="alert bg-primary"><button type="button" onclick="showButton(\'resetpassbtn\')" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please enter new passwords</div>';
		_("resetpassbtn").style.display = "none";
	} else if(np1 != np2){
		status.innerHTML = '<div class="alert bg-maroon"><button type="button" onclick="showButton(\'resetpassbtn\')" class="close" data-dismiss="alert" aria-hidden="true">×</button>Your new passwords do not match</div>';
		_("resetpassbtn").style.display = "none";
	} else {
		_("resetpassbtn").style.display = "none";
		status.innerHTML = '<div class="preloader pl-size-xs"><div class="spinner-layer pl-blue"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
		_("relax").style.display = "block";
		var ajax = ajaxObj("POST", "reset.php");
		ajax.onreadystatechange = function() {
			if(ajaxReturn(ajax) == true) {
				if(ajax.responseText != "reset_success"){
					status.innerHTML = '<div class="alert bg-maroon"><button type="button" onclick="showButton(\'resetpassbtn\')" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+ajax.responseText+'</div>';
					_("resetpassbtn").style.display = "none";
					_("relax").style.display = "none";
				} else {
					_("resetpassbtn").style.display = "none";
					status.innerHTML = '<div class="preloader pl-size-xs"><div class="spinner-layer pl-grey"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
					window.location = "../bacsyd";
				}
			}
		}
		ajax.send("np1="+encodeURIComponent(np1)+"&np2="+encodeURIComponent(np2)+"&username="+username);
	}
}
</script>
</body>
</html>
