<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Website Settings</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">
        Update website settings
    </h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-6 -->
        <div class="col-lg-6">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <!-- begin panel-body -->
                <div class="panel-body">
                    <?php echo form_open('website_settings/update', array('method' => 'post', 'data-parsley-validate' => 'true')); ?>
                    <div class="form-group">
                        <label>Sytem Name *</label>
                        <input value="<?php echo html_escape($this->db->get_where('setting', array('name' => 'system_name'))->row()->content); ?>" alt="<?php echo $this->db->get_where('setting', array('name' => 'system_name'))->row()->content; ?>" type="text" name="system_name" placeholder="Enter system name" class="form-control" data-parsley-required="true">
                    </div>
                    <div class="form-group">
                        <label>Tagline *</label>
                        <input value="<?php echo html_escape($this->db->get_where('setting', array('name' => 'tagline'))->row()->content); ?>" type="text" name="tagline" placeholder="Enter tagline" class="form-control" data-parsley-required="true">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input name="address_line_1" value="<?php echo html_escape(explode('<br>', $this->db->get_where('setting', array('name' => 'address'))->row()->content)[0]); ?>" type="text" placeholder="Enter address line 1" class="form-control">
                    </div>
                    <div class="form-group">
                        <input name="address_line_2" value="<?php echo html_escape(explode('<br>', $this->db->get_where('setting', array('name' => 'address'))->row()->content)[1]); ?>" type="text" placeholder="Enter address line 2" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Currency *</label>
                        <div>
                            <select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="currency">
                                <option value="">Select currency</option>
                                <?php
                                $currencies = $this->db->get('currency')->result_array();
                                foreach ($currencies as $currency) :
                                ?>
                                    <option <?php if ($this->db->get_where('setting', array('name' => 'currency'))->row()->content == $currency['code']) echo 'selected'; ?> value="<?php echo html_escape($currency['code']); ?>"><?php echo html_escape($currency['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label>Automatic Late Fee Add Day (of Month)</label>
                        <input value="<?php // echo html_escape($this->db->get_where('setting', array('name' => 'automatic_late_fee_add_day'))->row()->content); 
                                        ?>" type="text" name="automatic_late_fee_add_day" placeholder="i. e. 19" class="form-control">
                    </div> -->

                    <button type="submit" class="mb-sm btn btn-primary">Update</button>
                    <?php echo form_close(); ?>
                </div>
                <!-- end panel-body -->
            </div>
            <!-- end panel -->
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <!-- begin panel-body -->
                <div class="panel-body">
                    <?php echo form_open('website_settings/update_smtp', array('method' => 'post', 'data-parsley-validate' => 'true')); ?>
                    <div class="form-group">
                        <label>SMTP Email</label>
                        <input value="<?php echo html_escape($this->db->get_where('setting', array('name' => 'smtp_user'))->row()->content); ?>" alt="<?php echo $this->db->get_where('setting', array('name' => 'system_name'))->row()->content; ?>" type="text" name="smtp_user" placeholder="Enter SMTP Email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>SMTP Password</label>
                        <input value="<?php echo html_escape($this->db->get_where('setting', array('name' => 'smtp_pass'))->row()->content); ?>" type="password" name="smtp_pass" placeholder="Enter SMTP Password" class="form-control">
                    </div>
                    <div class="note note-yellow m-b-15">
                        <span>For generating SMTP Password, visit: <a href="https://myaccount.google.com/apppasswords">App passwords</a></span>
                    </div>

                    <button type="submit" class="mb-sm btn btn-primary">Update</button>
                    <?php echo form_close(); ?>
                </div>
                <!-- end panel-body -->
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-6 -->
        <!-- begin col-6 -->
        <div class="col-lg-6">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <!-- begin panel-body -->
                <div class="panel-body">
                    <?php echo form_open_multipart('website_settings/update_favicon', array('method' => 'post', 'data-parsley-validate' => 'true')); ?>
                    <div class="form-group">
                        <label>Favicon Preview *</label>
                        <br>
                        <img style="width: 64px" src="<?php echo base_url(); ?>uploads/website/<?php echo $this->db->get_where('setting', array('name' => 'favicon'))->row()->content; ?>" alt="<?php echo $this->db->get_where('setting', array('name' => 'system_name'))->row()->content; ?>" class="img-responsive">
                    </div>
                    <div class="note note-yellow m-b-15">
                        <span>Choose an image of the dimension 64 X 64</span>
                    </div>
                    <span class="btn btn-primary fileinput-button">
                        <i class="fa fa-plus"></i>
                        <span>Add file</span>
                        <input class="form-control" type="file" name="favicon" data-parsley-required="true">
                    </span><br><br>

                    <button type="submit" class="mb-sm btn btn-primary">Update</button>
                    <?php echo form_close(); ?>
                </div>
                <!-- end panel-body -->
            </div>
            <!-- end panel -->
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <!-- begin panel-body -->
                <div class="panel-body">
                    <?php echo form_open_multipart('website_settings/login_bg', array('method' => 'post', 'data-parsley-validate' => 'true')); ?>
                    <div class="form-group">
                        <label>Login Background Preview *</label>
                        <br>
                        <img width="100%" src="<?php echo base_url(); ?>uploads/website/<?php echo $this->db->get_where('setting', array('name' => 'login_bg'))->row()->content; ?>" alt="<?php echo $this->db->get_where('setting', array('name' => 'system_name'))->row()->content; ?>" class="img-responsive">
                    </div>
                    <div class="note note-yellow m-b-15">
                        <span>Choose an image of the dimension 1920 X 1280</span>
                    </div>
                    <span class="btn btn-primary fileinput-button">
                        <i class="fa fa-plus"></i>
                        <span>Add file</span>
                        <input class="form-control" type="file" name="login_bg" data-parsley-required="true">
                    </span><br><br>

                    <button type="submit" class="mb-sm btn btn-primary">Update</button>
                    <?php echo form_close(); ?>
                </div>
                <!-- end panel-body -->
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-6 -->
    </div>
    <!-- end row -->
</div>
<!-- end #content -->