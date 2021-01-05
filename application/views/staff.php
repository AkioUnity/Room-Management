<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Staff</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">
        <a href="<?php echo base_url(); ?>add_staff">
            <button type="button" class="btn btn-inverse"><i class="fa fa-plus"></i> Add Staff</button>
        </a>
    </h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-lg-12">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <!-- begin panel-body -->
                <div class="panel-body">
                    <table id="data-table-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="1%">#</th>
                                <th class="text-nowrap">Name</th>
                                <th class="text-nowrap">Status</th>
                                <th class="text-nowrap">Role</th>
                                <th class="text-nowrap">Mobile Number</th>
                                <th class="text-nowrap">Email</th>
                                <th class="text-nowrap">Remarks</th>
                                <th class="text-nowrap">Created On</th>
                                <th class="text-nowrap">Created By</th>
                                <th class="text-nowrap">Updated On</th>
                                <th class="text-nowrap">Updated By</th>
                                <th class="text-nowrap">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            $this->db->order_by('timestamp', 'desc');
                            $staff = $this->db->get('staff')->result_array();
                            foreach ($staff as $row) :
                            ?>
                                <tr>
                                    <td width="1%"><?php echo $count++; ?></td>
                                    <td><?php echo html_escape($row['name']); ?></td>
                                    <td>
                                        <?php
                                        if ($row['status'])
                                            echo '<span class="badge badge-primary">Active</span>';
                                        else
                                            echo '<span class="badge badge-warning">Inactive</span>';
                                        ?>
                                    </td>
                                    <td><?php echo $row['role'] ? html_escape($row['role']) : 'N/A'; ?></td>
                                    <td><?php echo html_escape($row['mobile_number']); ?></td>
                                    <td>
                                        <?php
                                        if ($this->db->get_where('user', array('user_type' => 2, 'person_id' => $row['staff_id']))->num_rows() > 0) {
                                            echo html_escape($this->db->get_where('user', array('user_type' => 2, 'person_id' => $row['staff_id']))->row()->email);
                                        } else {
                                            echo 'N/A';
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $row['remarks'] ? html_escape($row['remarks']) : 'N/A'; ?></td>
                                    <td><?php echo date('d M, Y', $row['created_on']); ?></td>
                                    <td>
                                        <?php
                                        $user_type =  $this->db->get_where('user', array('user_id' => $row['created_by']))->row()->user_type;
                                        if ($user_type == 1) {
                                            echo 'Admin';
                                        } else {
                                            $person_id = $this->db->get_where('user', array('user_id' => $row['created_by']))->row()->person_id;
                                            echo html_escape($this->db->get_where('staff', array('staff_id' => $person_id))->row()->name);
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo date('d M, Y', $row['timestamp']); ?></td>
                                    <td>
                                        <?php
                                        $user_type =  $this->db->get_where('user', array('user_id' => $row['updated_by']))->row()->user_type;
                                        if ($user_type == 1) {
                                            echo 'Admin';
                                        } else {
                                            $person_id = $this->db->get_where('user', array('user_id' => $row['updated_by']))->row()->person_id;
                                            echo html_escape($this->db->get_where('staff', array('staff_id' => $person_id))->row()->name);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-white btn-xs">Action</button>
                                            <button type="button" class="btn btn-white btn-xs dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="javascript:;" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_staff/<?php echo $row['staff_id']; ?>');">
                                                    Edit
                                                </a>
                                                <?php if ($this->db->get_where('user', array('user_type' => 2, 'person_id' => $row['staff_id']))->num_rows() > 0) : ?>
                                                    <a class="dropdown-item" href="javascript:;" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_permissions/<?php echo $row['staff_id']; ?>');">
                                                        Permissions
                                                    </a>
                                                <?php endif; ?>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="javascript:;" onclick="deactivate_modal('<?php echo base_url(); ?>staff/deactivate/<?php echo $row['staff_id']; ?>');">
                                                    Deactivate
                                                </a>
                                                <a class="dropdown-item" href="javascript:;" onclick="confirm_modal('<?php echo base_url(); ?>staff/remove/<?php echo $row['staff_id']; ?>');">
                                                    Remove
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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