<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Tenants</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">
        <a href="<?php echo base_url(); ?>add_tenant">
            <button type="button" class="btn btn-inverse"><i class="fa fa-plus"></i> Add Tenant</button>
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
                                <th class="text-nowrap">Image</th>
                                <th class="text-nowrap">Name</th>
                                <th class="text-nowrap">Status</th>
                                <th class="text-nowrap">Mobile</th>
                                <th class="text-nowrap">ID</th>
                                <th class="text-nowrap">ID Number</th>
                                <th class="text-nowrap">Room</th>
                                <th class="text-nowrap">Emergency Person</th>
                                <th class="text-nowrap">Emergency Contact</th>
                                <th class="text-nowrap">Updated On</th>
                                <th class="text-nowrap">Updated By</th>
                                <th class="text-nowrap">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            $this->db->order_by('timestamp', 'desc');
                            $tenants = $this->db->get_where('tenant', array('status' => 0))->result_array();
                            foreach ($tenants as $tenant) :
                            ?>
                                <tr>
                                    <td width="1%"><?php echo $count++; ?></td>
                                    <td>
                                        <?php if ($tenant['image_link']) : ?>
                                            <span><img width="100%" src="<?php echo base_url(); ?>uploads/tenants/<?php echo html_escape($tenant['image_link']); ?>" alt="<?php echo html_escape($tenant['name']); ?>" class="media-object" /></span>
                                        <?php else : ?>
                                            <span><img width="100%" src="<?php echo base_url(); ?>assets/img/tenant.png" alt="Tenant image not found" class="media-object" /></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo html_escape($tenant['name']); ?></td>
                                    <td>
                                        <?php
                                        if ($tenant['status'])
                                            echo '<span class="badge badge-primary">Active</span>';
                                        else
                                            echo '<span class="badge badge-warning">Inactive</span>';
                                        ?>
                                    </td>
                                    <td><?php echo $tenant['mobile_number'] ? html_escape($tenant['mobile_number']) : 'N/A'; ?></td>
                                    <td><?php echo $tenant['id_number'] ? html_escape($this->db->get_where('id_type', array('id_type_id' => $tenant['id_type_id']))->row()->name) : 'N/A'; ?></td>
                                    <td><?php echo $tenant['id_number'] ? html_escape($tenant['id_number']) : 'N/A'; ?></td>
                                    <td><?php echo $tenant['room_id'] ? html_escape($this->db->get_where('room', array('room_id' => $tenant['room_id']))->row()->room_number) : 'N/A'; ?></td>
                                    <td><?php echo $tenant['emergency_person'] ? html_escape($tenant['emergency_person']) : 'N/A'; ?></td>
                                    <td><?php echo $tenant['emergency_contact'] ? html_escape($tenant['emergency_contact']) : 'N/A'; ?></td>
                                    <td><?php echo date('d M, Y', $tenant['timestamp']); ?></td>
                                    <td>
                                        <?php
                                        $user_type =  $this->db->get_where('user', array('user_id' => $tenant['updated_by']))->row()->user_type;
                                        if ($user_type == 1) {
                                            echo 'Admin';
                                        } else {
                                            $person_id = $this->db->get_where('user', array('user_id' => $tenant['updated_by']))->row()->person_id;
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
                                                <a class="dropdown-item" href="javascript:;" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_show_tenant_details/<?php echo $tenant['tenant_id']; ?>');">
                                                    Details
                                                </a>
                                                <a class="dropdown-item" href="javascript:;" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_change_tenant_image/<?php echo $tenant['tenant_id']; ?>');">
                                                    Change Image
                                                </a>
                                                <a class="dropdown-item" href="javascript:;" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_tenant/<?php echo $tenant['tenant_id']; ?>');">
                                                    Edit
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="javascript:;" onclick="confirm_modal('<?php echo base_url(); ?>tenants/remove/<?php echo $tenant['tenant_id']; ?>');">
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

<style>
    .hover_img a {
        position: relative;
    }

    .hover_img a span {
        position: absolute;
        display: none;
        z-index: 99;
    }

    .hover_img a:hover span {
        display: block;
    }
</style>