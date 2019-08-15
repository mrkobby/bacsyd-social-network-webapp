<a onclick="home('<?php echo $log_username; ?>')" class="logo hand" id="top_nav">
    <span class="logo-mini"><b>B</b></span>
	<span class="logo-lg"><img style="width:100px;" src="_ast/_img/new_bacsyd.png"></span>
</a>
<div id="searchNavBox" class="input-group" style="position: absolute;top: 0px;display:none;">
	<span class="input-group-addon">@</span>
	<input type="text" name="er" id="er" onKeyUp="fp(this.value)" class="form-control" style="height: 50px;" placeholder="Search...">
</div>
<script>
function fp(str){
var s1=document.getElementById("er").value;
var xmlhttp;
if (str.length==0) {
    document.getElementById("livesearchMobile").innerHTML="";
    document.getElementById("livesearchMobile").style.border="0px";
	document.getElementById("search-layer").style.width="auto";
	document.getElementById("search-layer").style.height="auto";
	document.getElementById("livesearchMobile").style.display="block";
    return;
  }
if (window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();
  }else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
xmlhttp.onreadystatechange=function(){
  if (xmlhttp.readyState==4 && xmlhttp.status==200){
    document.getElementById("livesearchMobile").innerHTML=xmlhttp.responseText;
	document.getElementById("search-layer").style.width="100%";
	document.getElementById("search-layer").style.height="100%";
	document.getElementById("livesearchMobile").style.display="block";
    }
  }
xmlhttp.open("GET","_ext/_search/call_main_search_ajax.php?n="+encodeURIComponent(s1),true);
xmlhttp.send();	
}
</script>