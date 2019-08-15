<?php 
include_once("../../_sys/check_login_status.php");
if($user_ok == false){
    exit();
}
?><?php 
include_once("../../_sys/db_connection.php");
$s1=$_REQUEST["n"];
$select_query = "SELECT * FROM _users WHERE username LIKE '%".$s1."%' OR firstname LIKE '%".$s1."%' OR lastname LIKE '%".$s1."%' LIMIT 10";
$user_query = mysqli_query($db_connection, $select_query) or die (mysqli_error());
$s="";

while($row = mysqli_fetch_array($user_query)){
	$firstname = $row["firstname"];
	$lastname = $row["lastname"];
	$username = $row["username"];
	$sql = "SELECT avatar FROM _useroptions WHERE username='$username'";
	$ava_query = mysqli_query($db_connection, $sql);
	while ($row = mysqli_fetch_array($ava_query)) {
		$picture = $row["avatar"];
	}
	$image = "<img class='img-circle' src='_USER/".$username."/".$picture."' alt=".$username."/>";
	if($picture == NULL){
		$image = "<img class='img-circle' src='_ast/_img/avatardefault.png' />";
	}
	
	$s=$s."
	<a class='link-p-colr' href='uid&".$username."'>
		<div class='live-outer'>
			<div class='live-im'>
                ".$image."
            </div>
            <div class='live-user-det'>
                <div class='live-user-name'>
                    <p>".$firstname." ".$lastname."</p>
                </div>
                <div class='live-user-uname'>
					<div class='live-user-uname-text'><p>".$username."</p></div>
                </div>
            </div>
        </div>
	</a>
	"	;
}
echo $s;
?>
