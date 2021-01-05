<?php echo form_open('tickets/update/' . $param2, array('id' => 'reply_to_ticket', 'class' => 'form-horizontal', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label>Details</label>
	<textarea rows="10" style="resize: none" type="text" name="content" placeholder="Enter details of the reply" class="form-control"></textarea>
</div>

<button type="submit" class="mb-sm btn btn-primary">Submit</button>
<?php echo form_close(); ?>

<script>
	$('#reply_to_ticket').parsley();
</script>