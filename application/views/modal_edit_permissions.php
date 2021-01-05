<?php echo form_open('staff/permission/' . $param2, array('method' => 'post')); ?>
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th><b>Module</b></th>
				<th><b>Permission</b></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$count = 1;
			$permissions = $this->db->get_where('user', array('person_id' => $param2, 'user_type' => 2))->row()->permissions;
			if (isset($permissions)) $permissions_no_comma = explode(",", $permissions);
			$modules = $this->db->get('module')->result_array();
			foreach ($modules as $module) :
			?>
				<tr>
					<td><?php echo $count++; ?></td>
					<td><?php echo html_escape($module['module_title']); ?></td>
					<td>
						<div class="form-group">
							<div class="col-sm-2">
								<div class="checkbox checkbox-css">
									<input type="checkbox" id="<?php echo $module['module_id'] ?>" name="permission[]" value="<?php echo html_escape($module['module_id']); ?>" <?php if (isset($permissions_no_comma) && in_array($module['module_id'], $permissions_no_comma)) echo 'checked'; ?>>
									<label for="<?php echo $module['module_id'] ?>"></label>
								</div>
							</div>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<button type="submit" class="mb-sm btn btn-primary">Update</button>
<?php echo form_close(); ?>