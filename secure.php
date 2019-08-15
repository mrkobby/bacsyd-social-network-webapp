<?php
include_once("_sys/check_login_status.php");
if($user_ok == false){
	header("location: ../bacsyd");
    exit();
}
?><?php
if(isset($_POST["xquestion"])){	
	$_SESSION['xquestion'] = $xquestion = $_POST['xquestion'];
	$_SESSION['xanswer'] = $xanswer = $_POST['xanswer'];
	$_SESSION['yanswer'] = $yanswer = $_POST['yanswer'];
	$_SESSION['yquestion'] = $yquestion = $_POST['yquestion'];
	
	if($xquestion == "Choose Question 1:" || $xanswer == "" || $yanswer == "" || $yquestion == "Choose Question 2:"){
		echo '<h7 style="color:rgb(192, 41, 41);">&deg;The form submission is missing values.</h7> ';
        exit();
	} else{
		$sql = "UPDATE _usersecurity SET xquestion='$xquestion', xanswer='$xanswer', yquestion='$yquestion', yanswer='$yanswer' WHERE username='$log_username' LIMIT 1";
		$query = mysqli_query($db_connection, $sql);
	}		
	echo "security_success";
	exit();
}
?><?php
include_once("_parse/_ulog_enf.php");
if($u != $log_username){
	header("location: ../bacsyd");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="description" content="Set-up your security questions provided by R A V E N" />
	  <meta name="keywords" content="secure bacsyd,security questions,raven,Bacsydreset,reset password,www.bacsyd.com,the bacsyd,bacsydsocial,bacsyd social,kwabena aboagye dougan,bacsyd.com" />
	  <title><?php echo $log_username; ?> - R A V E N</title>
	  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	  <?php include_once("_ext/_def/all-css.php");?>
  </head>
<body class="hold-transition register-page color-anime">
<?php include_once("_ext/_def/bd-dialog-searchlayer.php");?>
<div class="register-box" style="margin: 5% auto;">
	<div class="register-logo">
		<span id="hithere" class="hand" onclick="window.location = '../bacsyd';"></span>
	</div>
	<div id="starterbox" class="register-box-body" style="text-align:center;display:none;">
		<p class="login-box-msg" style="padding: 0 0px 20px 0px;"> 
			<span id="first" style="display:none;">Set-up security questions with R A V E N.</span><br>
			<br>If you forget your password, you can reset it with these security questions.</span>
		</p>
		<form role="form" method="post" onSubmit="return false;">
			<div class="row">
				<div class="col-xs-12">
					<button type="submit" id="starternext" class="btn btn-primary btn-block btn-flat">Lets Get Started</button><br>
					<b><a onclick="window.history.go(-1);" onclick="return false;" class="link-black hand text-center" style="text-decoration:none;">Cancel</a></b><br><br>
					<b><a onclick="window.location = '_parse/_logout.php';" class="text-red hand text-center" style="text-decoration:none;"><span class="fa fa-power-off" ></span>&nbsp;Logout</a></b>
				</div>
			</div>
		</form>
	</div>
	<div id="xbox" class="register-box-body" style="text-align:center;display:none;">
		<p class="login-box-msg"> 
			Step 1: Select first question and provide an answer</p>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group has-feedback">	
						<select class="form-control inputBox" name="xquestion" id="xquestion">
							<option Selected disabled>Choose Question 1:</option>
							<option value="What was the name of your elementary / primary school?">What was the name of your elementary / primary school?</option>
							<option value="What time of the day were you born?">What time of the day were you born?</option>'+
							<option value="In what city or town does your nearest sibling live?">In what city or town does your nearest sibling live?</option>
							<option value="What is the name of your pet?">What is the name of your pet?</option>
							<option value="What was your childhood nickname?">What was your childhood nickname?</option>
							<option value="In what city or town did your mother and father meet?">In what city or town did your mother and father meet?</option>
						</select>
					</div>
					<div class="form-group has-feedback">
						<input type="text" class="form-control" placeholder="Answer" name="xanswer" id="xanswer" maxlength="30">
					</div>
					
					<button type="submit" id="xnext" class="btn btn-primary btn-block btn-flat" style="display:none;">Next</button><br>
					<b><a onclick="window.history.go(-1);" onclick="return false;" class="hand text-center text-black" style="text-decoration:none;">Cancel</a></b>
				</div>
			</div>
	</div>
	<div id="ybox" class="register-box-body" style="text-align:center;display:none;">
		<p class="login-box-msg"> 
			<span>Step 2: Well done! Now your final question and answer</span></p>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group">
						<select class="form-control inputBox" name="yquestion" id="yquestion">
							<option Selected disabled>Choose Question 2:</option>
							<option value="What is the first name of the person you first kissed?">What is the first name of the person you first kissed?</option>
							<option value="What is the last name of the teacher who gave you your first failing grade?">What is the last name of the teacher who gave you your first failing grade?</option>
							<option value="What is your dream job?">What is your dream job?</option>
							<option value="What is the model of your first car?">What is the model of your first car?</option>
							<option value="What is your favorite sport?">What is your favorite sport?</option>
							<option value="What was the name of the hospital where you were born?">What was the name of the hospital where you were born?</option>
							</select>
						</div>
					<div class="form-group has-feedback">
						<input type="text" class="form-control" placeholder="Answer" name="yanswer" id="yanswer" maxlength="30">
					</div>
						<div id="lastBtns">
							<div class="pull-left" style="width:28%;" id="yback"><button type="submit" class="btn btn-info btn-block">Back</button></div>
							<div class="pull-right" style="width:68%;" id="ynext" ><button type="submit" class="btn btn-primary btn-block" onclick="setup()">Finsih</button></div>
							<br><br><br>
						</div>
					<b><a id="cancelBtn" onclick="window.history.go(-1);" onclick="return false;" class="hand text-center text-black" style="text-decoration:none;">Cancel</a></b>
				</div>
			</div>
		<span id="status"></span>
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
<script src="_ast/_js/_dialog.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#starterbox").fadeIn(400);
	$("#first").slideDown(0);
	$("#second").slideDown(1500);
	$("#third").slideDown(1500);
	
	$("#starternext").click(function(){
		$("#starterbox").hide(200);
		$("#ybox").hide(700);
		$("#xbox").fadeIn(700);
		$("#xnext").slideDown(100);
	})
	$("#xnext").click(function(){
		$("#starterbox").hide(500);
		$("#xbox").hide(200);
		$("#ybox").fadeIn(700);
		$("#ynext").slideDown(100);
	})
	$("#yback").click(function(){
		$("#starterbox").hide(0);
		$("#ybox").hide(0);
		$("#xbox").fadeIn(700);
		$("#xnext").slideDown(700);
	})
});

function setup(){
	var xquestion = _("xquestion").value;
	var xanswer = _("xanswer").value;
	var yanswer = _("yanswer").value;
	var yquestion = _("yquestion").value;
	var status = _("status");
	if(xquestion == "Choose Question 1:" || xanswer == "" || yanswer == "" || yquestion == "Choose Question 2:"){
		Alert.render("Please fill out all of the form data.");
	} else if(!xquestion.replace(/\s/g, '').length || !xanswer.replace(/\s/g, '').length || !yanswer.replace(/\s/g, '').length || !yquestion.replace(/\s/g, '').length){
		Alert.render("Please fill out all of the form data!.");
	} else {
		status.innerHTML = '<div class="preloader pl-size-xs"><div class="spinner-layer pl-red"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
		_("lastBtns").style.display = "none";
		_("cancelBtn").style.display = "none";
		var ajax = ajaxObj("POST", "secure.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText != "security_success"){
					Alert.render(ajax.responseText);
					_("lastBtns").style.display = "block";
					_("cancelBtn").style.display = "block";
				} else {
					window.scrollTo(0,0);
					_("ybox").innerHTML = "<span style='font-size:24px;'>Awesome </span><br>Your account is now secured.<br><br><a class='btn btn-success btn-block' href='home&<?php echo $log_username;?>'>Done</a><br>";
				}
	        }
        }
       ajax.send("xquestion="+xquestion+"&xanswer="+encodeURIComponent(xanswer)+"&yanswer="+encodeURIComponent(yanswer)+"&yquestion="+yquestion);
	}
}

var myString = "Hi <?php echo $firstname; ?>";
var myArray = myString.split("");
var loopTimer;
function frameLooper() {
	if(myArray.length > 0) {
		document.getElementById("hithere").innerHTML += myArray.shift();
	} else {
		clearTimeout(loopTimer); 
                return false;
	}
	loopTimer = setTimeout('frameLooper()',100);
}
frameLooper();
</script>
</body>
</html>