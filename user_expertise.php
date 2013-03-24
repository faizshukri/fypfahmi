<?php

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Form is submit
if(!empty($_POST)){
	//debug($_POST);
	$tmphard = (isset($_POST['hardskills']['new']))?$_POST['hardskills']['new']:'';
	$tmpsoft = (isset($_POST['softskills']['new']))?$_POST['softskills']['new']:'';
	if(isset($_POST['hardskills'][0])) $tmphard[] = $_POST['hardskills'][0];
	if(isset($_POST['softskills'][0])) $tmpsoft[] = $_POST['softskills'][0];
	$newContent = array(
		'Hard' => $tmphard,
		'Soft' => $tmpsoft
	);
	
	unset($_POST['hardskills']['new']);
	unset($_POST['softskills']['new']);
	unset($_POST['hardskills'][0]);
	unset($_POST['softskills'][0]);

	$skills = array(
		'Hard' => $_POST['hardskills'],
		'Soft' => $_POST['softskills']
	);
	
	
	//Insert
	foreach($newContent as $index => $content){
		//debug($content);
		if(!empty($content)){
			foreach($content as $index2 => $skill){
				if(!empty($skill))
					updateSkill(null, array('type'=>$index, 'skill_name' => $skill, 'user_id' => $loggedInUser->user_id));
			}
		}
	}
	
	//Update
	foreach($skills as $index => $cat){
		if(!empty($cat)){
			foreach($cat as $index2 => $skill){
				if(!empty($skill))
					updateSkill($index2, array('type'=>$index, 'skill_name' => $skill, 'user_id' => $loggedInUser->user_id));
			}
		}
	}
	
	//debug($newContent);
	
	//updateSkill($loggedInUser->user_id , $data_content);
	//debug($newContent);
	//($skills);
	$errors = array();
	
	//End data validation
	if(count($errors) == 0){
		if(updateUserData($loggedInUser->user_id, 'user_skills', json_encode($skills)))
			$successes[] = 'User expertise has been saved.';
		else
			$errors[] = 'There an error to save your data. Please try again.';
	}
}
$data_content = array(
	'type' => 'Hard',
	'skill_name' => 'Main game'
);

$data = false;
$data2 = getSkill(null, $loggedInUser->user_id);

if(!empty($data2)){
	foreach($data2 as $index => $tmp){
		$data[$tmp['type']][$tmp['id']] = $tmp['skill_name'];
	}
}

//debug($data);

if(!$data){
	$data = array(
		'Hard' => array(''),
		'Soft' => array('')
	);
} else {
	if(!isset($data['Hard'])) $data['Hard'] = array('');
	if(!isset($data['Soft'])) $data['Soft'] = array('');
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
				<input disabled class="input-xlarge" name="hardskills[new][]" type="text" placeholder="Skills Possessed"  />
				<button class="btn-close btn btn-danger btn-small">X</button>
				<br /><br />
			</div>
			
			<?php 
			$count = 1;
			foreach($data['Hard'] as $index => $hard){ ?>
			<?php echo ($count == 1)? '<label class="control-label" for="hardskills">Skills Possessed: </label>':''; ?>
			<div class="controls">
				<input class="input-xlarge" name="hardskills[<?php echo $index; ?>]" type="text" id="hardskills" placeholder="Skills Possessed"  value="<?php echo $hard; ?>" />
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
				<input disabled class="input-xlarge" name="softskills[new][]" type="text" placeholder="Skills Possessed"  />
				<button class="btn-close btn btn-danger btn-small">X</button>
				<br /><br />
			</div>
		
			<?php 
			$count = 1;
			foreach($data['Soft'] as $index => $soft){ ?>
			<?php echo ($count == 1)? '<label class="control-label" for="softskills">Skills Possessed: </label>':''; ?>
			<div class="controls">
				<input class="input-xlarge" name="softskills[<?php echo $index; ?>]" type="text" id="softskills" placeholder="Skills Possessed" value="<?php echo $soft; ?>" />
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
				$.ajax({
					url: 'user_expertise_ajax.php',
					data: {cmd: 'delete', skill_id: $(this).parent().find('input').attr('name').split('[')[1].split(']')[0]},
					type: 'get'
				}).done(function(data){
					if(data == 'success')
						curBtn.parent().remove();
					else
						alert('fail to delete');
				});
				return false;
			});
		});
		
	});
</script>
</body>
</html>