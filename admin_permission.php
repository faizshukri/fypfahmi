<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$permissionId = $_GET['id'];

//Check if selected permission level exists
if(!permissionIdExists($permissionId)){
	header("Location: admin_permissions.php"); die();	
}

$permissionDetails = fetchPermissionDetails($permissionId); //Fetch information specific to permission level

//Forms posted
if(!empty($_POST)){
	
	//Delete selected permission level
	if(!empty($_POST['delete'])){
		$deletions = $_POST['delete'];
		if ($deletion_count = deletePermission($deletions)){
		$successes[] = lang("PERMISSION_DELETIONS_SUCCESSFUL", array($deletion_count));
		}
		else {
			$errors[] = lang("SQL_ERROR");	
		}
	}
	else
	{
		//Update permission level name
		if($permissionDetails['name'] != $_POST['name']) {
			$permission = trim($_POST['name']);
			
			//Validate new name
			if (permissionNameExists($permission)){
				$errors[] = lang("ACCOUNT_PERMISSIONNAME_IN_USE", array($permission));
			}
			elseif (minMaxRange(1, 50, $permission)){
				$errors[] = lang("ACCOUNT_PERMISSION_CHAR_LIMIT", array(1, 50));	
			}
			else {
				if (updatePermissionName($permissionId, $permission)){
					$successes[] = lang("PERMISSION_NAME_UPDATE", array($permission));
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}
		}
		
		//Remove access to pages
		if(!empty($_POST['removePermission'])){
			$remove = $_POST['removePermission'];
			if ($deletion_count = removePermission($permissionId, $remove)) {
				$successes[] = lang("PERMISSION_REMOVE_USERS", array($deletion_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		//Add access to pages
		if(!empty($_POST['addPermission'])){
			$add = $_POST['addPermission'];
			if ($addition_count = addPermission($permissionId, $add)) {
				$successes[] = lang("PERMISSION_ADD_USERS", array($addition_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		//Remove access to pages
		if(!empty($_POST['removePage'])){
			$remove = $_POST['removePage'];
			if ($deletion_count = removePage($remove, $permissionId)) {
				$successes[] = lang("PERMISSION_REMOVE_PAGES", array($deletion_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		//Add access to pages
		if(!empty($_POST['addPage'])){
			$add = $_POST['addPage'];
			if ($addition_count = addPage($add, $permissionId)) {
				$successes[] = lang("PERMISSION_ADD_PAGES", array($addition_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
			$permissionDetails = fetchPermissionDetails($permissionId);
	}
}

$pagePermissions = fetchPermissionPages($permissionId); //Retrieve list of accessible pages
$permissionUsers = fetchPermissionUsers($permissionId); //Retrieve list of users with membership
$userData = fetchAllUsers(); //Fetch all users
$pageData = fetchAllPages(); //Fetch all pages

require_once("models/header.php"); ?>


<div class="container-fluid">
  <div class="row-fluid">
	<?php include("left-nav.php"); ?>

	<div class="span9">
		<?php echo resultBlock($errors,$successes); ?>

<form name='adminPermission' action='<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $permissionId; ?>' method='post'>
<table class='table'>
<tr><td>
<h3>Permission Information</h3>
<div id='regbox'>
<p>
<label>ID:</label>
<?php echo $permissionDetails['id']; ?>
</p>
<p>
<label>Name:</label>
<input type='text' name='name' value='<?php echo $permissionDetails['name']; ?>' />
</p>
<label>Delete:</label>
<input type='checkbox' name='delete[<?php echo $permissionDetails['id']; ?>]' id='delete[<?php echo $permissionDetails['id']; ?>]' value='<?php echo $permissionDetails['id']; ?>'>
</p>
</div></td><td>
<h3>Permission Membership</h3>
<div id='regbox'>
<p>Remove Members:
<?php
//List users with permission level
foreach ($userData as $v1) {
	if(isset($permissionUsers[$v1['id']])){ ?>
		<br><input type='checkbox' name='removePermission[<?php echo $v1['id']; ?>]' id='removePermission[<?php echo $v1['id']; ?>]' value='<?php echo $v1['id']; ?>'> <?php echo $v1['display_name']; ?></input>
	<?php }
} ?>

</p><p>Add Members:

<?php
//List users without permission level
foreach ($userData as $v1) {
	if(!isset($permissionUsers[$v1['id']])){ ?>
		<br><input type='checkbox' name='addPermission[<?php echo $v1['id']; ?>]' id='addPermission[<?php echo $v1['id']; ?>]' value='<?php echo $v1['id']; ?>'> <?php echo $v1['display_name']; ?></input>
	<?php }
} ?>

</p>
</div>
</td>
<td>
<h3>Permission Access</h3>
<div id='regbox'>
<p>
Public Access:

<?php
//List public pages
foreach ($pageData as $v1) {
	if($v1['private'] != 1){ ?>
		<br><?php echo $v1['page']; ?>
	<?php }
} ?>

</p>
<p>
Remove Access:
<?php 
//List pages accessible to permission level
foreach ($pageData as $v1) {
	if(isset($pagePermissions[$v1['id']]) AND $v1['private'] == 1){ ?>
		<br><input type='checkbox' name='removePage[<?php echo $v1['id']; ?>]' id='removePage[<?php echo $v1['id']; ?>]' value='<?php echo $v1['id']; ?>'> <?php echo $v1['page']; ?></input>
	<?php }
} ?>

</p><p>Add Access:
<?php 
//List pages inaccessible to permission level
foreach ($pageData as $v1) {
	if(!isset($pagePermissions[$v1['id']]) AND $v1['private'] == 1){ ?>
		<br><input type='checkbox' name='addPage[<?php echo $v1['id']; ?>]' id='addPage[<?php echo $v1['id']; ?>]' value='<?php echo $v1['id']; ?>'> <?php echo $v1['page']; ?></input>
	<?php }
} ?>

</p>
</div>
</td>
</tr>
</table>
<p>
<label>&nbsp;</label>
<input type='submit' value='Update' class='btn btn-primary' />
</p>
</form>
</div>
<div id='bottom'></div>
</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('.nav-left li').removeClass('active');
		$('.nav-left .admin-perm').addClass('active');
	});
</script>
<?php require_once('models/footer.php'); ?>
