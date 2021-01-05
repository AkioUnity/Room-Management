<!-- begin #header -->
<div id="header" class="header navbar-default hidden-print">
    <!-- begin navbar-header -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed navbar-toggle-left" data-click="sidebar-minify">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="<?php echo base_url(); ?>" class="navbar-brand">
            <?php echo strtoupper($this->db->get_where('setting', array('name' => 'system_name'))->row()->content); ?>
        </a>
    </div>
    <!-- end navbar-header -->

    <!-- begin header-nav -->
    <ul class="navbar-nav navbar-right">
        <li class="dropdown navbar-user">
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                <?php
                echo '<span class="d-md-inline">';
                echo 'Hi, ';
                $header_user_type =  $this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row()->user_type;
                if ($header_user_type == 1) {
                    echo 'Admin';
                    echo '<img src="' . base_url() . 'uploads/website/' . $this->db->get_where('setting', array('name' => 'favicon'))->row()->content . '" alt="Mars Hostel Management System"' . '/>';
                } else if ($header_user_type == 2) {
                    $header_person_id = $this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row()->person_id;
                    echo html_escape($this->db->get_where('staff', array('staff_id' => $header_person_id))->row()->name);
                    echo '<img src="' . base_url() . 'uploads/website/' . $this->db->get_where('setting', array('name' => 'favicon'))->row()->content . '" alt="Mars Hostel Management System"' . '/>';
                } else {
                    $header_person_id = $this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row()->person_id;
                    $header_tenant_image = $this->db->get_where('tenant', array('tenant_id' => $header_person_id))->row()->image_link;
                    echo html_escape($this->db->get_where('tenant', array('tenant_id' => $header_person_id))->row()->name);
                    if ($header_tenant_image)
                        echo '<img src="' . base_url() . 'uploads/tenants/' . $header_tenant_image . '" alt="Mars Hostel Management System"' . '/>';
                    else
                        echo '<img src="' . base_url() . 'uploads/website/' . $this->db->get_where('setting', array('name' => 'favicon'))->row()->content . '" alt="Mars Hostel Management System"' . '/>';
                }
                echo '</span>';
                ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="<?php echo base_url(); ?>profile_settings" class="dropdown-item">Profile Settings</a>
                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url(); ?>auth/logout" class="dropdown-item">Log Out</a>
            </div>
        </li>
    </ul>
    <!-- end header navigation right -->

    <div class="search-form">
        <button class="search-btn" type="submit"><i class="material-icons">search</i></button>
        <input type="text" class="form-control" placeholder="Search Something..." />
        <a href="#" class="close" data-dismiss="navbar-search"><i class="material-icons">close</i></a>
    </div>
</div>
<!-- end #header -->