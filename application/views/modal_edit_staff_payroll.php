<?php echo form_open('staff_payroll/update/' . $param2, array('id' => 'edit_staff_salary', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$staff_salary_details = $this->db->get_where('staff_salary', array('staff_salary_id' => $param2))->result_array();
foreach ($staff_salary_details as $row) :
?>
	<div class="form-group">
		<label>Name *</label>
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="staff_id">
			<option value="">Select Staff</option>
			<?php
			$staff = $this->db->get('staff')->result_array();
			foreach ($staff as $row2) :
			?>
				<option <?php if ($row2['staff_id'] == $row['staff_id']) echo 'selected'; ?> value="<?php echo html_escape($row2['staff_id']); ?>"><?php echo html_escape($row2['name']); ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="form-group">
		<label>Year *</label>
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="year">
			<option value="">Select Year</option>
			<option <?php if ($row['year'] == date('Y') - 4) echo 'selected'; ?> value="<?php echo date('Y') - 4; ?>"><?php echo date('Y') - 4; ?></option>
			<option <?php if ($row['year'] == date('Y') - 3) echo 'selected'; ?> value="<?php echo date('Y') - 3; ?>"><?php echo date('Y') - 3; ?></option>
			<option <?php if ($row['year'] == date('Y') - 2) echo 'selected'; ?> value="<?php echo date('Y') - 2; ?>"><?php echo date('Y') - 2; ?></option>
			<option <?php if ($row['year'] == date('Y') - 1) echo 'selected'; ?> value="<?php echo date('Y') - 1; ?>"><?php echo date('Y') - 1; ?></option>
			<option <?php if ($row['year'] == date('Y')) echo 'selected'; ?> value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
			<option <?php if ($row['year'] == date('Y') + 1) echo 'selected'; ?> value="<?php echo date('Y') + 1; ?>"><?php echo date('Y') + 1; ?></option>
			<option <?php if ($row['year'] == date('Y') + 2) echo 'selected'; ?> value="<?php echo date('Y') + 2; ?>"><?php echo date('Y') + 2; ?></option>
			<option <?php if ($row['year'] == date('Y') + 3) echo 'selected'; ?> value="<?php echo date('Y') + 3; ?>"><?php echo date('Y') + 3; ?></option>
			<option <?php if ($row['year'] == date('Y') + 4) echo 'selected'; ?> value="<?php echo date('Y') + 4; ?>"><?php echo date('Y') + 4; ?></option>
		</select>
	</div>
	<div class="form-group">
		<label>Month *</label>
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="month">
			<option value="">Select Month</option>
			<option <?php if ($row['month'] == 'January') echo 'selected'; ?> value="January">January</option>
			<option <?php if ($row['month'] == 'February') echo 'selected'; ?> value="February">February</option>
			<option <?php if ($row['month'] == 'March') echo 'selected'; ?> value="March">March</option>
			<option <?php if ($row['month'] == 'April') echo 'selected'; ?> value="April">April</option>
			<option <?php if ($row['month'] == 'May') echo 'selected'; ?> value="May">May</option>
			<option <?php if ($row['month'] == 'June') echo 'selected'; ?> value="June">June</option>
			<option <?php if ($row['month'] == 'July') echo 'selected'; ?> value="July">July</option>
			<option <?php if ($row['month'] == 'August') echo 'selected'; ?> value="August">August</option>
			<option <?php if ($row['month'] == 'September') echo 'selected'; ?> value="September">September</option>
			<option <?php if ($row['month'] == 'October') echo 'selected'; ?> value="October">October</option>
			<option <?php if ($row['month'] == 'November') echo 'selected'; ?> value="November">November</option>
			<option <?php if ($row['month'] == 'December') echo 'selected'; ?> value="December">December</option>
		</select>
	</div>
	<div class="form-group">
		<label>Amount (<?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>) *</label>
		<input value="<?php echo html_escape($row['amount']); ?>" type="text" name="amount" placeholder="Enter amount" class="form-control" data-parsley-required="true" data-parsley-type="number" min="0">
	</div>
	<div class="form-group">
		<label>Status *</label>
		<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="status">
			<option value="">Select Status</option>
			<option <?php if ($row['status'] == 0) echo 'selected' ?> value="0">Due</option>
			<option <?php if ($row['status'] == 1) echo 'selected' ?> value="1">Paid</option>
		</select>
	</div>

	<button type="submit" class="mb-sm btn btn-primary">Update</button>
<?php endforeach; ?>
<?php echo form_close(); ?>

<script>
	$('#edit_staff_salary').parsley();
	FormPlugins.init();

	$('select:not(.normal)').each(function() {
		$(this).select2({
			dropdownParent: $(this).parent()
		});
	});
</script>