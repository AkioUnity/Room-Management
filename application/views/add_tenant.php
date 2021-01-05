<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Add Tenant</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">
        Add new tenant here
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
                    <?php echo form_open_multipart('tenants/add', array('method' => 'post', 'data-parsley-validate' => 'true')); ?>
                    <div class="form-group">
                        <label>Name *</label>
                        <input type="text" name="name" placeholder="Enter name" class="form-control" data-parsley-required="true">
                    </div>
                    <div class="form-group">
                        <label>Mobile *</label>
                        <input type="text" name="mobile_number" placeholder="Enter mobile number" class="form-control" data-parsley-required="true">
                    </div>
                    <div class="form-group">
                        <label>Email (For tenant login)</label>
                        <input type="email" name="email" placeholder="Enter email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Password (For tenant login)</label>
                        <input type="text" name="password" id="password-indicator-visible" class="form-control m-b-5">
                        <div id="passwordStrengthDiv2" class="is0 m-t-5"></div>
                    </div>
                    <div class="note note-yellow m-b-15">
                        <span>Default password for login is: 123456</span>
                    </div>
                    <div class="form-group">
                        <label>Tenant Image</label>
                        <br>
                        <span class="btn btn-primary fileinput-button">
                            <i class="fa fa-plus"></i>
                            <span>Add file</span>
                            <input class="form-control" type="file" name="image_link">
                        </span>
                    </div>
                    <div class="form-group">
                        <label>ID Type</label>
                        <select style="width: 100%" class="form-control default-select2" name="id_type_id">
                            <option value="">Select ID Type</option>
                            <?php
                            $id_types = $this->db->get('id_type')->result_array();
                            foreach ($id_types as $id_type) :
                            ?>
                                <option value="<?php echo html_escape($id_type['id_type_id']); ?>"><?php echo html_escape($id_type['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>ID Number</label>
                        <input name="id_number" type="text" placeholder="Enter ID number" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>ID Image</label>
                        <br>
                        <span class="btn btn-primary fileinput-button">
                            <i class="fa fa-plus"></i>
                            <span>Add file front</span>
                            <input class="form-control" type="file" name="id_front_image_link">
                        </span>
                        <br><br>
                        <span class="btn btn-primary fileinput-button">
                            <i class="fa fa-plus"></i>
                            <span>Add file back</span>
                            <input class="form-control" type="file" name="id_back_image_link">
                        </span>
                    </div>
                    <div class="form-group">
                        <label>Lease period</label>
                        <div class="input-group input-daterange">
                            <input type="text" class="form-control" name="lease_start" placeholder="Date Start" />
                            <span class="input-group-addon">to</span>
                            <input type="text" class="form-control" name="lease_end" placeholder="Date End" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Home Address</label>
                        <input name="home_address_line_1" type="text" placeholder="Enter home address line 1" class="form-control">
                    </div>
                    <div class="form-group">
                        <input name="home_address_line_2" type="text" placeholder="Enter home address line 2" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Emergency Person</label>
                        <input type="text" name="emergency_person" placeholder="Enter emergency person's name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Emergency Contact</label>
                        <input type="text" name="emergency_contact" placeholder="Enter emergency person's mobile number" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Room</label>
                        <select style="width: 100%" class="form-control default-select2" name="room_id">
                            <option value="">Select room</option>
                            <?php
                            $rooms = $this->db->get_where('room', array('status' => 0))->result_array();
                            foreach ($rooms as $room) :
                            ?>
                                <option value="<?php echo html_escape($room['room_id']); ?>"><?php echo html_escape($room['room_number']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="note note-yellow m-b-15">
                        <span>To assign a room, You must activate the tenant.</span>
                    </div>
                    <div class="form-group">
                        <label>Profession</label>
                        <select style="width: 100%" class="form-control default-select2" name="profession_id">
                            <option value="">Select profession</option>
                            <?php
                            $professions = $this->db->get('profession')->result_array();
                            foreach ($professions as $profession) :
                            ?>
                                <option value="<?php echo html_escape($profession['profession_id']); ?>"><?php echo html_escape($profession['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Work/Institution Address</label>
                        <input name="work_address_line_1" type="text" placeholder="Enter work/Institution address line 1" class="form-control">
                    </div>
                    <div class="form-group">
                        <input name="work_address_line_2" type="text" placeholder="Enter work/Institution address line 2" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Status *</label>
                        <select style="width: 100%" class="form-control default-select2" data-parsley-required="true" name="status">
                            <option value="">Select status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="note note-yellow m-b-15">
                        <span>To activate a tenant, You must assign a room.</span>
                    </div>
                    <div class="form-group">
                        <label>Extra Note</label>
                        <textarea style="resize: none" type="text" name="extra_note" placeholder="Enter extra note" class="form-control"></textarea>
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