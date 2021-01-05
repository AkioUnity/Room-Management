<?php echo form_open('invoices/update_status/' . $param2, array('id' => 'edit_invoice_status', 'method' => 'post', 'data-parsley-validate' => 'true')); ?>
<div class="form-group">
    <label>Status *</label>
    <div>
        <select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="status">
            <option value="">Select Status</option>
            <option <?php if ($this->db->get_where('invoice', array('invoice_id' => $param2))->row()->status == 0) echo 'selected'; ?> value="0">Due</option>
            <option <?php if ($this->db->get_where('invoice', array('invoice_id' => $param2))->row()->status == 1) echo 'selected'; ?> value="1">Paid</option>
        </select>
    </div>
</div>
<div class="form-group">
    <label>Late Fee (<?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>)</label>
    <input value="<?php echo html_escape($this->db->get_where('invoice', array('invoice_id' => $param2))->row()->late_fee); ?>" type="text" name="late_fee" placeholder="Enter late fee" class="form-control" data-parsley-type="number">
</div>

<button type="submit" class="mb-sm btn btn-primary">Update</button>
<?php echo form_close(); ?>

<script>
    $('#edit_invoice_status').parsley();
    FormPlugins.init();

    $('select:not(.normal)').each(function() {
        $(this).select2({
            dropdownParent: $(this).parent()
        });
    });
</script>