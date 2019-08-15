		<div class="col-md-3 col-sm-6 col-xs-12 mobile-no-show">
			<div class="">
				<div class="box box-primary" <?php echo $usertype_filter;?>>
					<div class="box-header with-border">
					  <h3 class="box-title">Friends • <span><?php echo $friends_num ?></span></h3>
					  <div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					  </div>
					</div>
					<div class="box-body no-padding">
					  <ul class="users-list clearfix text-center">
						<?php echo $frndsList;?>
					  </ul>
					</div>
				   <div class="box-footer text-center">
					  <a href="javascript:void(0)" data-toggle="modal" data-target="#frndModal">View all friends</a>
				   </div>
				</div>
				<div class="box box-primary">
					<div class="box-header with-border">
					  <h3 class="box-title">Followers • <span><?php echo $followers_num ?></span></h3>
					  <div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					  </div>
					</div>
					<div class="box-body no-padding">
					  <ul class="users-list clearfix text-center">
						<?php echo $fllwsList ?>
					  </ul>
					</div>
				   <div class="box-footer text-center">
					  <a href="javascript:void(0)" data-toggle="modal" data-target="#flwModal">View all followers</a>
				   </div>
				</div>
				<div class="box box-primary">
					<div class="box-header with-border">
					  <h3 class="box-title">Photos</h3>
					  <div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					  </div>
					</div>
					<div class="box-body no-padding text-center">
					    <div data-grid="images" data-target-height="150">
							<?php echo $photos; ?>	
						</div>     
					</div>
				   <div class="box-footer text-center">
					  <a href="javascript:void(0)" onclick="photos('<?php echo $u; ?>')">View all photos</a>
				   </div>
				</div>
				<?php include_once("_ext/_def/default-footer.php");?>
			</div>
        </div>