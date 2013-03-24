<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

//Database Information
$db_host = "faizshukridb.cfrejxq6klx3.ap-southeast-1.rds.amazonaws.com"; //Host address (most likely localhost)
$db_name = "fypfahmi"; //Name of Database 
$db_user = "faizshukri"; //Name of database user
$db_pass = "terbaikdunia"; //Password for database user
$db_table_prefix = "uc_";

GLOBAL $errors;
GLOBAL $successes;

$errors = array();
$successes = array();

/* Create a new mysqli object with database connection parameters */
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
GLOBAL $mysqli;

if(mysqli_connect_errno()) {
	echo "Connection Failed: " . mysqli_connect_errno();
	exit();
}

//Direct to install directory, if it exists
if(is_dir("install/"))
{
	header("Location: install/");
	die();

}

?>
