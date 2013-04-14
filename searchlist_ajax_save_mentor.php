<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

if($_GET){
	$user_id = $_GET['user_id'];
	$parent_id = $_GET['parent_id'];
	if( updateAssignMentor($user_id, $parent_id)){
		echo 'true';
	} else {
		echo 'false';
	}
}