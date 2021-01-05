<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Welcome to <?php echo $this->db->get_where('setting', array('name' => 'system_name'))->row()->content; ?> <small><?php echo date('d F, Y'); ?></small></h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon"><i class="fa fa-building"></i></div>
                <div class="stats-info">
                    <h4><b>Total Rooms</b></h4>
                    <p><?php echo html_escape($this->db->get('room')->num_rows()); ?></p>
                </div>
                <div class="stats-link">
                    <a href="<?php echo base_url(); ?>rooms">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon"><i class="fa fa-building"></i></div>
                <div class="stats-info">
                    <h4><b>Unoccupied Rooms</b></h4>
                    <p><?php echo html_escape($this->db->get_where('room', array('status' => 0))->num_rows()); ?></p>
                </div>
                <div class="stats-link">
                    <a href="<?php echo base_url(); ?>unoccupied_rooms">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon"><i class="fa fa-building"></i></div>
                <div class="stats-info">
                    <h4><b>Occupied Rooms</b></h4>
                    <p><?php echo html_escape($this->db->get_where('room', array('status' => 1))->num_rows()); ?></p>
                </div>
                <div class="stats-link">
                    <a href="<?php echo base_url(); ?>occupied_rooms">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon"><i class="fa fa-user"></i></div>
                <div class="stats-info">
                    <h4><b>Total Staff</b></h4>
                    <p><?php echo html_escape($this->db->get('staff')->num_rows()); ?></p>
                </div>
                <div class="stats-link">
                    <a href="<?php echo base_url(); ?>staff">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon"><i class="fa fa-users"></i></div>
                <div class="stats-info">
                    <h4><b>Total Tenants</b></h4>
                    <p><?php echo html_escape($this->db->get('tenant')->num_rows()); ?></p>
                </div>
                <div class="stats-link">
                    <a href="<?php echo base_url(); ?>tenants">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon"><i class="fa fa-users"></i></div>
                <div class="stats-info">
                    <h4><b>Inactive Tenants</b></h4>
                    <p><?php echo html_escape($this->db->get_where('tenant', array('status' => 0))->num_rows()); ?></p>
                </div>
                <div class="stats-link">
                    <a href="<?php echo base_url(); ?>inactive_tenants">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon"><i class="fa fa-users"></i></div>
                <div class="stats-info">
                    <h4><b>Active Tenants</b></h4>
                    <p><?php echo html_escape($this->db->get_where('tenant', array('status' => 1))->num_rows()); ?></p>
                </div>
                <div class="stats-link">
                    <a href="<?php echo base_url(); ?>active_tenants">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon"><i class="fa fa-podcast"></i></div>
                <div class="stats-info">
                    <h4><b>Total Notices</b></h4>
                    <p><?php echo html_escape($this->db->get('notice')->num_rows()); ?></p>
                </div>
                <div class="stats-link">
                    <a href="<?php echo base_url(); ?>notices">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon"><i class="far fa-credit-card"></i></div>
                <div class="stats-info">
                    <h4><b>Total Invoices</b></h4>
                    <p><?php echo html_escape($this->db->get('invoice')->num_rows()); ?></p>
                </div>
                <div class="stats-link">
                    <a href="<?php echo base_url(); ?>invoices">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon"><i class="far fa-credit-card"></i></div>
                <div class="stats-info">
                    <h4><b>Unpaid Invoices</b></h4>
                    <p><?php echo html_escape($this->db->get_where('invoice', array('status' => 0))->num_rows()); ?></p>
                </div>
                <div class="stats-link">
                    <a href="<?php echo base_url(); ?>unpaid_invoices">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon"><i class="far fa-credit-card"></i></div>
                <div class="stats-info">
                    <h4><b>Paid Invoices</b></h4>
                    <p><?php echo html_escape($this->db->get_where('invoice', array('status' => 1))->num_rows()); ?></p>
                </div>
                <div class="stats-link">
                    <a href="<?php echo base_url(); ?>paid_invoices">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon"><i class="fa fa-money-bill-alt"></i></div>
                <div class="stats-info">
                    <h4><b>Total Utility Bills</b></h4>
                    <p><?php echo html_escape($this->db->get('utility_bill')->num_rows()); ?></p>
                </div>
                <div class="stats-link">
                    <a href="<?php echo base_url(); ?>utility_bills">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon"><i class="fa fa-life-ring"></i></div>
                <div class="stats-info">
                    <h4><b>Total Tickets</b></h4>
                    <p><?php echo html_escape($this->db->get('ticket')->num_rows()); ?></p>
                </div>
                <div class="stats-link">
                    <a href="<?php echo base_url(); ?>tickets">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon"><i class="fa fa-life-ring"></i></div>
                <div class="stats-info">
                    <h4><b>Open Tickets</b></h4>
                    <p><?php echo html_escape($this->db->get_where('ticket', array('status' => 0))->num_rows()); ?></p>
                </div>
                <div class="stats-link">
                    <a href="<?php echo base_url(); ?>open_tickets">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon"><i class="fa fa-life-ring"></i></div>
                <div class="stats-info">
                    <h4><b>Closed Tickets</b></h4>
                    <p><?php echo html_escape($this->db->get_where('ticket', array('status' => 1))->num_rows()); ?></p>
                </div>
                <div class="stats-link">
                    <a href="<?php echo base_url(); ?>closed_tickets">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon"><i class="fas fa-credit-card"></i></div>
                <div class="stats-info">
                    <h4><b>Total Expenses</b></h4>
                    <p><?php echo html_escape($this->db->get('expense')->num_rows()); ?></p>
                </div>
                <div class="stats-link">
                    <a href="<?php echo base_url(); ?>expenses">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->

        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="note note-light m-b-15">
                <h5><b>Due Rents of <?php echo date('M, Y'); ?></b></h5>
                <p>
                    <?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>
                    <?php
                    $this->db->select_sum('amount');
                    $this->db->from('tenant_rent');
                    $this->db->where('status', 0);
                    $this->db->where('month', date('F'));
                    $this->db->where('year', date('Y'));
                    $query = $this->db->get();

                    $due_amount = $query->row()->amount;

                    echo round($due_amount > 0 ? $due_amount : 0);
                    ?>
                </p>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="note note-light m-b-15">
                <h5><b>Total Rents of <?php echo date('M, Y'); ?></b></h5>
                <p>
                    <?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>
                    <?php
                    $this->db->select_sum('amount');
                    $this->db->from('tenant_rent');
                    $this->db->where('month', date('F'));
                    $this->db->where('year', date('Y'));
                    $query = $this->db->get();

                    $total_amount = $query->row()->amount;

                    echo round($total_amount > 0 ? $total_amount : 0);
                    ?>
                </p>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="note note-light m-b-15">
                <h5><b>Due Rents of <?php echo date('F, Y', strtotime("-1 months")); ?></b></h5>
                <p>
                    <?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>
                    <?php
                    $this->db->select_sum('amount');
                    $this->db->from('tenant_rent');
                    $this->db->where('status', 0);
                    $this->db->where('month', date('F', strtotime("-1 months")));
                    $this->db->where('year', date('Y'));
                    $query = $this->db->get();

                    $last_due_amount = $query->row()->amount;

                    echo round($last_due_amount > 0 ? $last_due_amount : 0);
                    ?>
                </p>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="note note-light m-b-15">
                <h5><b>Total Rents of <?php echo date('F, Y', strtotime("-1 months")); ?></b></h5>
                <p>
                    <?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>
                    <?php
                    $this->db->select_sum('amount');
                    $this->db->from('tenant_rent');
                    $this->db->where('month', date('F', strtotime("-1 months")));
                    $this->db->where('year', date('Y'));
                    $query = $this->db->get();

                    $last_total_amount = $query->row()->amount;

                    echo round($last_total_amount > 0 ? $last_total_amount : 0);
                    ?>
                </p>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="note note-light m-b-15">
                <h5><b>Total Utility Bills Overall</b></h5>
                <p>
                    <?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>
                    <?php
                    $this->db->select_sum('amount');
                    $this->db->from('utility_bill');
                    $query = $this->db->get();

                    $overall_utility_bill = $query->row()->amount;

                    if ($overall_utility_bill > 1000000) {
                        echo round($overall_utility_bill / 1000000) . ' M';
                    } else {
                        echo round($overall_utility_bill  > 0 ? $overall_utility_bill : 0);
                    }
                    ?>
                </p>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="note note-light m-b-15">
                <h5><b>Total Expenses Overall</b></h5>
                <p>
                    <?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>
                    <?php
                    $this->db->select_sum('amount');
                    $this->db->from('expense');
                    $query = $this->db->get();

                    $overall_expense = $query->row()->amount;

                    if ($overall_expense > 1000000) {
                        echo round($overall_expense / 1000000) . ' M';
                    } else {
                        echo round($overall_expense > 0 ? $overall_expense : 0);
                    }
                    ?>
                </p>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="note note-light m-b-15">
                <h5><b>Total Due Rents Overall</b></h5>
                <p>
                    <?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>
                    <?php
                    $this->db->select_sum('amount');
                    $this->db->from('tenant_rent');
                    $this->db->where('status', 0);
                    $query = $this->db->get();

                    $overall_due_amount = $query->row()->amount;

                    echo round($overall_due_amount > 0 ? $overall_due_amount : 0);
                    ?>
                </p>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-lg-3 col-md-6">
            <div class="note note-light m-b-15">
                <h5><b>Total Rents Overall</b></h5>
                <p>
                    <?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>
                    <?php
                    $this->db->select_sum('amount');
                    $this->db->from('tenant_rent');
                    $query = $this->db->get();

                    $overall_amount = $query->row()->amount;

                    echo round($overall_amount > 0 ? $overall_amount : 0);
                    ?>
                </p>
            </div>
        </div>
        <!-- end col-3 -->
    </div>
    <!-- end row -->
</div>
<!-- end #content -->