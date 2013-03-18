<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

if (!securePage($_SERVER['PHP_SELF'])){die();}
$user = fetchUserDetails(null, null, $loggedInUser->user_id);
$perms2 = fetchUserPermissions($loggedInUser->user_id);
$perm_list2 = array();
foreach($perms2 as $index => $perm){
	$perm_detail = fetchPermissionDetails($perm['permission_id']);
	$perm_list2[] = $perm_detail['name'];
}
//debug(sizeof($perm_list2));
?>
  <div class="span3">
  <div class="well nav-left" style="padding: 8px 0;">
	<div style="margin: 5px 15px;">Welcome <strong><?php echo $user['display_name']; ?></strong>,<br />
	You login as <small><strong><?php 
	foreach($perm_list2 as $index => $perm){
		echo $perm;
		echo ($index < (sizeof($perm_list2) - 1))?', ':'';
	}?></strong></small>
	</div>
 <?php

//Links for logged in user
if(isUserLoggedIn()) { ?>
	<ul class="nav nav-list">
	  <?php if ($loggedInUser->checkPermission(array(1))){ ?>
	  <li class="nav-header">User Profile</li>
	  <li class="biodata"><a href="user_biodata.php">Biodata</a></li>
	  <li class="education"><a href="user_education.php">Education Background</a></li>
	  <li class="expertise"><a href="user_expertise.php">Expertise</a></li>
	  <!-- <li class="membership"><a href="user_membership.php">Membership</a></li>-->
	  <li class="personal"><a href="user_development.php">Personal Development</a></li>
	  <?php } ?>
	  <li class="nav-header">User Menu</li>
	  <li class="account"><a href="account.php">Account Home</a></li>
	  <li class="user"><a href='user_settings.php'>Change Email / Password</a></li>
	  <?php if($loggedInUser->checkPermission(array(2))){ ?>
		<li class="register"><a href='register.php'>Register User</a></li>
	  <?php } ?>
	   <?php if($loggedInUser->checkPermission(array(3))){ ?>
		<li class="register"><a href='register.php'>Register Mentee</a></li>
	    <li class="mentee"><a href="admin_users.php">Mentee List</a></li>
	    <li class="dev_personal"><a href="development_add.php">Personal Development</a></li>
	    <li class="monitor"><a href="development_monitor.php">Development Monitoring</a></li>
	   <?php } ?>
	  <li class="logout"><a href='logout.php'>Logout</a></li>
	  <?php 
		//Links for permission level 2 (default admin)
		if ($loggedInUser->checkPermission(array(2))){ ?>
			<li class="nav-header">Admin Menu</li>
			<li class="admin-conf"><a href="admin_configuration.php">Main Configuration</a></li>
			<li class="admin-user"><a href="admin_users.php">Users List</a></li>
			<li class="admin-perm"><a href="admin_permissions.php">Permissions List</a></li>
			<li class="admin-page"><a href="admin_pages.php">Pages List</a></li>
	<?php } ?>
	  
	</ul> <?php

} 
//Links for users not logged in
else { ?>
	<ul>
	<li><a href='index.php'>Home</a></li>
	<li><a href='login.php'>Login</a></li>
	<li><a href='register.php'>Register</a></li>
	<li><a href='forgot-password.php'>Forgot Password</a></li>";
	<?php if ($emailActivation){ ?>
		<li><a href='resend-activation.php'>Resend Activation Email</a></li>
	<?php } ?>
	</ul>
<?php } ?>
</div>
</div>
