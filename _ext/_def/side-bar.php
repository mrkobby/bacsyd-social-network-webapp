<?php
$photo_num = "";
$phtosql = "SELECT COUNT(id) FROM photos WHERE user='$log_username'";
$phtoquery = mysqli_query($db_connection,$phtosql);
$numrows = mysqli_num_rows($phtoquery);
$query_count = mysqli_fetch_row($phtoquery);
$photo_count = $query_count[0];
if($photo_count < 1){
	$photo_num = '';
}else{
	$photo_num = '<small class="label pull-right bg-primary">'.$photo_count.'</small>';
}
?>
 <aside class="main-sidebar">
    <section class="sidebar">
	<div class="user-panel bg-primary color-raven hand" onclick="window.location = 'uid&<?php echo $log_username;?>';">
        <div class="pull-left image targetDpLayer hand">
           <?php echo $sidebar_profile_pic;?>
        </div>
        <div class="pull-left info border-bottom">
          <p class="hand" onclick="window.location = 'uid&<?php echo $log_username;?>';">
			<span>@<?php echo $log_username;?></span>
		  </p>
          <?php echo $status_check;?>
        </div>
      </div>
	  <ul class="sidebar-menu">
		<li class="header" style="padding: 0px 0px 3px 15px;"></li>
		<li>
          <a class="hand" onclick="home('<?php echo $log_username;?>')">
            <i class="fa fa-home"></i> <span>Home</span>
          </a>
        </li>
		<li>
          <a class="hand" onclick="uid('<?php echo $log_username;?>')">
            <i class="fa fa-user"></i> <span>My profile</span>
            <span class="pull-right-container"></span>
          </a>
        </li>
		<li>
          <a class="hand" onclick="alerts('<?php echo $log_username;?>')">
            <i class="fa fa-bell"></i> <span>Notifications</span>
            <span class="pull-right-container" id="quick_note_num"><?php echo $note_label;?></span>
          </a>
        </li>
        <li>
          <a class="hand" onclick="explore('<?php echo $log_username;?>')">
            <i class="fa fa-globe"></i> <span>Explore</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-primary"></small>
            </span>
          </a>
        </li>
		<li>
          <a class="hand" onclick="photos('<?php echo $log_username;?>')">
            <i class="fa fa-photo"></i> <span>Photo gallery</span>
            <span class="pull-right-container">
              <?php echo $photo_num;?>
            </span>
          </a>
        </li>
		<li>
          <a class="hand" onclick="discover('<?php echo $log_username;?>')">
            <i class="fa fa-group"></i> <span>Discover people</span>
          </a>
        </li>
		<li class="header" style="padding: 0px 0px 3px 15px;"></li>
		<li class="treeview">
          <a class="hand">
            <i class="fa fa-power-off"></i>
            <span>Power</span>
          </a>
          <ul class="treeview-menu">
            <li><a class="hand" onclick="lockscreen()"><i class="fa fa-lock"></i>Lockscreen</a></li>
            <li><a class="text-red hand" onclick="logout()"><i class="fa fa-sign-out"></i> Logout</a></li>
          </ul>
        </li>
		<li class="header" style="padding: 0px 0px 3px 15px;"></li>
      </ul>
    </section>
  </aside>