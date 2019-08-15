<?php
include_once("_sys/check_login_status.php");
if($user_ok == false){
	header("location: ../bacsyd");
    exit();
}
$sql = "SELECT * FROM _useroptions WHERE username='$log_username'";
$query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$state = $row["state"];
	}
if($state != "lock"){
	header("location: home&".$log_username."");
	exit();
}
?><?php
if(isset($_POST["p"])){
	include_once("_sys/db_connection.php");
	$p = md5($_POST['p']);
	if($p == ""){
		echo "login_failed";
        exit();
	} else {
		$sql = "SELECT username, password FROM _users WHERE username='$log_username'";
        $query = mysqli_query($db_connection, $sql);
		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$db_username = $row["username"];
			$db_pass_str = $row["password"];
		}
		if($p != $db_pass_str){
			echo "login_failed";
            exit();
		} else {
			$sql = "UPDATE _userinfo SET status='online' WHERE username='$db_username'";
            $query = mysqli_query($db_connection, $sql);
			mysqli_query($db_connection, "UPDATE _useroptions SET state='log' WHERE username='$log_username'");
			echo $db_username;
		    exit();
		}
	}
}
?><?php
include_once("_parse/_ulog_enf.php");
if($u != $log_username){
	header("location: lock&".$log_username."");
    exit();
}
$profile_logo = '<img src="_USER/'.$log_username.'/'.$avatar.'" alt="'.$log_username.'">';
if($avatar == NULL){
	$profile_logo = '<img src="_ast/_img/avatardefault.png" alt="'.$log_username.'">';
}
?>
<!DOCTYPE html>
<html>
<head>
  <?php include_once("_ext/_def/logged-head.php");?>
  <?php include_once("_ext/_def/all-css.php");?>
</head>
<body class="color-anime">
<?php include_once("_ext/_def/bd-load.php");?>
<div class="lockscreen-wrapper">
	<div class="lockscreen-logo">
		<a class="hand" onclick="window.location = 'lock&<?php echo $log_username; ?>';">
			<span class="hand" onclick="window.location = '../bacsyd';"><img style="width:130px;" src="_ast/_img/new_bacsyd.png"></span>
		</a>
	</div>
	<div class="lockscreen-name"><span><?php echo $firstname; ?></span> <span><?php echo $lastname; ?></span></div>
	<div class="lockscreen-item" id="user-log">
		<div class="lockscreen-image hand">
			<?php echo $profile_logo ?>
		</div>
		<form class="lockscreen-credentials" role="form" id="logon" onSubmit="return false;">
			<div class="input-group">
				<div style="width: 100%;" id="inputB">
					<input type="password" class="form-control inputBox" id="password" name="password" onfocus="emptyElement('status','sync')" placeholder="Password">
				</div>
				<div class="input-group-btn" id="loginBtn">
				  <button type="submit" class="btn" onclick="logon()"><i class="fa fa-arrow-right text-black"></i></button>
				</div>
			</div>
		</form>
		<span id="sync"></span>
	</div>
	<div class="help-block text-center">
		<span id="status">Enter your password to retrieve your session</span>	
	</div>
	<div class="text-center">
		<a class="link-black hand" onclick="window.location = '_parse/_logout.php';" style="text-decoration:none;"><b>Or sign in as a different user</b></a>
	</div>
	<div class="lockscreen-footer text-center">
		<div style="backgroud: inherit;border-top: 0px solid;border-bottom: 0px solid;">
			<div class="box-header">
				<div class="user-block">
					 © 2018 Bacsyd. All rights reserved.
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once("_ext/_def/all-js.php");?>
<script>
function emptyElement(x,y){
	_(x).innerHTML = "";
	_(y).style.display = "block";
}
function logon(){
	var p = _("password").value;
	if(p == ""){
		_("status").innerHTML = '<h7 style="color:rgb(192, 41, 41);font-size: 12px;" > Please enter your password</h7>';
	} else {
		_("status").innerHTML = '<h7 style="color:rgb(10, 85, 128);font-size: 12px;">please wait...</h7>';
		_("user-log").style.display = "none";
		var ajax = ajaxObj("POST", "lock.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText == "login_failed"){
					_("status").innerHTML = '<h7 style="color:rgb(192, 41, 41);font-size: 12px;">Wrong password.</h7>';
					_("user-log").style.display = "block";
				} else {
					window.location = "home&"+ajax.responseText;
				}
	        }
        }
        ajax.send("p="+p);
	} 
}
</script>
</body>
</html>
