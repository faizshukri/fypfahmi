<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$set_data = 0;

if(isset($_GET['submit'])){ //next / prev
	$checked = $_GET['value'];
	$activity_id = $_GET['activity_id'];
	$data_content = array(
		date('Y') => array(
			date('n') => $checked
		)
	);
	if(updateChecklist($activity_id, json_encode($data_content)))
		echo 'success';

} else { //default. current month
	global $set_data;
	$activity_id = $_GET['activity_id'];
	$curCheckList = fetchChecklist($activity_id);
	$curCheckList = json_decode($curCheckList['check'], true);
	
	$set_data = (isset($curCheckList[date('Y')][date('n')])) ? $curCheckList[date('Y')][date('n')]: false;
	$num = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
	
	$month = array();
	for($i = 1; $i <= $num; $i++){
		$month[ date('D', strtotime(date('Y').'/'.date('m').'/'.$i)) ][] = $i;
	}
	
	$maxWeek = 0;
	
	foreach($month as $mon){
		if(sizeof($mon) > $maxWeek)
			$maxWeek = sizeof($mon);
	}
	
	echo '<h3>'.date('F Y').'</h3>';
	echo '<form id="formCalCheck">';
	echo '<table class="table">
	<thead>
		<tr>
			<td>Sun</td>
			<td>Mon</td>
			<td>Tue</td>
			<td>Wed</td>
			<td>Thu</td>
			<td>Fri</td>
			<td>Sat</td>
		</tr>
	</thead>
	<tbody>
	';
		$start = false;
		$stop = false;
		for($i = 0; $i < $maxWeek + 5; $i++){
			echo '<tr>';
			echo '<td style="text-align: right;">';
			
			if(isset($month['Sun'][0]) && $month['Sun'][0] == 1) $start = true;
			if(isset($month['Sun'][0]) && $month['Sun'][0] == $num) $stop = true;
			echo ($start && !empty($month['Sun']))? dequeue($month['Sun']) : '';
			echo '</td><td style="text-align: right;">';
			if(isset($month['Mon'][0]) && $month['Mon'][0] == 1) $start = true;
			if(isset($month['Mon'][0]) && $month['Mon'][0] == $num) $stop = true;
			echo ($start && !empty($month['Mon']))? dequeue($month['Mon']) : '';
			echo '</td><td style="text-align: right;">';
			if(isset($month['Tue'][0]) && $month['Tue'][0] == 1) $start = true;
			if(isset($month['Tue'][0]) && $month['Tue'][0] == $num) $stop = true;
			echo ($start && !empty($month['Tue']))? dequeue($month['Tue']) : '';
			echo '</td><td style="text-align: right;">';
			if(isset($month['Wed'][0]) && $month['Wed'][0] == 1) $start = true;
			if(isset($month['Wed'][0]) && $month['Wed'][0] == $num) $stop = true;
			echo ($start && !empty($month['Wed']))? dequeue($month['Wed']) : '';
			echo '</td><td style="text-align: right;">';
			if(isset($month['Thu'][0]) && $month['Thu'][0] == 1) $start = true;
			if(isset($month['Thu'][0]) && $month['Thu'][0] == $num) $stop = true;
			echo ($start && !empty($month['Thu']))? dequeue($month['Thu']) : '';
			echo '</td><td style="text-align: right;">';
			if(isset($month['Fri'][0]) && $month['Fri'][0] == 1) $start = true;
			if(isset($month['Fri'][0]) && $month['Fri'][0] == $num) $stop = true;
			echo ($start && !empty($month['Fri']))? dequeue($month['Fri']) : '';
			echo '</td><td style="text-align: right;">';
			if(isset($month['Sat'][0]) && $month['Sat'][0] == 1) $start = true;
			if(isset($month['Sat'][0]) && $month['Sat'][0] == $num) $stop = true;
			echo ($start && !empty($month['Sat']))? dequeue($month['Sat']) : '';
			echo '</td>';
			echo '</tr>';
			if($stop) break;
		}
	echo '</tbody></table>';
	echo '<button id="submitFormCheck" class="btn btn-primary">Save</button>';
	echo '</form>';
	
	
	echo '
	<script>
	
		$("#submitFormCheck").click(function(){
			
			var tmp = new Array();
			$("input[type=\'checkbox\']:checked").each(function(){
				tmp.push( $(this).val() );
			});
			
			
			submitChecklist(tmp);
			return false;
		});
	
		function submitChecklist(value){
			$.ajax({
				url: "calendar_checklist.php",
				data: {submit: true, value: value, activity_id: '.$activity_id.'},
				type: "get"
			}).done(function(data){
				if(data=="success")
					alert("Successfully saved.");
				else
					alert("Fail. Please try again.");
			});
		}
	</script>
	';
	
	// echo '<pre>';
	// var_dump($month);
	// echo '</pre>';
}

function dequeue(&$value){
	global $set_data;
	if(!empty($value)){
		$tmp = $value[0];
		unset($value[0]);
		foreach($value as $index => $tmp2){
			if($index-1 >= 0)
				$value[$index-1] = $tmp2;
			
			if($index == (sizeof($value) - 1))
				unset($value[$index]);
		}
		
		if(!empty($set_data) && in_array($tmp, $set_data)) $checked = 'checked';
		else $checked = '';
		
		return $tmp . '&nbsp;<input '.$checked.' type="checkbox" value="'.$tmp.'" name="check['.$tmp.']">';
	}
	
	return '';
}



?>