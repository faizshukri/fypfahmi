<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

$query3 = $_SERVER['PHP_SELF'];
$path = pathinfo( $query3 );
$current1 = $path['basename'];

$site_url = getConfig('website_url');
$site_url = $site_url['value'];

echo "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html lang='en' xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta name='viewport' content='width=device-width, initial-scale=1.0' />

<title>".$websiteName."</title>
<link href='".$template."' rel='stylesheet' type='text/css' />
<link href='".$site_url."/css/jquery-ui.min.css' rel='stylesheet' type='text/css' />

<script src='js/jquery-1.9.1.min.js'></script>
<script src='".$site_url."/js/jquery-ui.min.js' type='text/javascript'></script>
<script src='models/funcs.js' type='text/javascript'></script>
";

if($current1 != "login.php")
{
echo "
<style>body{padding-top:120px;background:url('logo.png') no-repeat,url('test.jpg') repeat-x, url('bg.png') repeat-x;}</style>
";}
else{
echo"
<style>body{padding-top:120px;background:url('home.png') no-repeat top center, url('bg.png') repeat-x;}</style>
";}

echo "</head>
<body>
";
?>
<style>
.span9 {
  background-color: white;
  border: 1px solid #ddd;
  padding: 20px 10px;
}
</style>