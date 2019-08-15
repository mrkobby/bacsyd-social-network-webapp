<?php
mysqli_query($db_connection, "UPDATE _userinfo SET notecheck=now() WHERE username='$log_username'");
mysqli_query($db_connection, "UPDATE alerts SET did_read='1' WHERE username='$log_username'");
mysqli_query($db_connection, "UPDATE _userinfo SET status='online' WHERE username='$log_username'");
mysqli_query($db_connection, "DELETE FROM alerts WHERE date_time < DATE_ADD(NOW(),INTERVAL -1 DAY) AND did_read='1'");
mysqli_query($db_connection, "DELETE FROM friends WHERE datemade < DATE_ADD(NOW(),INTERVAL -1 DAY) AND accepted='0'");
?>