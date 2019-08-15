<?php
include_once("../_sys/check_login_status.php");
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php
if (isset($_POST['action']) && $_POST['action'] == "status_update"){
	if(!isset($_POST['s']) || $_POST['s'] == ""){
		mysqli_close($db_connection);
		echo "update_failed";
		exit();
	}
	$s =  $_POST['s'];
	$sql = "UPDATE _useroptions SET userstatus='$s', editdate=now() WHERE username='$log_username' LIMIT 1";
    $query = mysqli_query($db_connection, $sql); 
	echo $s;
	exit();
}
?><?php
if (isset($_POST['action']) && $_POST['action'] == "sch_update"){
	if(!isset($_POST['sch']) || $_POST['sch'] == ""){
		mysqli_close($db_connection);
		echo "update_failed";
		exit();
	}
	$sch =  $_POST['sch'];
	$sql = "UPDATE _userdetails SET education='$sch', updatedate=now() WHERE username='$log_username' LIMIT 1";
    $query = mysqli_query($db_connection, $sql); 
	echo $sch;
	exit();
}
?><?php
if (isset($_POST['action']) && $_POST['action'] == "loc_update"){
	if(!isset($_POST['loc']) || $_POST['loc'] == ""){
		mysqli_close($db_connection);
		echo "update_failed";
		exit();
	}
	$loc =  $_POST['loc'];
	$sql = "UPDATE _userdetails SET location='$loc', updatedate=now() WHERE username='$log_username' LIMIT 1";
    $query = mysqli_query($db_connection, $sql); 
	echo $loc;
	exit();
}
?><?php
if (isset($_POST['action']) && $_POST['action'] == "ps_update"){
	if(!isset($_POST['ps']) || $_POST['ps'] == ""){
		mysqli_close($db_connection);
		echo "update_failed";
		exit();
	}
	$ps =  $_POST['ps'];
	$sql = "UPDATE _userdetails SET profession='$ps', updatedate=now() WHERE username='$log_username' LIMIT 1";
    $query = mysqli_query($db_connection, $sql); 
	echo $ps;
	exit();
}
?><?php 
if (isset($_POST['action']) && $_POST['action'] == "num_update"){
	if(!isset($_POST['num']) || $_POST['num'] == ""){
		mysqli_close($db_connection);
		echo "update_failed";
		exit();
	}
	$num = preg_replace('#[^0-9]#i', '', $_POST['num']);		
	$sql = "UPDATE _userdetails SET mobile='$num', updatedate=now() WHERE username='$log_username' LIMIT 1";
	$query = mysqli_query($db_connection, $sql);
	echo $num;
	exit();
}
?><?php 
if (isset($_POST['action']) && $_POST['action'] == "fn_update"){
	if(!isset($_POST['fn']) || $_POST['fn'] == ""){
		mysqli_close($db_connection);
		echo "update_failed";
		exit();
	}
	$fn = preg_replace('#[^a-z .]#i', '', $_POST['fn']);	
	$sql = "UPDATE _users SET firstname='$fn' WHERE username='$log_username' LIMIT 1";
	$query = mysqli_query($db_connection, $sql);
	echo $fn;
	exit();
}
?><?php 
if (isset($_POST['action']) && $_POST['action'] == "ln_update"){
	if(!isset($_POST['ln']) || $_POST['ln'] == ""){
		mysqli_close($db_connection);
		echo "update_failed";
		exit();
	}
	$ln = preg_replace('#[^a-z .]#i', '', $_POST['ln']);	
	$sql = "UPDATE _users SET lastname='$ln' WHERE username='$log_username' LIMIT 1";
	$query = mysqli_query($db_connection, $sql);
	echo $ln;
	exit();
}
?><?php 
if (isset($_POST['action']) && $_POST['action'] == "e_update"){
	if(!isset($_POST['e']) || $_POST['e'] == ""){
		mysqli_close($db_connection);
		echo "update_failed";
		exit();
	}
	$e = mysqli_real_escape_string($db_connection, $_POST['e']);
	$sql = "SELECT id FROM _users WHERE email='$e'";
    $query = mysqli_query($db_connection, $sql); 
	$e_check = mysqli_num_rows($query);
	if($e_check > 0){ 
		echo "same_email";
		exit();
	}else{
		$sql = "UPDATE _users SET email='$e' WHERE username='$log_username' LIMIT 1";
		$query = mysqli_query($db_connection, $sql);
		
		$qsql = "SELECT id, username, password FROM _users WHERE BINARY email = BINARY '$e' OR BINARY username = BINARY '$log_username' LIMIT 1";
        $qquery = mysqli_query($db_connection, $qsql);
        $row = mysqli_fetch_row($qquery);
		$db_id = $row[0];
		$db_username = $row[1];
        $db_pass_str = $row[2];
		
		$to = "$e";							 
		$from = "noreply@bacsyd.com";
		$subject = 'Bacsyd Account Activation';
		$message = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>';
		$message .= '<span style="font-size:16px;">Hey there,<br /><br />Your email was updated.<br /><br />';
		$message .= 'Next, please confirm your new email address and re-activate your account by clicking on the link below.<br /><br /><br />';
		$message .= '<div style="padding: 20px;background-color: rgb(217, 226, 245);"><a href="http://www.bacsyd.com/activation.php?id='.$db_id.'&u='.$db_username.'&e='.$e.'&p='.$db_pass_str.'">Click here to activate your account now</a></div>';
		$message .= '<br /><br /><br /><b>Bacsyd Team</b></span></body></html>';
		$headers = "From: noreply@bacsyd.com\r\n";
		$headers .= "Reply-To: noreply@bacsyd.com\r\n";
		$headers .= "Return-Path: noreply@bacsyd.com\r\n";
		$headers .= "CC: noreply@bacsyd.com\r\n";
		$headers .= "BCC: noreply@bacsyd.com\r\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
		mail($to, $subject, $message, $headers);
		
		$a_sql = "UPDATE _usersecurity SET activation='0' WHERE username='$log_username' LIMIT 1";
		$a_query = mysqli_query($db_connection, $a_sql);
		echo $e;
		exit();
	}
}
?><?php 
if (isset($_POST['action']) && $_POST['action'] == "pass_update"){
	if(!isset($_POST['op']) || $_POST['op'] == "" || $_POST['np2'] == ""){
		mysqli_close($db_connection);
		echo "update_failed";
		exit();
	}
	$op = md5($_POST['op']);
	$_POST['np1'] = $np1 = $_POST['np1'];
	$_POST['np2'] = $np2 = $_POST['np2'];
	
	if($op == "" || $np1 == "" || $np2 == ""){
		echo "Please fill all password fields";
        exit();
	}else if (strlen($np2) < 6) {
        echo "Password is too short. Try 6 or more characters";
        exit(); 
    } else {
		$sql = "SELECT email, password FROM _users WHERE username='$log_username' LIMIT 1";
        $query = mysqli_query($db_connection, $sql);
        $row = mysqli_fetch_row($query);
		$db_email = $row[0];
		$db_pass_str = $row[1];
		if($op != $db_pass_str){
			echo "Your old password is incorrect";
            exit();
		} else {
			$np_hash = md5($np1);
			$sql = "UPDATE _users SET password='$np_hash' WHERE username='$log_username' LIMIT 1";
			$query = mysqli_query($db_connection, $sql);
			
			$to = "$db_email";							 
			$from = "noreply@bacsyd.com";
			$subject = 'Bacsyd Account Password Changed';
			$message = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>';
			$message .= '<span style="font-size:16px;">Hey there,<br /><br />Your password was changed.<br /><br />';
			$message .= 'If you did not make this change or an authorized person has accessed your account, you should re-change your password as soon as ';
			$message .= 'possible from your Bacsyd Account page at &nbsp;<a href="http://www.bacsyd.com/reset">http://www.bacsyd.com/reset</a>';
			$message .= '<br /><br /><br /><b>Bacsyd Security Team</b></span></body></html>';
			$headers = "From: noreply@bacsyd.com\r\n";
			$headers .= "Reply-To: noreply@bacsyd.com\r\n";
			$headers .= "Return-Path: noreply@bacsyd.com\r\n";
			$headers .= "CC: noreply@bacsyd.com\r\n";
			$headers .= "BCC: noreply@bacsyd.com\r\n";
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
			mail($to, $subject, $message, $headers);			
			echo "security_success";
			exit();
		}
	}
}
?>