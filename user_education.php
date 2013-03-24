<?php

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Form is submit
if(!empty($_POST)){

	$prischool = $_POST['prischool'];
	$secschool = $_POST['secschool'];
	$higschool = $_POST['higschool'];
	
	foreach($_POST['priyearend'] as $index => $year){
		$prischool[$prischool[$index]] = $year;
		unset($prischool[$index]);
	}
	
	foreach($_POST['secyearend'] as $index => $year){
		$secschool[$secschool[$index]] = $year;
		unset($secschool[$index]);
	}
	
	foreach($_POST['higyearend'] as $index => $year){
		$course = $_POST['higcourse'];
		$higschool[$higschool[$index]] = array(
			'year' => $year,
			'course' => $course[$index]
		);
		unset($higschool[$index]);
	}
	
	$education = array(
		'primary' => $prischool,
		'secondary' => $secschool,
		'high' => $higschool
	);
	
	$errors = array();
	
	//End data validation
	if(count($errors) == 0){
		if(updateUserData($loggedInUser->user_id, 'user_education', json_encode($education)))
			$successes[] = 'User profile has been saved.';
		else
			$errors[] = 'There an error to save your data. Please try again.';
	}
}

$data = fetchUserData($loggedInUser->user_id, 'user_education');
if(!$data){
	$data = array(
		'primary' => array(
			'' => ''
		),
		'secondary' => array(
			'' => ''
		),
		'high' => array(
			'' => array(
				'year' => '',
				'course' => ''
			)
		)
	);
} else {
	$data = json_decode($data['content'], true);
}
//debug($data);
require_once("models/header.php"); 

?>

<body>
<div class="container-fluid">
  <div class="row-fluid">
	<?php include("left-nav.php"); ?>

	<div class="span9">
		<?php echo resultBlock($errors,$successes); ?>
		
<div id='regbox'>
<form class="form-horizontal" name='newUser' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post'>
<fieldset><!-- start primary -->
    <legend>Primary School</legend>
<div class="control-group">
	<table id="tblprischool">
	<tr id="sampleprischool" style="display: none;">
	<td>
	<div class="controls">
		<input disabled name="prischool[new][]" type="text" placeholder="Primary School">
	</div>
	</td>
	<td>
	<label class="control-label">Year End</label>
	<div class="controls">
		<input disabled name="priyearend[]" type="text" placeholder="Year End">
		<button class="btn-close btn btn-small btn-danger">X</button>
	</div>
	</td>
	</tr>
	<?php 
	$count = 1;
	foreach($data['primary'] as $index => $primary){ ?>
	<tr>
	<td>
	<?php echo ($count == 1) ? '<label class="control-label" for="prischool">Primary School</label>': ''; ?>
	<div class="controls">
		<input name="prischool[]" type="text" <?php echo ($count == 1) ? 'id="prischool"':''; ?> placeholder="Primary School" value="<?php echo $index; ?>" />
	</div>
	</td>
	<td>
	<label class="control-label">Year End</label>
	<div class="controls">
		<input name="priyearend[]" type="text" placeholder="Year End" value="<?php echo $primary; ?>">
		<?php echo ($count != 1) ? '<button class="btn-close2 btn btn-small btn-danger">X</button>':''; ?>
	</div>
	</td>
	</tr>
	<?php ++$count; } ?>
	</table>
	<p>&nbsp;</p>
	<div class="controls">
	<button id="addprischool" class="btn btn-small btn-success">Add if more than 1</button>
	</div>
</div>
</legend>
</fieldset><!-- end primary -->

<fieldset><!-- start secondary -->
    <legend>Secondary School</legend>
<div class="control-group">
	<table id="tblsecschool">
	<tr id="samplesecschool" style="display: none;">
	<td>
	<div class="controls">
		<input disabled name="secschool[]" type="text" placeholder="Secondary School">
	</div>
	</td>
	<td>
	<label class="control-label">Year End</label>
	<div class="controls">
		<input disabled name="secyearend[]" type="text" placeholder="Year End">
		<button class="btn-close btn btn-small btn-danger">X</button>
	</div>
	</td>
	</tr>
	<?php 
	$count = 1;
	foreach($data['secondary'] as $index => $second){ ?>
	<tr>
	<td>
	<?php echo ($count == 1) ? '<label class="control-label" for="secschool">Secondary School</label>': ''; ?>
	
	<div class="controls">
		<input name="secschool[]" type="text" <?php echo ($count == 1) ? 'id="secschool"': ''; ?>placeholder="Secondary School" value="<?php echo $index; ?>" />
	</div>
	</td>
	<td>
	<label class="control-label">Year End</label>
	<div class="controls">
		<input name="secyearend[]" type="text" placeholder="Year End" value="<?php echo $second; ?>" />
		<?php echo ($count != 1) ? '<button class="btn-close2 btn btn-small btn-danger">X</button>':''; ?>
	</div>
	</td>
	</tr>
	<?php ++$count; } ?>
	</table>
	<p>&nbsp;</p>
	<div class="controls">
	<button id="addsecschool" class="btn btn-small btn-success">Add if more than 1</button>
	</div>
</div>
</legend>
</fieldset><!-- end secondary -->

<fieldset><!-- start higher -->
    <legend>Higher Education</legend>
<div class="control-group">
	<table id="tblhigschool">
	<tr id="samplehigschool" style="display: none;">
	<td>
	<label class="control-label">Higher Education</label>
	<div class="controls">
		<input disabled name="higschool[]" type="text" placeholder="Higher Education" />
	</div>
	<p>&nbsp;</p>
	<label class="control-label">Course</label>
	<div class="controls">
		<input disabled name="higcourse[]" type="text" placeholder="Course" />
	</div>
	<p>&nbsp;</p>
	</td>
	<td>
	<label class="control-label">Year End</label>
	<div class="controls">
		<input disabled name="higyearend[]" type="text" placeholder="Year End">
		<button class="btn-close btn btn-small btn-danger">X</button>
	</div>
	
	</td>
	</tr>
	<?php 
	$count = 1;
	foreach($data['high'] as $index => $high){ ?>
	<tr>
	<td>
	<label class="control-label" for="higschool">Higher Education</label>
	<div class="controls">
		<input name="higschool[]" type="text" id="higschool" placeholder="Higher Education" value="<?php echo $index; ?>" />
	</div>
	<p>&nbsp;</p>
	<label class="control-label" for="higcourse">Course</label>
	<div class="controls">
		<input name="higcourse[]" type="text" id="higcourse" placeholder="Course" value="<?php echo $high['course']; ?>" />
	</div>
	<p>&nbsp;</p>
	</td>
	<td>
	<label class="control-label">Year End</label>
	<div class="controls">
		<input name="higyearend[]" type="text" placeholder="Year End" value="<?php echo $high['year']; ?>" />
		<?php echo ($count != 1) ? '<button class="btn-close2 btn btn-small btn-danger">X</button>':''; ?>
	</div>
	</td>
	</tr>
	<?php ++$count; } ?>
	</table>
	
	<div class="controls">
	<button id="addhigschool" class="btn btn-small btn-success">Add if more than 1</button>
	</div>
	<p>&nbsp;</p>
</div>
</legend>
</fieldset><!-- end higher -->

<div class="form-actions">
	<button type="submit" class="btn btn-primary">Save</button>
</div>
</form>
		
		
	</div>
  </div>
  <div id='bottom'></div>
</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('.nav-left li').removeClass('active');
		$('.nav-left .education').addClass('active');
		
		$('#addprischool').click(function(){
			$('#sampleprischool')
			.clone()
			.insertAfter('#tblprischool tr:last')
			.show()
			.find('.btn-close')
			.click(function(){
				$(this).parent().parent().parent().remove();
				return false;
			}).parent().parent().parent()
			.find('input')
			.removeAttr('disabled');
			return false;
		});
		
		$('#addsecschool').click(function(){
			$('#samplesecschool')
			.clone()
			.insertAfter('#tblsecschool tr:last')
			.show()
			.find('.btn-close')
			.click(function(){
				$(this).parent().parent().parent().remove();
				return false;
			}).parent().parent().parent()
			.find('input')
			.removeAttr('disabled');
			return false;
		});
		
		$('#addhigschool').click(function(){
			$('#samplehigschool')
			.clone()
			.insertAfter('#tblhigschool tr:last')
			.show()
			.find('.btn-close')
			.click(function(){
				$(this).parent().parent().parent().remove();
				return false;
			}).parent().parent().parent()
			.find('input')
			.removeAttr('disabled');
			return false;
		});
		
		$('.btn-close2').each(function(){
			var curBtn = $(this);
			curBtn.click(function(){
				$(this).parent().parent().parent().remove();
				return false;
			});
		});
	});
</script>
</body>
</html>