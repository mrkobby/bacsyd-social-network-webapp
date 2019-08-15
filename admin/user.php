<?php 
include_once("_admin_ext/admin_check_status.php");
if($id_ok == false){
	header("location: ../index.php");
    exit();
}
$vid = "";
if(isset($_GET["vid"])){
	$vid = preg_replace('#[^a-z0-9]#i', '', $_GET['vid']);
} else {
    header("location: ../index.php");
    exit();	
}
$sql = "SELECT * FROM admin WHERE vid='$vid' LIMIT 1";
$query = mysqli_query($db_connection, $sql);
$numrows = mysqli_num_rows($query);
if($numrows < 1 ){
	echo "That user does not exist, press back";
    exit();	
}
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
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
<div id="relax" style="display: none;opacity: .8;position: fixed;font-size: 22px;color: #fff;top: 0px;left: 0px;background: #363636;width: 100%;height: 100%;z-index: 99999;line-height: 400px;text-align: center;">Please wait...</div>
<?php include_once("_admin_ext/users.php");?>
<div id="dialogoverlay"></div><div id="dialogbox"><div><div id="dialogboxhead"></div><div id="dialogboxbody"></div><div id="dialogboxfoot"></div></div></div>
<div class="wrapper">
  <header class="main-header">
	 <a onclick="window.location = 'user.php?vid=<?php echo $vid;?>';" class="logo hand" style="text-decoration:none;">
		<span class="logo-mini"><b>B</b></span>
		<span class="logo-lg"><img style="width:100px;" src="../_ast/_img/new_bacsyd.png"></span>
    </a>
    <nav class="navbar navbar-static-top">
	<div style="color: #fff;font-weight: 700;width: 185px;position: absolute;margin: 15px 0px 0px 15px;border-radius: 3px;"><?php echo $usercount;?></div>
	  <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
		 <li class="dropdown notifications-menu">
            <a onclick="window.location = '_admin_ext/logout.php';" class="dropdown-toggle hand"><i class="fa fa-power-off"></i><span class="label label-danger"></span></a>
          </li>
		</ul>
      </div>
    </nav>
  </header>
  
  <div class="content-wrapper">
    <section class="content" style="min-height: 80px;">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
			<input class="form-control input-md" name="qu" id="qu" onKeyUp="fx(this.value)" autocomplete="off" type="text" placeholder="Search users" tabindex="1">
        </div>
      </div>
		<div class="row" id="userlist" style="margin-top: 15px;">		
			<?php echo $userlist;?>	
		</div>
		<div class="row" id="searchresult" style="margin-top: 15px;">		
				
		</div>
    </section>
  </div>	
</div> 
<script src="../_ast/_js/_query.js"></script>
<script src="../_ast/_js/_scroll.js"></script>
<script src="../_ast/_js/_nscroll.js"></script>
<script src="../_ast/_js/_script.js"></script>
<script src="../_ast/_js/_ajax.js"></script>
<script src="../_ast/_js/_main.js"></script>
<script src="../_ast/_js/_dialog.js"></script>
<script> 
function fx(str){
var s1=document.getElementById("qu").value;
var xmlhttp;
if (str.length==0) {
    document.getElementById("searchresult").innerHTML="";
	document.getElementById("searchresult").style.display="block";
    document.getElementById("userlist").style.display="block";
	return;
  }
if (window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();
  }else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
xmlhttp.onreadystatechange=function(){
  if (xmlhttp.readyState==4 && xmlhttp.status==200){
    document.getElementById("searchresult").innerHTML=xmlhttp.responseText;
	document.getElementById("searchresult").style.display="block";
	 document.getElementById("userlist").style.display="none";
    }
  }
xmlhttp.open("GET","_admin_ext/users_search.php?n="+s1,true);
xmlhttp.send();	
}
</script>
</body>
</html>
