<?php echo form_open('email_invoice/' . $param2, array('id' => 'show_invoice', 'method' => 'post')); ?>
<div class="form-group">
	<label>Invoice Preview</label>
	<br>
	<embed src="<?php echo base_url(); ?>uploads/invoices/<?php echo html_escape($this->db->get_where('invoice', array('invoice_id' => $param2))->row()->invoice_number . '.pdf'); ?>" width="100%" height="640px">
</div>

<button type="submit" class="mb-sm btn btn-primary">Send Email</button>
<?php echo form_close(); ?>

<script>
	$('.modal-dialog').css('max-width', '720px');
</script>