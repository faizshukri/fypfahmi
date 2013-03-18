<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$mentee_list = fetchAllUsersByMentor($loggedInUser->user_id);
//debug($mentee_list);

require_once("models/header.php"); 

?>

<body>
<link href="css/jquery.fancybox.css" rel="stylesheet">
<script src="js/jquery.fancybox.pack.js" type="text/javascript"></script>
<div class="container-fluid">
  <div class="row-fluid">
	<?php include("left-nav.php"); ?>

	<div class="span9">
		<?php echo resultBlock($errors,$successes); ?>

<div id='regbox'>
<label for="mentee_list">Please select your mentee.</label>
<select name="mentee_list" id="mentee_list">
	<option selected value="">-- please select your mentee --</option>
	<?php foreach($mentee_list as $mentee){ ?>
		<option value="<?php echo $mentee['id']; ?>"><?php echo $mentee['display_name']; ?></option>
	<?php } ?>
</select>
<div style="display: none;" id="mainContent">
<table class="table">
<tr>
<td>
<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post' id="formAddMaterial">
<div class="input-append">
  <label class="control-label" for="readingMaterial">Reading Materials</label>
  <input class="input-xlarge" name="readingMaterial" id="readingMaterial" type="text">
  <button class="btn btn-primary" type="submit" id="addMaterial">Add</button>
</div>
</form>
<div id="resultReading"></div>
</td>
<td>
<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post' id="formAddEvent">
<div class="input-append">
  <label class="control-label" for="event">Seminar / Workshop / Event</label>
  <input class="input-xlarge" name="event" id="event" type="text">
  <button class="btn btn-primary" type="submit" id="addEvent">Add</button>
</div>
</form>
<div id="resultEvent"></div>
</td>
</tr>
<tr>
<td colspan="2">
<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post' id="formChecklist">
<div class="input-append">
  <label class="control-label" for="checklist">Daily Checklist</label>
  <input class="input-xlarge" name="checklist" id="checklist" type="text" placeholder="Insert activities" />
  <button class="btn btn-primary" type="submit" id="addChecklist">Add</button>
</div>
</form>
<div id="checklistResult">
<table class="table">
	<thead>
		<tr>
			<td>No.</td>
			<td>Activity.</td>
			<td>Checklist.</td>
		</tr>
	</thead>
	<tbody></tbody>
</table>
</div>
</td>
</tr>
</table>
</div>
</div>

</div>
<div id='bottom'></div>
</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('.nav-left li').removeClass('active');
		$('.nav-left .dev_personal').addClass('active');
		$("a#inline").fancybox();
		$('#mentee_list').change(function(){
			if($('#mentee_list').val().length != 0){
				$('#mainContent').show();
				$('[id^="result"]').html('');
				$('input').val('');
			} else {
				$('#mainContent').hide();
			}
			$('#checklistResult table tbody').html('');
			fetchChecklist();
		});
		
		//Add Material
		$('#addMaterial').click(function(){
			addMaterial( $('#readingMaterial').val(), 'reading', $('#resultReading'));
			return false;
		});
		
		$('#formAddMaterial').submit(function(){
			addMaterial( $('#readingMaterial').val(), 'reading', $('#resultReading'));
			return false;
		});
		
		//Add Event
		$('#addEvent').click(function(){
			addMaterial( $('#event').val(), 'event', $('#resultEvent'));
			return false;
		});
		
		$('#formAddEvent').submit(function(){
			addMaterial( $('#event').val(), 'event', $('#resultEvent'));
			return false;
		});
		
		//Add Activity
		$('#addChecklist').click(function(){
			addActivity();
			return false;
		});
		
		$('#formChecklist').submit(function(){
			addActivity();
			return false;
		});
		
	});
	
	function addMaterial( value, type, result){
		$.ajax({
			url: 'development_add_ajax.php',
			type: 'get',
			data: {mentee_id: $('#mentee_list').val(), type: type, value: value }
		}).done(function(data){
			result.prepend('<div class="alert alert-info">'+data+'</div>');
		});
	}
	
	function addActivity(){
		$.ajax({
			url: 'development_add_ajax.php',
			type: 'get',
			data: { mentee_id: $('#mentee_list').val(), type: 'activity', value: $('#checklist').val() }
		}).done(function(data){
			$('#checklistResult table tbody').html('').show(400, function(){
				fetchChecklist();
			});
			
		});
	}
	
	function fetchChecklist(){
		$.ajax({
			url: 'development_fetchchecklist.php',
			type: 'get',
			data: { mentee_id: $('#mentee_list').val() },
			dataType: 'json'
		}).done(function(data){
			
			for(var i = 0; i < data.length; i++){
				console.log(data.length);
				$('#checklistResult table tbody').append(
				'<tr><td>'+(i+1)+'</td><td>'+data[i].activity+'</td><td><a style="cursor: pointer;" href="javascript: openCal('+data[i].id+')">View</a></td></tr>'
				);
			}
		});
	}
	
	function openCal(activity_id){
		$('#fancydata').html('Calendar checklist for activity '+activity_id+' will be added here.');
		$('a#inline').click();
	}
</script>
<a style="display: none;" id="inline" href="#fancydata">Trigger Fancy</a>
<div style="display:none"><div id="fancydata"></div></div>
</body>
</html>