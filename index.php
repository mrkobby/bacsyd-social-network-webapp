<?php 
include_once("_sys/check_login_status.php");
if($user_ok == true){
	header("location: home&".$_SESSION["username"]);
    exit();
}
?><?php
if(isset($_POST["id"])){
	include_once("_sys/db_connection.php");
	$id = $_POST['id'];
	$p = md5($_POST['p']);
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));

	if($id == "" || $p == ""){
		echo "login_failed";
        exit();
	} else {
		$sql = "SELECT id, username, password FROM _users WHERE BINARY email = BINARY '$id' OR BINARY username = BINARY '$id' LIMIT 1";
        $query = mysqli_query($db_connection, $sql);
        $row = mysqli_fetch_row($query);
		$db_id = $row[0];
		$db_username = $row[1];
        $db_pass_str = $row[2];
		if($p != $db_pass_str){
			echo "login_failed";
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
  <meta name="description" content="Welcome back to Bacsyd. You can share your daily activities (from anywhere), create photo galleries, use custom interfaces, find and follow friends with just a tap, and many more." />
  <meta name="keywords" content="Bacsyd,bacsyd,thebacsyd,bacid,bacsys,bacs,bacmid,the bacsyd,bacsyd social,kwabena aboagye dougan,bacsyd.com,www.bacsyd.com" />
  <title>Bacsyd</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php include_once("_ext/_def/all-css.php");?>
</head>
<body class="hold-transition skin-blue fixed color-anime">
<?php include_once("_ext/_def/bd-load.php");?>
<?php include_once("_ext/_def/bd-load-starter.php");?>
<div class="login-box">
	<div class="register-logo">
		<span class="hand" onclick="bacsydhome()"><img style="width:130px;" src="_ast/_img/new_bacsyd.png"></span>
	</div>
	<div class="login-box-body">
		<p class="carousel headline slide" id="headline">
			<div id="intro" class="carousel-inner slide" style="text-align: center;">
				<div class="item active">
					<span>Welcome to the Bacsyd</span>
				</div>	
				<div class="item">
					<span>Sign in to start your session</span>
				</div>	
			</div>
		</p>
		<form role="form" id="login" class="text-center" onSubmit="return false;">
			<div class="form-group has-feedback">
				<input type="text" style="border:1px solid black;" class="form-control" placeholder="Email or Username" id="id" onfocus="emptyElement('status')" onkeyup="restrict('id')">
				<span class="fa fa-user form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<input type="password" style="border:1px solid black;" class="form-control" placeholder="Password" id="password-in" onfocus="emptyElement('status')" placeholder="Password" onpaste="return false"/>
				<span class="fa fa-lock form-control-feedback"></span>
			</div>
			<div class="row" id="loginbtn">
				<div class="col-xs-12">
					<button type="submit" class="btn btn-primary btn-block btn-flat" onclick="login()">Sign In</button>
				</div>
			</div>
			<span id="status"></span>
		</form>

		<div class="social-auth-links text-center">
			<b><a class="text-center text-black hand" onclick="reset()" style="text-decoration:none;">Forgot password?</a></b><br><br>
			<b><a onclick="signup()" class="text-center text-black hand" style="text-decoration:none;">Register as a new member</a></b><br><br>
		</div>
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
$('#intro').carousel({
	interval: 10000,
	cycle: true
});
function restrict(elem){
	var tf = _(elem);
	var rx = new RegExp;
	if(elem == "id"){
		rx = /[^a-z0-9@._-]/gi;
	}
	tf.value = tf.value.replace(rx, "");
}
function emptyElement(x){
	_(x).innerHTML = "";
	_("loginbtn").style.display = "block";
	_("id").style.borderColor = "black";
	_("password-in").style.borderColor = "black";
}
function showButton(){
	_("loginbtn").style.display = "block";
}
function login(){
	var id = _("id").value;
	var p = _("password-in").value;
	if(id == ""){
		_("status").innerHTML = '<div class="alert bg-primary"><button type="button" onclick="showButton()" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please fill out all of the form data</div>';
		_("loginbtn").style.display = "none";
		_("id").style.borderColor = "red";
	} else if(p == ""){
		_("status").innerHTML = '<div class="alert bg-primary"><button type="button" onclick="showButton()" class="close" data-dismiss="alert" aria-hidden="true">×</button>Please fill out all of the form data</div>';
		_("loginbtn").style.display = "none";
		_("password-in").style.borderColor = "red";
	}else {
		_("loginbtn").style.display = "none";
		_("status").innerHTML = '<div class="preloader pl-size-xs"><div class="spinner-layer pl-red"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
		var ajax = ajaxObj("POST", "index.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText == "login_failed"){
					_("status").innerHTML = '<div class="alert bg-maroon"><button type="button" onclick="showButton()" class="close" data-dismiss="alert" aria-hidden="true">×</button>Wrong ID or Password</div>';
					_("loginbtn").style.display = "none";
				} else {
					window.location = "home&"+ajax.responseText;
				}
	        }
        }
        ajax.send("id="+id+"&p="+encodeURIComponent(p));
	}
}
</script>
</body>
</html>
