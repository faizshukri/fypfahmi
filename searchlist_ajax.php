<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

if($_GET){

	if(isset($_GET['zone_id']) && !isset($_GET['state_id'])){
		
		$states = selectStateByZone($_GET['zone_id']);
		//print_r($states);
		$selectState = '<select id="states"><option value="">Please select State</option>';
		
		$ipt = '<select id="ipt"><option value="">Please select IPT</option>';
		
		foreach($states as $index => $state){
			$tmp = selectIptByState($index);
			if(!empty($tmp)){
				foreach( $tmp as $index2 => $ipt2){
					$ipt .= '<option value="'. $index2 . '">'.$ipt2.'</option>';
				}
			}
			$selectState .= '<option value="'. $index . '">'.$state.'</option>';
		}
		$ipt .= '</select>';
		$selectState .= '</select>';
		echo trim($selectState). ' ' ;
		echo trim($ipt);
		
		
	} else if(isset($_GET['state_id'])){
	
		$zone_id = $_GET['zone_id'];
		
		$selectIpt = '<select id="ipt"><option value="">Please select IPT</option>';
		
		if(!empty($_GET['state_id'])){
			$ipts = selectIptByState($_GET['state_id']);
			if(!empty($ipts)){
				foreach($ipts as $index => $ipt){
					$selectIpt .= '<option value="'. $index . '">'.$ipt.'</option>';
				}
			}
		} else {
			$states = selectStateByZone($zone_id);
			foreach($states as $index => $state){
				$tmp = selectIptByState($index);
				if(!empty($tmp)){
					foreach( $tmp as $index2 => $ipt2){
						$selectIpt .= '<option value="'. $index2 . '">'.$ipt2.'</option>';
					}
				}
			}
		}
		
		$selectIpt .= '</select>';
		echo trim($selectIpt);
	} else if(isset($_GET['ipt_id'])){
		echo 'ipt';
	}
} else {
	die();
}