<script type="text/javascript">
	function showAjaxModal(url) {
		// Showing ajax perloader image
		//jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="assets/images/preloader.gif" /></div>');

		// Loading the ajax modal
		jQuery('#modal_ajax').modal('show', {
			backdrop: 'true'
		});

		//Show ajax response on request success
		$.ajax({
			url: url,
			success: function(response) {
				jQuery('#modal_ajax .modal-body').html(response);
			}
		});
	}
</script>

<!-- Ajax modal -->
<div class="modal fade" id="modal_ajax">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body"></div>
		</div>
	</div>
</div>


<script type="text/javascript">
	function vacant_modal(vacant_url) {
		jQuery('#modal_vacant').modal('show', {
			backdrop: 'static'
		});
		document.getElementById('vacant_link').setAttribute('href', vacant_url);
	}

	function deactivate_modal(deactivate_url) {
		jQuery('#modal_deactivate').modal('show', {
			backdrop: 'static'
		});
		document.getElementById('deactivate_link').setAttribute('href', deactivate_url);
	}

	function confirm_modal(delete_url) {
		jQuery('#modal_delete').modal('show', {
			backdrop: 'static'
		});
		document.getElementById('delete_link').setAttribute('href', delete_url);
	}

	function confirm_close_modal(close_url) {
		jQuery('#modal_close').modal('show', {
			backdrop: 'static'
		});
		document.getElementById('close_link').setAttribute('href', close_url);
	}
</script>

<!-- Vacant modal -->
<div class="modal fade" id="modal_vacant">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Are you sure you want to vacant?</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-warning" id="vacant_link">Vacant</a>
				<a href="javascript:;" class="btn btn-info" data-dismiss="modal">Cancel</a>
			</div>
		</div>
	</div>
</div>

<!-- Deactivate modal -->
<div class="modal fade" id="modal_deactivate">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Are you sure you want to deactivate?</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-warning" id="deactivate_link">Deactivate</a>
				<a href="javascript:;" class="btn btn-info" data-dismiss="modal">Cancel</a>
			</div>
		</div>
	</div>
</div>

<!-- Delete modal -->
<div class="modal fade" id="modal_delete">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Are you sure you want to remove this?</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-danger" id="delete_link">Delete</a>
				<a href="javascript:;" class="btn btn-info" data-dismiss="modal">Cancel</a>
			</div>
		</div>
	</div>
</div>

<!-- CLose modal -->
<div class="modal fade" id="modal_close">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Are you sure you want to close this ticket?</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-danger" id="close_link">Close</a>
				<a href="javascript:;" class="btn btn-info" data-dismiss="modal">Cancel</a>
			</div>
		</div>
	</div>
</div>