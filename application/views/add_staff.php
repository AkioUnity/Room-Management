<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Add Staff</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">
        Add new staff here
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
                    <?php echo form_open('staff/add', array('method' => 'post', 'data-parsley-validate' => 'true')); ?>
                    <div class="form-group">
                        <label>Name *</label>
                        <input type="text" name="name" placeholder="Enter name" class="form-control" data-parsley-required="true">
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <input type="text" name="role" placeholder="Enter role i.e. Manager" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email (For staff login)</label>
                        <input type="email" name="email" placeholder="Enter email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Password (For staff login)</label>
                        <input type="text" name="password" id="password-indicator-visible" class="form-control m-b-5">
                        <div id="passwordStrengthDiv2" class="is0 m-t-5"></div>
                    </div>
                    <div class="note note-yellow m-b-15">
                        <span>Default password for login is: 123456</span>
                    </div>
                    <div class="form-group">
                        <label>Mobile Number *</label>
                        <input type="text" name="mobile_number" placeholder="Enter mobile number" class="form-control" data-parsley-required="true">
                    </div>
                    <div class="form-group">
                        <label>Status *</label>
                        <select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="status">
                            <option value="">Select Status</option>
                            <option value="0">Inactive</option>
                            <option value="1">Active</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Remarks</label>
                        <textarea style="resize: none" type="text" name="remarks" placeholder="Enter remarks" class="form-control"></textarea>
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