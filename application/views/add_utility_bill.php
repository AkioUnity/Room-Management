<!-- begin #content -->
<div id="content" class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
		<li class="breadcrumb-item active">Add Utility Bill</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">
		Add new utility bill here
	</h1>
	<!-- end page-header -->

	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-lg-6 offset-lg-3">
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<!-- begin panel-body -->
				<div class="panel-body">
					<?php echo form_open_multipart('utility_bills/add', array('method' => 'post', 'data-parsley-validate' => 'true')); ?>
					<div class="form-group">
						<label>Name *</label>
						<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="utility_bill_category_id">
							<option value="">Select Utility Bill Category</option>
							<?php
							$utility_bill_categories = $this->db->get('utility_bill_category')->result_array();
							foreach ($utility_bill_categories as $utility_bill_category) :
							?>
								<option value="<?php echo html_escape($utility_bill_category['utility_bill_category_id']); ?>"><?php echo html_escape($utility_bill_category['name']); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label>Year *</label>
						<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="year">
							<option value="">Select Year</option>
							<option value="<?php echo date('Y') - 4; ?>"><?php echo date('Y') - 4; ?></option>
							<option value="<?php echo date('Y') - 3; ?>"><?php echo date('Y') - 3; ?></option>
							<option value="<?php echo date('Y') - 2; ?>"><?php echo date('Y') - 2; ?></option>
							<option value="<?php echo date('Y') - 1; ?>"><?php echo date('Y') - 1; ?></option>
							<option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
							<option value="<?php echo date('Y') + 1; ?>"><?php echo date('Y') + 1; ?></option>
							<option value="<?php echo date('Y') + 2; ?>"><?php echo date('Y') + 2; ?></option>
							<option value="<?php echo date('Y') + 3; ?>"><?php echo date('Y') + 3; ?></option>
							<option value="<?php echo date('Y') + 4; ?>"><?php echo date('Y') + 4; ?></option>
						</select>
					</div>
					<div class="form-group">
						<label>Month *</label>
						<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="month">
							<option value="">Select Month</option>
							<option value="January">January</option>
							<option value="February">February</option>
							<option value="March">March</option>
							<option value="April">April</option>
							<option value="May">May</option>
							<option value="June">June</option>
							<option value="July">July</option>
							<option value="August">August</option>
							<option value="September">September</option>
							<option value="October">October</option>
							<option value="November">November</option>
							<option value="December">December</option>
						</select>
					</div>
					<div class="form-group">
						<label>Amount (<?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>) *</label>
						<input type="text" name="amount" placeholder="Enter amount" class="form-control" data-parsley-required="true" data-parsley-type="number" min="0">
					</div>
					<div class="form-group">
						<label>Utility Bill Image</label>
						<br>
						<span class="btn btn-primary fileinput-button">
							<i class="fa fa-plus"></i>
							<span>Add file</span>
							<input class="form-control" type="file" name="image_link">
						</span>
					</div>
					<div class="form-group">
						<label>Status *</label>
						<select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="status">
							<option value="">Select Status</option>
							<option value="0">Due</option>
							<option value="1">Paid</option>
						</select>
					</div>

					<button type="submit" class="mb-sm btn btn-primary">Submit</button>
					<?php echo form_close(); ?>
				</div>
				<!-- end panel-body -->
			</div>
			<!-- end panel -->
		</div>
		<!-- end col-12 -->
	</div>
	<!-- end row -->
</div>
<!-- end #content -->