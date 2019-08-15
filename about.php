<?php
include_once("_sys/check_login_status.php");
if($user_ok == true){
	header("location: home&".$_SESSION["username"]);
    exit();
}
?><?php
if(isset($_POST["nm"]) && isset($_POST["email"]) && isset($_POST["msg"])){
	$name =  $_POST['nm'];						 
	$email =  $_POST['email'];						 
	$message =  $_POST['msg'];	
	
	$to = "kobbydougan@gmail.com";							 
	$from = "$email";
	$subject = 'Message from '.$name.'';
	$message = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>';
	$message .= '<span style="font-size:16px;">'.$message.'</span></body></html>';

	$headers = "From: $email\r\n";
	$headers .= "Reply-To: $email\r\n";
	$headers .= "Return-Path: $email\r\n";
	$headers .= "CC: noreply@bacsyd.com\r\n";
	$headers .= "BCC: noreply@bacsyd.com\r\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
	mail($to, $subject, $message, $headers);
	echo "sent";
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="You can share your daily activities (from anywhere), create photo galleries, use custom interfaces, find and follow friends with just a tap, and many more." />
  <meta name="keywords" content="Bacsyd,bacsyd,thebacsyd,bacid,bacsys,bacs,bacmid,the bacsyd,bacsyd social,kwabena aboagye dougan,bacsyd.com,www.bacsyd.com" />
  <title>Bacsyd</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
  <link rel="stylesheet" href="_ast/_css/_fa.css">
  <link rel="stylesheet" href="_ast/_css/_mtc.css">
  <link rel="stylesheet" href="about/assets/css/main.css" />
  <link href="_ast/_img/bacsyd_icon.png" rel="icon" />
  <style>
  #dialogbox > div > #dialogboxbody {background: #3b3b3b;}
  #dialogbox > div > #dialogboxfoot {background: #151515;}
  </style>
</head>
<body>
<?php include_once("_ext/_def/bd-dialog-searchlayer.php");?>
<div id="wrapper" class="bg">
<?php include_once("_ext/_def/bd-load.php");?>
<?php include_once("_ext/_def/bd-load-starter.php");?>
	<header id="header">
		<span href="javascript:void(0)" onclick="bacsydhome()" style="text-decoration:none;cursor:pointer;">
			<div class="logo">
				<span style="font-size: 3em;font-weight: 800;">B<span>
			</div>
		</span>
		<div class="content">
			<div class="inner">
				<p>Welcome to Bacsyd <i class="fa fa-smile-o"></i> <br />You can share your daily activities (from anywhere),<br /> create photo galleries,
				use custom interfaces, find and follow<br /> friends with just a tap, and many more.</p>
			</div>
		</div>
		<nav>
			<ul>
				<li><a href="#about">About</a></li>
				<li><a href="#contact">Contact</a></li>
				<li><a href="#terms">Terms of Use</a></li>
			</ul>
		</nav>
	</header>
	<div id="main">
		<article id="about">
			<h2 class="major">About</h2>
			<span class="image main"><img src="about/images/abt01.png" alt="" /></span>
			<p>Bacsyd is a free social networking website that allows registered users
			to create profiles, upload photos, send messages and keep in touch with friends, 
			family and colleagues. Within each member's personal profile, there are several key networking components. 
			The most popular is arguably the Wall, which is essentially a virtual bulletin board.
			Messages left on a member's Wall can be text or photos. Another popular component 
			is the virtual Photo Album. Photos can be uploaded from the desktop or directly from a smartphone camera.</p>
			<span class="image main"><img src="about/images/abt02.png" alt="" /></span>
			<p>Bacsyd offers a range of privacy options to its members.  A member can make all his communications 
			visible to everyone, he can block specific connections or he can keep all his communications
			private. Members can decide which parts of their profile are public, decide what not to put in their
			news feed and determine exactly who can see their posts. </p>
			<br />
			<h3 class="dp"><b>Developer</b></h3>
			<p>Bacsyd was developed by Kwabena Aboagye. He has established a reputation as a successful entrepreneur
			and well-respected voice in the programming community. He founded Dak Incorporation to build a digital agency
			committed to high quality web design & development, interaction design and user interface design. He works
			to connect great people with the goal of making meaningful work and hopefully making the world a better place along the way. 
		</article>
		<article id="contact">
			<h2 class="major">Contact</h2>
			<form action="javascript:void(0)">
				<div class="field half first">
					<label for="name">Name</label>
					<input type="text" name="name" id="name" maxlength="30" />
				</div>
				<div class="field half">
					<label for="email">Email</label>
					<input type="text" name="email" id="email" />
				</div>
				<div class="field">
					<label for="message">Message</label>
					<textarea name="message" id="message" rows="4" maxlength="100"></textarea>
				</div>
				<ul class="actions">
					<li><input type="button" onclick="submitContactForm()" value="Send Message" class="special" /></li>
					<li><input type="reset" value="Reset" /></li>
				</ul>
			</form>
			<ul class="icons">
				<li><a href="https://www.facebook.com/kwabena.dougan" class="icon fa-facebook" target="blank"><span class="label">Facebook</span></a></li>
				<li><a href="https://www.instagram.com/___kobby" class="icon fa-instagram" target="blank"><span class="label">Instagram</span></a></li>
			</ul>
		</article>
		<article id="terms">
			<h2 class="major">Terms of Use</h2>
			Please read this carefully. Contact us if you have any questions or suggestions. 
			<br /><br />
			<h3 class="dp"><b>1. Accepting the Terms of Service</b></h3>
			<p>By using or accessing our services, you ("Subscriber" or "you") agree to be bound by all the 
			terms and conditions of this Agreement. If you don’t agree to all the terms and conditions 
			of this Agreement, you shouldn't, and aren't permitted to, use the Services. 
			<br /><br />
			<h3><b>2. Modifications to this Agreement</b></h3>
			<p>Bacsyd reserves the right to modify this Agreement by (1) posting a revised Agreement on 
			and/or through the Services and (2) providing notice to you that this Agreement has changed,
			generally via email where practicable, and otherwise through the Services (such as through
			a notification in your Bacsyd account). Modifications will not apply retroactively. You are 
			responsible for reviewing and becoming familiar with any modifications to this Agreement. 
			<p>We may sometimes ask you to review and to explicitly agree to (or reject) a revised version of
			this Agreement. In such cases, modifications will be effective at the time of your agreement to 
			the modified version of this Agreement. If you do not agree at that time, you are not permitted
			to use the Services.
			<p>In cases where we do not ask for your explicit agreement to a modified version of this Agreement,
			but otherwise provide notice as set forth above, the modified version of this Agreement will become 
			effective fourteen days after we have posted the modified Agreement and provided you notification 
			of the modifications. Your use of the Services following that period constitutes your acceptance 
			of the terms and conditions of this Agreement as modified. If you do not agree to the modifications,
			you are not permitted to use, and should discontinue your use of, the Services. 
			<br /><br />
			<h3><b>3. Use of the Services</b></h3>
			<p><b>Eligibility:</b>
			<p>No individual under the age of thirteen (13) may use the Services, provide any personal 
			information to Bacsyd, or otherwise submit personal information through the Services (including, 
			for example, a name, country, or email address). You may only use the Services if you can form a
			binding contract with Bacsyd and are not legally prohibited from using the Services. 
			<p><b>Service Changes and Limitations:</b>
			<p>The Services change frequently, and their form and functionality may change without prior notice 
			to you. Bacsyd retains the right to create limits on and related to use of the Services in its
			sole discretion at any time with or without notice. Bacsyd may also impose limits on certain 
			Services or aspects of those Services or restrict your access to parts or all of the Services 
			without notice or liability. Bacsyd may change, suspend, or discontinue any or all of the
			Services at any time, including the availability of any product, feature, database, or Content (as defined below). 
			Bacsyd may also terminate or suspend Accounts at any time, in its sole discretion. 
			<p><b>Service Changes and Limitations:</b>
			<p>You may not, without express prior written permission, do any of the following while accessing 
			or using the Services: (a) tamper with, or use non-public areas of the Services, or the computer or 
			delivery systems of Bacsyd and/or its service providers; (b) probe, scan, or test any system or network
			(particularly for vulnerabilities), or otherwise attempt to breach or circumvent any security or
			authentication measures; (c) access or search or attempt to access or search the Services by any means 
			(automated or otherwise) other than through our currently available, published interfaces that are provided 
			by Bacsyd (and only pursuant to those terms and conditions) or unless permitted by Bacsyd's robots.txt file
			or other robot exclusion mechanisms; (d) scrape the Services, and particularly scrape Content (as defined below)
			from the Services; (e) use the Services to send altered, deceptive, or false source-identifying 
			information, including without limitation by forging TCP-IP packet headers or email headers; or (f) 
			interfere with, or disrupt, (or attempt to do so), the access of any Subscriber, host or network, 
			including, without limitation, by sending a virus to, spamming, or overloading the Services, or by 
			scripted use of the Services in such a manner as to interfere with or create an undue burden on the Services. 
			<br /><br />
			<h3><b>4. Registration, Bacsyd URLs, and Security</b></h3>
			<p>As a condition to using certain of the Services, you may be required to create an account (an "Account")
			and select a password and Bacsyd username, which will serve as a default link to your default Bacsyd profile of 
			the form www.bacsyd.com/profile/[username] (a "Bacsyd URL"). You must select a different Bacsyd URL for each new blog you create. 
			<p>You agree to provide Bacsyd with accurate, complete, and updated registration information, particularly your email address.
			<p>You are also responsible for maintaining the confidentiality of your Account password and for the security of your Account, and 
			you will notify Bacsyd immediately of any actual or suspected loss, theft, or unauthorized use of your Account or Account password.
			<br /><br />
			<h3><b>5. Themes</b></h3>
			<p>Bacsyd makes available specialized HTML and CSS code ("Bacsyd Template Code") for the design and layout of blog pages 
			available for use on some of the Services ("Themes"). Certain Themes are available for purchase as a Paid Service
			(as defined below). Purchased Premium Themes may not be transferred between Accounts,
			between profiles, or between Services on a single Account and are subject to the payment terms herein. 
			<br /><br />
			<h3><b>6. Miscellaneous</b></h3>
			<p>This Agreement, as modified from time to time, constitutes the entire agreement between you and Bacsyd 
			with respect to the subject matter hereof. This Agreement replaces all prior or contemporaneous understandings 
			or agreements, written or oral, regarding the subject matter hereof and constitutes the entire and exclusive 
			agreement between the parties. The failure of either party to exercise, in any way, any right provided for
			herein shall not be deemed a waiver of any further rights hereunder. If any provision of this Agreement is found 
			to be unenforceable or invalid, that provision shall be limited or eliminated to the minimum extent necessary
			so that this Agreement shall otherwise remain enforceable and in full force and effect. This Agreement is not assignable, 
			transferable, or sublicensable by you except with Bacsyd's prior written consent. Bacsyd
			may assign this Agreement in whole or in part at any time without your consent. No agency, 
			partnership, joint venture, or employment is created as a result of this Agreement and you 
			do not have any authority of any kind to bind Bacsyd in any respect whatsoever. Any notice to Bacsyd 
			that is required or permitted by this Agreement shall be in writing and shall be deemed 
			effective upon receipt, when delivered in person by nationally recognized overnight courier or
			mailed by first class, registered or certified mail, postage prepaid, to Bacsyd, Inc., Satellite-Kuntunse, Accra Ghana. 
			<br /><br />
			<h4 class="dp"><b>CEO</b></h4>
			 mtckobby@gmail.com 
			<br /><br />
		</article>
	</div>
	<footer id="footer">
		<p class="copyright">© 2018 Bacsyd. All rights reserved.</p>
	</footer>
</div>
<script src="_ast/_js/_query.js"></script>
<script src="_ast/_js/_main.js"></script>
<script src="_ast/_js/_scroll.js"></script>
<script src="_ast/_js/_nscroll.js"></script>
<script src="_ast/_js/_dialog.js"></script>
<script src="about/assets/js/skel.min.js"></script>
<script src="about/assets/js/util.js"></script>
<script src="about/assets/js/main.js"></script>
<script type="text/javascript">
function submitContactForm(){
	var nm = document.getElementById("name").value;
	var email = document.getElementById("email").value;
	var msg = document.getElementById("message").value;
	if(nm != "" || email != "" || msg != ""){
		var ajax = ajaxObj("POST", "about.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
				if(ajax.responseText != "sent"){
					Alert.render("Message was not sent :( Please try again");
					document.getElementById("name").value = ""
					document.getElementById("email").value = ""
					document.getElementById("message").value = ""
				}else {
					Alert.render("Message was sent :) We're get back to you within 24hrs");
					document.getElementById("name").value = ""
					document.getElementById("email").value = ""
					document.getElementById("message").value = ""
				}
	        }
        }
        ajax.send("nm="+nm+"&email="+email+"&msg="+msg);
	}else{
		Alert.render("Please fill out all data forms");
	}
}
</script>
</body>
</html>

