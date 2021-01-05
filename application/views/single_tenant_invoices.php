<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Monthly Invoices</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <?php
    $tenants        =   $this->db->get('tenant')->result_array();
    $tenant_name    =   $this->db->get_where('tenant', array('tenant_id' => $tenant_id))->row()->name;
    ?>
    <h1 class="page-header">
        Showing invoices of <?php echo $tenant_name; ?>
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
                                <th class="text-nowrap">Invoice</th>
                                <th class="text-nowrap">Tenant Name</th>
                                <th class="text-nowrap">Tenant Mobile</th>
                                <th class="text-nowrap">Status</th>
                                <th class="text-nowrap">Room</th>
                                <th class="text-nowrap">Amount</th>
                                <th class="text-nowrap">Due Date</th>
                                <th class="text-nowrap">Late Fee</th>
                                <th class="text-nowrap">Updated On</th>
                                <th class="text-nowrap">Updated By</th>
                                <?php if ($this->session->userdata('user_type') != 3) : ?>
                                    <th class="text-nowrap">Options</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            $this->db->order_by('timestamp', 'desc');

                            $bill_info = [];
                            $invoices = $this->db->get_where('invoice', array('tenant_id' => $tenant_id))->result_array();
                            foreach ($invoices as $invoice) {
                                $tenant_rents = $this->db->get_where('tenant_rent', array('invoice_id' => $invoice['invoice_id']))->result_array();
                                foreach ($tenant_rents as $tenant_rent) {
                                    array_push($bill_info, $invoice);
                                }
                            }
                            foreach ($bill_info as $row) :
                            ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td>
                                        <a href="<?php echo base_url(); ?>invoice/<?php echo $row['invoice_id']; ?>">
                                            #<?php echo html_escape($row['invoice_number']); ?>
                                        </a>
                                    </td>
                                    <td><?php echo html_escape($row['tenant_name']); ?></td>
                                    <td><?php echo html_escape($row['tenant_mobile']); ?></td>
                                    <td>
                                        <?php if ($row['status'] == 0) : ?>
                                            <span class="badge badge-warning">Due</span>
                                        <?php endif; ?>
                                        <?php if ($row['status'] == 1) : ?>
                                            <span class="badge badge-primary">Paid</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo html_escape($row['room_number']); ?></td>
                                    <td>
                                        <?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>
                                        <?php
                                        $this->db->select_sum('amount');
                                        $this->db->from('tenant_rent');
                                        $this->db->where('invoice_id', $row['invoice_id']);
                                        $query = $this->db->get();

                                        echo ($row['late_fee'] > 0) ? $query->row()->amount + $row['late_fee'] : $query->row()->amount;
                                        ?>
                                    </td>
                                    <td><?php echo date('d M, Y', $row['due_date']); ?></td>
                                    <td><?php echo html_escape($this->db->get_where('setting', array('name' => 'currency'))->row()->content . ' ' . $row['late_fee']); ?></td>
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
                                    <?php if ($this->session->userdata('user_type') != 3) : ?>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-white btn-xs">Action</button>
                                                <button type="button" class="btn btn-white btn-xs dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="javascript:;" onclick="showInvoiceModal(<?php echo $row['invoice_id']; ?>)">
                                                        Show Invoice PDF
                                                    </a>
                                                    <a class="dropdown-item" href="javascript:;" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_edit_invoice_status/<?php echo $row['invoice_id']; ?>');">
                                                        Update Status
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="javascript:;" onclick="confirm_modal('<?php echo base_url(); ?>invocies/remove/<?php echo $row['invoice_id']; ?>');">
                                                        Remove
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    <?php endif; ?>
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
                        <label>Tenant *</label>
                        <div>
                            <select style="width: 100%" class="form-control default-select2" data-parsley-required="true" id="tenant_id">
                                <option value="">Select Tenant</option>
                                <?php foreach ($tenants as $tenant) : ?>
                                    <option <?php if ($tenant['tenant_id'] == $tenant_id) echo 'selected'; ?> value="<?php echo $tenant['tenant_id']; ?>"><?php echo $tenant['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <button type="button" onclick="showSingleTenantInvoices()" class="mb-sm btn btn-block btn-primary">Show</button>
                </div>
                <!-- end panel-body -->
            </div>
            <!-- end panel -->
            <?php if ($this->session->userdata('user_type') != 3) : ?>
                <div class="widget widget-stats bg-orange">
                    <div class="stats-icon"><i class="fa fa-money-bill-alt"></i></div>
                    <div class="stats-info">
                        <h4><b>Due Rents of <?php echo $tenant_name; ?></b></h4>
                        <p>
                            <?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>
                            <?php
                            $this->db->select_sum('amount');
                            $this->db->from('tenant_rent');
                            $this->db->where('status', 0);
                            $this->db->where('tenant_id', $tenant_id);
                            $query = $this->db->get();

                            echo $query->row()->amount > 0 ? $query->row()->amount : 0;
                            ?>
                        </p>
                    </div>
                </div>
                <div class="widget widget-stats bg-blue">
                    <div class="stats-icon"><i class="fa fa-credit-card"></i></div>
                    <div class="stats-info">
                        <h4><b>Total Rents of <?php echo $tenant_name; ?></b></h4>
                        <p>
                            <?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>
                            <?php
                            $this->db->select_sum('amount');
                            $this->db->from('tenant_rent');
                            $this->db->where('tenant_id', $tenant_id);
                            $query = $this->db->get();

                            echo $query->row()->amount > 0 ? $query->row()->amount : 0;
                            ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <!-- end col-3 -->
    </div>
    <!-- end row -->
</div>
<!-- end #content -->

<script>
    function showInvoiceModal(invoice_id) {
        $.ajax({
            url: "<?php echo base_url(); ?>generate_invoice_pdf/" + invoice_id,
            success: function(result) {
                // console.log(result);
            }
        });

        showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_show_invoice_pdf/' + invoice_id);
    }

    function showSingleTenantInvoices() {
        var tenant_id = $("#tenant_id").val();

        url = "<?php echo base_url(); ?>single_tenant_invoices/" + tenant_id;

        window.location = url;
    }
</script>