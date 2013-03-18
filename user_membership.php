<?php

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

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
		$('.nav-left .membership').addClass('active');
	});
</script>
</body>
</html>