<?php echo form_open('rooms/assign_tenant/' . $param2, array('id' => 'assign_room_to_tenant', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
    <label>Room</label>
    <p><?php echo $this->db->get_where('room', array('room_id' => $param2))->row()->room_number; ?></p>
</div>
<div class="form-group">
    <label>Tenant *</label>
    <div>
        <select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="tenant_id">
            <option value="">Select tenant</option>
            <?php
            $tenants = $this->db->get_where('tenant', array('status' => 0))->result_array();
            foreach ($tenants as $tenant) :
            ?>
                <option value="<?php echo html_escape($tenant['tenant_id']); ?>"><?php echo html_escape($tenant['name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<button type="submit" class="mb-sm btn btn-primary">Update</button>
<?php echo form_close(); ?>

<script>
    $('#assign_room_to_tenant').parsley();
    FormPlugins.init();

    $('select:not(.normal)').each(function() {
        $(this).select2({
            dropdownParent: $(this).parent()
        });
    });
</script>