		<div class="col-md-9">
			<div class="">
			  <div class="nav-tabs-custom no-padding">
				<ul class="nav nav-tabs">
				  <li class="active"><a href="#home" data-toggle="tab"><i class="fa fa-user"></i></a></li>
				  <li><a href="#about" data-toggle="tab">About <span class="ufnametext"><?php echo $fname; ?></span></a></li>
				  <li><a class="hand" onclick="photos('<?php echo $u; ?>')">Photos</a></li>
				</ul>
				<div class="tab-content no-padding">
				 <div class="active tab-pane" id="home">
					<div class="box box-widget widget-user chat-bg-gradient" style="border-top: 0px solid;">
						<div id="targetBackgroundLayer" style="text-align: center;"><div class="widget-user-header bg-primary" <?php echo $user_bg_pic;?>></div></div>
						<a <?php echo $edit_profile;?> style="position:absolute;width:auto;right:0;top:-3px;" href="javascript:void(0)" pd-popup-open="changeBackground" class="btn btn-default btn-block"><b><span class="fa fa-edit"></span></b></a>		
						<div id="targetDpLayer" class="widget-user-image"><?php echo $uid_profile_pic;?></div>
						<div class="widget-user-image">
							<a <?php echo $edit_profile;?> href="javascript:void(0)" pd-popup-open="changeDp" class="btn btn-default btn-block uid-dp-edit"><b><span class="fa fa-edit"></span></b></a>
						</div>
					
						<div class="banner-user text-center" style="padding-top: 40px;">
							<h3 class="profile-username text-center"><span class="ufnametext"><?php echo $fname; ?></span> <span class="ulnametext"><?php echo $lname;?></span> 
							<br><span style="font-size:14px;">@<?php echo $uname;?></span><?php echo $page_check;?></h3>
							<p <?php echo $usertype_filter;?> class="label label-primary"><?php echo $user_profession;?></p>
							<p class="text-muted bioContent" style="margin-top: 10px;margin-bottom: 10px;"><span class="biotext"><?php echo $user_status;?></span></p>
						</div>
						 <div class="row mobile-only-show">
							<div class="col-xs-6 border-right">
							  <div class="description-block hand" data-toggle="modal" data-target="#frndModal">
								<h5 class="description-header" <?php echo $usertype_filter_srkout;?>><?php echo $friends_num;?></h5>
								<span class="description-text" <?php echo $usertype_filter_srkout;?>>Friends</span>
							  </div>
							</div>
							<div class="col-xs-6">
							  <div class="description-block hand" data-toggle="modal" data-target="#flwModal">
								<h5 class="description-header"><?php echo $followers_num;?></h5>
								<span class="description-text">Followers</span>
							  </div>
							</div>
						  </div>
						<div class="box-footer frnd-fllw-bg-gradient" style="padding-top: 0px;"></div>
					  </div>
				  </div>
				  <div class="tab-pane" id="about">
					<div class="box-body">
					  <strong><i class="fa fa-file-text-o margin-r-5"></i> Bio</strong>
					  <a <?php echo $edit_profile;?> href="javascript:void(0)" pd-popup-open="changeBio" class="pull-right btn-box-tool"><i class="fa fa-edit"></i> Edit</i></a>
					  <p class="text-muted"><span class="biotext"><?php echo $user_status;?></span></p>
					  <hr class="hr">
					  <strong <?php echo $usertype_filter;?>><i class="fa fa-book margin-r-5"></i> Education</strong>
					  <a <?php echo $edit_profile;?> href="javascript:void(0)" pd-popup-open="changeEdu" class="pull-right btn-box-tool"><i class="fa fa-edit"></i> Edit</i></a>
						<p <?php echo $usertype_filter;?> class="text-muted"><span class="edutext"><?php echo $user_education;?></span></p>
					  <hr class="hr">
					  <strong <?php echo $usertype_filter;?>><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
					  <a <?php echo $edit_profile;?> href="javascript:void(0)" pd-popup-open="changeLocation" class="pull-right btn-box-tool"><i class="fa fa-edit"></i> Edit</i></a>
						<p <?php echo $usertype_filter;?> class="text-muted"><span class="locationtext"><?php echo $user_location;?></span>, <span><?php echo $user_country;?></span></p>
					  <hr class="hr">
					  <strong <?php echo $usertype_filter;?>><i class="fa fa-briefcase margin-r-5"></i> Profession</strong>
					  <a <?php echo $edit_profile;?> href="javascript:void(0)" pd-popup-open="changeProfession" class="pull-right btn-box-tool"><i class="fa fa-edit"></i> Edit</i></a>
						<p <?php echo $usertype_filter;?> class="text-muted"><span class="professiontext"><?php echo $user_profession;?></span></p>
					  <hr class="hr">
					  <strong><i class="fa fa-phone margin-r-5"></i> Contact</strong>
					  <a <?php echo $edit_profile;?> href="javascript:void(0)" pd-popup-open="changeContact" class="pull-right btn-box-tool"><i class="fa fa-edit"></i> Edit</i></a>
						<p class="text-muted"><span class="mobiletext"><?php echo $user_mobile;?></span></p>
					</div>
				  </div>
				</div>
			  </div>
			</div>
        </div>
		