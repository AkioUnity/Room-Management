<?php echo form_open_multipart('tenants/change_id_image/' . $param2, array('id' => 'change_tenant_id_image', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label>Existing Front Image</label>
	<br>
	<?php if (html_escape($this->db->get_where('tenant', array('tenant_id' => $param2))->row()->id_front_image_link)) : ?>
		<img src="<?php echo base_url(); ?>uploads/tenants/<?php echo html_escape($this->db->get_where('tenant', array('tenant_id' => $param2))->row()->id_front_image_link); ?>" alt="Image" class="img-thumbnail thumb128">
	<?php else : ?>
		<p>No Preview Available.</p>
	<?php endif; ?>
</div>
<div class="form-group">
	<label>Existing Back Image</label>
	<br>
	<?php if (html_escape($this->db->get_where('tenant', array('tenant_id' => $param2))->row()->id_back_image_link)) : ?>
		<img src="<?php echo base_url(); ?>uploads/tenants/<?php echo html_escape($this->db->get_where('tenant', array('tenant_id' => $param2))->row()->id_back_image_link); ?>" alt="Image" class="img-thumbnail thumb128">
	<?php else : ?>
		<p>No Preview Available.</p>
	<?php endif; ?>
</div>

<div class="form-group">
	<label>For New Image</label>
	<br>
	<span class="btn btn-primary fileinput-button">
		<i class="fa fa-plus"></i>
		<span>Add file front</span>
		<input class="form-control" type="file" name="id_front_image_link">
	</span>
	<br><br>
	<span class="btn btn-primary fileinput-button">
		<i class="fa fa-plus"></i>
		<span>Add file back</span>
		<input class="form-control" type="file" name="id_back_image_link">
	</span>
</div>

<hr>

<button type="submit" class="mb-sm btn btn-primary">Change</button>
<?php echo form_close(); ?>

<script>
	$('#change_tenant_id_image').parsley();
</script>