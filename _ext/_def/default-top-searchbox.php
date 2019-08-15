<a href="" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
	<span id="quick_note_toggle_num" style="font-size: 10px;"><?php echo $note_label_tog;?></span>
</a>

<div class="input-group searchb">
	<span class="input-group-addon">@</span>
	<input type="text" name="qu" id="qu" onKeyUp="fx(this.value)" class="form-control" data-action="grow" placeholder="Search...">
</div>
<script> 
function fx(str){
var s1=document.getElementById("qu").value;
var xmlhttp;
if (str.length==0) {
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";
	document.getElementById("search-layer").style.width="auto";
	document.getElementById("search-layer").style.height="auto";
	document.getElementById("livesearch").style.display="block";
    return;
  }
if (window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();
  }else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
xmlhttp.onreadystatechange=function(){
  if (xmlhttp.readyState==4 && xmlhttp.status==200){
    document.getElementById("livesearch").innerHTML=xmlhttp.responseText;
	document.getElementById("search-layer").style.width="100%";
	document.getElementById("search-layer").style.height="100%";
	document.getElementById("livesearch").style.display="block";
    }
  }
xmlhttp.open("GET","_ext/_search/call_main_search_ajax.php?n="+encodeURIComponent(s1),true);
xmlhttp.send();	
}
</script>