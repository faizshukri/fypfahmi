<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $_GET['id'];

//Check if selected user exists
if(!userIdExists($userId)){
	header("Location: admin_users.php"); die();
}

$biodata = fetchUserData($userId, 'user_biodata');
$education = fetchUserData($userId, 'user_education');
$skill = fetchUserData($userId, 'user_skills');


$biodata = json_decode($biodata['content'],true);
$education = json_decode($education['content'],true);
$skill = json_decode($skill['content'],true);

//debug($education);
$userdetails = fetchUserDetails(NULL, NULL, $userId); //Fetch user details

require_once("models/header.php"); 

?>


<div class="container-fluid">
  <div class="row-fluid">
	<?php include("left-nav.php"); ?>

	<div class="span9">
		<?php echo resultBlock($errors,$successes); ?>
		
<div id='regbox'>
<table>
<tr style="vertical-align: top;">
<td style="padding-right: 50px;">
	<h1>Biodata</h1>	
	<?php 
		if($biodata){
		foreach($biodata as $index => $bio){ ?>
		<div><strong><?php echo $index; ?>: </strong><br /><?php echo nl2br($bio); ?></div><br />
	<?php }
	} else { ?>
		<div>Mentee didn't fill biodata.</div>
	<?php } ?>
</td>
<td style="padding-right: 50px;">
	<h1>Education</h1>	
	<?php 
		if($education){
		foreach($education as $index => $bio){ ?>
			
			<h3><?php echo $index; ?></h3>
			<?php 
				if($index != 'high'){
				foreach($bio as $school => $yearend){ ?>
				<div><strong>School: </strong><br /><?php echo $school?> (end => '<?php echo $yearend; ?>')</div>
			<?php } 
			} else {
				foreach($bio as $college => $detail){ ?>
					<div><strong>College / University: </strong><br /><?php echo $college?> (course=> '<?php echo $detail['course']; ?>', end => '<?php echo $detail['year']; ?>')</div>
				<?php 
				}
			}
			echo '<p>&nbsp;</p>';
				
		}
	} else { ?>
		<div>Mentee didn't fill education.</div>
	<?php } ?>
</td>
<td>
	<h1>Skills</h1>
	<?php if($skill){ ?>
	<?php foreach($skill as $type => $skill_list) { ?>
		<h3><?php echo $type;?></h3>
		<ul>
		<?php foreach($skill_list as $betul){ ?>
			<li><?php echo $betul; ?></li>
		<?php } ?>
		</ul>
	
	<?php } 
	} else { ?>
		<div>Mentee didn't fill skill.</div>
	<?php } ?>
</td>
</tr>
</table>
	</div>
  </div>
  <div id='bottom'></div>
</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('.nav-left li').removeClass('active');
		$('.nav-left .mentee').addClass('active');
	});
</script>
<?php require_once('models/footer.php'); ?>