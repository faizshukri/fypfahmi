<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

if(isset($_GET['cmd']) && $_GET['cmd'] == 'delete'){
	$education_id = (isset($_GET['education_id']))?$_GET['education_id']:false;
	if($education_id){ deleteEducation($education_id); echo 'success'; }
	else { die('fail'); }
}