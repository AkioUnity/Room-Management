<?php echo form_open('tenants/update/' . $param2, array('id' => 'edit_tenant', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<?php
$tenant_info = $this->db->get_where('tenant', array('tenant_id' => $param2))->result_array();
foreach ($tenant_info as $tenant) :
?>
	<div class="form-group">
		<label>Name *</label>
		<input value="<?php echo html_escape($tenant['name']); ?>" type="text" name="name" placeholder="Enter name" class="form-control" data-parsley-required="true">
	</div>
	<div class="form-group">
		<label>Mobile *</label>
		<input value="<?php echo html_escape($tenant['mobile_number']); ?>" type="text" name="mobile_number" placeholder="Enter mobile number" class="form-control" data-parsley-required="true">
	</div>
	<div class="form-group">
		<label>Email (For tenant login)</label>
		<?php
		if ($this->db->get_where('user', array('user_type' => 3, 'person_id' => $tenant['tenant_id']))->num_rows() > 0) {
			$tenant_email = $this->db->get_where('user', array('user_type' => 3, 'person_id' => $tenant['tenant_id']))->row()->email;
		} else {
			$tenant_email = '';
		}
		?>
		<input value="<?php echo html_escape($tenant['email']); ?>" type="email" name="email" placeholder="Enter email" class="form-control">
	</div>
	<?php if (!$tenant_email) : ?>
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
		<label>ID Type</label>
		<div>
			<select style="width: 100%" class="form-control default-select2" name="id_type_id">
				<option value="">Select ID Type</option>
				<?php
				$id_types = $this->db->get('id_type')->result_array();
				foreach ($id_types as $id_type) :
				?>
					<option <?php if ($id_type['id_type_id'] == $tenant['id_type_id']) echo 'selected'; ?> value="<?php echo html_escape($id_type['id_type_id']); ?>"><?php echo html_escape($id_type['name']); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label>ID Number</label>
		<input value="<?php echo html_escape($tenant['id_number']); ?>" name="id_number" type="text" placeholder="Enter ID number" class="form-control">
	</div>
	<div class="form-group">
		<label>Lease period</label>
		<div class="input-group input-daterange">
			<input type="text" class="form-control" value="<?php echo $tenant['lease_start'] ? date('m/d/Y', $tenant['lease_start']) : ''; ?>" name="lease_start" placeholder="Date Start" />
			<span class="input-group-addon">to</span>
			<input type="text" class="form-control" value="<?php echo $tenant['lease_end'] ? date('m/d/Y', $tenant['lease_end']) : ''; ?>" name="lease_end" placeholder="Date End" />
		</div>
	</div>
	<div class="form-group">
		<label>Home Address</label>
		<input value="<?php echo html_escape(explode('<br>', $tenant['home_address'])[0]); ?>" name="home_address_line_1" type="text" placeholder="Enter home address line 1" class="form-control">
	</div>
	<div class="form-group">
		<input value="<?php echo html_escape(explode('<br>', $tenant['home_address'])[1]); ?>" name="home_address_line_2" type="text" placeholder="Enter home address line 2" class="form-control">
	</div>
	<div class="form-group">
		<label>Emergency Person</label>
		<input value="<?php echo html_escape($tenant['emergency_person']); ?>" type="text" name="emergency_person" placeholder="Enter emergency person's name" class="form-control">
	</div>
	<div class="form-group">
		<label>Emergency Contact</label>
		<input value="<?php echo html_escape($tenant['emergency_contact']); ?>" type="text" name="emergency_contact" placeholder="Enter emergency person's mobile number" class="form-control">
	</div>
	<div class="form-group">
		<label>Room</label>
		<div>
			<select style="width: 100%" class="form-control default-select2" name="room_id">
				<option value="">Select room</option>
				<?php if ($tenant['room_id'] > 0) : ?>
					<option value="<?php echo html_escape($tenant['room_id']); ?>" selected><?php echo html_escape($this->db->get_where('room', array('room_id' => $tenant['room_id']))->row()->room_number); ?></option>
				<?php
				endif;
				$rooms = $this->db->get_where('room', array('status' => 0))->result_array();
				foreach ($rooms as $room) :
				?>
					<option value="<?php echo html_escape($room['room_id']); ?>"><?php echo html_escape($room['room_number']); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="note note-yellow m-b-15">
		<span>To assign a room, You must activate the tenant.</span>
	</div>
	<div class="form-group">
		<label>Profession</label>
		<div>
			<select style="width: 100%" class="form-control default-select2" name="profession_id">
				<option value="">Select profession</option>
				<?php
				$professions = $this->db->get('profession')->result_array();
				foreach ($professions as $profession) :
				?>
					<option <?php if ($profession['profession_id'] == $tenant['profession_id']) echo 'selected'; ?> value="<?php echo html_escape($profession['profession_id']); ?>"><?php echo html_escape($profession['name']); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label>Work/Institution Address</label>
		<input value="<?php echo html_escape(explode('<br>', $tenant['work_address'])[0]); ?>" name="work_address_line_1" type="text" placeholder="Enter work/Institution address line 1" class="form-control">
	</div>
	<div class="form-group">
		<input value="<?php echo html_escape(explode('<br>', $tenant['work_address'])[1]); ?>" name="work_address_line_2" type="text" placeholder="Enter work/Institution address line 2" class="form-control">
	</div>
	<div class="form-group">
		<label>Status *</label>
		<div>
			<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="status">
				<option value="">Select status</option>
				<option <?php if ($tenant['status'] == 1) echo 'selected'; ?> value="1">Active</option>
				<option <?php if ($tenant['status'] == 0) echo 'selected'; ?> value="0">Inactive</option>
			</select>
		</div>
	</div>
	<div class="note note-yellow m-b-15">
		<span>To activate a tenant, You must assign a room.</span>
	</div>
	<div class="form-group">
		<label>Extra Note</label>
		<textarea style="resize: none" type="text" name="extra_note" placeholder="Enter extra note" class="form-control"><?php echo html_escape($tenant['extra_note']); ?></textarea>
	</div>

	<button type="submit" class="mb-sm btn btn-primary">Update</button>
<?php endforeach; ?>
<?php echo form_close(); ?>

<script>
	$('#edit_tenant').parsley();
	FormPlugins.init();

	$('select:not(.normal)').each(function() {
		$(this).select2({
			dropdownParent: $(this).parent()
		});
	});
</script>