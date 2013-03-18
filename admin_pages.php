<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$pages = getPageFiles(); //Retrieve list of pages in root usercake folder
$dbpages = fetchAllPages(); //Retrieve list of pages in pages table
$creations = array();
$deletions = array();

//Check if any pages exist which are not in DB
foreach ($pages as $page){
	if(!isset($dbpages[$page])){
		$creations[] = $page;	
	}
}

//Enter new pages in DB if found
if (count($creations) > 0) {
	createPages($creations)	;
}

if (count($dbpages) > 0){
	//Check if DB contains pages that don't exist
	foreach ($dbpages as $page){
		if(!isset($pages[$page['page']])){
			$deletions[] = $page['id'];	
		}
	}
}

//Delete pages from DB if not found
if (count($deletions) > 0) {
	deletePages($deletions);
}

//Update DB pages
$dbpages = fetchAllPages();

require_once("models/header.php"); ?>

<body>
<div class="container-fluid">
  <div class="row-fluid">
	<?php include("left-nav.php"); ?>

	<div class="span6">

<table class='table table-condensed table-striped table-hover'>
<tr><th>Id</th><th>Page</th><th>Access</th></tr>

<?php
//Display list of pages
foreach ($dbpages as $page){ ?>
	<tr>
	<td>
	<?php echo $page['id']; ?>
	</td>
	<td>
	<a href ='admin_page.php?id=<?php echo $page['id']; ?>'><?php echo $page['page']; ?></a>
	</td>
	<td>
	
	<?php
	//Show public/private setting of page
	if($page['private'] == 0){
		echo "Public";
	}
	else {
		echo "Private";	
	} ?>

	</td>
	</tr>
<?php } ?>

</table>
</div>
<div id='bottom'></div>
</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('.nav-left li').removeClass('active');
		$('.nav-left .admin-page').addClass('active');
	});
</script>
</body>
</html>
