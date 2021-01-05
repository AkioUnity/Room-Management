<?php echo form_open_multipart('utility_bills/change_image/' . $param2, array('id' => 'change_utility_bill_image', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label>Existing Image</label>
	<br>
	<?php if (html_escape($this->db->get_where('utility_bill', array('utility_bill_id' => $param2))->row()->image_link)) : ?>
		<img src="<?php echo base_url(); ?>uploads/bills/<?php echo html_escape($this->db->get_where('utility_bill', array('utility_bill_id' => $param2))->row()->image_link); ?>" alt="Image" class="img-thumbnail thumb128">
	<?php else : ?>
		<p>No Preview Available.</p>
	<?php endif; ?>
</div>

<div class="form-group">
	<label>For New Image *</label>
	<br>
	<span class="btn btn-primary fileinput-button">
		<i class="fa fa-plus"></i>
		<span>Add file</span>
		<input class="form-control" type="file" name="image_link" data-parsley-required="true">
	</span>
</div>

<hr>

<button type="submit" class="mb-sm btn btn-primary">Change</button>
<?php echo form_close(); ?>

<script>
	$('#change_utility_bill_image').parsley();
</script>