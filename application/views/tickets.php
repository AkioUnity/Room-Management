<!-- begin #content -->
<div id="content" class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
		<li class="breadcrumb-item active"><?php echo $this->security->xss_clean($page_title); ?></li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">
		<a href="<?php echo base_url(); ?>add_ticket">
			<button type="button" class="btn btn-inverse"><i class="fa fa-plus"></i> Add Ticket</button>
		</a>
	</h1>
	<!-- end page-header -->

	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-md-12">
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<div class="panel-body">
					<table id="data-table-buttons" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Ticket Number</th>
								<th>Title</th>
								<th>Status</th>
								<th>Total Messages</th>
								<?php if ($this->session->userdata('user_type') != 3) : ?>
									<th>Tenant</th>
								<?php endif; ?>
								<th>Created On</th>
								<th>Created By</th>
								<th>Updated On</th>
								<th>Updated By</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$count = 1;
							$this->db->order_by('timestamp', 'desc');
							if ($this->session->userdata('user_type') == 3) {
								$tenant_id = $this->security->xss_clean($this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row()->person_id);
								$tickets = $this->security->xss_clean($this->db->get_where('ticket', array('tenant_id' => $tenant_id))->result_array());
							} else {
								$tickets = $this->security->xss_clean($this->db->get('ticket')->result_array());
							}
							foreach ($tickets as $row) :
							?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo $row['ticket_number']; ?></td>
									<td>
										<a onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_view_ticket_details/<?php echo $row['ticket_id']; ?>');" href="javascript:;">
											<?php echo $row['subject']; ?>
										</a>
									</td>
									<td>
										<?php if ($row['status'] == 0) : ?>
											<span class="badge badge-warning">Open</span>
										<?php endif; ?>
										<?php if ($row['status'] == 1) : ?>
											<span class="badge badge-primary">Closed</span>
										<?php endif; ?>
									</td>
									<td><?php echo $this->db->get_where('ticket_details', array('ticket_id' => $row['ticket_id']))->num_rows(); ?></td>
									<?php if ($this->session->userdata('user_type') != 3) : ?>
										<td><?php echo $this->db->get_where('tenant', array('tenant_id' => $row['tenant_id']))->row()->name; ?></td>
									<?php endif; ?>
									<td><?php echo date('d M, Y', $row['created_on']); ?></td>
									<td>
										<?php
										$user_type =  $this->db->get_where('user', array('user_id' => $row['created_by']))->row()->user_type;
										if ($user_type == 1) {
											echo 'Admin';
										} else if ($user_type == 2) {
											$person_id = $this->db->get_where('user', array('user_id' => $row['created_by']))->row()->person_id;
											echo html_escape($this->db->get_where('staff', array('staff_id' => $person_id))->row()->name);
										} else {
											$person_id = $this->db->get_where('user', array('user_id' => $row['created_by']))->row()->person_id;
											echo html_escape($this->db->get_where('tenant', array('tenant_id' => $person_id))->row()->name);
										}
										?>
									</td>
									<td><?php echo date('d M, Y', $row['timestamp']); ?></td>
									<td>
										<?php
										$user_type =  $this->db->get_where('user', array('user_id' => $row['updated_by']))->row()->user_type;
										if ($user_type == 1) {
											echo 'Admin';
										} else if ($user_type == 2) {
											$person_id = $this->db->get_where('user', array('user_id' => $row['updated_by']))->row()->person_id;
											echo html_escape($this->db->get_where('staff', array('staff_id' => $person_id))->row()->name);
										} else {
											$person_id = $this->db->get_where('user', array('user_id' => $row['updated_by']))->row()->person_id;
											echo html_escape($this->db->get_where('tenant', array('tenant_id' => $person_id))->row()->name);
										}
										?>
									</td>
									<td>
										<?php if (!$row['status']) : ?>
											<div class="btn-group">
												<button type="button" class="btn btn-white btn-xs">Action</button>
												<button type="button" class="btn btn-white btn-xs dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<span class="sr-only">Toggle Dropdown</span>
												</button>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_reply_to_ticket/<?php echo $row['ticket_id']; ?>');" href="javascript:;">Reply</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" onclick="confirm_close_modal('<?php echo base_url(); ?>tickets/close/<?php echo $row['ticket_id']; ?>');" href="javascript:;">Close</a>
												</div>
											</div>
										<?php else : ?>
											<p>N/A</p>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- end panel -->
		</div>
		<!-- end col-12 -->
	</div>
	<!-- end row -->
</div>
<!-- end #content -->