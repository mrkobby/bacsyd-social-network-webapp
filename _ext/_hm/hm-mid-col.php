		<div class="col-md-3 col-sm-6 col-xs-12 mobile-no-show" style="position: fixed;right: 20%;width: 21%;">
			<div class="middle-most-fixed">
				<?php include_once("_ext/_manual_updts/_weather.php");?>
				<div class="box box-primary">
					<div class="box-header with-border">
					  <h3 class="box-title">Latest Members</h3>
					  <div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					  </div>
					</div>
					<div class="box-body no-padding">
					  <ul class="users-list clearfix">
						<?php echo $userlist;?>
					  </ul>
					</div>
				   <div class="box-footer text-center">
					  <a href="javascript:void(0)" onclick="discover('<?php echo $log_username; ?>')">View all users</a>
				   </div>
				</div>
				<?php include_once("_ext/_manual_updts/_sponsored.php");?>
				<?php include_once("_ext/_def/default-footer.php");?>
			</div>
        </div>