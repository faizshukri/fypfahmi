<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$mentee_list = fetchAllUsersByMentor($loggedInUser->user_id);
//debug($mentee_list);

require_once("models/header.php"); 

?>

<body>
<link href="css/jquery.fancybox.css" rel="stylesheet">
<script src="js/jquery.fancybox.pack.js" type="text/javascript"></script>
<div class="container-fluid">
  <div class="row-fluid">
	<?php include("left-nav.php"); ?>

	<div class="span9">
		<?php echo resultBlock($errors,$successes); ?>

<div id='regbox'>

</div>
</div>
<div id='bottom'></div>
</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('.nav-left li').removeClass('active');
		$('.nav-left .monitor').addClass('active');
	});
</script>
</body>
</html>