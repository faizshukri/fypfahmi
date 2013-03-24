<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$users_id = fetchPermissionUsers(1);
$users_detail = array();
foreach($users_id as $user){
	$users_detail[] = fetchUserDetails(null, null, $user['user_id']);
}

//what's inside $user_detail ? (uncomment line below to dump it)
//debug($users_detail);

//try to print it nicely
foreach($users_detail as $user){
	foreach($user as $index => $col){
		echo $index . ' => ' . $col . '<br />';
	}
	echo '<br /><hr /><br />';
}

?>