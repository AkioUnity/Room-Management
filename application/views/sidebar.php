<!-- begin #sidebar -->
<div id="sidebar" class="sidebar" data-disable-slide-animation="true">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">
        <!-- begin sidebar user -->
        <ul class="nav">
            <li class="nav-profile">
                <div class="text-center">
                    <div class="cover with-shadow"></div>
                    <div class="image">
                        <?php
                        $sidebar_user_type =  $this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row()->user_type;
                        if ($sidebar_user_type == 1) {
                            echo '<img src="' . base_url() . 'uploads/website/' . $this->db->get_where('setting', array('name' => 'favicon'))->row()->content . '" alt="Mars Hostel Management System"' . '/>';
                        } else if ($sidebar_user_type == 2) {
                            echo '<img src="' . base_url() . 'uploads/website/' . $this->db->get_where('setting', array('name' => 'favicon'))->row()->content . '" alt="Mars Hostel Management System"' . '/>';
                        } else {
                            $sidebar_person_id = $this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row()->person_id;
                            $sidebar_tenant_image = $this->db->get_where('tenant', array('tenant_id' => $sidebar_person_id))->row()->image_link;

                            if ($header_tenant_image)
                                echo '<img src="' . base_url() . 'uploads/tenants/' . $header_tenant_image . '" alt="Mars Hostel Management System"' . '/>';
                            else
                                echo '<img src="' . base_url() . 'uploads/website/' . $this->db->get_where('setting', array('name' => 'favicon'))->row()->content . '" alt="Mars Hostel Management System"' . '/>';
                        }

                        ?>
                    </div>
                    <div class="info">
                        <?php
                        if ($sidebar_user_type == 1) {
                            echo 'Admin';
                        } else if ($sidebar_user_type == 2) {
                            $sidebar_person_id = $this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row()->person_id;
                            echo html_escape($this->db->get_where('staff', array('staff_id' => $sidebar_person_id))->row()->name);
                        } else {
                            $sidebar_person_id = $this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row()->person_id;
                            echo html_escape($this->db->get_where('tenant', array('tenant_id' => $sidebar_person_id))->row()->name);
                        }
                        ?>
                        <small>
                            <?php
                            if ($sidebar_user_type == 1) {
                                echo 'Admin';
                            } else if ($sidebar_user_type == 2) {
                                $sidebar_person_id = $this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row()->person_id;
                                if ($this->db->get_where('staff', array('staff_id' => $sidebar_person_id))->row()->role)
                                    echo html_escape($this->db->get_where('staff', array('staff_id' => $sidebar_person_id))->row()->role);
                                else
                                    echo 'Staff';
                            } else {
                                $sidebar_person_id = $this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row()->person_id;
                                $profession_id = $this->db->get_where('tenant', array('tenant_id' => $sidebar_person_id))->row()->profession_id;
                                if ($profession_id)
                                    echo html_escape($this->db->get_where('profession', array('profession_id' => $profession_id))->row()->name);
                                else
                                    echo 'Tenant';
                            }
                            ?>
                        </small>
                    </div>
                </div>
            </li>
        </ul>
        <!-- end sidebar user -->
        <!-- begin sidebar nav -->
        <ul class="nav">
            <li class="nav-header">Navigation</li>
            <?php if (in_array($this->db->get_where('module', array('module_name' => 'dashboard'))->row()->module_id, $this->session->userdata('permissions'))) : ?>
                <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>">
                        <i class="fa fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (in_array($this->db->get_where('module', array('module_name' => 'rooms'))->row()->module_id, $this->session->userdata('permissions'))) : ?>
                <li class="<?php if ($page_name == 'add_room' || $page_name == 'rooms' || $page_name == 'occupied_rooms' || $page_name == 'unoccupied_rooms') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>rooms">
                        <i class="fa fa-building"></i>
                        <span>Rooms</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (in_array($this->db->get_where('module', array('module_name' => 'tenants'))->row()->module_id, $this->session->userdata('permissions'))) : ?>
                <li class="<?php if ($page_name == 'add_tenant' || $page_name == 'tenants' || $page_name == 'active_tenants' || $page_name == 'inactive_tenants') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>tenants">
                        <i class="fa fa-users"></i>
                        <span>Tenants</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php
            if (!in_array($this->db->get_where('module', array(
                'module_name' => 'generate_invoice'
            ))->row()->module_id, $this->session->userdata('permissions')) && !in_array($this->db->get_where('module', array(
                'module_name' => 'Invoices'
            ))->row()->module_id, $this->session->userdata('permissions'))) :
            ?>

            <?php else : ?>
                <li class="has-sub <?php if ($page_name == 'generate_invoice' || $page_name == 'monthly_invoices' || $page_name == 'single_month_invoices' || $page_name == 'tenant_invoices' || $page_name == 'single_tenant_invoices' || $page_name == 'invoices' || $page_name == 'paid_invoices' || $page_name == 'unpaid_invoices' || $page_name == 'invoice') echo 'active'; ?>">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="far fa-credit-card"></i>
                        <span>Invoices</span>
                    </a>
                    <ul class="sub-menu">
                        <?php if (in_array($this->db->get_where('module', array('module_name' => 'generate_invoice'))->row()->module_id, $this->session->userdata('permissions'))) : ?>
                            <li class="<?php if ($page_name == 'generate_invoice') echo 'active'; ?>">
                                <a href="<?php echo base_url(); ?>generate_invoice">Generate Invoice</a>
                            </li>
                        <?php endif; ?>
                        <?php if (in_array($this->db->get_where('module', array('module_name' => 'invoices'))->row()->module_id, $this->session->userdata('permissions'))) : ?>
                            <li class="<?php if ($page_name == 'monthly_invoices' || $page_name == 'single_month_invoices') echo 'active'; ?>">
                                <a href="<?php echo base_url(); ?>monthly_invoices">Monthly Invoices</a>
                            </li>
                            <?php if ($this->session->userdata('user_type') != 3 && (count($this->db->get('tenant')->result_array()) > 0)) : ?>
                                <li class="<?php if ($page_name == 'tenant_invoices' || $page_name == 'single_tenant_invoices') echo 'active'; ?>">
                                    <a href="<?php echo base_url(); ?>tenant_invoices">Tenant Invoices</a>
                                </li>
                            <?php endif; ?>
                            <li class="<?php if ($page_name == 'invoices' || $page_name == 'paid_invoices' || $page_name == 'unpaid_invoices' || $page_name == 'invoice') echo 'active'; ?>">
                                <a href="<?php echo base_url(); ?>invoices">All Invoices</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (in_array($this->db->get_where('module', array('module_name' => 'tickets'))->row()->module_id, $this->session->userdata('permissions'))) : ?>
                <li class="<?php if ($page_name == 'tickets' || $page_name == 'add_ticket' || $page_name == 'closed_tickets' || $page_name == 'open_tickets') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>tickets">
                        <i class="fa fa-life-ring"></i>
                        <span>Tickets</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php
            if (!in_array($this->db->get_where('module', array(
                'module_name' => 'staff'
            ))->row()->module_id, $this->session->userdata('permissions')) && !in_array($this->db->get_where('module', array(
                'module_name' => 'staff_payroll'
            ))->row()->module_id, $this->session->userdata('permissions'))) :
            ?>

            <?php else : ?>
                <li class="has-sub <?php if ($page_name == 'add_staff' || $page_name == 'staff' || $page_name == 'add_staff_payroll' || $page_name == 'staff_payroll' || $page_name == 'single_month_staff_payroll') echo 'active'; ?>">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-user"></i>
                        <span>Staff</span>
                    </a>
                    <ul class="sub-menu">
                        <?php if (in_array($this->db->get_where('module', array('module_name' => 'staff'))->row()->module_id, $this->session->userdata('permissions'))) : ?>
                            <li class="<?php if ($page_name == 'add_staff' || $page_name == 'staff') echo 'active'; ?>">
                                <a href="<?php echo base_url(); ?>staff">Staff</a>
                            </li>
                        <?php endif; ?>
                        <?php if (in_array($this->db->get_where('module', array('module_name' => 'staff_payroll'))->row()->module_id, $this->session->userdata('permissions'))) : ?>
                            <li class="<?php if ($page_name == 'add_staff_payroll') echo 'active'; ?>">
                                <a href="<?php echo base_url(); ?>add_staff_payroll">Add Staff Payroll</a>
                            </li>
                            <li class="<?php if ($page_name == 'staff_payroll' || $page_name == 'single_month_staff_payroll') echo 'active'; ?>">
                                <a href="<?php echo base_url(); ?>staff_payroll">Staff Payroll</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (in_array($this->db->get_where('module', array('module_name' => 'notices'))->row()->module_id, $this->session->userdata('permissions'))) : ?>
                <li class="<?php if ($page_name == 'notices' || $page_name == 'add_notice') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>notices">
                        <i class="fa fa-podcast"></i>
                        <span>Notices</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (in_array($this->db->get_where('module', array('module_name' => 'utility_bills'))->row()->module_id, $this->session->userdata('permissions'))) : ?>
                <li class="has-sub <?php if ($page_name == 'add_utility_bill' || $page_name == 'utility_bills' || $page_name == 'utility_bill_categories') echo 'active'; ?>">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-money-bill-alt"></i>
                        <span>Utility Bills</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="<?php if ($page_name == 'add_utility_bill' || $page_name == 'utility_bills') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>utility_bills">Utility Bill</a>
                        </li>
                        <li class="<?php if ($page_name == 'utility_bill_categories') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>utility_bill_categories">Utility Bill Category</a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (in_array($this->db->get_where('module', array('module_name' => 'expenses'))->row()->module_id, $this->session->userdata('permissions'))) : ?>
                <li class="<?php if ($page_name == 'add_expense' || $page_name == 'expenses') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>expenses">
                        <i class="fas fa-credit-card"></i>
                        <span>Expenses</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (in_array($this->db->get_where('module', array('module_name' => 'account'))->row()->module_id, $this->session->userdata('permissions'))) : ?>
                <li class="<?php if ($page_name == 'account') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>account">
                        <i class="fa fa-list-ol"></i>
                        <span>Account</span>
                    </a>
                </li>
            <?php endif; ?>
            <li class="has-sub <?php if ($page_name == 'website_settings' || $page_name == 'profession_settings' || $page_name == 'id_type_settings' || $page_name == 'profile_settings') echo 'active'; ?>">
                <a href="javascript:;">
                    <b class="caret"></b>
                    <i class="fa fa-cog"></i>
                    <span>Settings</span>
                </a>
                <ul class="sub-menu">
                    <?php if (in_array($this->db->get_where('module', array('module_name' => 'settings'))->row()->module_id, $this->session->userdata('permissions'))) : ?>
                        <li class="<?php if ($page_name == 'website_settings') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>website_settings">Website</a>
                        </li>
                        <li class="<?php if ($page_name == 'profession_settings') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>profession_settings">Profession</a>
                        </li>
                        <li class="<?php if ($page_name == 'id_type_settings') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>id_type_settings">ID Type</a>
                        </li>
                    <?php endif; ?>
                    <li class="<?php if ($page_name == 'profile_settings') echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>profile_settings">Profile</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<!-- end #sidebar -->