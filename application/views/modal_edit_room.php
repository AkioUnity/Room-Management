<?php echo form_open('rooms/update/' . $param2, array('id' => 'edit_room', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
	<label>Room Number/Name *</label>
	<input value="<?php echo html_escape($this->db->get_where('room', array('room_id' => $param2))->row()->room_number); ?>" type="text" name="room_number" placeholder="Enter room number or name" data-parsley-required="true" class="form-control">
</div>
<div class="form-group">
	<label>Daily Rent (<?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>) *</label>
	<input value="<?php echo html_escape($this->db->get_where('room', array('room_id' => $param2))->row()->daily_rent); ?>" type="text" data-parsley-required="true" data-parsley-type="number" name="daily_rent" placeholder="Enter daily rent for generating invoice for daily guests" class="form-control" min="0">
</div>
<div class="form-group">
	<label>Monthly Rent (<?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>) *</label>
	<input value="<?php echo html_escape($this->db->get_where('room', array('room_id' => $param2))->row()->monthly_rent); ?>" type="text" data-parsley-required="true" data-parsley-type="number" name="monthly_rent" placeholder="Enter monthly rent for generating invoice for monthly guests" class="form-control" min="0">
</div>
<div class="form-group">
	<label>Floor Number</label>
	<input value="<?php echo html_escape($this->db->get_where('room', array('room_id' => $param2))->row()->floor); ?>" type="text" name="floor" placeholder="Enter floor number" class="form-control">
</div>
<div class="form-group">
	<label>Remarks</label>
	<textarea style="resize: none" type="text" name="remarks" placeholder="Enter remarks" class="form-control"><?php echo html_escape($this->db->get_where('room', array('room_id' => $param2))->row()->remarks); ?></textarea>
</div>

<button type="submit" class="mb-sm btn btn-primary">Update</button>
<?php echo form_close(); ?>

<script>
	$('#edit_room').parsley();
</script>