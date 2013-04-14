<?php

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
//Form is submit
if(!empty($_POST)){
	// echo 'post';
	// debug($_POST);
	$tmpprischool = (isset($_POST['prischool']['new']) && !empty($_POST['prischool']['new']))?$_POST['prischool']['new']:array();
	$tmppriyearend = (isset($_POST['priyearend']['new']) && !empty($_POST['priyearend']['new']))?$_POST['priyearend']['new']:array();
	
	$tmpsecschool = (isset($_POST['secschool']['new']) && !empty($_POST['secschool']['new']))?$_POST['secschool']['new']:array();
	$tmpsecyearend = (isset($_POST['secyearend']['new']) && !empty($_POST['secyearend']['new']))?$_POST['secyearend']['new']:array();
	
	$tmphigschool = (isset($_POST['higschool']['new']) && !empty($_POST['higschool']['new']))?$_POST['higschool']['new']:array();
	$tmphigyearend = (isset($_POST['higyearend']['new']) && !empty($_POST['higyearend']['new']))?$_POST['higyearend']['new']:array();
	$tmphigcourse = (isset($_POST['higcourse']['new']) && !empty($_POST['higcourse']['new']))?$_POST['higcourse']['new']:array();
	
	
	$newContent = array();
	foreach($tmpprischool as $id => $value){
		$newContent['Primary'][$id][$tmppriyearend[$id]] = $value;
	}
	foreach($tmpsecschool as $id => $value){
		$newContent['Secondary'][$id][$tmpsecyearend[$id]] = $value;
	}
	foreach($tmphigschool as $id => $value){
		$newContent['Higher'][$id][$tmphigcourse[$id]][$tmphigyearend[$id]] = $value;
	}

	unset($_POST['prischool']['new']);
	unset($_POST['priyearend']['new']);
	unset($_POST['secschool']['new']);
	unset($_POST['secyearend']['new']);
	unset($_POST['higschool']['new']);
	unset($_POST['higyearend']['new']);
	unset($_POST['higcourse']['new']);

	$edus = array();
	foreach($_POST['prischool'] as $id => $value){
		$edus['Primary'][$id][$_POST['priyearend'][$id]] = $value;
	}
	foreach($_POST['secschool'] as $id => $value){
		$edus['Secondary'][$id][$_POST['secyearend'][$id]] = $value;
	}
	foreach($_POST['higschool'] as $id => $value){
		$edus['Higher'][$id][$_POST['higcourse'][$id]][$_POST['higyearend'][$id]] = $value;
	}

	
	$errors = array();
	$successes = array();
	//Insert
	foreach($newContent as $type => $content){
		if(!empty($content) && ($type == 'Primary' || $type == 'Secondary')){
			foreach($content as $index => $edu_array){
				if(!empty($edu_array))
				foreach($edu_array as $year => $place){
					if(!updateEducation(null, array('type'=>$type, 'edu_place'=>$place, 'year' => $year , 'course' => '', 'user_id' => $loggedInUser->user_id)))
						$errors[] = 'Error';
				}
			}
		}
		
		if(!empty($content) && $type == 'Higher'){
			foreach($content as $index => $edu_array){
				if(!empty($edu_array))
				foreach($edu_array as $course => $year_array){
					foreach($year_array as $year => $place){
						if(!updateEducation(null, array('type'=>$type, 'edu_place'=>$place, 'year' => $year , 'course' => $course, 'user_id' => $loggedInUser->user_id)))
							$errors[] = 'Error';
					}
				}
			}
		}
	}
	
	//Update
	foreach($edus as $type => $content){
		if(!empty($content) && ($type == 'Primary' || $type == 'Secondary')){
			foreach($content as $id => $edu_array){
				if(!empty($edu_array))
				foreach($edu_array as $year => $place){
					if(!updateEducation($id, array('type'=>$type, 'edu_place'=>$place, 'year' => $year , 'course' => '', 'user_id' => $loggedInUser->user_id)))
						$errors[] = 'Error';
				}
			}
		}
		
		if(!empty($content) && $type == 'Higher'){
			foreach($content as $id => $edu_array){
				if(!empty($edu_array))
				foreach($edu_array as $course => $year_array){
					foreach($year_array as $year => $place){
						if(!updateEducation($id, array('type'=>$type, 'edu_place'=>$place, 'year' => $year , 'course' => $course, 'user_id' => $loggedInUser->user_id)))
							$errors[] = 'Error';
					}
				}
			}
		}
	}

	//End data validation
	if(count($errors) == 0){
		$successes[] = 'User profile has been saved.';
	} else {
		$errors[] = 'There an error to save your data. Please try again.';
	}
}

$data = false;
$data2 = getEducation(null, $loggedInUser->user_id);
$ipts = getAllIpt();

//debug($data2);
//die();

if(!empty($data2)){
	foreach($data2 as $index => $tmp){
		
	
		if($tmp['type'] == 'Higher'){
			$data[$tmp['type']][$tmp['id']][$tmp['course']] = array($tmp['year'] => $tmp['edu_place']);
		} else {
			$data[$tmp['type']][$tmp['id']] = array($tmp['year'] => $tmp['edu_place']);
		}
		
	}	
}

//debug($data);

if(!$data){
	$data = array(
		'Primary' => array(
			'' => ''
		),
		'Secondary' => array(
			'' => ''
		),
		'Higher' => array(
			'' => array(
				'year' => '',
				'course' => ''
			)
		)
	);
} else {
	//if(!isset($data['Primary'])) $data['Primary'] = array('');
	//if(!isset($data['Secondary'])) $data['Secondary'] = array('');
	//if(!isset($data['Higher'])) $data['Higher'] = array('');
}
//debug($data);
require_once("models/header.php"); 

?>


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
		<input disabled name="priyearend[new][]" type="text" placeholder="Year End">
		<button class="btn-close btn btn-small btn-danger">X</button>
	</div>
	</td>
	</tr>
	<?php 
	$count = 1;
	foreach($data['Primary'] as $index => $primary){ 
	
		foreach($primary as $year => $place){ ?>
		<tr>
		<td>
		<?php echo ($count == 1) ? '<label class="control-label" for="prischool">Primary School</label>': ''; ?>
		<div class="controls">
			<input name="prischool[<?php echo $index; ?>]" type="text" <?php echo ($count == 1) ? 'id="prischool"':''; ?> placeholder="Primary School" value="<?php echo $place; ?>" />
		</div>
		</td>
		<td>
		<label class="control-label">Year End</label>
		<div class="controls">
			<input name="priyearend[<?php echo $index; ?>]" type="text" placeholder="Year End" value="<?php echo $year; ?>">
			<?php echo ($count != 1) ? '<button class="btn-close2 btn btn-small btn-danger">X</button>':''; ?>
		</div>
		</td>
		</tr>
	<?php } ++$count;  } ?>
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
		<input disabled name="secschool[new][]" type="text" placeholder="Secondary School">
	</div>
	</td>
	<td>
	<label class="control-label">Year End</label>
	<div class="controls">
		<input disabled name="secyearend[new][]" type="text" placeholder="Year End">
		<button class="btn-close btn btn-small btn-danger">X</button>
	</div>
	</td>
	</tr>
	<?php 
	$count = 1;
	foreach($data['Secondary'] as $index => $second){ 
		foreach($second as $year => $place){ ?>
		<tr>
		<td>
		<?php echo ($count == 1) ? '<label class="control-label" for="secschool">Secondary School</label>': ''; ?>
		
		<div class="controls">
			<input name="secschool[<?php echo $index; ?>]" type="text" <?php echo ($count == 1) ? 'id="secschool"': ''; ?>placeholder="Secondary School" value="<?php echo $place; ?>" />
		</div>
		</td>
		<td>
		<label class="control-label">Year End</label>
		<div class="controls">
			<input name="secyearend[<?php echo $index; ?>]" type="text" placeholder="Year End" value="<?php echo $year; ?>" />
			<?php echo ($count != 1) ? '<button class="btn-close2 btn btn-small btn-danger">X</button>':''; ?>
		</div>
		</td>
		</tr>
	<?php } ++$count; } ?>
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
		<select disabled name="higschool[new][]">
			<option value="" selected>Please select IPT</option>
			<?php foreach($ipts as $index2 => $ipt){ ?>
				<option value="<?php echo $index2; ?>"><?php echo $ipt; ?></option>
			<?php } ?>
		</select>
	</div>
	<p>&nbsp;</p>
	<label class="control-label">Course</label>
	<div class="controls">
		<input disabled name="higcourse[new][]" type="text" placeholder="Course" />
	</div>
	<p>&nbsp;</p>
	</td>
	<td>
	<label class="control-label">Year End</label>
	<div class="controls">
		<input disabled name="higyearend[new][]" type="text" placeholder="Year End">
		<button class="btn-close btn btn-small btn-danger">X</button>
	</div>
	
	</td>
	</tr>
	<?php 
	$count = 1;
	foreach($data['Higher'] as $index => $high){ 
		foreach($high as $course => $yearplace){ 
		foreach($yearplace as $year => $place){ ?>
		<tr>
		<td>
		<label class="control-label" for="higschool">Higher Education</label>
		<div class="controls">
			<select name="higschool[<?php echo $index; ?>]" id="higschool">
				<option value="">Please select IPT</option>
				<?php foreach($ipts as $index2 => $ipt){ ?>
					<option <?php echo ($place == $index2)? 'selected':''; ?> value="<?php echo $index2; ?>"><?php echo $ipt; ?></option>
				<?php } ?>
			</select>
		</div>
		<p>&nbsp;</p>
		<label class="control-label" for="higcourse">Course</label>
		<div class="controls">
			<input name="higcourse[<?php echo $index; ?>]" type="text" id="higcourse" placeholder="Course" value="<?php echo $course; ?>" />
		</div>
		<p>&nbsp;</p>
		</td>
		<td>
		<label class="control-label">Year End</label>
		<div class="controls">
			<input name="higyearend[<?php echo $index; ?>]" type="text" placeholder="Year End" value="<?php echo $year; ?>" />
			<?php echo ($count != 1) ? '<button class="btn-close2 btn btn-small btn-danger">X</button>':''; ?>
		</div>
		</td>
		</tr>
	<?php } } ++$count; } ?>
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
			.find('input, select')
			.removeAttr('disabled');
			return false;
		});
		
		
		$('.btn-close2').each(function(){
			var curBtn = $(this);
			curBtn.click(function(){
			
				$.ajax({
					url: 'user_education_ajax.php',
					data: {cmd: 'delete', education_id: $(this).parent().find('input').attr('name').split('[')[1].split(']')[0]},
					type: 'get'
				}).done(function(data){
					if(data == 'success')
						curBtn.parent().parent().parent().remove();
					else
						alert('fail to delete');
				});
			
			
				//$(this).parent().parent().parent().remove();
				return false;
			});
		});
	});
</script>
<?php require_once('models/footer.php'); ?>