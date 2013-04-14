<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $_GET['id'];

//Check if selected user exists
if(!userIdExists($userId)){
	header("Location: admin_users.php"); die();
}

$userdetails = fetchUserDetails(NULL, NULL, $userId); //Fetch user details

//Forms posted
if(!empty($_POST))
{	
	//Delete selected account
	if(!empty($_POST['delete'])){
		$deletions = $_POST['delete'];
		if ($deletion_count = deleteUsers($deletions)) {
			$successes[] = lang("ACCOUNT_DELETIONS_SUCCESSFUL", array($deletion_count));
		}
		else {
			$errors[] = lang("SQL_ERROR");
		}
	}
	else
	{
		//Update display name
		if ($userdetails['display_name'] != $_POST['display']){
			$displayname = trim($_POST['display']);
			
			//Validate display name
			if(displayNameExists($displayname))
			{
				$errors[] = lang("ACCOUNT_DISPLAYNAME_IN_USE",array($displayname));
			}
			elseif(minMaxRange(5,25,$displayname))
			{
				$errors[] = lang("ACCOUNT_DISPLAY_CHAR_LIMIT",array(5,25));
			}
			elseif(!ctype_alnum($displayname)){
				$errors[] = lang("ACCOUNT_DISPLAY_INVALID_CHARACTERS");
			}
			else {
				if (updateDisplayName($userId, $displayname)){
					$successes[] = lang("ACCOUNT_DISPLAYNAME_UPDATED", array($displayname));
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}
			
		}
		else {
			$displayname = $userdetails['display_name'];
		}
		
		//Activate account
		if(isset($_POST['activate']) && $_POST['activate'] == "activate"){
			if (setUserActive($userdetails['activation_token'])){
				$successes[] = lang("ACCOUNT_MANUALLY_ACTIVATED", array($displayname));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		//Update email
		if ($userdetails['email'] != $_POST['email']){
			$email = trim($_POST["email"]);
			
			//Validate email
			if(!isValidEmail($email))
			{
				$errors[] = lang("ACCOUNT_INVALID_EMAIL");
			}
			elseif(emailExists($email))
			{
				$errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));
			}
			else {
				if (updateEmail($userId, $email)){
					$successes[] = lang("ACCOUNT_EMAIL_UPDATED");
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}
		}
		
		//Update title
		if ($userdetails['title'] != $_POST['title']){
			$title = trim($_POST['title']);
			
			//Validate title
			if(minMaxRange(1,50,$title))
			{
				$errors[] = lang("ACCOUNT_TITLE_CHAR_LIMIT",array(1,50));
			}
			else {
				if (updateTitle($userId, $title)){
					$successes[] = lang("ACCOUNT_TITLE_UPDATED", array ($displayname, $title));
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}
		}
		
		//Remove permission level
		if(!empty($_POST['removePermission'])){
			$remove = $_POST['removePermission'];
			if ($deletion_count = removePermission($remove, $userId)){
				$successes[] = lang("ACCOUNT_PERMISSION_REMOVED", array ($deletion_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		if(!empty($_POST['addPermission'])){
			$add = $_POST['addPermission'];
			if ($addition_count = addPermission($add, $userId)){
				$successes[] = lang("ACCOUNT_PERMISSION_ADDED", array ($addition_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		$userdetails = fetchUserDetails(NULL, NULL, $userId);
	}
}

$userPermission = fetchUserPermissions($userId);
$permissionData = fetchAllPermissions();

require_once("models/header.php"); ?>


<div class="container-fluid">
  <div class="row-fluid">
	<?php include("left-nav.php"); ?>

	<div class="span9">
		<?php echo resultBlock($errors,$successes); ?>

<form name='adminUser' action='<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $userId; ?>' method='post'>
<table class='table'><tr><td>
<h3>User Information</h3>
<div id='regbox'>
<p>
<label>ID:</label>
<?php echo $userdetails['id']; ?>
</p>
<p>
<label>Username:</label>
<?php echo $userdetails['user_name']; ?>
</p>
<p>
<label>Display Name:</label>
<input type='text' name='display' value='<?php echo $userdetails['display_name']; ?>' />
</p>
<p>
<label>Email:</label>
<input type='text' name='email' value='<?php echo $userdetails['email']; ?>' />
</p>
<p>
<label>Active:</label>

<?php
//Display activation link, if account inactive
if ($userdetails['active'] == '1'){
	echo "Yes";	
}
else{
	echo "No
	</p>
	<p>
	<label>Activate:</label>
	<input type='checkbox' name='activate' id='activate' value='activate'>
	";
}
?>
</p>
<p>
<label>Title:</label>
<input type='text' name='title' value='<?php echo $userdetails['title']; ?>' />
</p>
<p>
<label>Sign Up:</label>
<?php echo date("j M, Y", $userdetails['sign_up_stamp']); ?>
</p>
<p>
<label>Last Sign In:</label>

<?php
//Last sign in, interpretation
if ($userdetails['last_sign_in_stamp'] == '0'){
	echo "Never";	
}
else {
	echo date("j M, Y", $userdetails['last_sign_in_stamp']);
} ?>
</p>
<p>
<label>Delete:</label>
<input type='checkbox' name='delete[<?php echo $userdetails['id']; ?>]' id='delete[<?php echo $userdetails['id']; ?>]' value='<?php echo $userdetails['id']; ?>' />
</p>
<p>
<label>&nbsp;</label>
<input type='submit' value='Update' class='btn btn-primary' />
</p>
</div>
</td>
<?php if ($loggedInUser->checkPermission(array(2))){ ?>
<td>
<h3>Permission Membership</h3>
<div id='regbox'>
<p>Remove Permission:
<?php
//List of permission levels user is apart of
foreach ($permissionData as $v1) {
	if(isset($userPermission[$v1['id']])){ ?>
		<br><input type='checkbox' name='removePermission[<?php echo $v1['id']; ?>]' id='removePermission[<?php echo $v1['id']; ?>]' value='<?php echo $v1['id']; ?>'> <?php echo $v1['name']; ?></input>
	<?php }
}

//List of permission levels user is not apart of
echo "</p><p>Add Permission:";
foreach ($permissionData as $v1) {
	if(!isset($userPermission[$v1['id']])){ ?>
		<br><input type='checkbox' name='addPermission[<?php echo $v1['id']; ?>]' id='addPermission[<?php echo $v1['id']; ?>]' value='<?php echo $v1['id']; ?>'> <?php echo $v1['name']; ?></input>
	<?php }
} ?>

</p>
</div>
</td>
<?php } ?>
</tr>
</table>
</form>
</div>
<div id='bottom'></div>
</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('.nav-left li').removeClass('active');
		$('.nav-left .admin-user').addClass('active');
	});
</script>
<?php require_once('models/footer.php'); ?>
