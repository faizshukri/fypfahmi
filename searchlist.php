<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}


$lists = getAllList();

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
<form name='newUser' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post' class="form-inline">
<div id="selectContainer">
<select class="init" id="zones">
	<option value="">Please select Zone</option>
	<?php foreach($lists['zones'] as $index => $zone){ ?>
	<option value="<?php echo $index; ?>"><?php echo $zone; ?></option>
	<?php } ?>
</select>

<select class="init" id="states">
	<option value="">Please select State</option>
	<?php foreach($lists['states'] as $index => $state){ ?>
	<option value="<?php echo $index; ?>"><?php echo $state; ?></option>
	<?php } ?>
</select>

<select class="init" id="ipt">
	<option value="">Please select IPT</option>
	<?php foreach($lists['ipt'] as $index => $ipt){ ?>
	<option value="<?php echo $index; ?>"><?php echo $ipt; ?></option>
	<?php } ?>
</select>
<button class="btn btn-primary" id="btnReset">Reset</button>
</div>



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
		$('.nav-left .searchlist').addClass('active');
		
		$('#zones').change(function(){
			changeZone();
		});
		
		$('#btnReset').click(function(){
			$('#zones').val('');
			changeZone();
			return false;
		});
		
		changeState();
		changeListTable();
		
		
	});
	
	function changeZone(){
		
		$.ajax({
			url: 'searchlist_ajax.php',
			data: { zone_id: $('#zones').val() },
			type: 'GET'
		}).done(function(data){
			console.log(data);
			var thisparent = $('#states').parent();
			$('#states').remove();
			$('#ipt').remove();
			thisparent.find('#zones').after(' '+data);
			changeState();
			changeListTable();
		});
	}
	
	function changeState(){
		$('#states').change(function(){
			$.ajax({
				url: 'searchlist_ajax.php',
				data: { state_id: $('#states').val(), zone_id: $('#zones').val() },
				type: 'GET'
			}).done(function(data){
				console.log(data);
				var thisparent = $('#states').parent();
				$('#ipt').remove();
				thisparent.find('#states').after(' '+data);
				changeListTable();
			});
		});
	}
	
	function changeListTable(){
		$('#selectContainer select').each(function(){
			$(this).change(function(){
			
				$.ajax({
					url: 'searchlist_ajax_table.php',
					data: { state_id: $('#states').val(), zone_id: $('#zones').val(), ipt_id: $('#ipt').val() },
					type: 'GET'
				}).done(function(data){
					console.log(data);
				});
				
			});
		});
		
	}
	
</script>
</body>
</html>