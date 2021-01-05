<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Profile Settings</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">
        Update your profile information
    </h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-lg-4 offset-lg-4">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <!-- begin panel-body -->
                <div class="panel-body">
                    <?php echo form_open('profile_settings/update/' . $this->session->userdata('user_id'), array('method' => 'post', 'data-parsley-validate' => 'true')); ?>
                    <?php
                    $user_info = $this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->result_array();
                    foreach ($user_info as $row) :
                        ?>
                        <div class="form-group">
                            <label>Email *</label>
                            <input value="<?php echo html_escape($row['email']); ?>" type="email" name="email" placeholder="Enter email" class="form-control" data-parsley-required="true">
                        </div>
                        <div class="form-group">
                            <label>Current Password *</label>
                            <input type="password" name="old_password" placeholder="Enter your current password" class="form-control" data-parsley-required="true">
                        </div>
                        <div class="form-group">
                            <label>New Password *</label>
                            <input type="password" name="new_password" placeholder="Enter new password" class="form-control" data-parsley-required="true">
                        </div>

                        <button type="submit" class="mb-sm btn btn-primary">Update</button>
                    <?php endforeach; ?>
                    <?php echo form_close(); ?>
                    <!-- end panel-body -->
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-12 -->
    </div>
    <!-- end row -->
</div>
<!-- end #content -->