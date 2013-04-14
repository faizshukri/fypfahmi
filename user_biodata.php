<?php

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$states = getState();
$tmp = array();
foreach($states as $index => $row){
	$tmp[$row['id']] = $row['state'];
}
$states = $tmp;

//Form is submit
if(!empty($_POST)){
	$errors = array();
	$date_birth = new DateTime(trim($_POST["date_birth"]));
	$user_data = array(
		'fullname' => trim($_POST["fullname"]),
		'ic_no' => trim($_POST["ic_no"]),
		'date_birth' => $date_birth->format('Y-m-d H:i:s'),
		'contact' => trim($_POST["contact"]),
		'address' => trim($_POST["address"]),
		'city' => trim($_POST["city"]),
		'state_id' => trim($_POST["state_id"])
	);
	
	//End data validation
	if(count($errors) == 0){
		
		if(updateUserBiodata($loggedInUser->user_id, $user_data))
		// if(updateUserData($loggedInUser->user_id, 'user_biodata', json_encode($user_data)))
			$successes[] = 'User profile has been saved.';
		else
			$errors[] = 'There an error to save your data. Please try again.';
	}
}

//$data = fetchUserData($loggedInUser->user_id, 'user_biodata');
$data = getUserBiodata($loggedInUser->user_id);
if(!$data){
	$data = array(
		'fullname' => '',
		'ic_no' => '',
		'date_birth' => '',
		'contact' => '',
		'address' => '',
		'city' => '',
		'state_id' => ''
	);
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
<label for="fullname">Full Name:</label>
<input name='fullname' id="fullname" type="text" value="<?php echo $data['fullname']; ?>" />
</p>
<p>
<label for="ic_no">IC No.:</label>
<input name='ic_no' id="ic_no" type="text" value="<?php echo $data['ic_no']; ?>" />
</p>
<p>
<label for="date_birth">Date of Birth:</label>
<input name='date_birth' id="date_birth" type="text"  value="<?php echo $data['date_birth']; ?>"/>
</p>
<p>
<label for="contact">Contact No.:</label>
<input name='contact' id="contact" type="text" value="<?php echo $data['contact']; ?>" />
</p>
<p>
<label for="address">Home Address:</label>
<textarea name='address' id="address" cols="200" rows="5"><?php echo $data['address']; ?></textarea>
</p>
<p>
<label for="city">City:</label>
<input name='city' id="city" type="text" value="<?php echo $data['city']; ?>" />
</p>
<p>
<label for="state_id">State:</label>
<select name="state_id">
	<?php foreach($states as $index => $state){ ?>
	<option value="<?php echo $index; ?>" <?php echo ($data['state_id'] == $index)? 'selected': ''; ?>><?php echo $state; ?></option>
	<?php } ?>
</select>
</p>
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
		$('.nav-left .biodata').addClass('active');
		
		$( "#date_birth" ).datepicker({ defaultDate: "-20y",currentText: "Now", dateFormat: 'yy-mm-dd' });
		$( "#date_birth" ).datepicker( "setDate", "<?php echo $data['date_birth']; ?>" );
	});
</script>
<?php require_once('models/footer.php'); ?>