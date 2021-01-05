<!doctype html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding-top: 30px;
            /* border: 1px solid #eee; */
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(4) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 24px;
            line-height: 24px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(4) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(4) {
            text-align: left;
        }
    </style>
</head>

<body>
    <?php
    $tenant_id = $this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->tenant_id;
    $invoice_type = $this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->invoice_type;
    $tenant_rents = $this->db->get_where('tenant_rent', array('invoice_id' => $invoice_id))->result_array();

    $invoice_total = 0;
    ?>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                <?php echo $this->db->get_where('setting', array('name' => 'tagline'))->row()->content; ?>
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                Invoice #: <?php echo $this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->invoice_number; ?><br>
                                Created: <?php echo date('F d, Y', $this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->created_on); ?><br>
                                Due: <?php echo date('F d, Y', $this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->due_date); ?><br>
                                Status: <?php echo $this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->status ? 'Paid' : 'Due'; ?><br>
                                Late Fee: <?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content . ' ' . $late_fee = $this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->late_fee; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                <?php echo html_escape($this->db->get_where('setting', array('name' => 'system_name'))->row()->content); ?><br>
                                <?php echo $this->db->get_where('setting', array('name' => 'address'))->row()->content; ?>
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <?php echo $this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->tenant_name; ?><br>
                                <?php echo $this->db->get_where('tenant', array('tenant_id' => $tenant_id))->row()->work_address; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Description</td>
                <?php if ($invoice_type == 0) : ?>
                    <td>Starting Date</td>
                    <td>Ending Date</td>
                <?php else : ?>
                    <td>Month</td>
                    <td>Year</td>
                <?php endif; ?>
                <td>Row Total</td>
            </tr>
            <?php if ($invoice_type == 0) : ?>
                <?php // foreach ($tenant_rents as $tenant_rent) : 
                ?>
                <tr class="item">
                    <td>Date Range Rent</td>
                    <td><?php echo date('d M, Y', $this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->start_date); ?></td>
                    <td><?php echo date('d M, Y', $this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->end_date); ?></td>
                    <td>
                        <?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>
                        <?php
                        $this->db->select_sum('amount');
                        $this->db->from('tenant_rent');
                        $this->db->where('invoice_id', $invoice_id);
                        $query = $this->db->get();

                        $invoice_total += $query->row()->amount;

                        echo $query->row()->amount;
                        ?>
                    </td>
                </tr>
                <?php // endforeach; 
                ?>
            <?php else : ?>
                <?php foreach ($tenant_rents as $tenant_rent) : ?>
                    <tr class="item">
                        <td>Monthly Rent</td>
                        <td><?php echo $tenant_rent['month']; ?></td>
                        <td><?php echo $tenant_rent['year']; ?></td>
                        <td>
                            <?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>
                            <?php 
                                $invoice_total += $tenant_rent['amount'];
                                echo $tenant_rent['amount']; 
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>

            <tr class="total">
                <td></td>
                <td></td>
                <td></td>
                <td>Total: <?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content . ' ' . ($invoice_total + $late_fee); ?></td>
            </tr>
        </table>
    </div>
</body>

</html>