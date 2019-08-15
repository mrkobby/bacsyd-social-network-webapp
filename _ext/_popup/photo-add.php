<div class="popup" id="addPhoto" pd-popup="addPhoto">
	<div class="popup-inner">
		<div id="photoPostDiv" style="display: none; z-index:10; text-align: center;position: absolute;background: rgba(60, 57, 57, 0.85);width: 100%;height: 100%;font-size: 22px;color: #fff;left:0px;top:0px;line-height: 180px;">Uploading...</div>
		<div class="box-header">
			<i class="fa fa-photo"></i>
			<h4 class="box-title">Add photo</h4>
			<h6>Choose a gallery, select photo and Add</h6>
		</div>
		<div class="box-body">
			<div class="box box-primary">
				<?php echo $photo_form;?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(e){
	$("#choose_photo").change(function(){
		$(".fileCaption").hide(200);
		$(".fileBtn").removeClass('btn-info').addClass('color-raven');	
	});
	$("#photoform").on('submit',(function(e) {	
		document.getElementById("photoPostDiv").style.display = 'block';
		e.preventDefault();
		$.ajax({
        	url: "_ext/_phto/_upload_photo.php",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data){
			   $("#galleries").html(data);
			   document.getElementById("choose_photo").value = "";
				$(".fileCaption").show(200);
				$(".fileBtn").removeClass('color-raven').addClass('btn-info');
				$("#addPhoto").fadeOut(100);
				document.getElementById("photoPostDiv").style.display = 'none';
				document.getElementById("caption").value = "";
		    },
		  	error: function() {} 	        
	   });
	}));
	$('#photoCancelBtn').on('click', function(e)  {
		document.getElementById("choose_photo").value = "";
		document.getElementById("caption").value = "";
		$(".fileCaption").fadeIn(500);
		$(".fileBtn").removeClass('color-raven').addClass('btn-info');
	});
});
function showGallery(gallery,user){
	_("galleries").style.display = "none";
	_("addBtn").style.display = "none";
	_("phtoBackBtn").style.display = "block";
	_("photos").style.display = "block";
	_("photos").innerHTML = '<div class="preloader pl-size-xs"><div class="spinner-layer pl-red"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
	var ajax = ajaxObj("POST", "_parse/_system_photo.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			_("photos").innerHTML = '';
			var pics = ajax.responseText.split("|||");
			for (var i = 0; i < pics.length; i++){
				var pic = pics[i].split("|");
				_("photos").innerHTML += '<div class="col-sm-3 col-xs-6 portfolio-item hand"><img style="border:1px solid black;" onclick="photoShowcase(\''+pics[i]+'\')" src="_USER/'+user+'/'+pic[1]+'" alt="pic"></div>';
			}
			_("photos").innerHTML += '<p style="clear:left;"></p>';
		}
	}
	ajax.send("show=galpics&gallery="+gallery+"&user="+user);
}
function backToGalleries(){
	_("photos").style.display = "none";
	_("addBtn").style.display = "block";
	_("phtoBackBtn").style.display = "none";
	_("galleries").style.display = "block";
}
function photoShowcase(picdata){
	var data = picdata.split("|");
	_("addBtn").style.display = "none";
	_("phtoBackBtn").style.display = "none";
	_("photos").style.display = "none";
	_("picbox").style.display = "block";
	_("picbox").innerHTML = '<span style="margin-right: 5px;width: auto;"><button class="btn btn-primary" onclick="closePhoto()">Back</button></span>';
	if("<?php echo $isOwner ?>" == "yes"){
		_("picbox").innerHTML += '<span id="deletelink" style="margin-left: 5px;width: auto;"><button class="btn btn-danger" onclick="deletePhoto(\''+data[0]+'\')">Delete photo</button></span>';
	}
	_("picbox").innerHTML += '<div class="col-sm-12" data-action="zoom" style="margin-top: 10px;"><img src="_USER/<?php echo $u; ?>/'+data[1]+'" alt="photo"></div>';
}
function closePhoto(){
	_("picbox").innerHTML = '';
	_("picbox").style.display = "none";
	_("phtoBackBtn").style.display = "block";
	_("photos").style.display = "block";
	_("addBtn").style.display = "none";
}
function deletePhoto(id){
	Confirm.render("Are you sure you want to delete this photo?");
	Confirm.yes = function(){
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverlay').style.display = "none";
		_("deletelink").style.visibility = "hidden";
		_("deletePhoto").style.display = "block";
		var ajax = ajaxObj("POST", "_parse/_system_photo.php");
		ajax.onreadystatechange = function() {
			if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "deleted_ok"){
					window.location = "photos&<?php echo $log_username;?>";
				}
			}
		}
		ajax.send("delete=photo&id="+id);
	}
	Confirm.no = function(){
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverlay').style.display = "none";
	}
}
</script>