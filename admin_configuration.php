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
	$cfgId = array();
	$newSettings = $_POST['settings'];
	
	//Validate new site name
	if ($newSettings[1] != $websiteName) {
		$newWebsiteName = $newSettings[1];
		if(minMaxRange(1,150,$newWebsiteName))
		{
			$errors[] = lang("CONFIG_NAME_CHAR_LIMIT",array(1,150));
		}
		else if (count($errors) == 0) {
			$cfgId[] = 1;
			$cfgValue[1] = $newWebsiteName;
			$websiteName = $newWebsiteName;
		}
	}
	
	//Validate new URL
	if ($newSettings[2] != $websiteUrl) {
		$newWebsiteUrl = $newSettings[2];
		if(minMaxRange(1,150,$newWebsiteUrl))
		{
			$errors[] = lang("CONFIG_URL_CHAR_LIMIT",array(1,150));
		}
		else if (substr($newWebsiteUrl, -1) != "/"){
			$errors[] = lang("CONFIG_INVALID_URL_END");
		}
		else if (count($errors) == 0) {
			$cfgId[] = 2;
			$cfgValue[2] = $newWebsiteUrl;
			$websiteUrl = $newWebsiteUrl;
		}
	}
	
	//Validate new site email address
	if ($newSettings[3] != $emailAddress) {
		$newEmail = $newSettings[3];
		if(minMaxRange(1,150,$newEmail))
		{
			$errors[] = lang("CONFIG_EMAIL_CHAR_LIMIT",array(1,150));
		}
		elseif(!isValidEmail($newEmail))
		{
			$errors[] = lang("CONFIG_EMAIL_INVALID");
		}
		else if (count($errors) == 0) {
			$cfgId[] = 3;
			$cfgValue[3] = $newEmail;
			$emailAddress = $newEmail;
		}
	}
	
	//Validate email activation selection
	if ($newSettings[4] != $emailActivation) {
		$newActivation = $newSettings[4];
		if($newActivation != "true" AND $newActivation != "false")
		{
			$errors[] = lang("CONFIG_ACTIVATION_TRUE_FALSE");
		}
		else if (count($errors) == 0) {
			$cfgId[] = 4;
			$cfgValue[4] = $newActivation;
			$emailActivation = $newActivation;
		}
	}
	
	//Validate new email activation resend threshold
	if ($newSettings[5] != $resend_activation_threshold) {
		$newResend_activation_threshold = $newSettings[5];
		if($newResend_activation_threshold > 72 OR $newResend_activation_threshold < 0)
		{
			$errors[] = lang("CONFIG_ACTIVATION_RESEND_RANGE",array(0,72));
		}
		else if (count($errors) == 0) {
			$cfgId[] = 5;
			$cfgValue[5] = $newResend_activation_threshold;
			$resend_activation_threshold = $newResend_activation_threshold;
		}
	}
	
	//Validate new language selection
	if ($newSettings[6] != $language) {
		$newLanguage = $newSettings[6];
		if(minMaxRange(1,150,$language))
		{
			$errors[] = lang("CONFIG_LANGUAGE_CHAR_LIMIT",array(1,150));
		}
		elseif (!file_exists($newLanguage)) {
			$errors[] = lang("CONFIG_LANGUAGE_INVALID",array($newLanguage));				
		}
		else if (count($errors) == 0) {
			$cfgId[] = 6;
			$cfgValue[6] = $newLanguage;
			$language = $newLanguage;
		}
	}
	
	//Validate new template selection
	if ($newSettings[7] != $template) {
		$newTemplate = $newSettings[7];
		if(minMaxRange(1,150,$template))
		{
			$errors[] = lang("CONFIG_TEMPLATE_CHAR_LIMIT",array(1,150));
		}
		elseif (!file_exists($newTemplate)) {
			$errors[] = lang("CONFIG_TEMPLATE_INVALID",array($newTemplate));				
		}
		else if (count($errors) == 0) {
			$cfgId[] = 7;
			$cfgValue[7] = $newTemplate;
			$template = $newTemplate;
		}
	}
	
	//Update configuration table with new settings
	if (count($errors) == 0 AND count($cfgId) > 0) {
		updateConfig($cfgId, $cfgValue);
		$successes[] = lang("CONFIG_UPDATE_SUCCESSFUL");
	}
}

$languages = getLanguageFiles(); //Retrieve list of language files
$templates = getTemplateFiles(); //Retrieve list of template files
$permissionData = fetchAllPermissions(); //Retrieve list of all permission levels
require_once("models/header.php"); ?>


<div class="container-fluid">
  <div class="row-fluid">
	<?php include("left-nav.php"); ?>

	<div class="span9">
		<?php echo resultBlock($errors,$successes); ?>

	<div id='regbox'>
	<form name='adminConfiguration' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post'>
	<p>
	<label>Website Name:</label>
	<input type='text' name='settings[<?php echo $settings['website_name']['id']; ?>]' value='<?php echo $websiteName; ?>' />
	</p>
	<p>
	<label>Website URL:</label>
	<input type='text' name='settings[<?php echo $settings['website_url']['id']; ?>]' value='<?php echo $websiteUrl; ?>' />
	</p>
	<p>
	<label>Email:</label>
	<input type='text' name='settings[<?php echo $settings['email']['id']; ?>]' value='<?php echo $emailAddress; ?>' />
	</p>
	<p>
	<label>Activation Threshold:</label>
	<input type='text' name='settings[<?php echo $settings['resend_activation_threshold']['id']; ?>]' value='<?php echo $resend_activation_threshold; ?>' />
	</p>
	<p>
	<label>Language:</label>
	<select name='settings[<?php echo $settings['language']['id']; ?>]'>

	<?php //Display language options
	foreach ($languages as $optLang){
		if ($optLang == $language){ ?>
			<option value='<?php echo $optLang; ?>' selected><?php echo $optLang; ?></option>
		<?php } else { ?>
			<option value='<?php echo $optLang; ?>'><?php echo $optLang; ?></option>
		<?php } 
	}
	?>

	</select>
	</p>
	<p>
	<label>Email Activation:</label>
	<select name='settings[<?php echo $settings['activation']['id']; ?>]'>

	<?php
	//Display email activation options
	if ($emailActivation == "true"){ ?>
		<option value='true' selected>True</option>
		<option value='false'>False</option>
	<?php } else { ?>
		<option value='true'>True</option>
		<option value='false' selected>False</option>
	<?php } ?>
	</select>
	</p>
	<p>
	<label>Template:</label>
	<select name='settings[<?php echo $settings['template']['id']; ?>]'>

	<?php
	//Display template options
	foreach ($templates as $temp){
		if ($temp == $template){ ?>
			<option value='<?php echo $temp; ?>' selected><?php echo $temp; ?></option>
		<?php } else { ?>
			<option value='<?php echo $temp; ?>'><?php echo $temp; ?></option>
		<?php }
	} ?>

	</select>
	</p>
	<input class="btn btn-primary" type='submit' name='Submit' value='Submit' />
	</form>
	</div>
	</div>
	<div id='bottom'></div>
</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($){
		$('.nav-left li').removeClass('active');
		$('.nav-left .admin-conf').addClass('active');
	});
</script>
<?php require_once('models/footer.php'); ?>
