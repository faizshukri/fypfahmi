<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}


$lists = getAllList();

//debug($perm_list);
require_once("models/header.php"); 

?>
<link href="css/jquery.fancybox.css" rel="stylesheet">
<script src="js/jquery.fancybox.pack.js" type="text/javascript"></script>
<div class="container-fluid">
  <div class="row-fluid">
	<?php include("left-nav.php"); ?>

	<div class="span9">
		<?php echo resultBlock($errors,$successes); ?>

<div id='regbox'>
<form name='newUser' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post' class="form-inline">
<h3>Search Listing</h3>
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
<table class="table" id="result">
	<thead>
		<tr>
			<th>Name</th>
			<th>Phone No.</th>
			<th>Email</th>
			<th>IPT</th>
			<th>Home Address</th>
			<?php if($loggedInUser->checkPermission(array(2))){ ?>
				<th>Circle</th>
			<?php } ?>
		</tr>
	</thead>
	<tbody></tbody>
</table>


</form>
</div>

</div>
<div id='bottom'></div>
</div>
</div>
<a style="display: none;" id="inline" href="#fancydata">Trigger Fancy</a>
<div style="display:none"><div id="fancydata"></div></div>

<script type="text/javascript">
	jQuery(document).ready(function($){
		$('.nav-left li').removeClass('active');
		$('.nav-left .searchlist').addClass('active');
		
		$('#btnReset').click(function(){
			$('#zones').val('');
			$('#states').val('');
			$('#ipt').val('');
			changeZone();
			changeListStart();
			return false;
		});
		
		changeZone();
		changeState();
		changeIpt();
		changeListStart();
		$("a#inline").fancybox({
			beforeClose: function(){
				parent.location.reload(true);
			}
		});
		
	});
	
	function changeZone(){
		$('#zones').change(function(){
			$.ajax({
				url: 'searchlist_ajax.php',
				data: { zone_id: $('#zones').val() },
				type: 'GET'
			}).done(function(data){
				var thisparent = $('#states').parent();
				$('#states').remove();
				$('#ipt').remove();
				thisparent.find('#zones').after(' '+data);
				changeState();
				changeIpt();
				changeListStart();
			});
		});
	}
	
	function changeState(){
		$('#states').change(function(){
			$.ajax({
				url: 'searchlist_ajax.php',
				data: { state_id: $('#states').val(), zone_id: $('#zones').val() },
				type: 'GET'
			}).done(function(data){
				var thisparent = $('#states').parent();
				$('#ipt').remove();
				thisparent.find('#states').after(' '+data);
				changeIpt();
				changeListStart();
			});
		});
	}
	
	function changeIpt(){
		$('#ipt').change(function(){
			$.ajax({
				url: 'searchlist_ajax.php',
				data: { state_id: $('#states').val(), zone_id: $('#zones').val() },
				type: 'GET'
			}).done(function(data){
				changeListStart();
			});
		});
	}
	
	function changeListStart(){
		$.ajax({
			url: 'searchlist_ajax_table.php',
			data: { state_id: $('#states').val(), zone_id: $('#zones').val(), ipt_id: $('#ipt').val() },
			type: 'GET'
		}).done(function(data2){
			$('table#result tbody').html(data2);
		});
	}
	
	function showMentor(user_id){
	
		$.ajax({
			url: 'searchlist_ajax_mentor.php',
			data: {user_id: user_id},
			type: 'get'
		}).done(function(data){
			//console.log(data);
			var html = '<div class="alert alert-success result" style="display: none;"></div>'+
			 '<form class="form-horizontal">'+
			  '<div class="control-group">'+
				'<label class="control-label" for="assignMentor" style="width: 100px;">Assign Mentor</label>'+
				'<div class="controls" style="margin-left: 120px;">'+
				  data+
				'</div>'+
			  '</div>'+
			  '<div class="control-group">'+
				'<div class="controls" style="margin-left: 120px;">'+
				  '<a href="#" class="submit btn btn-info">Save</a>'+
				'</div>'+
			  '</div>'+
			'</form>';
		
			$('#fancydata').html(html);
			$('a#inline').click();
			
			$('#fancydata').find('.submit').click(function(){
				var curSelect = $('#fancydata').find('select');
				$.ajax({
					url: 'searchlist_ajax_save_mentor.php',
					data: {user_id: user_id, parent_id: curSelect.val()},
					type: 'get'
				}).done(function(result){
					if(result == 'true')
						$('.result').text('Successfully saved.').show();
					else
						$('.result').text('Theres a problem to save your data.').show();
						
					$.fancybox.update();
				});
			});
		});
	
		
	}
	
</script>
<?php require_once('models/footer.php'); ?>