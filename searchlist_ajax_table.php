<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

if($_GET){

	$zone_id = $_GET['zone_id'];
	$state_id = $_GET['state_id'];
	$ipt_id = $_GET['ipt_id'];
	$tableContent = '';
	
	if(!empty($ipt_id)){ //get from ipt
		$tmp = fetchAllUsersByIpt($ipt_id);
		
		if(!empty($tmp)){
			foreach($tmp as $user){
				$tableContent .= '<tr>
					<td>'.$user['display_name'] .'</td>
					<td>'.$user['display_name'] .'</td>
					<td>'.$user['display_name'] .'</td>
					<td>'.$user['display_name'] .'</td>
				
				</tr>';
			}
		}
	}
	
} else {
	die();
}