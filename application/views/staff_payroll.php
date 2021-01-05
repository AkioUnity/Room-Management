<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Staff Payroll</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">
        Showing staff payroll of <?php echo date('F') . ', ' .  date('Y'); ?>
    </h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-9 -->
        <div class="col-lg-9">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <!-- begin panel-body -->
                <div class="panel-body">
                    <table id="data-table-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="1%">#</th>
                                <th class="text-nowrap">Staff Name</th>
                                <th class="text-nowrap">Month</th>
                                <th class="text-nowrap">Year</th>
                                <th class="text-nowrap">Amount</th>
                                <th class="text-nowrap">Status</th>
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
                            $staff_payroll = $this->db->get_where('staff_salary', array('year' => date('Y'), 'month' => date('F')))->result_array();
                            foreach ($staff_payroll as $row) :
                            ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo html_escape($this->db->get_where('staff', array('staff_id' => $row['staff_id']))->row()->name); ?></td>
                                    <td><?php echo html_escape($row['month']); ?></td>
                                    <td><?php echo html_escape($row['year']); ?></td>
                                    <td>
                                        <?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>
                                        <?php echo html_escape($row['amount']); ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($row['status'] == 0)
                                            echo '<span class="badge badge-warning">Due</span>';
                                        else
                                            echo '<span class="badge badge-primary">Paid</span>';
                                        ?>
                                    </td>
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
                                                <a class="dropdown-item" href="javascript:;" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_staff_payroll/<?php echo $row['staff_salary_id']; ?>');">
                                                    Edit
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="javascript:;" onclick="confirm_modal('<?php echo base_url(); ?>staff_payroll/remove/<?php echo $row['staff_salary_id']; ?>');">
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
        <!-- end col-9 -->
        <!-- begin col-3 -->
        <div class="col-lg-3">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <!-- begin panel-body -->
                <div class="panel-body">
                    <div class="form-group">
                        <label>Year *</label>
                        <div>
                            <select style="width: 100%" class="form-control default-select2" data-parsley-required="true" id="year">
                                <option value="">Select Year</option>
                                <option value="<?php echo date('Y') - 4; ?>"><?php echo date('Y') - 4; ?></option>
                                <option value="<?php echo date('Y') - 3; ?>"><?php echo date('Y') - 3; ?></option>
                                <option value="<?php echo date('Y') - 2; ?>"><?php echo date('Y') - 2; ?></option>
                                <option value="<?php echo date('Y') - 1; ?>"><?php echo date('Y') - 1; ?></option>
                                <option <?php echo 'selected'; ?> value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
                                <option value="<?php echo date('Y') + 1; ?>"><?php echo date('Y') + 1; ?></option>
                                <option value="<?php echo date('Y') + 2; ?>"><?php echo date('Y') + 2; ?></option>
                                <option value="<?php echo date('Y') + 3; ?>"><?php echo date('Y') + 3; ?></option>
                                <option value="<?php echo date('Y') + 4; ?>"><?php echo date('Y') + 4; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Month *</label>
                        <div>
                            <select style="width: 100%" class="form-control default-select2" data-parsley-required="true" id="month">
                                <option value="">Select Month</option>
                                <option <?php if (date('F') == 'January') echo 'selected'; ?> value="January">January</option>
                                <option <?php if (date('F') == 'February') echo 'selected'; ?> value="February">February</option>
                                <option <?php if (date('F') == 'March') echo 'selected'; ?> value="March">March</option>
                                <option <?php if (date('F') == 'April') echo 'selected'; ?> value="April">April</option>
                                <option <?php if (date('F') == 'May') echo 'selected'; ?> value="May">May</option>
                                <option <?php if (date('F') == 'June') echo 'selected'; ?> value="June">June</option>
                                <option <?php if (date('F') == 'July') echo 'selected'; ?> value="July">July</option>
                                <option <?php if (date('F') == 'August') echo 'selected'; ?> value="August">August</option>
                                <option <?php if (date('F') == 'September') echo 'selected'; ?> value="September">September</option>
                                <option <?php if (date('F') == 'October') echo 'selected'; ?> value="October">October</option>
                                <option <?php if (date('F') == 'November') echo 'selected'; ?> value="November">November</option>
                                <option <?php if (date('F') == 'December') echo 'selected'; ?> value="December">December</option>
                            </select>
                        </div>
                    </div>

                    <button type="button" onclick="showSingleMonthPayroll()" class="mb-sm btn btn-block btn-primary">Show</button>
                </div>
                <!-- end panel-body -->
            </div>
            <!-- end panel -->
            <div class="widget widget-stats bg-orange">
                <div class="stats-icon"><i class="fa fa-money-bill-alt"></i></div>
                <div class="stats-info">
                    <h4><b>Due Salary of <?php echo date('F') . ', ' . date('Y'); ?></b></h4>
                    <p>
                        <?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>
                        <?php
                        $this->db->select_sum('amount');
                        $this->db->from('staff_salary');
                        $this->db->where('status', 0);
                        $this->db->where('month', date('F'));
                        $this->db->where('year', date('Y'));
                        $query = $this->db->get();

                        echo $query->row()->amount > 0 ? $query->row()->amount : 0;
                        ?>
                    </p>
                </div>
            </div>
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon"><i class="fa fa-credit-card"></i></div>
                <div class="stats-info">
                    <h4><b>Total Salary of <?php echo date('F') . ', ' . date('Y'); ?></b></h4>
                    <p>
                        <?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>
                        <?php
                        $this->db->select_sum('amount');
                        $this->db->from('staff_salary');
                        $this->db->where('month', date('F'));
                        $this->db->where('year', date('Y'));
                        $query = $this->db->get();

                        echo $query->row()->amount > 0 ? $query->row()->amount : 0;
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
    </div>
    <!-- end row -->
</div>
<!-- end #content -->

<script>
    function showSingleMonthPayroll() {
        var year = $("#year").val();
        var month = $("#month").val();

        url = "<?php echo base_url(); ?>single_month_staff_payroll/" + year + "/" + month;

        window.location = url;
    }
</script>