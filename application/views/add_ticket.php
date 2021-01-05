<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Add Ticket</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">
        Add new ticket here
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
                    <?php echo form_open('tickets/add', array('method' => 'post', 'data-parsley-validate' => 'true')); ?>
                    <?php if ($this->session->userdata('user_type') != 3) : ?>
                        <div class="form-group">
                            <label>Tenant *</label>
                            <div>
                                <select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="tenant_id">
                                    <option value="">Select tenant</option>
                                    <?php
                                    $tenants = $this->db->get_where('tenant', array('status' => 1))->result_array();
                                    foreach ($tenants as $tenant) :
                                    ?>
                                        <option value="<?php echo html_escape($tenant['tenant_id']); ?>"><?php echo html_escape($tenant['name'] . ' - ' . $this->db->get_where('room', array('room_id' => $tenant['room_id']))->row()->room_number); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Subject *</label>
                        <input type="text" name="subject" placeholder="Enter suject of the ticket" class="form-control" data-parsley-required="true">
                    </div>
                    <div class="form-group">
                        <label>Details</label>
                        <textarea rows="10" style="resize: none" type="text" name="content" placeholder="Enter details of the ticket" class="form-control"></textarea>
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