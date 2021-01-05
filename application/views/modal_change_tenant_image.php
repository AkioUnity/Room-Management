<?php echo form_open_multipart('tenants/change_image/' . $param2, array('id' => 'change_tenant_image', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label>Existing Image</label>
	<br>
	<?php if (html_escape($this->db->get_where('tenant', array('tenant_id' => $param2))->row()->image_link)) : ?>
		<img src="<?php echo base_url(); ?>uploads/tenants/<?php echo html_escape($this->db->get_where('tenant', array('tenant_id' => $param2))->row()->image_link); ?>" alt="Image" class="img-thumbnail thumb128">
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
	$('#change_tenant_image').parsley();
</script>