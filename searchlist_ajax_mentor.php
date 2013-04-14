<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

if($_GET){
	$user_id = $_GET['user_id'];
	
	$mentors = fetchAllMentorByUserState($user_id);
	$tmp = array();
	
	if(!empty($mentors)){
		foreach($mentors as $mentor){
			$tmp[$mentor['cat']][] = $mentor;
		}
		$mentors = $tmp;
		$html = '<select id="mentor"><option>Select mentor.</option>';
		foreach($mentors as $index => $cat){
			$html .= '<optgroup label="'.ucfirst($index).'">';
			foreach($cat as $mentor){
				$html .= '<option value="'.$mentor['id'].'">'.$mentor['fullname'].'</option>';
			}
			$html .= '</optgroup>';
		}
		$html .= '</select>';
			
		echo $html;
	}
}
?>