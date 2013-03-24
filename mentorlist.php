<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Forms posted
if(!empty($_POST))
{
	$deletions = $_POST['delete'];
	if ($deletion_count = deleteUsers($deletions)){
		$successes[] = lang("ACCOUNT_DELETIONS_SUCCESSFUL", array($deletion_count));
	}
	else {
		$errors[] = lang("SQL_ERROR");
	}
}

if($loggedInUser->checkPermission(array(2))){
	$users_id = fetchPermissionUsers(3);
} else {
	$users_id = fetchAllUsers(); //Fetch information for all users
}

$userData = array();
foreach($users_id as $user){
	$userData[] = fetchUserDetails(null, null, $user['user_id']);
}

require_once("models/header.php"); ?>

<body>
<div class="container-fluid">
  <div class="row-fluid">
	<?php include("left-nav.php"); ?>

	<div class="span9">
		<?php echo resultBlock($errors,$successes); ?>

		
		
<form name='adminUsers' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post'>
<table class='table table-striped table-hover'>
<tr>
<th>Delete</th><th>Username</th><th>Display Name</th><th>Title</th><th>Mentor</th><th>Last Sign In</th>
</tr>
<?php 
//Cycle through users
if($userData ){
foreach ($userData as $v1) { ?>
	<tr>
	<td><input type='checkbox' name='delete[<?php echo $v1['id']; ?>]' id='delete[<?php echo $v1['id']; ?>]' value='<?php echo $v1['id']; ?>'></td>
	<td>
		<a href='<?php echo ($loggedInUser->checkPermission(array(2)))?'admin_user.php':'mentee.php'; ?>?id=<?php echo $v1['id']; ?>'><?php echo $v1['user_name']; ?></a></td>
	<td><?php echo $v1['display_name']; ?></td>
	<td><?php echo $v1['title']; ?></td>
	<td><?php
	if($v1['user_parent'] != '0'){
		$details = fetchUserDetails(null, null, $v1['user_parent']);
		echo $details['display_name'];
	} else {
		echo '';
	}?></td>
	<td>
	<?php
	//Interprety last login
	if ($v1['last_sign_in_stamp'] == '0'){
		echo "Never";	
	}
	else {
		echo date("j M, Y", $v1['last_sign_in_stamp']);
	} ?>
	</td>
	</tr>
<?php } } ?>

</table>
<input class="btn btn-primary" type='submit' name='Submit' value='Delete' />
</form>


</div>
<div id='bottom'></div>
</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('.nav-left li').removeClass('active');
		
		$('.nav-left .<?php echo ($loggedInUser->checkPermission(array(2)))?'admin-user':'mentee';?>').addClass('active');
	});
</script>
</body>
</html>
