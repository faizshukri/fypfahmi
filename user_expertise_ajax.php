<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

if(isset($_GET['cmd']) && $_GET['cmd'] == 'delete'){
	$skill_id = (isset($_GET['skill_id']))?$_GET['skill_id']:false;
	if($skill_id){ deleteSkill($skill_id); echo 'success'; }
	else { die('fail'); }
}