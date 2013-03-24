<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

if($_GET){

	$zone_id = $_GET['zone_id'];
	$state_id = $_GET['state_id'];
	$ipt_id = $_GET['ipt_id'];
	$tableContent = '';
	$data = false;
	if(!empty($ipt_id)){ //get from ipt
		$data = getUserByPlace($ipt_id, false, false);

	} else if(!empty($state_id)){
		$data = getUserByPlace(false, $state_id, false);
	} else if(!empty($zone_id)){
		$data = getUserByPlace(false, false, $zone_id);
	} else {
		$data = getUserByPlace(false, false, false);
	}
	
	if($data){
		foreach($data as $member){
			$tableContent .= '<tr>
					<td>'.$member['fullname'] .'</td>
					<td>'.$member['contact'] .'</td>
					<td>'.$member['email'] .'</td>
					<td>'.$member['ipt'] .'</td>
					<td>'.$member['state'] .'</td>
				</tr>';
		}
	} else {
		$tableContent .= '<tr><td colspan="5">No member found in this location.</td></tr>';
	}
	
	echo $tableContent;
	
} else {
	die();
}