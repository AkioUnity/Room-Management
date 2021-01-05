<?php echo form_open('id_type_settings/update/' . $param2, array('id' => 'edit_id_type', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label>Name *</label>
	<input value="<?php echo html_escape($this->db->get_where('id_type', array('id_type_id' => $param2))->row()->name); ?>" type="text" name="name" placeholder="Enter ID type name" class="form-control" data-parsley-required="true">
</div>

<button type="submit" class="mb-sm btn btn-primary">Update</button>
<?php echo form_close(); ?>

<script>
	$('#edit_id_type').parsley();
</script>