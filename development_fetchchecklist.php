<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$mentee_id = (isset($_GET['mentee_id']))?$_GET['mentee_id']:false;
if($mentee_id){
	$check_list = fetchChecklistByUserId($mentee_id);
	echo json_encode($check_list);
}