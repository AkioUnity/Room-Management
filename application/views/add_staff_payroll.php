<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Add Staff Salary</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">
        Add staff salary here
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
                    <?php echo form_open('staff_payroll/add', array('method' => 'post', 'data-parsley-validate' => 'ture')); ?>
                    <div class="form-group">
                        <label>Name *</label>
                        <select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="staff_id">
                            <option value="">Select Staff</option>
                            <?php
                                $staff = $this->db->get_where('staff', array('status' => 1))->result_array();
                                foreach($staff as $row):
                            ?>
                                <option value="<?php echo html_escape($row['staff_id']); ?>"><?php echo html_escape($row['name']); ?></option>
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
