<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");

?>
<body>
<div class="container-fluid">
  <div class="row-fluid">
	<?php include("left-nav.php"); ?>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('.nav-left li').removeClass('active');
		$('.nav-left .account').addClass('active');
	});
</script>
</body>
</html>

<?php
/* 

<ul>
<li><a href='account.php'>Account Home</a></li>
<li><a href='user_settings.php'>User Settings</a></li>
<li><a href='logout.php'>Logout</a></li>
</ul>";

//Links for permission level 2 (default admin)
if ($loggedInUser->checkPermission(array(2))){
echo "
<ul>
<li><a href='admin_configuration.php'>Admin Configuration</a></li>
<li><a href='admin_users.php'>Admin Users</a></li>
<li><a href='admin_permissions.php'>Admin Permissions</a></li>
<li><a href='admin_pages.php'>Admin Pages</a></li>
</ul>";



echo "
<body>
<div id='wrapper'>
<div id='top'><div id='logo'></div></div>
<div id='content'>
<h1>UserCake</h1>
<h2>Account</h2>
<div id='left-nav'>";

include("left-nav.php");

echo "
</div>
<div id='main'>
Hey, $loggedInUser->displayname. This is an example secure page designed to demonstrate some of the basic features of UserCake. Just so you know, your title at the moment is $loggedInUser->title, and that can be changed in the admin panel. You registered this account on " . date("M d, Y", $loggedInUser->signupTimeStamp()) . ".
</div>
<div id='bottom'></div>
</div>
</body>
</html>"; */

?>
