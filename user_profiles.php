<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}


//Form is submit
if(!empty($_POST)){
	$errors = array();
	$user_data = array(
		'biodata' => trim($_POST["biodata"]),
		'education' => trim($_POST["education"]),
		'expertise' => trim($_POST["expertise"]),
		'development' => trim($_POST["development"]),
		'membership' => trim($_POST["membership"])
	);
	
	//End data validation
	if(count($errors) == 0){
		if(updateUserData($loggedInUser->user_id, 'user_profile', json_encode($user_data)))
			$successes[] = 'User profile has been saved.';
		else
			$errors[] = 'There an error to save your data. Please try again.';
	}
}

$data = fetchUserData($loggedInUser->user_id, 'user_profile');
if(!$data){
	$data = array(
		'biodata' => '',
		'education' => '',
		'expertise' => '',
		'development' => '',
		'membership' => ''
	);
} else {
	$data = json_decode($data['content'], true);
}

require_once("models/header.php"); 

?>


<div class="container-fluid">
  <div class="row-fluid">
	<?php include("left-nav.php"); ?>

	<div class="span9">
		<?php echo resultBlock($errors,$successes); ?>
		
		
<div id='regbox'>
<form name='newUser' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post'>

<p>
<label>Biodata:</label>
<textarea style="min-width: 400px;" name='biodata' cols="50" rows="5"><?php echo $data['biodata']; ?></textarea>
</p>

<p>
<label>Education Background:</label>
<textarea style="min-width: 400px;" name='education' cols="50" rows="5" ><?php echo $data['education']; ?></textarea>
</p>

<p>
<label>Expertise:</label>
<textarea style="min-width: 400px;" name='expertise' cols="50" rows="5" ><?php echo $data['expertise']; ?></textarea>
</p>

<p>
<label>Personal Development:</label>
<textarea style="min-width: 400px;" name='development' cols="50" rows="5" ><?php echo $data['development']; ?></textarea>
</p>

<p>
<label>Membership:</label>
<input type="text" name='membership' value="<?php echo $data['membership']; ?>" />
</p>

<p>
<label>&nbsp;<br>
<input name="submit" class="btn" type='submit' value='Save'/>
</p>
</form>
		
		
	</div>
  </div>
  <div id='bottom'></div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('.nav-left li').removeClass('active');
		$('.nav-left .profile').addClass('active');
	});
</script>
<?php require_once('models/footer.php'); ?>