	<div class="col-md-6 col-sm-12 col-xs-12">
		<div id="alertbox"><div><div id="alertboxbody"></div></div></div>
		<div <?php echo $uid_visibility;?> class="box box-primary" style="border-top:0px solid;background: transparent;">
			<div class="row box-body no-padding">
				<div class="col-xs-4" style="padding-right: 10px;" id="friendBtn">
					<?php echo $friend_button;?>
				</div>
				<div class="col-xs-4" style="padding-right: 10px;padding-left: 10px;" id="followBtn">
					<?php echo $follow_button;?>
				</div>
				<div class="col-xs-4" style="padding-left: 10px;" id="blockBtn">
					<?php echo $block_button;?>
				</div>
			</div>
		</div>
		<div class="box-body no-padding">
			<div class="box box-primaary">
				<div class="box-body no-padding">
					<?php echo $status_ui;?> 
				</div>
			</div>
		</div>
		<div id="profilelogs"> 
			<div style="text-align:center;margin: 5px;"> 
				<div class="preloader pl-size-xs"><div class="spinner-layer pl-green"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>
			</div>			
		</div>
	</div>