<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Add Expense</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">
        Add new expense here
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
                    <?php echo form_open('expenses/add', array('method' => 'post', 'data-parsley-validate' => 'true')); ?>
                    <div class="form-group">
                        <label>Name *</label>
                        <input type="text" name="name" placeholder="Enter name of the expense" class="form-control" data-parsley-required="true">
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
                        <label>Description</label>
                        <textarea style="resize: none" type="text" name="description" placeholder="Enter description of the expense" class="form-control"></textarea>
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