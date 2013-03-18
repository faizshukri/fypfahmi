<?php

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$states = getState();

//Form is submit
if(!empty($_POST)){
	$errors = array();
	$user_data = array(
		'fullname' => trim($_POST["fullname"]),
		'ic_no' => trim($_POST["ic_no"]),
		'dob' => trim($_POST["dob"]),
		'email' => trim($_POST["email"]),
		'no_phone' => trim($_POST["no_phone"]),
		'address' => trim($_POST["address"]),
		'city' => trim($_POST["city"]),
		'state' => trim($_POST["state"])
	);
	
	//End data validation
	if(count($errors) == 0){
		if(updateUserData($loggedInUser->user_id, 'user_biodata', json_encode($user_data)))
			$successes[] = 'User profile has been saved.';
		else
			$errors[] = 'There an error to save your data. Please try again.';
	}
}

$data = fetchUserData($loggedInUser->user_id, 'user_biodata');
if(!$data){
	$data = array(
		'fullname' => '',
		'ic_no' => '',
		'dob' => '',
		'email' => '',
		'no_phone' => '',
		'address' => '',
		'city' => '',
		'state' => ''
	);
} else {
	$data = json_decode($data['content'], true);
}

require_once("models/header.php"); 

?>

<body>
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
<label for="dob">Date of Birth:</label>
<input name='dob' id="dob" type="text"  value="<?php echo $data['dob']; ?>"/>
</p>
<p>
<label for="email">Email:</label>
<input name='email' id="email" type="text" value="<?php echo $data['email']; ?>" />
</p>
<p>
<label for="no_phone">Contact No.:</label>
<input name='no_phone' id="no_phone" type="text" value="<?php echo $data['no_phone']; ?>" />
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
<label for="state">State:</label>
<select name="state" value="<?php echo $data['state']; ?>" >
	<?php foreach($states as $state){ ?>
	<option value="<?php echo $state; ?>"><?php echo $state; ?></option>
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
		
		$( "#dob" ).datepicker({ defaultDate: "-20y",currentText: "Now" });
		
		$( "#dob" ).datepicker( "setDate", "<?php echo $data['dob']; ?>" );
	});
</script>
</body>
</html>