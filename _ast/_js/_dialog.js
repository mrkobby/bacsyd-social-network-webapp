$(function(){$("[pd-popup-open]").on("click",function(b){var a=jQuery(this).attr("pd-popup-open");$('[pd-popup="'+a+'"]').fadeIn(100);document.getElementById("statusPostBar").blur();b.preventDefault()});$("[pd-popup-close]").on("click",function(b){var a=jQuery(this).attr("pd-popup-close");$('[pd-popup="'+a+'"]').fadeOut(200);b.preventDefault()})});function CustomAlert(){this.render=function(b){var a=window.innerWidth;var e=window.innerHeight;var d=document.getElementById("dialogoverlay");var c=document.getElementById("dialogbox");$(d).fadeIn(300);d.style.height=e+"px";$(c).fadeIn(100);document.getElementById("dialogboxhead").innerHTML="";document.getElementById("dialogboxbody").innerHTML="<b>"+b+"</b>";document.getElementById("dialogboxfoot").innerHTML='<button class="btn btn-primary btn-flat" onclick="Alert.ok()">&nbsp;&nbsp;&nbsp; OK &nbsp;&nbsp;&nbsp;</button>'};this.ok=function(){document.getElementById("dialogbox").style.display="none";document.getElementById("dialogoverlay").style.display="none"}}var Alert=new CustomAlert();function CustomConfirm(){this.render=function(b){var a=window.innerWidth;var e=window.innerHeight;var d=document.getElementById("dialogoverlay");var c=document.getElementById("dialogbox");$(d).fadeIn(300);d.style.height=e+"px";$(c).fadeIn(100);document.getElementById("dialogboxhead").innerHTML="";document.getElementById("dialogboxbody").innerHTML="<b>"+b+"</b>";document.getElementById("dialogboxfoot").innerHTML='<button class="btn btn-primary btn-flat" onclick="Confirm.yes()"> Yes </button> &nbsp;&nbsp; <button class="btn btn-info btn-flat" onclick="Confirm.no()"> &nbsp;&nbsp;&nbsp;&nbsp; No &nbsp;&nbsp;&nbsp;&nbsp;</button>'}}var Confirm=new CustomConfirm();function QuickAlert(){this.render=function(a){var b=document.getElementById("alertbox");$(b).fadeIn(200);setTimeout(function(){$(b).fadeOut(500)},3000);document.getElementById("alertboxbody").innerHTML=""+a+""}}var Hint=new QuickAlert();