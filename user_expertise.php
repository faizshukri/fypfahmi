<?php

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Form is submit
if(!empty($_POST)){


	$skills = array(
		'hard' => $_POST['hardskills'],
		'soft' => $_POST['softskills']
	);

	$errors = array();
	
	//End data validation
	if(count($errors) == 0){
		if(updateUserData($loggedInUser->user_id, 'user_skills', json_encode($skills)))
			$successes[] = 'User expertise has been saved.';
		else
			$errors[] = 'There an error to save your data. Please try again.';
	}
}

$data = fetchUserData($loggedInUser->user_id, 'user_skills');



if(!$data){
	$data = array(
		'hard' => array(''),
		'soft' => array('')
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
<fieldset id="fieldHS"><!-- start hard skil -->
    <legend>Hard Skills</legend>
		<div class="control-group">
			<div class="controls" id="sampleHS" style="display: none;" >
				<input disabled class="input-xlarge" name="hardskills[]" type="text" placeholder="Skills Possessed"  />
				<button class="btn-close btn btn-danger btn-small">X</button>
				<br /><br />
			</div>
			
			<?php 
			$count = 1;
			foreach($data['hard'] as $hard){ ?>
			<?php echo ($count == 1)? '<label class="control-label" for="hardskills">Skills Possessed: </label>':''; ?>
			<div class="controls">
				<input class="input-xlarge" name="hardskills[]" type="text" id="hardskills" placeholder="Skills Possessed"  value="<?php echo $hard; ?>" />
				<?php echo ($count != 1)? '<button class="btn-close btn btn-danger btn-small">X</button>':''; ?>
				<br /><br />
			</div>
			<?php ++$count; } ?>
			<p>&nbsp;</p>
			<div class="controls">
				<button id="addHS" class="btn btn-small btn-success">Add if more than 1</button>
			</div>
		</div>
	</legend>
</fieldset><!-- end hard skil -->
<fieldset id="fieldSS"><!-- start soft skil -->
    <legend>Soft Skills</legend>
		<div class="control-group">
			<div class="controls" id="sampleSS" style="display: none;" >
				<input disabled class="input-xlarge" name="softskills[]" type="text" placeholder="Skills Possessed"  />
				<button class="btn-close btn btn-danger btn-small">X</button>
				<br /><br />
			</div>
		
			<?php 
			$count = 1;
			foreach($data['soft'] as $soft){ ?>
			<?php echo ($count == 1)? '<label class="control-label" for="softskills">Skills Possessed: </label>':''; ?>
			<div class="controls">
				<input class="input-xlarge" name="softskills[]" type="text" id="softskills" placeholder="Skills Possessed" value="<?php echo $soft; ?>" />
				<?php echo ($count != 1)? '<button class="btn-close btn btn-danger btn-small">X</button>':''; ?>
				<br /><br />
			</div>
			<?php ++$count; } ?>
			<p>&nbsp;</p>
			<div class="controls">
				<button id="addSS" class="btn btn-small btn-success">Add if more than 1</button>
			</div>
		</div>
	</legend>
</fieldset><!-- end soft skil -->

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
		$('.nav-left .expertise').addClass('active');
		
		$('#addHS').click(function(){
				$('#sampleHS')
				.clone()
				.insertAfter('#fieldHS .control-group .controls:not(:last):last')
				.show()
				.find('.btn-close')
				.click(function(){
					$(this).parent().remove();
					return false;
				}).parent()
				.find('input')
				.removeAttr('disabled');
			return false;
		});
		$('#addSS').click(function(){
				$('#sampleSS')
				.clone()
				.insertAfter('#fieldSS .control-group .controls:not(:last):last')
				.show()
				.find('.btn-close')
				.click(function(){
					$(this).parent().remove();
					return false;
				}).parent()
				.find('input')
				.removeAttr('disabled');
			return false;
		});
		
		$('.btn-close').each(function(){
			var curBtn = $(this);
			curBtn.click(function(){
				$(this).parent().remove();
				return false;
			});
		});
		
	});
</script>
</body>
</html>