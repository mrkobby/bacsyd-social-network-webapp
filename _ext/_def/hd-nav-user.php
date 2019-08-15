		<li class="dropdown user user-menu">
            <a href="" class="dropdown-toggle" data-toggle="dropdown">
               <?php echo $profile_logo ?>
              <span class="hidden-xs"><span class="fnametext"><?php echo $firstname; ?></span> <span class="lnametext"><?php echo $lastname; ?></span></span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header color-raven" onclick="uid('<?php echo $log_username; ?>')">
                <?php echo $profile_logo_dropdown ?>
                <p>
                  <span class="fnametext"><?php echo $firstname; ?></span> <span class="lnametext"><?php echo $lastname; ?></span>
                  <small>Member since <?php echo $member ?></small>
                </p>
              </li>
              <li class="user-body">
                <div class="row">
				  <div class="col-xs-6 text-center hand" data-toggle="modal" data-target="#ulogfrndModal">
                    <a>Friends <br><?php echo $ulog_friends_num ?></a>
                  </div>
                  <div class="col-xs-6 text-center right-border hand" data-toggle="modal" data-target="#ulogflwModal">
                    <a>Followers <br><?php echo $ulog_followers_num ?></a>
                  </div>
                </div>
              </li>
              <li class="user-footer">
				<div class="pull-left" style="width:50%;">
                  <a class="btn btn-info btn-block no-border-radius" onclick="lockscreen()"><span class="fa fa-lock" ></span>&nbsp;&nbsp;Lockscreen</a>
                </div>
                <div class="pull-right" style="width:50%;">
                  <a class="btn btn-primary btn-block no-border-radius hand" onclick="logout()"><b><span class="fa fa-power-off" ></span>&nbsp;&nbsp;Logout</b></a>
                </div>
              </li>
            </ul>
          </li>
		  <li>
		     <a href="" data-toggle="control-sidebar"><i class="fa fa-gear"></i></a>
          </li>