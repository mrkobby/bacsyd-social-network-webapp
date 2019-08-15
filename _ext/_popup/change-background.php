<div class="popup" id="changeBackground" pd-popup="changeBackground">
	<div class="popup-inner">
	<div id="bgPostDiv" style="display: none; z-index:10; text-align: center;position: absolute;background: rgba(60, 57, 57, 0.85);width: 100%;height: 100%;font-size: 22px;color: #fff;left:0px;top:0px;line-height: 180px;">Updating...</div>
		<div class="box-header">
			<i class="fa fa-photo"></i>
			<h4 class="box-title">Change background</h4>
		</div>
		<div class="box-body">
			<div class="box box-primary">
				<form id="uploadBackground" action="_parse/upload_bg.php" method="post">
					<div class="box-body no-padding" style="margin-bottom: 5px;">
						<div class="input-group" style="margin:20px auto;">
							<label id="bgBtn" for="bgfile" class="btn btn-primary btn-block" style="width: 100%;"><span id="fileCaptionBg">Select photo &nbsp;</span><span class="fa fa-photo"></span></label>
							<input name="userBackground" id="bgfile" style="width:0%;visibility:hidden;display: none;" type="file" accept="image/*" required />
						</div>
					</div>
					<div class="box-footer no-padding">
						<input type="submit" value="Save" class="btn btn-primary pull-right"></input>
						<a id="bgCancel" pd-popup-close="changeBackground" href="#" class="btn btn-default pull-left">Cancel</a>
					</div>
				</form>	
			</div>
		</div>
	</div>
</div>

<script src="_ast/_js/_query.js"></script>
<script type="text/javascript">
$(document).ready(function (e) {
	$("#bgfile").change(function(){
		$("#fileCaptionBg").hide(200);
		$("#bgBtn").removeClass('btn-primary').addClass('color-raven');
	});
	$("#uploadBackground").on('submit',(function(e) {
		document.getElementById("bgPostDiv").style.display = 'block';
		e.preventDefault();
		$.ajax({
        	url: "_parse/upload_bg.php",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data){
			   $("#targetBackgroundLayer").html(data);
			   document.getElementById("bgfile").value = "";
			   $("#fileCaptionBg").show(200);
			   $("#bgBtn").removeClass('color-raven').addClass('btn-primary');
			   $('#changeBackground').fadeOut(200);
			   document.getElementById("bgPostDiv").style.display = 'none';
		    },
		  	error: function() {} 	        
	   });
	}));
	$('#bgCancel').on('click', function(e)  {
		document.getElementById("bgfile").value = "";
		$("#fileCaptionBg").show(200);
		$("#bgBtn").removeClass('color-raven').addClass('btn-primary');
    });
});
</script>	