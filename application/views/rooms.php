<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Rooms</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">
        <a href="<?php echo base_url(); ?>add_room">
            <button type="button" class="btn btn-inverse"><i class="fa fa-plus"></i> Add Room</button>
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
                                <th class="text-nowrap">Number/Name</th>
                                <th class="text-nowrap">Status</th>
                                <th class="text-nowrap">Daily Rent</th>
                                <th class="text-nowrap">Monthly Rent</th>
                                <th class="text-nowrap">Floor</th>
                                <th class="text-nowrap">Remarks</th>
                                <th class="text-nowrap">Updated On</th>
                                <th class="text-nowrap">Updated By</th>
                                <th class="text-nowrap">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            $this->db->order_by('timestamp', 'desc');
                            $rooms = $this->db->get('room')->result_array();
                            foreach ($rooms as $room) :
                            ?>
                                <tr>
                                    <td width="1%"><?php echo $count++; ?></td>
                                    <td><?php echo html_escape($room['room_number']); ?></td>
                                    <td>
                                        <?php
                                        if ($room['status'])
                                            echo '<span class="badge badge-primary">Occupied</span>';
                                        else
                                            echo '<span class="badge badge-warning">Unoccupied</span>';
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>
                                        <?php echo html_escape($room['daily_rent']); ?>
                                    </td>
                                    <td>
                                        <?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>
                                        <?php echo html_escape($room['monthly_rent']); ?>
                                    </td>
                                    <td><?php echo $room['floor'] ? html_escape($room['floor']) : 'N/A'; ?></td>
                                    <td><?php echo $room['remarks'] ? html_escape($room['remarks']) : 'N/A'; ?></td>
                                    <td><?php echo date('d M, Y', $room['timestamp']); ?></td>
                                    <td>
                                        <?php
                                        $user_type =  $this->db->get_where('user', array('user_id' => $room['updated_by']))->row()->user_type;
                                        if ($user_type == 1) {
                                            echo 'Admin';
                                        } else {
                                            $person_id = $this->db->get_where('user', array('user_id' => $room['updated_by']))->row()->person_id;
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
                                                <a class="dropdown-item" href="javascript:;" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_room/<?php echo $room['room_id']; ?>');">
                                                    Edit
                                                </a>
                                                <?php if ($room['status']) : ?>
                                                    <a class="dropdown-item" href="javascript:;" onclick="vacant_modal('<?php echo base_url(); ?>rooms/vacant/<?php echo $room['room_id']; ?>');">
                                                        Vacant Room
                                                    </a>
                                                <?php endif; ?>
                                                <?php if (!$room['status']) : ?>
                                                    <a class="dropdown-item" href="javascript:;" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_assign_room_to_tenant/<?php echo $room['room_id']; ?>');">
                                                        Assign Tenant
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="javascript:;" onclick="confirm_modal('<?php echo base_url(); ?>rooms/remove/<?php echo $room['room_id']; ?>');">
                                                        Remove
                                                    </a>
                                                <?php endif; ?>
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