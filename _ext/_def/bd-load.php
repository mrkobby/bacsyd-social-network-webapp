<div id="loadx">
	<div class="page-loader-wrapper">
		<div class="loader">
			<div class="preloader">
				<div class="spinner-layer pl-white">
					<div class="circle-clipper left">
					   <div class="circle"></div>
					</div>
					<div class="circle-clipper right">
						<div class="circle"></div>
					</div>
				</div>
			</div>
		   <p style="color:#b3b3b3;">Please wait...</p>
		</div>
	</div>
</div>
<script>
window.addEventListener("load", function(){
	var load_screen = document.getElementById("loadx");
	$('.page-loader-wrapper').fadeOut(1000);
	setTimeout(function(){document.body.removeChild(load_screen);}, 1000);
/* 	document.body.removeChild(load_screen); */
});
</script>