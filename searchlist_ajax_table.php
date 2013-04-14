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
			$parent = fetchUserDetails(NULL, NULL, $member['parent_id']);
			//debug($parent);
			$tableContent .= '<tr>
					<td>'.$member['fullname'] .'</td>
					<td>'.$member['contact'] .'</td>
					<td>'.$member['email'] .'</td>
					<td>'.$member['ipt'] .'</td>
					<td>'.$member['state'] .'</td>';
					
			if($loggedInUser->checkPermission(array(2)))
				$tableContent .= '<td><a style="padding: 3px 5px;" title="Assign Mentor" id="'.$member['user_id'].'" href="#" class="show_mentor btn btn-mini btn-danger"><i class="icon-user icon-white"></i></a>';
				if(!empty($parent)) $tableContent .= '&nbsp;&nbsp;'.$parent['fullname'];
				$tableContent .= '</td>';
			$tableContent .= '</tr>';
		}
	} else {
		if($loggedInUser->checkPermission(array(2)))
			$tableContent .= '<tr><td colspan="6">No member found in this location.</td></tr>';
		else
			$tableContent .= '<tr><td colspan="5">No member found in this location.</td></tr>';
	}
	
	echo $tableContent;
	
} else {
	die();
}

?>
<script type="text/javascript">
jQuery(document).ready(function($){
	$('.show_mentor').each(function(){
		var curLink = $(this);
		curLink.click(function(){
			showMentor(curLink.attr('id'));
			return false;
		});
	});
});
</script>