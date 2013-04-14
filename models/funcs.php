<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

function getState(){

	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT *
		FROM ".$db_table_prefix."states
		ORDER BY state");
		
	$stmt->execute();
	$stmt->bind_result($id, $state, $zon_id);
	
	$row = false;
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'state' => $state, 'zon_id' => $zon_id);
	}
	$stmt->close();
	return ($row);

	// return array(
		// 'Johor' => 'Johor',
		// 'Kedah' => 'Kedah',
		// 'Kelantan' => 'Kelantan',
		// 'Kuala Lumpur' => 'Kuala Lumpur',
		// 'Melaka' => 'Melaka',
		// 'Negeri Sembilan' => 'Negeri Sembilan',
		// 'Pahang' => 'Pahang',
		// 'Perak' => 'Perak',
		// 'Perlis' => 'Perlis',
		// 'Pulau Pinang' => 'Pulau Pinang',
		// 'Sabah' => 'Sabah',
		// 'Sarawak' => 'Sarawak',
		// 'Selangor' => 'Selangor',
		// 'Terengganu' => 'Terengganu'
	// );
}

//Functions that do not interact with DB
//------------------------------------------------------------------------------

//Retrieve a list of all .php files in models/languages
function getLanguageFiles()
{
	$directory = "models/languages/";
	$languages = glob($directory . "*.php");
	//print each file name
	return $languages;
}

//Retrieve a list of all .css files in models/site-templates 
function getTemplateFiles()
{
	$directory = "models/site-templates/";
	$languages = glob($directory . "*.css");
	//print each file name
	return $languages;
}

//Retrieve a list of all .php files in root files folder
function getPageFiles()
{
	$directory = "";
	$pages = glob($directory . "*.php");
	//print each file name
	foreach ($pages as $page){
		$row[$page] = $page;
	}
	return $row;
}

//Destroys a session as part of logout
function destroySession($name)
{
	if(isset($_SESSION[$name]))
	{
		$_SESSION[$name] = NULL;
		unset($_SESSION[$name]);
	}
}

//Generate a unique code
function getUniqueCode($length = "")
{	
	$code = md5(uniqid(rand(), true));
	if ($length != "") return substr($code, 0, $length);
	else return $code;
}

//Generate an activation key
function generateActivationToken($gen = null)
{
	do
	{
		$gen = md5(uniqid(mt_rand(), false));
	}
	while(validateActivationToken($gen));
	return $gen;
}

//@ Thanks to - http://phpsec.org
function generateHash($plainText, $salt = null)
{
	if ($salt === null)
	{
		$salt = substr(md5(uniqid(rand(), true)), 0, 25);
	}
	else
	{
		$salt = substr($salt, 0, 25);
	}
	
	return $salt . sha1($salt . $plainText);
}

//Checks if an email is valid
function isValidEmail($email)
{
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return true;
	}
	else {
		return false;
	}
}

//Inputs language strings from selected language.
function lang($key,$markers = NULL)
{
	global $lang;
	if($markers == NULL)
	{
		$str = $lang[$key];
	}
	else
	{
		//Replace any dyamic markers
		$str = $lang[$key];
		$iteration = 1;
		foreach($markers as $marker)
		{
			$str = str_replace("%m".$iteration."%",$marker,$str);
			$iteration++;
		}
	}
	//Ensure we have something to return
	if($str == "")
	{
		return ("No language key found");
	}
	else
	{
		return $str;
	}
}

//Checks if a string is within a min and max length
function minMaxRange($min, $max, $what)
{
	if(strlen(trim($what)) < $min)
		return true;
	else if(strlen(trim($what)) > $max)
		return true;
	else
	return false;
}

//Replaces hooks with specified text
function replaceDefaultHook($str)
{
	global $default_hooks,$default_replace;	
	return (str_replace($default_hooks,$default_replace,$str));
}

//Displays error and success messages
function resultBlock($errors,$successes){
	//Error block
	
	$msg = '';
	
	if(count($errors) > 0)
	{
		$msg .= "<div class='alert alert-error'>
		<a class='close' data-dismiss='alert' href='#'>×</a>";
		foreach($errors as $error)
		{
			$msg .= '<div> - '.$error.'</div>';
		}
		$msg .= "</div>";
	}
	//Success block
	if(count($successes) > 0)
	{
		$msg .= "<div class='alert alert-success'>
		<a class='close' data-dismiss='alert' href='#'>×</a>";
		foreach($successes as $success)
		{
			$msg .= '<div> - '.$success.'</div>';
		}
		$msg .= "</div>";
	}
	
	return $msg;
}

//Completely sanitizes text
function sanitize($str)
{
	return strtolower(strip_tags(trim(($str))));
}

//Functions that interact mainly with .users table
//------------------------------------------------------------------------------

//Delete a defined array of users
function deleteUsers($users) {
	global $mysqli,$db_table_prefix; 
	$i = 0;
	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."users 
		WHERE id = ?");
	$stmt2 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_permission_matches 
		WHERE user_id = ?");
	foreach($users as $id){
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt2->bind_param("i", $id);
		$stmt2->execute();
		$i++;
	}
	$stmt->close();
	$stmt2->close();
	return $i;
}

//Check if a display name exists in the DB
function displayNameExists($displayname)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT active
		FROM ".$db_table_prefix."users
		WHERE
		display_name = ?
		LIMIT 1");
	$stmt->bind_param("s", $displayname);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Check if an email exists in the DB
function emailExists($email)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT active
		FROM ".$db_table_prefix."users
		WHERE
		email = ?
		LIMIT 1");
	$stmt->bind_param("s", $email);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Check if a user name and email belong to the same user
function emailUsernameLinked($email,$username)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT active
		FROM ".$db_table_prefix."users
		WHERE user_name = ?
		AND
		email = ?
		LIMIT 1
		");
	$stmt->bind_param("ss", $username, $email);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Retrieve information for all users
function fetchUserBiodataByIpt($ipt_id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		user_name,
		display_name,
		password,
		email,
		activation_token,
		last_activation_request,
		lost_password_request,
		active,
		title,
		ipt_id,
		user_parent,
		sign_up_stamp,
		last_sign_in_stamp
		FROM ".$db_table_prefix."users WHERE ipt_id='".$ipt_id."'");
	$stmt->execute();
	$stmt->bind_result($id, $user, $display, $password, $email, $token, $activationRequest, $passwordRequest, $active, $title, $ipt_id, $user_parent, $signUp, $signIn);
	
	$row = false;
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'user_name' => $user, 'display_name' => $display, 'password' => $password, 'email' => $email, 'activation_token' => $token, 'last_activation_request' => $activationRequest, 'lost_password_request' => $passwordRequest, 'active' => $active, 'title' => $title, 'ipt_id' => $ipt_id, 'user_parent' => $user_parent, 'sign_up_stamp' => $signUp, 'last_sign_in_stamp' => $signIn);
	}
	$stmt->close();
	return ($row);
}

//Retrieve information for all users
function fetchAllUsersByMentor($mentor_id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		user_name,
		display_name,
		password,
		email,
		activation_token,
		last_activation_request,
		lost_password_request,
		active,
		title,
		user_parent,
		sign_up_stamp,
		last_sign_in_stamp
		FROM ".$db_table_prefix."users WHERE user_parent='".$mentor_id."'");
	$stmt->execute();
	$stmt->bind_result($id, $user, $display, $password, $email, $token, $activationRequest, $passwordRequest, $active, $title, $user_parent, $signUp, $signIn);
	
	$row = false;
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'user_name' => $user, 'display_name' => $display, 'password' => $password, 'email' => $email, 'activation_token' => $token, 'last_activation_request' => $activationRequest, 'lost_password_request' => $passwordRequest, 'active' => $active, 'title' => $title, 'user_parent' => $user_parent, 'sign_up_stamp' => $signUp, 'last_sign_in_stamp' => $signIn);
	}
	$stmt->close();
	return ($row);
}
//Retrieve information for all users
function fetchAllMentorByUserState($user_id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT users.id, biodata.fullname
		FROM uc_users users, uc_user_biodata biodata, uc_user_permission_matches perm_match
		WHERE users.id=biodata.user_id
		AND perm_match.user_id=users.id
		AND perm_match.permission_id='3'
		AND biodata.state_id IN (SELECT states.id
		FROM uc_states states, uc_user_biodata biodata, uc_users users
		WHERE biodata.user_id = users.id
		AND biodata.state_id = states.id
		AND users.id='".$user_id."')");
	$stmt->execute();
	$stmt->bind_result($id, $fullname);
	
	$row = false;
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'fullname'=>$fullname, 'cat' => 'home');
	}
	$stmt->close();
	$stmt = $mysqli->prepare("SELECT users.id, biodata.fullname
		FROM uc_users users, uc_user_biodata biodata, uc_user_permission_matches perm_match
		WHERE users.id=biodata.user_id
		AND perm_match.user_id=users.id
		AND perm_match.permission_id='3'
		AND biodata.state_id IN (SELECT states.id
		FROM uc_states states, uc_users users, uc_user_education edu, uc_ipt ipt
		WHERE users.id=edu.user_id
		AND edu.edu_place = ipt.id
		AND ipt.state_id = states.id
		AND edu.`type`='Higher'
		AND users.id = '".$user_id."')");
	$stmt->execute();
	$stmt->bind_result($id, $fullname);
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'fullname'=>$fullname, 'cat' => 'ipt');
	}
	$stmt->close();
	return ($row);
}

//Retrieve information for all users
function fetchAllUsers()
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		user_name,
		display_name,
		password,
		email,
		activation_token,
		last_activation_request,
		lost_password_request,
		active,
		title,
		user_parent,
		sign_up_stamp,
		last_sign_in_stamp
		FROM ".$db_table_prefix."users");
	$stmt->execute();
	$stmt->bind_result($id, $user, $display, $password, $email, $token, $activationRequest, $passwordRequest, $active, $title, $user_parent, $signUp, $signIn);
	
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'user_name' => $user, 'display_name' => $display, 'password' => $password, 'email' => $email, 'activation_token' => $token, 'last_activation_request' => $activationRequest, 'lost_password_request' => $passwordRequest, 'active' => $active, 'title' => $title, 'user_parent' => $user_parent,'sign_up_stamp' => $signUp, 'last_sign_in_stamp' => $signIn);
	}
	$stmt->close();
	return ($row);
}

//Retrieve information for all users by Id
function fetchAllUsersById($id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		user_name,
		display_name,
		password,
		email,
		activation_token,
		last_activation_request,
		lost_password_request,
		active,
		title,
		user_parent,
		sign_up_stamp,
		last_sign_in_stamp
		FROM ".$db_table_prefix."users
		WHERE id = ?
		");
	$stmt->execute();
	$stmt->bind_result($id, $user, $display, $password, $email, $token, $activationRequest, $passwordRequest, $active, $title, $user_parent, $signUp, $signIn);
	
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'user_name' => $user, 'display_name' => $display, 'password' => $password, 'email' => $email, 'activation_token' => $token, 'last_activation_request' => $activationRequest, 'lost_password_request' => $passwordRequest, 'active' => $active, 'title' => $title, 'user_parent' => $user_parent,'sign_up_stamp' => $signUp, 'last_sign_in_stamp' => $signIn);
	}
	$stmt->close();
	return ($row);
}

//Update user biodata
function updateUserBiodata($user_id, $data){
	global $mysqli,$db_table_prefix;
	$sql = "UPDATE ".$db_table_prefix."user_biodata
		SET ";
	$count = 0;
	$datasize = sizeof($data);
	//debug($data);
	foreach($data as $index => $row){
		++$count;
		$sql .= $index . "='$row'"; 
		if($count < $datasize)
			$sql .= ',';
	}
	
	$sql .= " WHERE
	user_id = $user_id;";
	
	//debug($sql);
	//die();
	$stmt = $mysqli->prepare($sql);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}	

function getUserBiodata($id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		biodata.*
		FROM ".$db_table_prefix."user_biodata AS biodata 
		WHERE biodata.user_id = ? 
		LIMIT 1");
		$stmt->bind_param("i", $id);
	
	$stmt->execute();
	$stmt->bind_result($id, $user_id, $fullname, $ic_no, $date_birth, $contact, $address, $city, $state_id);
	while ($stmt->fetch()){
		$row = array('id' => $id, 'user_id' => $user_id, 'fullname' => $fullname, 'ic_no' => $ic_no, 'date_birth' => $date_birth, 'contact' => $contact, 'address' => $address, 'city' => $city, 'state_id' => $state_id);
	}
	$stmt->close();
	if(isset($row) && !empty($row))
		return ($row);
	
	return false;
}

//Retrieve complete user information by username, token or ID
function fetchUserDetails($username=NULL,$token=NULL, $id=NULL)
{
	if($username!=NULL) {
		$column = "user_name";
		$data = $username;
	}
	else if($token!=NULL) {
		$column = "activation_token";
		$data = $token;
	}
	else if($id!=NULL) {
		$column = "id";
		$data = $id;
	}
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		users.id,
		users.user_name,
		users.display_name,
		users.password,
		users.email,
		users.activation_token,
		users.last_activation_request,
		users.lost_password_request,
		users.active,
		users.title,
		users.user_parent,
		users.sign_up_stamp,
		users.last_sign_in_stamp,
		biodata.fullname 
		FROM ".$db_table_prefix."users AS users, ".$db_table_prefix."user_biodata AS biodata 
		WHERE users.`id` = biodata.`user_id` 
		AND users.`$column` = ? 
		LIMIT 1");
		$stmt->bind_param("s", $data);
	
	$stmt->execute();
	$stmt->bind_result($id, $user, $display, $password, $email, $token, $activationRequest, $passwordRequest, $active, $title, $user_parent, $signUp, $signIn, $fullname);
	//debug($stmt->fetch());
	while ($stmt->fetch()){
		$row = array('id' => $id, 'user_name' => $user, 'display_name' => $display, 'password' => $password, 'email' => $email, 'activation_token' => $token, 'last_activation_request' => $activationRequest, 'lost_password_request' => $passwordRequest, 'active' => $active, 'title' => $title, 'user_parent' => $user_parent, 'sign_up_stamp' => $signUp, 'last_sign_in_stamp' => $signIn, 'fullname' => $fullname);
	}
	$stmt->close();
	if(isset($row) && !empty($row))
		return ($row);
	
	return false;
}

//Toggle if lost password request flag on or off
function flagLostPasswordRequest($username,$value)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET lost_password_request = ?
		WHERE
		user_name = ?
		LIMIT 1
		");
	$stmt->bind_param("ss", $value, $username);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}

//Check if a user is logged in
function isUserLoggedIn()
{
	global $loggedInUser,$mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT 
		id,
		password
		FROM ".$db_table_prefix."users
		WHERE
		id = ?
		AND 
		password = ? 
		AND
		active = 1
		LIMIT 1");
	$stmt->bind_param("is", $loggedInUser->user_id, $loggedInUser->hash_pw);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if($loggedInUser == NULL)
	{
		return false;
	}
	else
	{
		if ($num_returns > 0)
		{
			return true;
		}
		else
		{
			destroySession("userCakeUser");
			return false;	
		}
	}
}

//Change a user from inactive to active
function setUserActive($token)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET active = 1
		WHERE
		activation_token = ?
		LIMIT 1");
	$stmt->bind_param("s", $token);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;
}

//Change a user's display name
function updateDisplayName($id, $display)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET display_name = ?
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("si", $display, $id);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}

//Update a user's email
function updateEmail($id, $email)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET 
		email = ?
		WHERE
		id = ?");
	$stmt->bind_param("si", $email, $id);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;
}

//Input new activation token, and update the time of the most recent activation request
function updateLastActivationRequest($new_activation_token,$username,$email)
{
	global $mysqli,$db_table_prefix; 	
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET activation_token = ?,
		last_activation_request = ?
		WHERE email = ?
		AND
		user_name = ?");
	$stmt->bind_param("ssss", $new_activation_token, time(), $email, $username);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;
}

//Generate a random password, and new token
function updatePasswordFromToken($pass,$token)
{
	global $mysqli,$db_table_prefix;
	$new_activation_token = generateActivationToken();
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET password = ?,
		activation_token = ?
		WHERE
		activation_token = ?");
	$stmt->bind_param("sss", $pass, $new_activation_token, $token);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;
}

//Update a user's title
function updateTitle($id, $title)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET 
		title = ?
		WHERE
		id = ?");
	$stmt->bind_param("si", $title, $id);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;	
}

//Check if a user ID exists in the DB
function userIdExists($id)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT active
		FROM ".$db_table_prefix."users
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Checks if a username exists in the DB
function usernameExists($username)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT active
		FROM ".$db_table_prefix."users
		WHERE
		user_name = ?
		LIMIT 1");
	$stmt->bind_param("s", $username);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Check if activation token exists in DB
function validateActivationToken($token,$lostpass=NULL)
{
	global $mysqli,$db_table_prefix;
	if($lostpass == NULL) 
	{	
		$stmt = $mysqli->prepare("SELECT active
			FROM ".$db_table_prefix."users
			WHERE active = 0
			AND
			activation_token = ?
			LIMIT 1");
	}
	else 
	{
		$stmt = $mysqli->prepare("SELECT active
			FROM ".$db_table_prefix."users
			WHERE active = 1
			AND
			activation_token = ?
			AND
			lost_password_request = 1 
			LIMIT 1");
	}
	$stmt->bind_param("s", $token);
	$stmt->execute();
	$stmt->store_result();
		$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//

//Functions that interact mainly with .checklist table
//------------------------------------------------------------------------------

function array_merge_recursive_distinct ( array &$array1, array &$array2 )
{
  $merged = $array1;

  foreach ( $array2 as $key => &$value )
  {
    if ( is_array ( $value ) && isset ( $merged [$key] ) && is_array ( $merged [$key] ) )
    {
      $merged [$key] = array_merge_recursive_distinct ( $merged [$key], $value );
    }
    else
    {
		if(!in_array($value, $merged))
			$merged[] = $value;
    }
  }

  return $merged;
}

function addChecklist($user_id, $activity){
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."checklist (
			user_id,
			activity
			)
			VALUES (
			?,
			?
			)");
	
	$stmt->bind_param("is", $user_id, $activity);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;	
}

function updateChecklist($activity_id, $check){
	global $mysqli,$db_table_prefix; 
	
	$tmp = fetchChecklist($activity_id);
	$tmp = json_decode($tmp['check'], true);
	if(!empty($tmp)){
		$final = array_merge_recursive_distinct($tmp, json_decode($check, true));
	} else {
		$final = json_decode($check, true);
	}
	
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."checklist
		SET `check` = ?
		WHERE
		`id` = ?");
	$stmt->bind_param("si", json_encode($final), $activity_id);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;
}

function fetchChecklist($activity_id){
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		`user_id`,
		`activity`,
		`check`
		FROM ".$db_table_prefix."checklist
		WHERE
		id = ? 
		LIMIT 1");
	$stmt->bind_param("i", $activity_id);
	$stmt->execute();
	$stmt->bind_result($user_id, $activity, $check);
	$row = false;
	while ($stmt->fetch()){
		$row = array('user_id' => $user_id, 'activity' => $activity, 'check' => $check);
	}
	$stmt->close();
	return ($row);
}

function fetchChecklistByUserId($user_id){
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT 
		`id`,
		`user_id`,
		`activity`,
		`check`
		FROM ".$db_table_prefix."checklist 
		WHERE 
		user_id = ? 
		");
	$stmt->bind_param("i", $user_id);
	$stmt->execute();
	$stmt->bind_result($id, $user_id2, $activity, $check);
	$row = false;
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'user_id' => $user_id2, 'activity' => $activity, 'check' => $check);
	}
	$stmt->close();
	return ($row);
}


//

//Functions that interact mainly with .user_data table
//------------------------------------------------------------------------------

function updateAssignMentor($user_id, $parent_id){
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE uc_users
		SET uc_users.user_parent = '".$parent_id."'
		WHERE uc_users.id = '".$user_id."'");
			
	$result = $stmt->execute();
	$stmt->close();	
	return $result;
}

function updateSkill($id = null, $data_content){
	global $mysqli,$db_table_prefix;
	if(!empty($id)){ //Update
		//debug($data_content);
		$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."user_skills
			SET 
			type = ? ,
			skill_name = ? 
			WHERE
			id = ?");
			
		$stmt->bind_param("ssi", $data_content['type'], $data_content['skill_name'], $id);
	} else { //not exist. add new record
		//debug($data_content);
		$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."user_skills (
			type,
			skill_name,
			user_id
			)
			VALUES (
			?,
			?,
			?
			)");
		$stmt->bind_param("ssi", $data_content['type'], $data_content['skill_name'], $data_content['user_id']);
	}
	
	$result = $stmt->execute();
	$stmt->close();	
	return $result;	
}

function getSkill($id = null, $user_id = null){
	global $mysqli,$db_table_prefix;
	$column = $cond = false;
	if($id != null){
		$column = 'id';
		$cond = $id;
	} else if($user_id != null) {
		$column = 'user_id';
		$cond = $user_id;
	}
	$stmt = $mysqli->prepare("SELECT 
		*
		FROM ".$db_table_prefix."user_skills
		WHERE
		".$column." = ?");
	$stmt->bind_param("i", $cond);
	$stmt->execute();
	$stmt->bind_result($id, $user_id, $type, $skill_name);
	$row = false;
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'user_id' => $user_id, 'type' => $type, 'skill_name' => $skill_name );
	}
	$stmt->close();
	return ($row);
}


function deleteSkill($id){
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_skills
			WHERE 
			id=?");
			
	$stmt->bind_param("i", $id);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;	
}

//Update Education
function updateEducation($id = null, $data_content){
	global $mysqli,$db_table_prefix;
	if(!empty($id)){ //Update
		//debug($data_content);
		$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."user_education
			SET 
			type = ? ,
			edu_place = ? ,
			year = ? ,
			course = ?
			WHERE
			id = ?");
			
		$stmt->bind_param("ssisi", $data_content['type'], $data_content['edu_place'], $data_content['year'], $data_content['course'], $id);
	} else { //not exist. add new record
		//debug($data_content);
		$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."user_education (
			type,
			edu_place,
			year,
			course,
			user_id
			)
			VALUES (
			?,
			?,
			?,
			?,
			?
			)");
		$stmt->bind_param("ssisi", $data_content['type'], $data_content['edu_place'], $data_content['year'], $data_content['course'], $data_content['user_id']);
	}
	
	$result = $stmt->execute();
	$stmt->close();	
	return $result;	
}

function getEducation($id = null, $user_id = null){
	global $mysqli,$db_table_prefix;
	$column = $cond = false;
	if($id != null){
		$column = 'id';
		$cond = $id;
	} else if($user_id != null) {
		$column = 'user_id';
		$cond = $user_id;
	}
	$stmt = $mysqli->prepare("SELECT 
		*
		FROM ".$db_table_prefix."user_education
		WHERE
		".$column." = ?");
	$stmt->bind_param("i", $cond);
	$stmt->execute();
	$stmt->bind_result($id, $type, $edu_place, $year, $course, $user_id);
	$row = false;
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'type' => $type,'edu_place' => $edu_place,'year' => $year,'course' => $course, 'user_id' => $user_id );
	}
	$stmt->close();
	return ($row);
}

function deleteEducation($id){
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_education
			WHERE 
			id=?");
			
	$stmt->bind_param("i", $id);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;	
}



//Update a user's title
function updateUserData($user_id, $type, $content)
{
	global $mysqli,$db_table_prefix;
	if(userDataExist($user_id, $type)){ //Update
		$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."user_data
			SET 
			content = ?
			WHERE
			user_id = ? 
			AND type = ? ");
	} else { //not exist. add new record
		$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."user_data (
			content,
			user_id,
			type
			)
			VALUES (
			?,
			?,
			?
			)");
	}
	
	$stmt->bind_param("sis", $content, $user_id, $type);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;	
}

//Retrieve information for a single permission level
function fetchUserData($user_id, $type)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		content
		FROM ".$db_table_prefix."user_data
		WHERE
		user_id = ? 
		AND type = ?
		LIMIT 1");
	$stmt->bind_param("is", $user_id, $type);
	$stmt->execute();
	$stmt->bind_result($content);
	$row = false;
	while ($stmt->fetch()){
		$row = array('content' => $content);
	}
	$stmt->close();
	return ($row);
}

//Checks if a username exists in the DB
function userDataExist($user_id, $type)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT id
		FROM ".$db_table_prefix."user_data
		WHERE
		user_id = ? 
		AND type = ? 
		LIMIT 1");
	$stmt->bind_param("is", $user_id, $type);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Functions that interact mainly with .permissions table
//------------------------------------------------------------------------------

//Create a permission level in DB
function createPermission($permission) {
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."permissions (
		name
		)
		VALUES (
		?
		)");
	$stmt->bind_param("s", $permission);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;
}

//Delete a permission level from the DB
function deletePermission($permission) {
	global $mysqli,$db_table_prefix,$errors; 
	$i = 0;
	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permissions 
		WHERE id = ?");
	$stmt2 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_permission_matches 
		WHERE permission_id = ?");
	$stmt3 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permission_page_matches 
		WHERE permission_id = ?");
	foreach($permission as $id){
		if ($id == 1){
			$errors[] = lang("CANNOT_DELETE_NEWUSERS");
		}
		elseif ($id == 2){
			$errors[] = lang("CANNOT_DELETE_ADMIN");
		}
		else{
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt2->bind_param("i", $id);
			$stmt2->execute();
			$stmt3->bind_param("i", $id);
			$stmt3->execute();
			$i++;
		}
	}
	$stmt->close();
	$stmt2->close();
	$stmt3->close();
	return $i;
}

//Retrieve information for all permission levels
function fetchAllPermissions()
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		name
		FROM ".$db_table_prefix."permissions");
	$stmt->execute();
	$stmt->bind_result($id, $name);
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'name' => $name);
	}
	$stmt->close();
	return ($row);
}

//Retrieve information for a single permission level
function fetchPermissionDetails($id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		name
		FROM ".$db_table_prefix."permissions
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->bind_result($id, $name);
	while ($stmt->fetch()){
		$row = array('id' => $id, 'name' => $name);
	}
	$stmt->close();
	return ($row);
}

//Check if a permission level ID exists in the DB
function permissionIdExists($id)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT id
		FROM ".$db_table_prefix."permissions
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Check if a permission level name exists in the DB
function permissionNameExists($permission)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT id
		FROM ".$db_table_prefix."permissions
		WHERE
		name = ?
		LIMIT 1");
	$stmt->bind_param("s", $permission);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Change a permission level's name
function updatePermissionName($id, $name)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."permissions
		SET name = ?
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("si", $name, $id);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;	
}

//Functions that interact mainly with .user_permission_matches table
//------------------------------------------------------------------------------

//Match permission level(s) with user(s)
function addPermission($permission, $user) {
	global $mysqli,$db_table_prefix; 
	$i = 0;
	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."user_permission_matches (
		permission_id,
		user_id
		)
		VALUES (
		?,
		?
		)");
	if (is_array($permission)){
		foreach($permission as $id){
			$stmt->bind_param("ii", $id, $user);
			$stmt->execute();
			$i++;
		}
	}
	elseif (is_array($user)){
		foreach($user as $id){
			$stmt->bind_param("ii", $permission, $id);
			$stmt->execute();
			$i++;
		}
	}
	else {
		$stmt->bind_param("ii", $permission, $user);
		$stmt->execute();
		$i++;
	}
	$stmt->close();
	return $i;
}

//Retrieve information for all user/permission level matches
function fetchAllMatches()
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		user_id,
		permission_id
		FROM ".$db_table_prefix."user_permission_matches");
	$stmt->execute();
	$stmt->bind_result($id, $user, $permission);
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'user_id' => $user, 'permission_id' => $permission);
	}
	$stmt->close();
	return ($row);	
}

//Retrieve list of permission levels a user has
function fetchUserPermissions($user_id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT
		id,
		permission_id
		FROM ".$db_table_prefix."user_permission_matches
		WHERE user_id = ?
		");
	$stmt->bind_param("i", $user_id);	
	$stmt->execute();
	$stmt->bind_result($id, $permission);
	while ($stmt->fetch()){
		$row[$permission] = array('id' => $id, 'permission_id' => $permission);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Retrieve list of users who have a permission level
function fetchPermissionUsers($permission_id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT id, user_id
		FROM ".$db_table_prefix."user_permission_matches
		WHERE permission_id = ?
		");
	$stmt->bind_param("i", $permission_id);	
	$stmt->execute();
	$stmt->bind_result($id, $user);
	while ($stmt->fetch()){
		$row[$user] = array('id' => $id, 'user_id' => $user);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Unmatch permission level(s) from user(s)
function removePermission($permission, $user) {
	global $mysqli,$db_table_prefix; 
	$i = 0;
	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_permission_matches 
		WHERE permission_id = ?
		AND user_id =?");
	if (is_array($permission)){
		foreach($permission as $id){
			$stmt->bind_param("ii", $id, $user);
			$stmt->execute();
			$i++;
		}
	}
	elseif (is_array($user)){
		foreach($user as $id){
			$stmt->bind_param("ii", $permission, $id);
			$stmt->execute();
			$i++;
		}
	}
	else {
		$stmt->bind_param("ii", $permission, $user);
		$stmt->execute();
		$i++;
	}
	$stmt->close();
	return $i;
}

//Functions that interact mainly with .configuration table
//------------------------------------------------------------------------------

//Update configuration table
function updateConfig($id, $value)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."configuration
		SET 
		value = ?
		WHERE
		id = ?");
	foreach ($id as $cfg){
		$stmt->bind_param("si", $value[$cfg], $cfg);
		$stmt->execute();
	}
	$stmt->close();	
}

function getConfig($name){
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		value
		FROM ".$db_table_prefix."configuration
		WHERE
		name = ?
		LIMIT 1");
	$stmt->bind_param("s", $name);
	$stmt->execute();
	$stmt->bind_result($value);
	while ($stmt->fetch()){
		$row = array('value' => $value);
	}
	$stmt->close();
	return ($row);
}

//Functions that interact mainly with .pages table
//------------------------------------------------------------------------------

//Add a page to the DB
function createPages($pages) {
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."pages (
		page
		)
		VALUES (
		?
		)");
	foreach($pages as $page){
		$stmt->bind_param("s", $page);
		$stmt->execute();
	}
	$stmt->close();
}

//Delete a page from the DB
function deletePages($pages) {
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."pages 
		WHERE id = ?");
	$stmt2 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permission_page_matches 
		WHERE page_id = ?");
	foreach($pages as $id){
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt2->bind_param("i", $id);
		$stmt2->execute();
	}
	$stmt->close();
	$stmt2->close();
}

//Fetch information on all pages
function fetchAllPages()
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		page,
		private
		FROM ".$db_table_prefix."pages");
	$stmt->execute();
	$stmt->bind_result($id, $page, $private);
	while ($stmt->fetch()){
		$row[$page] = array('id' => $id, 'page' => $page, 'private' => $private);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Fetch information for a specific page
function fetchPageDetails($id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		page,
		private
		FROM ".$db_table_prefix."pages
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->bind_result($id, $page, $private);
	while ($stmt->fetch()){
		$row = array('id' => $id, 'page' => $page, 'private' => $private);
	}
	$stmt->close();
	return ($row);
}

//Check if a page ID exists
function pageIdExists($id)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT private
		FROM ".$db_table_prefix."pages
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);	
	$stmt->execute();
	$stmt->store_result();	
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Toggle private/public setting of a page
function updatePrivate($id, $private)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."pages
		SET 
		private = ?
		WHERE
		id = ?");
	$stmt->bind_param("ii", $private, $id);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;	
}

//Functions that interact mainly with .permission_page_matches table
//------------------------------------------------------------------------------

//Match permission level(s) with page(s)
function addPage($page, $permission) {
	global $mysqli,$db_table_prefix; 
	$i = 0;
	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."permission_page_matches (
		permission_id,
		page_id
		)
		VALUES (
		?,
		?
		)");
	if (is_array($permission)){
		foreach($permission as $id){
			$stmt->bind_param("ii", $id, $page);
			$stmt->execute();
			$i++;
		}
	}
	elseif (is_array($page)){
		foreach($page as $id){
			$stmt->bind_param("ii", $permission, $id);
			$stmt->execute();
			$i++;
		}
	}
	else {
		$stmt->bind_param("ii", $permission, $page);
		$stmt->execute();
		$i++;
	}
	$stmt->close();
	return $i;
}

//Retrieve list of permission levels that can access a page
function fetchPagePermissions($page_id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT
		id,
		permission_id
		FROM ".$db_table_prefix."permission_page_matches
		WHERE page_id = ?
		");
	$stmt->bind_param("i", $page_id);	
	$stmt->execute();
	$stmt->bind_result($id, $permission);
	while ($stmt->fetch()){
		$row[$permission] = array('id' => $id, 'permission_id' => $permission);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Retrieve list of pages that a permission level can access
function fetchPermissionPages($permission_id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT
		id,
		page_id
		FROM ".$db_table_prefix."permission_page_matches
		WHERE permission_id = ?
		");
	$stmt->bind_param("i", $permission_id);	
	$stmt->execute();
	$stmt->bind_result($id, $page);
	while ($stmt->fetch()){
		$row[$page] = array('id' => $id, 'permission_id' => $page);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Unmatched permission and page
function removePage($page, $permission) {
	global $mysqli,$db_table_prefix; 
	$i = 0;
	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permission_page_matches 
		WHERE page_id = ?
		AND permission_id =?");
	if (is_array($page)){
		foreach($page as $id){
			$stmt->bind_param("ii", $id, $permission);
			$stmt->execute();
			$i++;
		}
	}
	elseif (is_array($permission)){
		foreach($permission as $id){
			$stmt->bind_param("ii", $page, $id);
			$stmt->execute();
			$i++;
		}
	}
	else {
		$stmt->bind_param("ii", $permission, $user);
		$stmt->execute();
		$i++;
	}
	$stmt->close();
	return $i;
}

//Check if a user has access to a page
function securePage($uri){
	
	//Separate document name from uri
	$tokens = explode('/', $uri);
	$page = $tokens[sizeof($tokens)-1];
	global $mysqli,$db_table_prefix,$loggedInUser;
	//retrieve page details
	$stmt = $mysqli->prepare("SELECT 
		id,
		page,
		private
		FROM ".$db_table_prefix."pages
		WHERE
		page = ?
		LIMIT 1");
	$stmt->bind_param("s", $page);
	$stmt->execute();
	$stmt->bind_result($id, $page, $private);
	while ($stmt->fetch()){
		$pageDetails = array('id' => $id, 'page' => $page, 'private' => $private);
	}
	$stmt->close();
	//If page does not exist in DB, allow access
	if (empty($pageDetails)){
		return true;
	}
	//If page is public, allow access
	elseif ($pageDetails['private'] == 0) {
		return true;	
	}
	//If user is not logged in, deny access
	elseif(!isUserLoggedIn()) 
	{
		header("Location: login.php");
		return false;
	}
	else {
		//Retrieve list of permission levels with access to page
		$stmt = $mysqli->prepare("SELECT
			permission_id
			FROM ".$db_table_prefix."permission_page_matches
			WHERE page_id = ?
			");
		$stmt->bind_param("i", $pageDetails['id']);	
		$stmt->execute();
		$stmt->bind_result($permission);
		while ($stmt->fetch()){
			$pagePermissions[] = $permission;
		}
		$stmt->close();
		//Check if user's permission levels allow access to page
		if ($loggedInUser->checkPermission($pagePermissions)){ 
			return true;
		}
		//Grant access if master user
		elseif ($loggedInUser->user_id == $master_account){
			return true;
		}
		else {
			header("Location: account.php");
			return false;	
		}
	}
}

//Functions that interact mainly with search listing
//------------------------------------------------------------------------------

function getAllList(){
	$cols = array(
		'states' => 'state', 
		'ipt' => 'ipt', 
		'zones' => 'zone'
	);
	global $mysqli,$db_table_prefix; 
	$row = false;
	foreach($cols as $index => $col ){
		
		$stmt = $mysqli->prepare("SELECT terbaik.id, terbaik.".$col." 
				FROM ".$db_table_prefix.$index." terbaik ORDER BY terbaik.".$col." ASC ");
		$stmt->execute();
		$stmt->bind_result($id, $value);
		
		while ($stmt->fetch()){
			$row[$index][$id] = $value;
		}
	}
	$stmt->close();
	return ($row);
}

function selectStateByZone($zone_id = ''){
	global $mysqli,$db_table_prefix; 
	$sql = "SELECT 
			`id`,
			`state`
			FROM ".$db_table_prefix."states as state";
	if(!empty($zone_id)){
		$sql.="	WHERE state.zon_id=? ";
	}
	$sql .= " ORDER BY state.state ASC";
	$stmt = $mysqli->prepare($sql);
	if(!empty($zone_id)){ $stmt->bind_param("i", $zone_id); }
	$stmt->execute();
	$stmt->bind_result($id, $state);
	$row = false;
	while ($stmt->fetch()){
		$row[$id] = $state;
	}
	$stmt->close();
	return ($row);
}

function selectIptByState($state_id){
	global $mysqli,$db_table_prefix; 
	$sql = "SELECT 
			`id`,
			`ipt`
			FROM ".$db_table_prefix."ipt as ipt";
	if(!empty($state_id)){
		$sql.="	WHERE ipt.state_id=? ";
	}
	$sql .= " ORDER BY ipt.ipt ASC";
	$stmt = $mysqli->prepare($sql);
	if(!empty($state_id)){ $stmt->bind_param("i", $state_id); }
	$stmt->execute();
	$stmt->bind_result($id, $ipt);
	$row = false;
	while ($stmt->fetch()){
		$row[$id] = $ipt;
	}
	$stmt->close();
	return ($row);
}

function getUserByPlace($ipt_id = false, $state_id = false, $zone_id = false){
	global $mysqli,$db_table_prefix; 
	$sql = "SELECT biodata.fullname, biodata.contact, users.email, ipt.ipt, state.state, MAX(edu.year), users.id, users.user_parent
		FROM uc_users users, uc_user_biodata biodata, uc_states state, uc_user_education edu, uc_ipt ipt
		WHERE biodata.user_id = users.id AND biodata.state_id = state.id AND edu.user_id = users.id AND edu.edu_place = ipt.id 
		AND edu.`type` = 'Higher'" ;
	if(!empty($ipt_id)){
		$sql .= " AND ipt.id=".$ipt_id;
	} else if(!empty($state_id)){
		$sql .= " AND ipt.state_id=".$state_id;
	} else if(!empty($zone_id)){
		$states = selectStateByZone($zone_id);
		$states_id = '';
		foreach($states as $index => $state){
			$states_id .= ','.$index;
		}
		$states_id = trim($states_id, ",");
		$sql .= " AND ipt.state_id IN(".$states_id.")";
	}
	$sql .= " AND edu.`year` = (SELECT max(edu2.`year`) FROM uc_user_education edu2 WHERE edu2.user_id = edu.user_id AND edu2.`type` = 'Higher' ) GROUP BY edu.user_id";
	$stmt = $mysqli->prepare($sql);
	$stmt->execute();
	$stmt->bind_result($fullname, $contact, $email, $ipt, $state, $year, $user_id, $parent_id);
	$row = false;
	while ($stmt->fetch()){
		$row[] = array('fullname' => $fullname, 'contact' => $contact, 'email' => $email, 'ipt' => $ipt, 'state' => $state, 'user_id' => $user_id, 'parent_id' => $parent_id);
	}
	$stmt->close();
	return ($row);
}

function getAllIpt(){
	global $mysqli,$db_table_prefix; 
	$sql = "SELECT ipt.id, ipt.ipt FROM ".$db_table_prefix."ipt ipt";
	$stmt = $mysqli->prepare($sql);
	$stmt->execute();
	$stmt->bind_result($id, $ipt);
	$row = false;
	while ($stmt->fetch()){
		$row[$id] = $ipt;
	}
	$stmt->close();
	return ($row);
}

function getIptById($id){
	global $mysqli,$db_table_prefix; 
	$sql = "SELECT ipt.ipt FROM ".$db_table_prefix."ipt ipt WHERE ipt.id=? LIMIT 1";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->bind_result($ipt);
	$row = false;
	while ($stmt->fetch()){
		$row = array('ipt' => $ipt);
	}
	$stmt->close();
	return ($row);
}



function debug($text){
	echo '<pre>';
	var_dump($text);
	echo '</pre>';
}

?>
