<?php echo form_open('profession_settings/update/' . $param2, array('id' => 'edit_profession', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label>Name *</label>
	<input value="<?php echo html_escape($this->db->get_where('profession', array('profession_id' => $param2))->row()->name); ?>" type="text" name="name" placeholder="Enter profession name" class="form-control" data-parsley-required="true">
</div>

<button type="submit" class="mb-sm btn btn-primary">Update</button>
<?php echo form_close(); ?>

<script>
	$('#edit_profession').parsley();
</script>