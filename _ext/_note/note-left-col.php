	<div class="col-md-9 col-sm-12 col-xs-12">
          <div class="info-banner color-raven text-center">
              <span class="info-box-number">Notifications</span>
          </div>
          <div class="box box-primary" <?php echo $showreqbox;?>>
			<div class="box-header with-border">
				<h3 class="box-title">Friend Requests</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body no-padding">
			  <ul class="products-list product-list-in-box">
					<?php echo $friend_requests;?>
			  </ul>
			</div>
			<div class="box-footer text-center"></div>
		</div>
		<?php echo $notification_list;?>			
	</div>