<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Add Room</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">
        Add new room here
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
                    <?php echo form_open('rooms/add', array('method' => 'post', 'data-parsley-validate' => 'ture')); ?>
                    <div class="form-group">
                        <label>Room Number/Name *</label>
                        <input type="text" name="room_number" placeholder="Enter room number or name" data-parsley-required="true" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Daily Rent (<?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>) *</label>
                        <input type="text" data-parsley-required="true" data-parsley-type="number" name="daily_rent" placeholder="Enter daily rent for generating invoice for daily guests" class="form-control" min="0">
                    </div>
                    <div class="form-group">
                        <label>Monthly Rent (<?php echo $this->db->get_where('setting', array('name' => 'currency'))->row()->content; ?>) *</label>
                        <input type="text" data-parsley-required="true" data-parsley-type="number" name="monthly_rent" placeholder="Enter monthly rent for generating invoice for monthly guests" class="form-control" min="0">
                    </div>
                    <div class="form-group">
                        <label>Floor Number</label>
                        <input type="text" name="floor" placeholder="Enter floor number" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Remarks</label>
                        <textarea style="resize: none" type="text" name="remarks" placeholder="Enter remarks" class="form-control"></textarea>
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