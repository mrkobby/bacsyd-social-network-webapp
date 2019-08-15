<?php
include_once("db_connection.php");
$tbl_admin = "CREATE TABLE IF NOT EXISTS admin (
              id INT(11) NOT NULL AUTO_INCREMENT,
              vid VARCHAR(255) NOT NULL,
			  email VARCHAR(255) NOT NULL,
			  password VARCHAR(255) NOT NULL,
              PRIMARY KEY (id),
			  UNIQUE KEY vid (vid,email)
             )";
$query = mysqli_query($db_connection, $tbl_admin);
if ($query === TRUE) {echo "<h6 style='color:green;'>admin table created OK :) </h6>"; } else {echo "<h6 style='color:red;'>admin table NOT created :( </h6>"; }

$insertsql = "INSERT INTO admin (vid, email, password) VALUES ('06d4a01d68220f1b73df2dacba4e572f','mtckobby@gmail.com','2f6f13e75b39552b0135839b4c8f3a4d')";
$insertquery = mysqli_query($db_connection, $insertsql);
if ($insertquery === TRUE) {echo "<h6 style='color:blue;'>admin table filled with data :) </h6>"; } else {echo "<h6 style='color:red;'>admin table NOT filled with data :( </h6>"; }

$tbl_users = "CREATE TABLE IF NOT EXISTS _users (
              id INT(11) NOT NULL AUTO_INCREMENT,
			  firstname VARCHAR(255) NOT NULL,
			  lastname VARCHAR(255) NOT NULL,
			  username VARCHAR(16) NOT NULL,
			  email VARCHAR(255) NOT NULL,
			  password VARCHAR(255) NOT NULL,
			  usertype ENUM('user','page') NOT NULL DEFAULT 'user',
              PRIMARY KEY (id),
			  UNIQUE KEY username (username,email)
             )";
$query = mysqli_query($db_connection, $tbl_users);
if ($query === TRUE) {echo "<h6 style='color:green;'>_users table created OK :) </h6>"; } else {echo "<h6 style='color:red;'>_users table NOT created :( </h6>"; }

$tbl_userinfo = "CREATE TABLE IF NOT EXISTS _userinfo (
              id INT(11) NOT NULL AUTO_INCREMENT,
			  username VARCHAR(16) NOT NULL,
			  gender VARCHAR(6) NULL,
			  ip VARCHAR(255) NOT NULL,
			  signup DATETIME NOT NULL,
			  lastlogin DATETIME NOT NULL,
			  notecheck DATETIME NOT NULL,
			  status ENUM('offline','online') NOT NULL DEFAULT 'offline',
              PRIMARY KEY (id),
			  UNIQUE KEY username (username)
             )";
$query = mysqli_query($db_connection, $tbl_userinfo);
if ($query === TRUE) {echo "<h6 style='color:green;'>_userinfo table created OK :) </h6>"; } else {echo "<h6 style='color:red;'>_userinfo table NOT created :( </h6>"; }

$tbl_userdetails = "CREATE TABLE IF NOT EXISTS _userdetails (
              id INT(11) NOT NULL,
			  username VARCHAR(16) NOT NULL,
			  education VARCHAR(255) NULL,
			  location VARCHAR(255) NULL,
			  hometown VARCHAR(255) NULL,
			  profession VARCHAR(255) NULL,
			  mobile VARCHAR(255) NULL,
			  updatedate DATETIME NOT NULL,
              PRIMARY KEY (id),
			  UNIQUE KEY username (username)
             )";
$query = mysqli_query($db_connection, $tbl_userdetails);
if ($query === TRUE) {echo "<h6 style='color:green;'>_userdetails table created OK :) </h6>"; } else {echo "<h6 style='color:red;'>_userdetails table NOT created :( </h6>"; }

$tbl_userbasic = "CREATE TABLE IF NOT EXISTS _userbasic (
              id INT(11) NOT NULL,
			  username VARCHAR(16) NOT NULL,
			  nickname VARCHAR(255) NULL,
			  relationship VARCHAR(255) NULL,
			  country VARCHAR(255) NULL,
			  update_date DATETIME NOT NULL,
              PRIMARY KEY (id),
			  UNIQUE KEY username (username)
             )";
$query = mysqli_query($db_connection, $tbl_userbasic);
if ($query === TRUE) {echo "<h6 style='color:green;'>_userbasic table created OK :) </h6>"; } else {echo "<h6 style='color:red;'>_userbasic table NOT created :( </h6>"; }

$tbl_useroptions = "CREATE TABLE IF NOT EXISTS _useroptions ( 
                id INT(11) NOT NULL,
                username VARCHAR(16) NOT NULL,
				avatar VARCHAR(255) NULL,  
				background VARCHAR(255) NULL,
				userstatus TEXT NOT NULL,
				state ENUM('log','lock') NOT NULL DEFAULT 'log',
				privacy ENUM('0','1') NOT NULL DEFAULT '0',
				editdate DATETIME NOT NULL,
				lastchat DATETIME NOT NULL,
                PRIMARY KEY (id),
                UNIQUE KEY username (username) 
                )"; 
$query = mysqli_query($db_connection, $tbl_useroptions); 
if ($query === TRUE) {echo "<h6 style='color:green;'>_useroptions table created OK :) </h6>"; } else {echo "<h6 style='color:red;'>_useroptions table NOT created :( </h6>"; }

$tbl_userthumbnails = "CREATE TABLE IF NOT EXISTS _userthumbnails (
				id INT(11) NOT NULL,
				username VARCHAR(16) NOT NULL,
				avatartemp VARCHAR(255) NULL,  
				backgroundtemp VARCHAR(255) NULL,
				PRIMARY KEY (id),
				UNIQUE KEY username (username)
             )";
$query = mysqli_query($db_connection, $tbl_userthumbnails);
if ($query === TRUE) {echo "<h6 style='color:green;'>_userthumbnails table created OK :) </h6>"; } else {echo "<h6 style='color:red;'>_userthumbnails table NOT created :( </h6>"; }

$tbl_usersecurity = "CREATE TABLE IF NOT EXISTS _usersecurity (
				id INT(11) NOT NULL,
				username VARCHAR(16) NOT NULL,
				xquestion TEXT NOT NULL,  
				xanswer VARCHAR(255) NULL,
				yquestion TEXT NOT NULL,  
				yanswer VARCHAR(255) NULL,
				activation ENUM('0','1') NOT NULL DEFAULT '0',
				PRIMARY KEY (id),
				UNIQUE KEY username (username)
             )";
$query = mysqli_query($db_connection, $tbl_usersecurity);
if ($query === TRUE) {echo "<h6 style='color:green;'>_usersecurity table created OK :) </h6>"; } else {echo "<h6 style='color:red;'>_usersecurity table NOT created :( </h6>"; }


$tbl_friends = "CREATE TABLE IF NOT EXISTS friends ( 
                id INT(11) NOT NULL AUTO_INCREMENT,
                user1 VARCHAR(16) NOT NULL,
                user2 VARCHAR(16) NOT NULL,
                datemade DATETIME NOT NULL,
                accepted ENUM('0','1') NOT NULL DEFAULT '0',
                PRIMARY KEY (id)
                )"; 
$query = mysqli_query($db_connection, $tbl_friends); 
if ($query === TRUE) {echo "<h6 style='color:green;'>friends table created OK :) </h6>"; } else {echo "<h6 style='color:red;'>friends table NOT created :( </h6>"; }

$tbl_followers = "CREATE TABLE IF NOT EXISTS followers ( 
                id INT(11) NOT NULL AUTO_INCREMENT,
                user1 VARCHAR(16) NOT NULL,
                user2 VARCHAR(16) NOT NULL,
                date_made DATETIME NOT NULL,
                PRIMARY KEY (id)
                )"; 
$query = mysqli_query($db_connection, $tbl_followers); 
if ($query === TRUE) {echo "<h6 style='color:green;'>followers table created OK :) </h6>"; } else {echo "<h6 style='color:red;'>followers table NOT created :( </h6>"; }

$tbl_blockedusers = "CREATE TABLE IF NOT EXISTS blockedusers ( 
                id INT(11) NOT NULL AUTO_INCREMENT,
                blocker VARCHAR(16) NOT NULL,
                blockee VARCHAR(16) NOT NULL,
                blockdate DATETIME NOT NULL,
                PRIMARY KEY (id) 
                )"; 
$query = mysqli_query($db_connection, $tbl_blockedusers); 
if ($query === TRUE) {echo "<h6 style='color:green;'>blockedusers table created OK :) </h6>"; } else {echo "<h6 style='color:red;'>blockedusers table NOT created :( </h6>"; }

$tbl_story = "CREATE TABLE IF NOT EXISTS story ( 
                id INT(11) NOT NULL AUTO_INCREMENT,
                osid INT(11) NOT NULL,
                account_name VARCHAR(16) NOT NULL,
                author VARCHAR(16) NOT NULL,
                type ENUM('a','b','c','x','p') NOT NULL,
                data TEXT NOT NULL,
                datacaption TEXT NOT NULL,
				image VARCHAR(255) NOT NULL,
                postdate DATETIME NOT NULL,
                PRIMARY KEY (id) 
                )"; 
$query = mysqli_query($db_connection, $tbl_story); 
if ($query === TRUE) {echo "<h6 style='color:green;'>story table created OK :) </h6>"; } else {echo "<h6 style='color:red;'>story table NOT created :( </h6>"; }

$tbl_storylikes = "CREATE TABLE IF NOT EXISTS storylikes ( 
                id INT(11) NOT NULL AUTO_INCREMENT,
				author VARCHAR(16) NOT NULL,
				storyid INT(11) NOT NULL,
                username VARCHAR(16) NOT NULL,
                PRIMARY KEY (id)
                )"; 
$query = mysqli_query($db_connection, $tbl_storylikes); 
if ($query === TRUE) {echo "<h6 style='color:green;'>storylikes table created OK :) </h6>"; } else {echo "<h6 style='color:red;'>storylikes table NOT created :( </h6>"; }

$tbl_chats = "CREATE TABLE IF NOT EXISTS chats ( 
                id INT(11) NOT NULL AUTO_INCREMENT,
				chatid INT(11) NOT NULL,
                user1 VARCHAR(16) NOT NULL,
				user2 VARCHAR(16) NOT NULL,
				data TEXT NOT NULL,
				timesent DATETIME NOT NULL,
				seen ENUM('0','1') NOT NULL DEFAULT '0',
                PRIMARY KEY (id) 
                )"; 
$query = mysqli_query($db_connection, $tbl_chats); 
if ($query === TRUE) {echo "<h6 style='color:green;'>chats table created OK :) </h6>"; } else {echo "<h6 style='color:red;'>chats table NOT created :( </h6>"; }

$tbl_photos = "CREATE TABLE IF NOT EXISTS photos ( 
                id INT(11) NOT NULL AUTO_INCREMENT,
                user VARCHAR(16) NOT NULL,
                gallery VARCHAR(16) NOT NULL,
				filename VARCHAR(255) NOT NULL,
                description VARCHAR(255) NULL,
                postid INT(11) NOT NULL,
                uploaddate DATETIME NOT NULL,
                PRIMARY KEY (id) 
                )"; 
$query = mysqli_query($db_connection, $tbl_photos); 
if ($query === TRUE) {echo "<h6 style='color:green;'>photos table created OK :) </h6>"; } else {echo "<h6 style='color:red;'>photos table NOT created :( </h6>"; }

$tbl_alerts = "CREATE TABLE IF NOT EXISTS alerts ( 
                id INT(11) NOT NULL AUTO_INCREMENT,
				story_id INT(11) NOT NULL,
                username VARCHAR(16) NOT NULL,
                initiator VARCHAR(16) NOT NULL,
                app VARCHAR(255) NOT NULL,
                note VARCHAR(255) NOT NULL,
                did_read ENUM('0','1') NOT NULL DEFAULT '0',
                date_time DATETIME NOT NULL,
                PRIMARY KEY (id) 
                )"; 
$query = mysqli_query($db_connection, $tbl_alerts); 
if ($query === TRUE) {echo "<h6 style='color:green;'>alerts table created OK :) </h6>"; } else {echo "<h6 style='color:red;'>alerts table NOT created :( </h6>"; }

?>