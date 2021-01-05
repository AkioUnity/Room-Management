<?php echo form_open('staff/update/' . $param2, array('id' => 'edit_staff', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$staff_details = $this->db->get_where('staff', array('staff_id' => $param2))->result_array();
foreach ($staff_details as $row) :
?>
	<div class="form-group">
		<label>Name *</label>
		<input value="<?php echo html_escape($row['name']); ?>" type="text" name="name" placeholder="Enter name" class="form-control" data-parsley-required="true">
	</div>
	<div class="form-group">
		<label>Role</label>
		<input value="<?php echo html_escape($row['role']); ?>" type="text" name="role" placeholder="Enter role" class="form-control">
	</div>
	<div class="form-group">
		<label>Mobile Number *</label>
		<input value="<?php echo html_escape($row['mobile_number']); ?>" type="text" name="mobile_number" placeholder="Enter mobile number" class="form-control" data-parsley-required="true">
	</div>
	<div class="form-group">
		<label>Email (For staff login)</label>
		<?php
		if ($this->db->get_where('user', array('user_type' => 2, 'person_id' => $row['staff_id']))->num_rows() > 0) {
			$staff_email = $this->db->get_where('user', array('user_type' => 2, 'person_id' => $row['staff_id']))->row()->email;
		} else {
			$staff_email = '';
		}
		?>
		<input value="<?php echo $staff_email ? html_escape($staff_email) : ''; ?>" type="email" name="email" placeholder="Enter email" class="form-control">
	</div>
	<?php if (!$staff_email) : ?>
		<div class="form-group">
			<label>Password (For staff login)</label>
			<input type="text" name="password" id="password-indicator-visible" class="form-control m-b-5">
			<div id="passwordStrengthDiv2" class="is0 m-t-5"></div>
		</div>
		<div class="note note-secondary note-purple m-b-15">
			<span>Default password for login is: 123456</span>
		</div>
	<?php endif; ?>
	<div class="form-group">
		<label>Status *</label>
		<div>
			<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="status">
				<option value="">Select status</option>
				<option <?php if ($row['status'] == 0) echo 'selected'; ?> value="0">Inactive</option>
				<option <?php if ($row['status'] == 1) echo 'selected'; ?> value="1">Active</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label>Remarks</label>
		<textarea style="resize: none" type="text" name="remarks" placeholder="Enter remarks" class="form-control"><?php echo html_escape($row['remarks']); ?></textarea>
	</div>

	<button type="submit" class="mb-sm btn btn-primary">Update</button>
<?php endforeach; ?>
<?php echo form_close(); ?>

<script>
	$('#edit_staff').parsley();
	FormPlugins.init();

	$('select:not(.normal)').each(function() {
		$(this).select2({
			dropdownParent: $(this).parent()
		});
	});
</script>