<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$pageId = $_GET['id'];

//Check if selected pages exist
if(!pageIdExists($pageId)){
	header("Location: admin_pages.php"); die();	
}

$pageDetails = fetchPageDetails($pageId); //Fetch information specific to page

//Forms posted
if(!empty($_POST)){
	$update = 0;
	
	if(!empty($_POST['private'])){ $private = $_POST['private']; }
	
	//Toggle private page setting
	if (isset($private) AND $private == 'Yes'){
		if ($pageDetails['private'] == 0){
			if (updatePrivate($pageId, 1)){
				$successes[] = lang("PAGE_PRIVATE_TOGGLED", array("private"));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
	}
	elseif ($pageDetails['private'] == 1){
		if (updatePrivate($pageId, 0)){
			$successes[] = lang("PAGE_PRIVATE_TOGGLED", array("public"));
		}
		else {
			$errors[] = lang("SQL_ERROR");	
		}
	}
	
	//Remove permission level(s) access to page
	if(!empty($_POST['removePermission'])){
		$remove = $_POST['removePermission'];
		if ($deletion_count = removePage($pageId, $remove)){
			$successes[] = lang("PAGE_ACCESS_REMOVED", array($deletion_count));
		}
		else {
			$errors[] = lang("SQL_ERROR");	
		}
		
	}
	
	//Add permission level(s) access to page
	if(!empty($_POST['addPermission'])){
		$add = $_POST['addPermission'];
		if ($addition_count = addPage($pageId, $add)){
			$successes[] = lang("PAGE_ACCESS_ADDED", array($addition_count));
		}
		else {
			$errors[] = lang("SQL_ERROR");	
		}
	}
	
	$pageDetails = fetchPageDetails($pageId);
}

$pagePermissions = fetchPagePermissions($pageId);
$permissionData = fetchAllPermissions();

require_once("models/header.php"); ?>


<div class="container-fluid">
  <div class="row-fluid">
	<?php include("left-nav.php"); ?>

	<div class="span9">
		<?php echo resultBlock($errors,$successes); ?>

<form name='adminPage' action='<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $pageId; ?>' method='post'>
<input type='hidden' name='process' value='1'>
<table class='table'>
<tr><td>
<h3>Page Information</h3>
<div id='regbox'>
<p>
<label>ID:</label>
<?php echo $pageDetails['id']; ?>
</p>
<p>
<label>Name:</label>
<?php echo $pageDetails['page']; ?>
</p>
<p>
<label>Private:</label>

<?php
//Display private checkbox
if ($pageDetails['private'] == 1){ ?>
	<input type='checkbox' name='private' id='private' value='Yes' checked />
<?php } else { ?>
	<input type='checkbox' name='private' id='private' value='Yes' />	
<?php } ?>

</p>
</div></td><td>
<h3>Page Access</h3>
<div id='regbox'>
<p>
Remove Access:
<?php
//Display list of permission levels with access
foreach ($permissionData as $v1) {
	if(isset($pagePermissions[$v1['id']])){ ?>
		<br><input type='checkbox' name='removePermission[<?php echo $v1['id']; ?>]' id='removePermission[<?php echo $v1['id']; ?>]' value='<?php echo $v1['id']; ?>'> <?php echo $v1['name']; ?></input>
	<?php }
} ?>

</p><p>Add Access:
<?php
//Display list of permission levels without access
foreach ($permissionData as $v1) {
	if(!isset($pagePermissions[$v1['id']])){ ?>
		<br><input type='checkbox' name='addPermission[<?php echo $v1['id']; ?>]' id='addPermission[<?php echo $v1['id']; ?>]' value='<?php echo $v1['id']; ?>'> <?php echo $v1['name']; ?></input>
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
<?php require_once('models/footer.php'); ?>
