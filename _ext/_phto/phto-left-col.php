		<div class="col-md-9">
		<div id="alertbox"><div><div id="alertboxbody"></div></div></div>
			<div class="">
			  <div class="nav-tabs-custom no-padding" style="background: inherit;">
				<ul class="nav nav-tabs navtab-bg-gradient">
				  <li><a class="hand" onclick="uid('<?php echo $u;?>')"><i class="fa fa-user"></i></a></li>
				  <li class="active"><a href="#photo" data-toggle="tab">Photos of <?php echo $fname;?></a></li>
				</ul>
				<div class="tab-content no-padding" style="background: inherit;">
				  <div class="tab-pane active" id="photo">
					 <div id="portfolio" class="box-body">
						  <span id="addBtn">
							 <p <?php echo $edit_profile;?> style="margin: 10px auto 10px auto;width: auto;text-align: center;">
								<button pd-popup-open="addPhoto" class="btn btn-primary"><span class="fa fa-plus-circle"></span> &nbsp; Add photo</button>
							 </p>
						  </span>
						  <p id="phtoBackBtn" style="margin: 10px auto 10px auto;width: auto;text-align: center;display:none;">
							<button class="btn btn-info" onclick="backToGalleries()">Back to Galleries</button>
						  </p>
						<div id="galleries" class="row" style="margin: auto; text-align: center;">
							<?php echo $gallery_list; ?>
						</div>
						<div id="photos" class="row" style="margin: auto; text-align: center;"></div>
					</div>
					<div class="row" id="picbox"></div>	
				  </div>
				</div>
			  </div>
			</div>
        </div>
		