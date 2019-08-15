function _(x){
		return document.getElementById(x);
}
function toggleElement(x){
		var x = _(x);
		if(x.style.display == 'block'){
			x.style.display = 'none';
		}else{
			x.style.display = 'block';
		}
}
function bacsydhome(){
	$("#loader-starter").fadeIn(300);
	window.location = "../bacsyd";
}
function signup(){
	$("#loader-starter").fadeIn(300);
	window.location = "signup";
}
function reset(){
	$("#loader-starter").fadeIn(300);
	window.location = "reset";
}
function home(user){
	$("#loader-starter").fadeIn(300);
	window.location = "home&"+user;
}
function uid(user){
	$("#loader-starter").fadeIn(300);
	window.location = "uid&"+user;
}
function alerts(user){
	$("#loader-starter").fadeIn(300);
	window.location = "alerts&"+user;
}
function explore(user){
	$("#loader-starter").fadeIn(300);
	window.location = "explore&"+user;
}
function photos(user){
	$("#loader-starter").fadeIn(300);
	window.location = "photos&"+user;
}
function discover(user){
	$("#loader-starter").fadeIn(300);
	window.location = "discover&"+user;
}
function chat(user){
	$("#loader-starter").fadeIn(300);
	window.location = "chat&"+user;
}
function lockscreen(){
	$("#loader-starter").fadeIn(300);
	window.location = "_parse/_lockscreen.php";
}
function logout(){
	$("#loader-starter").fadeIn(300);
	window.location = "_parse/_logout.php";
}

$("#searchNavBtn").click(function(){
	$("#searchNavBox").show(400);
	$("#searchNavBtn").hide(0);
	$("#closeSearchNavBtn").show(0);
	$("#search-layer").fadeIn(100);
	document.getElementById("er").focus();
});
$("#closeSearchNavBtn").click(function(){
	$("#searchNavBox").hide(400);
	$("#searchNavBtn").show(0);
	$("#closeSearchNavBtn").hide(0);
	document.getElementById("er").value = "";
	$("#search-layer").fadeOut(100);
});
