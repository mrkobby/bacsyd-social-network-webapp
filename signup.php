<?php 
include_once("_sys/check_login_status.php");
if($user_ok == true){
	header("location: home&".$_SESSION["username"]);
    exit();
}
?><?php
if(isset($_POST["usernamecheck"])){
	include_once("_sys/db_connection.php");
	$username = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);
	$sql = "SELECT id FROM _users WHERE username='$username'";
    $query = mysqli_query($db_connection, $sql); 
    $uname_check = mysqli_num_rows($query);
    if (strlen($username) < 3 || strlen($username) > 16) {
	    echo '<span style="color:rgb(192, 41, 41);"><b>Too short</b></span>';
	    exit();
    }if (is_numeric($username[0])) {
	    echo '<span style="color:rgb(192, 41, 41);"><b>Begin with a letter</b></span>';
	    exit();
    }if ($uname_check < 1) {
	    echo '<span style="color:#009900;">Cool name &nbsp;<span class="fa fa-user"></span></span>';
	    exit();
    } else {
	    echo '<span style="color:rgb(192, 41, 41);">already exists &nbsp;<span class="fa fa-user"></span></span>';
	    exit();
    }
}
if(isset($_POST["u"])){	
	include_once("_sys/db_connection.php");	
	$_SESSION['f'] = $f = preg_replace('#[^a-z ]#i', '', $_POST['f']);
	$_SESSION['l'] = $l = preg_replace('#[^a-z ]#i', '', $_POST['l']);
	$_SESSION['u'] = $u = preg_replace('#[^a-z0-9]#i', '', $_POST['u']);
	
	$sql = "SELECT id FROM _users WHERE username='$u'";
    $query = mysqli_query($db_connection, $sql); 
	$u_check = mysqli_num_rows($query);

	$userstring = "";
	
	if($u == ""){
		echo 'The form submission is missing values';
        exit();
	} else if ($u_check > 0){ 
        echo 'Username already exists';
        exit();
	}else if (strlen($u) < 3 || strlen($u) > 16) {
        echo 'Username must be between 3 and 16 characters';
        exit(); 
    } else if (is_numeric($u[0])) {
        echo 'Username cannot begin with a number';
        exit();
    } else {		
		$userstring .= "success|$f|$l|$u|||";
		$userstring = trim($userstring, "|||");
		echo $userstring;
		exit();
	}
	exit();
}
if(isset($_POST["uname"])){	
	$_SESSION['f'] = $fname = preg_replace('#[^a-z ]#i', '', $_POST['f']);
	$_SESSION['l'] = $lname = preg_replace('#[^a-z ]#i', '', $_POST['l']);
	$_SESSION['uname'] = $uname = preg_replace('#[^a-z0-9]#i', '', $_POST['uname']);
	$_SESSION['e'] = $email = mysqli_real_escape_string($db_connection, $_POST['e']);
	$_SESSION['p'] = $pass = $_POST['p'];
	$_SESSION['g'] = $gender = preg_replace('#[^a-z ]#i', '', $_POST['g']);
	
	$sql = "SELECT id FROM _users WHERE username='$uname'";
    $query = mysqli_query($db_connection, $sql); 
	$u_check1 = mysqli_num_rows($query);

	$sql = "SELECT id FROM _users WHERE email='$email'";
    $query = mysqli_query($db_connection, $sql); 
	$e_check1 = mysqli_num_rows($query);

	$userstring2 = "";
	
	if($uname == "" || $email == "" || $pass == "" || $gender == "Gender:"){
		echo 'The form submission is missing values';
        exit();
	} else if ($u_check1 > 0){ 
        echo 'Username already exists';
        exit();
	} else if ($e_check1 > 0){ 
        echo 'Email address is already in use';
        exit();
	} else if (strlen($uname) < 3 || strlen($uname) > 16) {
        echo 'Username must be between 3 and 16 characters';
        exit(); 
    } else if (is_numeric($uname[0])) {
        echo 'Username cannot begin with a number';
        exit();
    }else if (strlen($pass) < 6) {
        echo "Password is too short. Try 6 or more characters";
        exit(); 
    } else {		
		$p_hash = md5($pass);	
		$userstring2 .= "success|$fname|$lname|$uname|$email|$gender|$p_hash|||";
		$userstring2 = trim($userstring2, "|||");
		echo $userstring2;
		exit();
	}
	exit();
}
?><?php
if(isset($_POST["q1"])){	
	$_SESSION['fo'] = $fo = preg_replace('#[^a-z ]#i', '', $_POST['fo']);
	$_SESSION['lo'] = $lo = preg_replace('#[^a-z ]#i', '', $_POST['lo']);
	$_SESSION['uo'] = $uo = preg_replace('#[^a-z0-9]#i', '', $_POST['uo']);
	$_SESSION['eo'] = $eo = mysqli_real_escape_string($db_connection, $_POST['eo']);
	$_SESSION['po'] = $po = $_POST['po'];
	$_SESSION['go'] = $go = preg_replace('#[^a-z ]#i', '', $_POST['go']);
	
	$_SESSION['a1'] = $a1 = $_POST['a1'];
	$_SESSION['a2'] = $a2 = $_POST['a2'];
	
	$_SESSION['q1'] = $q1 = $_POST['q1'];
	$_SESSION['q2'] = $q2 = $_POST['q2'];
	
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	
	$sql = "SELECT id FROM _users WHERE username='$uo'";
    $query = mysqli_query($db_connection, $sql); 
	$u_check3 = mysqli_num_rows($query);

	$sql = "SELECT id FROM _users WHERE email='$eo'";
    $query = mysqli_query($db_connection, $sql); 
	$e_check3 = mysqli_num_rows($query);

	if($uo == "" || $eo == "" || $po == "" || $a1 == "" || $a2 == ""){
		echo 'The form submission is missing values';
		echo "signup_failed";
        exit();
	} else if ($u_check3 > 0){ 
        echo 'Username already exists';
        exit();
	} else if ($e_check3 > 0){ 
        echo 'Email address is already in use';
        exit();
	} else if (strlen($uo) < 3 || strlen($uo) > 16) {
        echo 'Username must be between 3 and 16 characters';
        exit(); 
    } else if (is_numeric($uo[0])) {
        echo 'Username cannot begin with a number';
        exit();
    } else {
		$sql = "INSERT INTO _users (firstname ,lastname ,username, email, password)       
		        VALUES('$fo','$lo','$uo','$eo','$po')";
		$query = mysqli_query($db_connection, $sql); 
		$uid = mysqli_insert_id($db_connection);
		
		$sql = "INSERT INTO _userinfo (id, username, gender, ip, signup) VALUES ('$uid','$uo','$go','$ip',now())";
		$query = mysqli_query($db_connection, $sql);
		
		$sql = "INSERT INTO _useroptions (id, username, userstatus, state) VALUES ('$uid','$uo','Hi there! I\'m new on bacsyd.','log')";
		$query = mysqli_query($db_connection, $sql);
		
		$sql = "INSERT INTO _userdetails (id, username, education, location, hometown, profession, mobile) VALUES ('$uid','$uo','','','','','')";
		$query = mysqli_query($db_connection, $sql);
		
		$sql = "INSERT INTO _userbasic (id, username, nickname, relationship, country) VALUES ('$uid','$uo','','','Ghana')";
		$query = mysqli_query($db_connection, $sql);
		
		$sql = "INSERT INTO _userthumbnails (id, username) VALUES ('$uid','$uo')";
		$query = mysqli_query($db_connection, $sql);
		
		$sql = "INSERT INTO _usersecurity (id, username) VALUES ('$uid','$uo')";
		$query = mysqli_query($db_connection, $sql);
		
		$sql = "UPDATE _usersecurity SET xquestion='$q1', xanswer='$a1', yquestion='$q2', yanswer='$a2' WHERE username='$uo' LIMIT 1";
		$query = mysqli_query($db_connection, $sql);
		
		if (!file_exists("_USER/$uo")) {
			mkdir("_USER/$uo", 0755);
		}	
		copy("_USER/index.php","_USER/$uo/index.php");
		
		$to = "$eo";							 
		$from = "noreply@bacsyd.com";
		$subject = 'Bacsyd Account Activation';
		$message = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>';
		$message .= '<span style="font-size:16px;">Hi '.$fo.',<br /><br />Looks like this was the right email. :)<br /><br />';
		$message .= 'Next, please confirm your email address and activate your account by clicking on the link below.<br /><br /><br />';
		$message .= '<div style="padding: 20px;background-color: rgb(217, 226, 245);"><a href="http://www.bacsyd.com/activation.php?id='.$uid.'&u='.$uo.'&e='.$eo.'&p='.$po.'">Click here to activate your account now</a></div>';
		$message .= '<br /><br /><br /><b>Bacsyd Team</b></span></body></html>';

		$headers = "From: noreply@bacsyd.com\r\n";
		$headers .= "Reply-To: noreply@bacsyd.com\r\n";
		$headers .= "Return-Path: noreply@bacsyd.com\r\n";
		$headers .= "CC: noreply@bacsyd.com\r\n";
		$headers .= "BCC: noreply@bacsyd.com\r\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
		mail($to, $subject, $message, $headers);
		
		$sql = "SELECT id, username, password FROM _users WHERE BINARY username = BINARY '$uo' LIMIT 1";
        $query = mysqli_query($db_connection, $sql);
        $row = mysqli_fetch_row($query);
		$db_id = $row[0];
		$db_username = $row[1];
        $db_pass_str = $row[2];
		if($po != $db_pass_str){
			echo "signup_failed";
            exit();
		} else {
			$_SESSION['userid'] = $db_id;
			$_SESSION['username'] = $db_username;
			$_SESSION['password'] = $db_pass_str;
			setcookie("id", $db_id, strtotime( '+30 days' ), "/", "", "", TRUE);
			setcookie("user", $db_username, strtotime( '+30 days' ), "/", "", "", TRUE);
    		setcookie("pass", $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE);

			$sql = "UPDATE _userinfo SET ip='$ip', lastlogin=now(), status='online' WHERE username='$db_username' LIMIT 1";
            $query = mysqli_query($db_connection, $sql);
			echo $db_username;
		    exit();
		}
	}
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Create your own Bascyd account today." />
  <meta name="keywords" content="bacsyd,signup,thebacsyd,bacid,bacsys,bacs,bacmid,the bacsyd,bacsyd social,kwabena aboagye dougan,bacsyd.com,www.bacsyd.com" />
  <title>Bacsyd</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php include_once("_ext/_def/all-css.php");?>
  <?php include_once("_ext/_def/bd-load-starter.php");?>
</head>
<body class="hold-transition skin-blue fixed color-anime">
<?php include_once("_ext/_def/bd-load.php");?>
<div id="relax" style="display: none;opacity: .8;position: fixed;font-size: 22px;color: #fff;top: 0px;left: 0px;background: #363636;width: 100%;height: 100%;z-index: 99999;line-height: 400px;text-align: center;">Please wait...</div>
<div class="register-logo" style="margin: 5% auto 0% auto;">
	<span class="hand" onclick="bacsydhome()" style="font-weight: bold;color: #01496e;"><img style="width:130px;" src="_ast/_img/new_bacsyd.png"></span>
</div>
<div id="progress" class="pro_container">
	<ul class="progressbar">
		<li class="active">Step 1</li>
		<li>Step 2</li>
		<li>Step 3</li>
	</ul>
</div>
<div class="register-box" style="margin: 7% auto 2% auto;">
	<div id="signupform" class="register-box-body" style="text-align:center;">
		<p>Register as a new member</p>
		<form role="form" method="post" onSubmit="return false;">
			<div class="form-group has-feedback">
				<input type="text" style="border:1px solid black;" class="form-control" placeholder="Username" name="username" id="username" onfocus="emptyElement('status','unamestatus','next1')" onblur="checkusername()" onkeyup="restrict('username')" maxlength="16" placeholder="Username">
				<span style="width:50%;" class="form-control-feedback" id="unamestatus"></span>
			</div>
			<div class="form-group">
				<input type="text" style="border:1px solid black;" class="form-control" onkeyup="restrict('firstname')" placeholder="First name" name="firstname" id="firstname" onfocus="emptyElement('status','status','next1')" maxlength="20">
			</div>
			<div class="form-group">
				<input type="text" style="border:1px solid black;" class="form-control" onkeyup="restrict('lastname')" placeholder="Last name" name="lastname" id="lastname" onfocus="emptyElement('status','status','next1')" maxlength="20">
			</div>
			<div class="row">
				<div class="col-xs-12">
					<button type="submit" id="next1" class="btn btn-primary btn-block btn-flat" onclick="nextone()">Next</button>
				</div>
			</div>
			<span id="status"></span>
		</form>
		<div class="social-auth-links text-center">
			<b><a onclick="bacsydhome()" class="hand text-center text-black" style="text-decoration:none;">I'm already a member</a></b>
		</div><br/>
		<?php include_once("_ext/_strt/_strt-up-btm.php");?>
	</div>
</div>

<script src="_ast/_js/_query.js"></script>
<script src="_ast/_js/_strap.js"></script>
<script src="_ast/_js/_scroll.js"></script>
<script src="_ast/_js/_nscroll.js"></script>
<script src="_ast/_js/_script.js"></script>
<script src="_ast/_js/_ajax.js"></script>
<script src="_ast/_js/_main.js"></script>
<script src="_ast/_js/_autoscroll.js"></script>
<script type="text/javascript">
function restrict(elem){
	var tf = _(elem);
	var rx = new RegExp;
	if(elem == "email"){
		rx = /[' "]/gi;
	} else if(elem == "username"){
		rx = /[^a-z0-9]/gi;
	}else if(elem == "firstname"){
		rx = /[^a-z- ]/gi;
	}else if(elem == "lastname"){
		rx = /[^a-z-]/gi;
	}
	tf.value = tf.value.replace(rx, "");
}
function emptyElement(x,y,z){
	_(x).innerHTML = "";
	_(y).innerHTML = "";
	_(z).style.display = "block";
}
function showButton(button){
	_(button).style.display = "block";
}
function checkusername(){
	var u = _("username").value;
	if(u != ""){
		_("unamestatus").innerHTML = '';
		var ajax = ajaxObj("POST", "signup.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            _("unamestatus").innerHTML = ajax.responseText;
	        }
        }
        ajax.send("usernamecheck="+u);
	}
}
function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}
function validate() {
  var e = _("email").value;
  var status = _("verify");
  if (!validateEmail(e)) {
	status.innerHTML = '<h7 style="color:rgb(192, 41, 41);background: #ececec;">Invalid email</h7>';
  }
  return false;
}
function nextone(){
	var f = _("firstname").value;
	var l = _("lastname").value;
	var u = _("username").value;
	var status = _("status");
	if(f == "" || l == "" || u == ""){
		_("status").style.display = "block";
		status.innerHTML = '<div class="alert bg-primary"><button type="button" onclick="showButton(\'next1\')" class="close" data-dismiss="alert" aria-hidden="true">×</button>Fill out all of the form data</div>';
		_("next1").style.display = "none";
	}else if(!f.replace(/\s/g, '').length || !l.replace(/\s/g, '').length){
		_("status").style.display = "block";
		status.innerHTML = '<div class="alert bg-primary"><button type="button" onclick="showButton(\'next1\')" class="close" data-dismiss="alert" aria-hidden="true">×</button>Fill out all of the form data</div>';
		_("next1").style.display = "none";
	}else {
		_("next1").style.display = "none";
		_("status").style.display = "block";
		status.innerHTML = '<div class="preloader pl-size-xs"><div class="spinner-layer pl-blue"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
		var ajax = ajaxObj("POST", "signup.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
				var ustring = ajax.responseText.split("|||");
				for (var i = 0; i < ustring.length; i++){
					var string = ustring[i].split("|");		
				}		
				var text = string[0];
				var fname = string[1];
				var lname = string[2];
				var uname = string[3];
	            if(text != "success"){
					status.innerHTML = '<div class="alert bg-maroon"><button type="button" onclick="showButton(\'next1\')" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+ajax.responseText+'</div>';
					_("status").style.display = "block";
					_("next1").style.display = "none";
				} else {
					window.scrollTo(0,0);
					_("progress").innerHTML = '<ul class="progressbar"><li class="active finish"><span class="glyphicon glyphicon-user"></span></li><li class="active">Step 2</li><li>Step 3</li></ul>';
					_("signupform").innerHTML = '<p><b>Hello!  '+fname+' '+lname+'</p>'+
												'<form role="form" class="text-center" method="post" onSubmit="return false;">'+
												'<div class="form-group has-feedback">'+
												'<input type="email" style="border:1px solid black;" class="form-control" placeholder="Email" name="email" id="email" onblur="validate()"  onfocus="emptyElement(\'verify\',\'status1\',\'next2\')" onkeyup="restrict(\'email\')">'+
												'<span style="width:30%;" class="form-control-feedback" id="verify"></span>'+
												'</div>'+
												'<div class="form-group">'+
												'<input type="password" style="border:1px solid black;" class="form-control" placeholder="Password" name="pass1" id="pass1" onfocus="emptyElement(\'status1\',\'status1\',\'next2\')" maxlength="40" onpaste="return false"/>'+
												'</div>'+
												'<div class="form-group">'+
												'<input type="password" style="border:1px solid black;" class="form-control" placeholder="Re-type Password" name="pass2" id="pass2" onfocus="emptyElement(\'status1\',\'status1\',\'next2\')" maxlength="40" onpaste="return false"/>'+
												'</div>'+
												'<div class="form-group">'+
												'<select style="border:1px solid black;" class="form-control inputBox" name="gender" id="gender" onfocus="emptyElement(\'status1\',\'status1\',\'next2\')">'+
												'<option Selected disabled>Gender:</option>'+
												'<option value="m">Male</option>'+
												'<option value="f">Female</option>'+
												'</select>'+
												'</div>'+
												'<div class="row">'+
												'<div class="col-xs-12">'+
												'<button type="submit" id="next2" class="btn btn-info btn-block btn-flat" onclick="nexttwo(\''+fname+'\',\''+lname+'\',\''+uname+'\')">Almost done</button>'+
												'</div>'+
												'</div>'+
												'<span id="status1"></span>'+
												'</form>'+
												'<div class="social-auth-links text-center">'+
												'<br>'+
												'<b><a onclick="signup()" class="hand text-center text-black" style="text-decoration:none;">Cancel Registration</a></b>'+
												'</div>';		
				}
	        }
        }
      ajax.send("u="+u+"&f="+f+"&l="+l);
	}
}
function nexttwo(fname,lname,uname){
	var e = _("email").value;
	var p1 = _("pass1").value;
	var p2 = _("pass2").value;
	var g = _("gender").value;
	var status = _("status1");
	if(fname == "" || lname == "" || uname == "" || e == "" || p1 == "" || p2 == "" || g == "Gender:"){
		_("status1").style.display = "block";
		status.innerHTML = '<div class="alert bg-primary"><button type="button" onclick="showButton(\'next2\')" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please fill out all of the form data</div>';
		_("next2").style.display = "none";
	}else if(!e.replace(/\s/g, '').length){
		_("status1").style.display = "block";
		status.innerHTML = '<div class="alert bg-primary"><button type="button" onclick="showButton(\'next2\')" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please fill out all of the form data</div>';
		_("next2").style.display = "none";
	}else if(!validateEmail(e)){
		_("status1").style.display = "block";
		status.innerHTML = '<div class="alert bg-maroon"><button type="button" onclick="showButton(\'next2\')" class="close" data-dismiss="alert" aria-hidden="true">×</button>Your email is invalid</div>';
		_("next2").style.display = "none";
	}else if(p1 != p2){
		_("status1").style.display = "block";
		status.innerHTML = '<div class="alert bg-maroon"><button type="button" onclick="showButton(\'next2\')" class="close" data-dismiss="alert" aria-hidden="true">×</button>Your passwords do not match</div>';
		_("next2").style.display = "none";
	}else {
		_("next2").style.display = "none";
		_("status1").style.display = "block";
		status.innerHTML = '<div class="preloader pl-size-xs"><div class="spinner-layer pl-green"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
		var ajax = ajaxObj("POST", "signup.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
				var ustring = ajax.responseText.split("|||");
				for (var i = 0; i < ustring.length; i++){
					var string = ustring[i].split("|");		
				}	
				var text = string[0];
				var fname = string[1];
				var lname = string[2];
				var uname = string[3];
				var email = string[4];
				var gender = string[5];
				var pass = string[6];
	            if(text != "success"){
					status.innerHTML = '<div class="alert bg-maroon"><button type="button" onclick="showButton(\'next2\')" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+ajax.responseText+'</div>';
					_("status1").style.display = "block";
					_("next2").style.display = "none";
				} else {
					window.scrollTo(0,0);
					_("progress").innerHTML = '<ul class="progressbar"><li class="active finish"><span class="glyphicon glyphicon-user"></span></li><li class="active finish"><span class="glyphicon glyphicon-envelope"></span></li><li class="active">Step 3</li></ul>';
					_("signupform").innerHTML = '<p><b>Finish up by setting acount security questions.</b></p>'+
												'<form role="form" class="text-center" method="post" onSubmit="return false;">'+
												'<div class="form-group">'+
												'<select style="border:1px solid black;" class="form-control inputBox" name="q1" id="q1" onfocus="emptyElement(\'status2\',\'status2\',\'next3\')">'+
												'<option Selected disabled>Choose Question 1:</option>'+
												'<option value="What was the name of your elementary / primary school?">What was the name of your elementary / primary school?</option>'+
												'<option value="What time of the day were you born?">What time of the day were you born?</option>'+
												'<option value="In what city or town does your nearest sibling live?">In what city or town does your nearest sibling live?</option>'+
												'<option value="What is the name of your pet?">What is the name of your pet?</option>'+
												'<option value="What was your childhood nickname?">What was your childhood nickname?</option>'+
												'<option value="In what city or town did your mother and father meet?">In what city or town did your mother and father meet?</option>'+
												'</select>'+
												'</div>'+
												'<div class="form-group">'+
												'<input type="text" style="border:1px solid black;display:;" class="form-control" onfocus="emptyElement(\'status2\',\'status2\',\'next3\')" placeholder="Answer 1" name="a1" id="a1">'+
												'</div>'+
												'<div class="form-group">'+
												'<select style="border:1px solid black;" class="form-control inputBox" name="q2" id="q2" onfocus="emptyElement(\'status2\',\'status2\',\'next3\')">'+
												'<option Selected disabled>Choose Question 2:</option>'+
												'<option value="What is the first name of the person you first kissed?">What is the first name of the person you first kissed?</option>'+
												'<option value="What is the last name of the teacher who gave you your first failing grade?">What is the last name of the teacher who gave you your first failing grade?</option>'+
												'<option value="What is your dream job?">What is your dream job?</option>'+
												'<option value="What is the model of your first car?">What is the model of your first car?</option>'+
												'<option value="What is your favorite sport?">What is your favorite sport?</option>'+
												'<option value="What was the name of the hospital where you were born?">What was the name of the hospital where you were born?</option>'+
												'</select>'+
												'</div>'+
												'<div class="form-group">'+
												'<input type="text" style="border:1px solid black;display:;" class="form-control" onfocus="emptyElement(\'status2\',\'status2\',\'next3\')" placeholder="Answer 2" name="a2" id="a2">'+
												'</div>'+
												'<div class="row">'+
												'<div class="col-xs-12">'+
												'<button type="submit" id="next3" class="btn btn-success btn-block btn-flat" onclick="finishup(\''+fname+'\',\''+lname+'\',\''+uname+'\',\''+email+'\',\''+gender+'\',\''+pass+'\')">Finish</button>'+
												'</div>'+
												'</div>'+
												'<span id="status2"></span>'+
												'</form>'+
												'<div class="social-auth-links text-center">'+
												'<br>'+
												'<b><a onclick="signup()" class="hand text-center text-black" style="text-decoration:none;">Cancel Registration</a></b>'+
												'</div>';		
				}
	        }
        }
      ajax.send("uname="+uname+"&e="+e+"&p="+encodeURIComponent(p1)+"&g="+g+"&f="+fname+"&l="+lname);
	}
}
function finishup(fname,lname,uname,email,gender,pass){
	var q1 = _("q1").value;
	var q2 = _("q2").value;
	var a1 = _("a1").value;
	var a2 = _("a2").value;
	var status = _("status2");
	if(a1 == "" || a2 == "" || q1 == "Choose Question 1:" || q2 == "Choose Question 2:"){
		_("status2").style.display = "block";
		status.innerHTML = '<div class="alert bg-primary"><button type="button" onclick="showButton(\'next3\')" class="close" data-dismiss="alert" aria-hidden="true">×</button>Fill out all of the form data</div>';
		_("next3").style.display = "none";
	}else if(!a1.replace(/\s/g, '').length || !a2.replace(/\s/g, '').length){
		_("status2").style.display = "block";
		status.innerHTML = '<div class="alert bg-primary"><button type="button" onclick="showButton(\'next3\')" class="close" data-dismiss="alert" aria-hidden="true">×</button>Fill out all of the form data</div>';
		_("next3").style.display = "none";
	}else {
		_("next3").style.display = "none";
		_("status2").style.display = "block";
		status.innerHTML = '<div class="preloader pl-size-xs"><div class="spinner-layer pl-red"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
		_("relax").style.display = "block";
		var ajax = ajaxObj("POST", "signup.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText == "signup_failed"){
					status.innerHTML = '<div class="alert bg-maroon"><button type="button" onclick="showButton(\'next3\')" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+ajax.responseText+'</div>';
					_("status2").style.display = "block";
					_("next3").style.display = "none";
					_("relax").style.display = "none";
				} else {
					window.location = "home&"+ajax.responseText;				
				}
	        }
        }
       ajax.send("q1="+q1+"&q2="+q2+"&a1="+encodeURIComponent(a1)+"&a2="+encodeURIComponent(a2)+"&uo="+uname+"&eo="+email+"&po="+encodeURIComponent(pass)+"&go="+gender+"&fo="+fname+"&lo="+lname);
	}
}
</script>
</body>
</html>
