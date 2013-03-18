<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
//if(isUserLoggedIn()) { header("Location: account.php"); die(); }

//Forms posted
if(!empty($_POST))
{
	$errors = array();
	$email = trim($_POST["email"]);
	$username = trim($_POST["username"]);
	$displayname = trim($_POST["displayname"]);
	$password = trim($_POST["password"]);
	$confirm_pass = trim($_POST["passwordc"]);
	$level = (isset($_POST["level"]))? trim($_POST["level"]): 1;
	$parent = (isset($_POST["parent"]))? trim($_POST["parent"]): 0;
	//$captcha = md5($_POST["captcha"]);
	
	
	// if ($captcha != $_SESSION['captcha'])
	// {
		// $errors[] = lang("CAPTCHA_FAIL");
	// }
	if(minMaxRange(5,25,$username))
	{
		$errors[] = lang("ACCOUNT_USER_CHAR_LIMIT",array(5,25));
	}
	if(!ctype_alnum($username)){
		$errors[] = lang("ACCOUNT_USER_INVALID_CHARACTERS");
	}
	if(minMaxRange(5,25,$displayname))
	{
		$errors[] = lang("ACCOUNT_DISPLAY_CHAR_LIMIT",array(5,25));
	}
	if(!ctype_alnum($displayname)){
		$errors[] = lang("ACCOUNT_DISPLAY_INVALID_CHARACTERS");
	}
	if(minMaxRange(8,50,$password) && minMaxRange(8,50,$confirm_pass))
	{
		$errors[] = lang("ACCOUNT_PASS_CHAR_LIMIT",array(8,50));
	}
	else if($password != $confirm_pass)
	{
		$errors[] = lang("ACCOUNT_PASS_MISMATCH");
	}
	if(!isValidEmail($email))
	{
		$errors[] = lang("ACCOUNT_INVALID_EMAIL");
	}
	//End data validation
	if(count($errors) == 0)
	{	
		//Construct a user object
		$user = new User($username,$displayname,$password,$email,$level,$parent);
		
		//Checking this flag tells us whether there were any errors such as possible data duplication occured
		if(!$user->status)
		{
			if($user->username_taken) $errors[] = lang("ACCOUNT_USERNAME_IN_USE",array($username));
			if($user->displayname_taken) $errors[] = lang("ACCOUNT_DISPLAYNAME_IN_USE",array($displayname));
			if($user->email_taken) 	  $errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));		
		}
		else
		{
			//Attempt to add the user to the database, carry out finishing  tasks like emailing the user (if required)
			if(!$user->userCakeAddUser())
			{
				if($user->mail_failure) $errors[] = lang("MAIL_ERROR");
				if($user->sql_failure)  $errors[] = lang("SQL_ERROR");
			}
		}
	}
	if(count($errors) == 0) {
		$successes[] = $user->success;
	}
}
$mentors = fetchPermissionUsers(3);
$mentor_list = array();
foreach($mentors as $mentor){
	$tmp = fetchUserDetails(null, null, $mentor['user_id']);
	$mentor_list[$tmp['id']] = $tmp['display_name'];
}

$perms = fetchAllPermissions();
$perm_list = array();
foreach($perms as $perm){
	$perm_list[$perm['id']] = $perm['name'];
}
//debug($perm_list);
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
<label>User Name:</label>
<input type='text' name='username' />
</p>
<p>
<label>Display Name:</label>
<input type='text' name='displayname' />
</p>
<p>
<label>Password:</label>
<input type='password' name='password' />
</p>
<p>
<label>Confirm:</label>
<input type='password' name='passwordc' />
</p>
<p>
<label>Email:</label>
<input type='text' name='email' />
</p>
<?php if($loggedInUser->checkPermission(array(2))){ ?>
<p>
<label>Level:</label>
<select id="selectLevel" name='level' >
	<?php foreach($perm_list as $index => $perm){ ?>
		<option value="<?php echo $index; ?>"><?php echo $perm; ?></option>
	<?php } ?>
</select>
</p>
<p>
<label>Parent:</label>
<select id="selectParent" name='parent'>
	<?php foreach($mentor_list as $index => $mentor){ ?>
		<option value="<?php echo $index; ?>"><?php echo $mentor; ?></option>
	<?php } ?>
</select>
</p>
<?php } else if($loggedInUser->checkPermission(array(3))){ ?>
	<input type="hidden" value="<?php echo $loggedInUser->user_id; ?>" name="parent" />
<?php } ?>
<!-- <p>
<label>Security Code:</label>
<img src='models/captcha.php'>
</p>
<p>
<label>Enter Security Code:</label>
<input name='captcha' type='text'>
</p>
-->
<p>
<label>&nbsp;<br>
<input class="btn btn-primary" type='submit' value='Register'/>
</p>

</form>
</div>

</div>
<div id='bottom'></div>
</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('.nav-left li').removeClass('active');
		$('.nav-left .register').addClass('active');
		
		$('#selectLevel').change(function(){
			if($(this).val() != 1){
				$('#selectParent').attr('disabled', 'disabled').parent().hide();
			} else {
				$('#selectParent').removeAttr('disabled').parent().show();
			}
		});
	});
</script>
</body>
</html>