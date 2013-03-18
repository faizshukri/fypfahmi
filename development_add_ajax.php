<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}


$type = (isset($_GET['type']))?$_GET['type']:false;
$mentee_id = (isset($_GET['mentee_id']))?$_GET['mentee_id']:false;
$value = (isset($_GET['value']))?$_GET['value']:false;

if($type=='reading'){
	$type2 = 'user_reading';
	$msg = 'reading lists';
} else if($type=='event'){
	$type2 = 'user_event';
	$msg = 'event lists';
} else {
	$type2 = '';
	$msg = '';
}

if($type != 'activity'){
	$userData = fetchUserData($mentee_id, $type2);

	if($userData){
		$tmp = json_decode($userData['content'], true);
	} else {
		$tmp = array();
	}

	$tmp[] = $value;
	updateUserData($mentee_id, $type2, json_encode($tmp));

	echo '<b>\''.$value . '\'</b> was added to '.$msg.'.';
} else {
	if(addChecklist($mentee_id, $value)){
		echo $value;
	} else {
		echo 'false';
	}
}

?>