<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model extends CI_Model
{
	function add_room()
	{
		$rooms 							= 	$this->db->get('room')->result_array();
		foreach ($rooms as $room) {
			if ($room['room_number'] == $this->input->post('room_number') && $room['floor'] == $this->input->post('floor')) {
				$this->session->set_flashdata('warning', 'Room in the same floor already exists.');

				redirect(base_url() . 'add_room', 'refresh');
			}
		}

		$data['room_number']			=	$this->input->post('room_number');
		$data['daily_rent']				=	$this->input->post('daily_rent');
		$data['monthly_rent']			=	$this->input->post('monthly_rent');
		$data['status']					=	0;
		$data['floor']					=	$this->input->post('floor');
		$data['remarks']				=	$this->input->post('remarks');
		$data['created_on']				=	time();
		$data['created_by']				=	$this->session->userdata('user_id');
		$data['timestamp']				=	time();
		$data['updated_by']				=	$this->session->userdata('user_id');

		$this->db->insert('room', $data);

		$this->session->set_flashdata('success', 'New room has been added successfully.');

		redirect(base_url() . 'rooms', 'refresh');
	}

	function update_room($room_id = '')
	{
		$existing_room_number 			=	$this->db->get_where('room', array('room_id' => $room_id))->row()->room_number;
		$existing_floor_number			=	$this->db->get_where('room', array('room_id' => $room_id))->row()->floor;

		if ($existing_room_number != $this->input->post('room_number') || $existing_floor_number != $this->input->post('floor')) {
			$rooms 							= 	$this->db->get('room')->result_array();
			foreach ($rooms as $room) {
				if ($room['room_number'] == $this->input->post('room_number') && $room['floor'] == $this->input->post('floor')) {
					$this->session->set_flashdata('warning', 'Room in the same floor already exists.');

					redirect(base_url() . 'rooms', 'refresh');
				}
			}
		}

		$data['room_number']			=	$this->input->post('room_number');
		$data['daily_rent']				=	$this->input->post('daily_rent');
		$data['monthly_rent']			=	$this->input->post('monthly_rent');
		$data['floor']					=	$this->input->post('floor');
		$data['remarks']				=	$this->input->post('remarks');
		$data['timestamp']				=	time();
		$data['updated_by']				=	$this->session->userdata('user_id');

		$this->db->where('room_id', $room_id);
		$this->db->update('room', $data);

		$this->session->set_flashdata('success', 'Room has been updated successfully.');

		redirect(base_url() . 'rooms', 'refresh');
	}

	function remove_room($room_id = '')
	{
		$this->db->where('room_id', $room_id);
		$this->db->delete('room');

		$this->session->set_flashdata('success', 'Room has been deleted successfully.');

		redirect(base_url() . 'rooms', 'refresh');
	}

	function assign_tenant($room_id = '')
	{
		$data['status']			=	1;
		$data['timestamp']		=	time();
		$data['updated_by']		=	$this->session->userdata('user_id');

		$this->db->where('room_id', $room_id);
		$this->db->update('room', $data);

		$data2['room_id']		=	$room_id;
		$data2['status']		=	1;
		$data2['timestamp']		=	time();
		$data2['updated_by']	=	$this->session->userdata('user_id');

		$this->db->where('tenant_id', $this->input->post('tenant_id'));
		$this->db->update('tenant', $data2);

		$array = array('user_type' => 3, 'person_id' => $this->input->post('tenant_id'));
		$this->db->where($array);
		$this->db->update('user', $data);

		$this->session->set_flashdata('success', 'Room has been assigned to tenant successfully.');

		redirect(base_url() . 'rooms', 'refresh');
	}

	function vacant_room($room_id = '')
	{
		$data['status']			=	0;
		$data['timestamp']		=	time();
		$data['updated_by']		=	$this->session->userdata('user_id');

		$this->db->where('room_id', $room_id);
		$this->db->update('room', $data);

		$tenant_id 				=	$this->db->get_where('tenant', array('room_id' => $room_id))->row()->tenant_id;

		$data2['room_id']		=	0;
		$data2['status']		=	0;
		$data2['timestamp']		=	time();
		$data2['updated_by']	=	$this->session->userdata('user_id');

		$this->db->where('tenant_id', $tenant_id);
		$this->db->update('tenant', $data2);

		$this->session->set_flashdata('success', 'Room is now vacant.');

		redirect(base_url() . 'rooms', 'refresh');
	}

	function add_tenant()
	{
		$ext 							= 	pathinfo($_FILES['image_link']['name'], PATHINFO_EXTENSION);
		$ext_id_front 					= 	pathinfo($_FILES['id_front_image_link']['name'], PATHINFO_EXTENSION);
		$ext_id_back 					= 	pathinfo($_FILES['id_back_image_link']['name'], PATHINFO_EXTENSION);

		$users = $this->db->get('user')->result_array();
		foreach ($users as $user) {
			if ($user['email'] == $this->input->post('email')) {
				$this->session->set_flashdata('warning', 'The email address is already registered.');

				redirect(base_url() . 'add_tenant', 'refresh');
			}
		}

		if ($this->input->post('status') && !($this->input->post('room_id'))) {
			$this->session->set_flashdata('warning', 'To activate a tenant, You must assign a room.');

			redirect(base_url() . 'add_tenant', 'refresh');
		} elseif (!($this->input->post('status')) && $this->input->post('room_id')) {
			$this->session->set_flashdata('warning', 'To assign a room, You must activate the tenant.');

			redirect(base_url() . 'add_tenant', 'refresh');
		} else {
			if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
				$data['image_link'] 			= 	strtolower(explode(" ", $this->input->post('name'))[0]) . '_' . time() . '.' . $ext;

				move_uploaded_file($_FILES['image_link']['tmp_name'], 'uploads/tenants/' . $data['image_link']);
			}

			if ($ext_id_front == 'jpeg' || $ext_id_front == 'jpg' || $ext_id_front == 'png' || $ext_id_front == 'JPEG' || $ext_id_front == 'JPG' || $ext_id_front == 'PNG') {
				$data['id_front_image_link'] 	= 	strtolower(explode(" ", $this->input->post('name'))[0]) . '_id_front_' . time() . '.' . $ext_id_front;

				move_uploaded_file($_FILES['id_front_image_link']['tmp_name'], 'uploads/tenants/' . $data['id_front_image_link']);
			}

			if ($ext_id_back == 'jpeg' || $ext_id_back == 'jpg' || $ext_id_back == 'png' || $ext_id_back == 'JPEG' || $ext_id_back == 'JPG' || $ext_id_back == 'PNG') {
				$data['id_back_image_link'] 	= 	strtolower(explode(" ", $this->input->post('name'))[0]) . '_id_back_' . time() . '.' . $ext_id_back;

				move_uploaded_file($_FILES['id_back_image_link']['tmp_name'], 'uploads/tenants/' . $data['id_back_image_link']);
			}

			$data['name']				=	$this->input->post('name');
			$data['mobile_number']		=	$this->input->post('mobile_number');
			$data['email']				=	$this->input->post('email');
			$data['id_type_id']			=	$this->input->post('id_type_id');
			$data['id_number']			=	$this->input->post('id_number');
			$data['home_address']		=	$this->input->post('home_address_line_1') . '<br>' . $this->input->post('home_address_line_2');
			$data['emergency_person']	=	$this->input->post('emergency_person');
			$data['emergency_contact']	=	$this->input->post('emergency_contact');
			$data['room_id']			=	$this->input->post('room_id') ? $this->input->post('room_id') : 0;

			if ($this->input->post('lease_start') && $this->input->post('lease_end')) {
				$data['lease_start']		=	strtotime($this->input->post('lease_start'));
				$data['lease_end']			=	strtotime($this->input->post('lease_end'));
			}

			$data['profession_id']		=	$this->input->post('profession_id');
			$data['work_address']		=	$this->input->post('work_address_line_1') . '<br>' . $this->input->post('work_address_line_2');
			$data['status']				=	$this->input->post('status');
			$data['extra_note']			=	$this->input->post('extra_note');
			$data['created_on']			=	time();
			$data['created_by']			=	$this->session->userdata('user_id');
			$data['timestamp']			=	time();
			$data['updated_by']			=	$this->session->userdata('user_id');

			$this->db->insert('tenant', $data);

			if ($this->input->post('email')) {
				$data2['person_id']		=	$this->db->insert_id();
				$data2['email']			=	$this->input->post('email');
				$data2['password']		=	$this->input->post('password') ? password_hash($this->input->post('password'), PASSWORD_DEFAULT) : password_hash(123456, PASSWORD_DEFAULT);
				$data2['user_type']		=	3;
				$data2['status']		=	$this->input->post('status');
				$data2['created_on']	= 	time();
				$data2['created_by']	=	$this->session->userdata('user_id');
				$data2['timestamp']		=	time();
				$data2['updated_by']	=	$this->session->userdata('user_id');
				$data2['permissions']	=	'10,13,14';

				$this->db->insert('user', $data2);
			}

			if ($this->input->post('room_id')) {
				$data3['status']		=	1;
				$data3['timestamp']		=	time();
				$data3['updated_by']	=	$this->session->userdata('user_id');

				$this->db->where('room_id', $data['room_id']);
				$this->db->update('room', $data3);
			}

			$this->session->set_flashdata('success', 'New tenant has been added successfully.');

			redirect(base_url() . 'tenants', 'refresh');
		}
	}

	function change_tenant_image($tenant_id = '')
	{
		$ext 							= 	pathinfo($_FILES['image_link']['name'], PATHINFO_EXTENSION);

		if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
			$image_link 				= 	$this->db->get_where('tenant', array('tenant_id' => $tenant_id))->row()->image_link;

			if (isset($image_link)) unlink('uploads/tenants/' . $image_link);

			$tenant_name 				=	$this->db->get_where('tenant', array('tenant_id' => $tenant_id))->row()->name;

			$data['image_link'] 		= 	strtolower(explode(" ", $tenant_name)[0]) . '_' . time() . '.' . $ext;
			$data['timestamp']			=	time();
			$data['updated_by']			=	$this->session->userdata('user_id');

			move_uploaded_file($_FILES['image_link']['tmp_name'], 'uploads/tenants/' . $data['image_link']);

			$this->db->where('tenant_id', $tenant_id);
			$this->db->update('tenant', $data);

			$this->session->set_flashdata('success', 'Tenant image has been updated successfully.');

			redirect(base_url() . 'tenants', 'refresh');
		} else {
			$this->session->set_flashdata('warning', 'Only supported image types: jpeg, jpg, png');

			redirect(base_url() . 'tenants', 'refresh');
		}
	}

	function change_tenant_id_image($tenant_id = '')
	{
		$ext_id_front 					= 	pathinfo($_FILES['id_front_image_link']['name'], PATHINFO_EXTENSION);
		$ext_id_back 					= 	pathinfo($_FILES['id_back_image_link']['name'], PATHINFO_EXTENSION);

		if ($ext_id_front == 'jpeg' || $ext_id_front == 'jpg' || $ext_id_front == 'png' || $ext_id_front == 'JPEG' || $ext_id_front == 'JPG' || $ext_id_front == 'PNG') {
			$image_link 				= 	$this->db->get_where('tenant', array('tenant_id' => $tenant_id))->row()->id_front_image_link;

			if (isset($image_link)) unlink('uploads/tenants/' . $image_link);

			$tenant_name 				=	$this->db->get_where('tenant', array('tenant_id' => $tenant_id))->row()->name;

			$data['id_front_image_link'] = 	strtolower(explode(" ", $tenant_name)[0]) . '_id_front_' . time() . '.' . $ext_id_front;
			$data['timestamp']			=	time();
			$data['updated_by']			=	$this->session->userdata('user_id');

			move_uploaded_file($_FILES['id_front_image_link']['tmp_name'], 'uploads/tenants/' . $data['id_front_image_link']);

			$this->db->where('tenant_id', $tenant_id);
			$this->db->update('tenant', $data);

			$this->session->set_flashdata('success', 'Tenant ID front image has been updated successfully.');
		} else {
			$this->session->set_flashdata('warning', 'Only supported image types: jpeg, jpg, png');
		}

		if ($ext_id_back == 'jpeg' || $ext_id_back == 'jpg' || $ext_id_back == 'png' || $ext_id_back == 'JPEG' || $ext_id_back == 'JPG' || $ext_id_back == 'PNG') {
			$image_link 				= 	$this->db->get_where('tenant', array('tenant_id' => $tenant_id))->row()->id_back_image_link;

			if (isset($image_link)) unlink('uploads/tenants/' . $image_link);

			$tenant_name 				=	$this->db->get_where('tenant', array('tenant_id' => $tenant_id))->row()->name;

			$data['id_back_image_link'] = 	strtolower(explode(" ", $tenant_name)[0]) . '_id_back_' . time() . '.' . $ext_id_back;
			$data['timestamp']			=	time();
			$data['updated_by']			=	$this->session->userdata('user_id');

			move_uploaded_file($_FILES['id_back_image_link']['tmp_name'], 'uploads/tenants/' . $data['id_back_image_link']);

			$this->db->where('tenant_id', $tenant_id);
			$this->db->update('tenant', $data);

			$this->session->set_flashdata('success', 'Tenant ID back image has been updated successfully.');
		} else {
			$this->session->set_flashdata('warning', 'Only supported image types: jpeg, jpg, png');
		}

		redirect(base_url() . 'tenants', 'refresh');
	}

	function update_tenant($tenant_id = '')
	{
		$existing_room_id 				=	$this->db->get_where('tenant', array('tenant_id' => $tenant_id))->row()->room_id;

		if ($this->input->post('status') && !($this->input->post('room_id'))) {
			$this->session->set_flashdata('warning', 'To activate a tenant, You must assign a room.');

			redirect(base_url() . 'tenants', 'refresh');
		} elseif (!($this->input->post('status')) && $this->input->post('room_id')) {
			$this->session->set_flashdata('warning', 'To assign a room, You must activate the tenant.');

			redirect(base_url() . 'tenants', 'refresh');
		} elseif (!($this->input->post('status')) && !($this->input->post('room_id'))) {
			$data4['status']			=	0;
			$data4['timestamp']			=	time();
			$data4['updated_by']		=	$this->session->userdata('user_id');

			$this->db->where('room_id', $existing_room_id);
			$this->db->update('room', $data4);

			$data['room_id ']			= 	0;
		} else {
			if ($existing_room_id != $this->input->post('room_id')) {
				if ($existing_room_id > 0) {
					$data2['status']		=	0;
					$data2['timestamp']		=	time();
					$data2['updated_by']	=	$this->session->userdata('user_id');

					$this->db->where('room_id', $existing_room_id);
					$this->db->update('room', $data2);
				}

				$data3['status']		=	1;
				$data3['timestamp']		=	time();
				$data3['updated_by']	=	$this->session->userdata('user_id');

				$this->db->where('room_id', $this->input->post('room_id'));
				$this->db->update('room', $data3);

				$data['room_id ']		= 	$this->input->post('room_id');
			}
		}

		$data['name']					=	$this->input->post('name');
		$data['mobile_number']			=	$this->input->post('mobile_number');
		$data['email']					=	$this->input->post('email');
		$data['id_type_id']				=	$this->input->post('id_type_id');
		$data['id_number']				=	$this->input->post('id_number');
		$data['home_address']			=	$this->input->post('home_address_line_1') . '<br>' . $this->input->post('home_address_line_2');
		$data['emergency_person']		=	$this->input->post('emergency_person');
		$data['emergency_contact']		=	$this->input->post('emergency_contact');
		$data['profession_id']			=	$this->input->post('profession_id');
		$data['work_address']			=	$this->input->post('work_address_line_1') . '<br>' . $this->input->post('work_address_line_2');
		$data['status']					=	$this->input->post('status');
		$data['extra_note']				=	$this->input->post('extra_note');
		$data['timestamp']				=	time();
		$data['updated_by']				=	$this->session->userdata('user_id');

		if ($this->input->post('lease_start') && $this->input->post('lease_end')) {
			$data['lease_start']		=	strtotime($this->input->post('lease_start'));
			$data['lease_end']			=	strtotime($this->input->post('lease_end'));
		}

		$this->db->where('tenant_id', $tenant_id);
		$this->db->update('tenant', $data);

		if ($this->input->post('email')) {
			if ($this->db->get_where('user', array('user_type' => 3, 'person_id' => $tenant_id))->num_rows() > 0) {
				$data2['email']					=	$this->input->post('email');
				$data2['status']				=	$this->input->post('status');
				$data2['timestamp']				=	time();
				$data2['updated_by']			=	$this->session->userdata('user_id');

				$array = array('user_type' => 3, 'person_id' => $tenant_id);
				$this->db->where($array);
				$this->db->update('user', $data2);
			} else {
				$data2['person_id']			=	$tenant_id;
				$data2['email']				=	$this->input->post('email');
				$data2['password']			=	$this->input->post('password') ? password_hash($this->input->post('password'), PASSWORD_DEFAULT) : password_hash(123456, PASSWORD_DEFAULT);
				$data2['user_type']			=	3;
				$data2['status']			=	$this->input->post('status');
				$data2['created_on']		= 	time();
				$data2['created_by']		=	$this->session->userdata('user_id');
				$data2['timestamp']			=	time();
				$data2['updated_by']		=	$this->session->userdata('user_id');
				$data2['permissions']		=	'10,13,14';

				$this->db->insert('user', $data2);
			}
		}

		$this->session->set_flashdata('success', 'Tenant has been updated successfully.');

		redirect(base_url() . 'tenants', 'refresh');
	}

	function deactivate_tenant($tenant_id = '')
	{
		$room_id 						=	$this->db->get_where('tenant', array('tenant_id' => $tenant_id))->row()->room_id;

		$data['status']					=	0;
		$data['timestamp']				=	time();
		$data['updated_by']				=	$this->session->userdata('user_id');

		if ($room_id) {
			$this->db->where('room_id', $room_id);
			$this->db->update('room', $data);
		}

		$data2['room_id']				=	0;
		$data2['status']				=	0;
		$data2['timestamp']				=	time();
		$data2['updated_by']			=	$this->session->userdata('user_id');

		$this->db->where('tenant_id', $tenant_id);
		$this->db->update('tenant', $data2);

		if ($this->db->get_where('user', array('user_type' => 3, 'person_id' => $tenant_id))->num_rows() > 0) {
			$array = array('user_type' => 3, 'person_id' => $tenant_id);
			$this->db->where($array);
			$this->db->update('user', $data);
		}

		$this->session->set_flashdata('success', 'Tenant has been deactivated successfully.');

		redirect(base_url() . 'tenants', 'refresh');
	}

	function remove_tenant($tenant_id = '')
	{
		$room_id 						=	$this->db->get_where('tenant', array('tenant_id' => $tenant_id))->row()->room_id;

		$data['status']					=	0;
		$data['timestamp']				=	time();
		$data['updated_by']				=	$this->session->userdata('user_id');

		if ($room_id) {
			$this->db->where('room_id', $room_id);
			$this->db->update('room', $data);
		}

		$image_link 					= 	$this->db->get_where('tenant', array('tenant_id' => $tenant_id))->row()->image_link;

		if (isset($image_link)) unlink('uploads/tenants/' . $image_link);

		$this->db->where('tenant_id', $tenant_id);
		$this->db->delete('tenant');

		if ($this->db->get_where('user', array('user_type' => 3, 'person_id' => $tenant_id))->num_rows() > 0) {
			$array = array('user_type' => 3, 'person_id' => $tenant_id);
			$this->db->where($array);
			$this->db->delete('user');
		}

		$this->session->set_flashdata('success', 'Tenant has been deleted successfully.');

		redirect(base_url() . 'tenants', 'refresh');
	}

	function add_utility_bill()
	{
		$ext 								= 	pathinfo($_FILES['image_link']['name'], PATHINFO_EXTENSION);

		if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
			$data['image_link'] 			= 	'utility_' . $this->input->post('year') . '_' . $this->input->post('month') . '_' . time() . '.' . $ext;

			move_uploaded_file($_FILES['image_link']['tmp_name'], 'uploads/bills/' . $data['image_link']);
		}

		$data['utility_bill_category_id']	=	$this->input->post('utility_bill_category_id');
		$data['year']						=	$this->input->post('year');
		$data['month']						=	$this->input->post('month');
		$data['amount']						=	$this->input->post('amount');
		$data['status']						=	$this->input->post('status');
		$data['created_on']					=	time();
		$data['created_by']					=	$this->session->userdata('user_id');
		$data['timestamp']					=	time();
		$data['updated_by']					=	$this->session->userdata('user_id');

		$this->db->insert('utility_bill', $data);

		$this->session->set_flashdata('success', 'New utility bill has been added successfully.');

		redirect(base_url() . 'utility_bills', 'refresh');
	}

	function update_utility_bill($utility_bill_id = '')
	{
		$data['utility_bill_category_id']	=	$this->input->post('utility_bill_category_id');
		$data['year']						=	$this->input->post('year');
		$data['month']						=	$this->input->post('month');
		$data['amount']						=	$this->input->post('amount');
		$data['status']						=	$this->input->post('status');
		$data['timestamp']					=	time();
		$data['updated_by']					=	$this->session->userdata('user_id');

		$this->db->where('utility_bill_id', $utility_bill_id);
		$this->db->update('utility_bill', $data);

		$this->session->set_flashdata('success', 'Utility bill has been updated successfully.');

		redirect(base_url() . 'utility_bills', 'refresh');
	}

	function change_utility_image($utility_bill_id = '')
	{
		$ext 							= 	pathinfo($_FILES['image_link']['name'], PATHINFO_EXTENSION);

		if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
			$image_link 				= 	$this->db->get_where('utility_bill', array('utility_bill_id' => $utility_bill_id))->row()->image_link;

			if (isset($image_link)) unlink('uploads/bills/' . $image_link);

			$year 						=	$this->db->get_where('utility_bill', array('utility_bill_id' => $utility_bill_id))->row()->year;
			$month 						=	$this->db->get_where('utility_bill', array('utility_bill_id' => $utility_bill_id))->row()->month;

			$data['image_link'] 		= 	'utility_' . $year . '_' . $month . '_' . time() . '.' . $ext;
			$data['timestamp']			=	time();
			$data['updated_by']			=	$this->session->userdata('user_id');

			move_uploaded_file($_FILES['image_link']['tmp_name'], 'uploads/bills/' . $data['image_link']);

			$this->db->where('utility_bill_id', $utility_bill_id);
			$this->db->update('utility_bill', $data);

			$this->session->set_flashdata('success', 'Utility image has been updated successfully.');

			redirect(base_url() . 'utility_bills', 'refresh');
		} else {
			$this->session->set_flashdata('warning', 'Only supported image types: jpeg, jpg, png');

			redirect(base_url() . 'utility_bills', 'refresh');
		}
	}

	function remove_utility_bill($utility_bill_id = '')
	{
		$this->db->where('utility_bill_id', $utility_bill_id);
		$this->db->delete('utility_bill');

		$this->session->set_flashdata('success', 'Utility bill has been deleted successfully.');

		redirect(base_url() . 'utility_bills', 'refresh');
	}

	// Function related to adding utility bill category
	function add_utility_bill_category()
	{
		$data['name']					=	$this->input->post('name');
		$data['created_on']				=	time();
		$data['created_by']				=	$this->session->userdata('user_id');
		$data['timestamp']				=	time();
		$data['updated_by']				=	$this->session->userdata('user_id');

		$this->db->insert('utility_bill_category', $data);

		$this->session->set_flashdata('success', 'New utility bill category has been added successfully.');

		redirect(base_url() . 'utility_bill_categories', 'refresh');
	}

	// Function related to updating utility bill category
	function update_utility_bill_category($utility_bill_category_id = '')
	{
		$data['name']					=	$this->input->post('name');
		$data['timestamp']				=	time();
		$data['updated_by']				=	$this->session->userdata('user_id');

		$this->db->where('utility_bill_category_id', $utility_bill_category_id);
		$this->db->update('utility_bill_category', $data);

		$this->session->set_flashdata('success', 'Utility bill category has been updated successfully.');

		redirect(base_url() . 'utility_bill_categories', 'refresh');
	}

	// Function related to removing utility bill category
	function remove_utility_bill_category($utility_bill_category_id = '')
	{
		$this->db->where('utility_bill_category_id', $utility_bill_category_id);
		$this->db->delete('utility_bill_category');

		$this->session->set_flashdata('success', 'Utility bill category has been deleted successfully.');

		redirect(base_url() . 'utility_bill_categories', 'refresh');
	}

	function add_expense()
	{
		$data['name']						=	$this->input->post('name');
		$data['amount']						=	$this->input->post('amount');
		$data['description']				=	$this->input->post('description');
		$data['year']						=	$this->input->post('year');
		$data['month']						=	$this->input->post('month');
		$data['created_on']					=	time();
		$data['created_by']					=	$this->session->userdata('user_id');
		$data['timestamp']					=	time();
		$data['updated_by']					=	$this->session->userdata('user_id');

		$this->db->insert('expense', $data);

		$this->session->set_flashdata('success', 'New expense has been added successfully.');

		redirect(base_url() . 'expenses', 'refresh');
	}

	function update_expense($expense_id = '')
	{
		$data['name']						=	$this->input->post('name');
		$data['amount']						=	$this->input->post('amount');
		$data['description']				=	$this->input->post('description');
		$data['year']						=	$this->input->post('year');
		$data['month']						=	$this->input->post('month');
		$data['timestamp']					=	time();
		$data['updated_by']					=	$this->session->userdata('user_id');

		$this->db->where('expense_id', $expense_id);
		$this->db->update('expense', $data);

		$this->session->set_flashdata('success', 'Expense has been updated successfully.');

		redirect(base_url() . 'expenses', 'refresh');
	}

	function remove_expense($expense_id = '')
	{
		$this->db->where('expense_id', $expense_id);
		$this->db->delete('expense');

		$this->session->set_flashdata('success', 'Expense has been deleted successfully.');

		redirect(base_url() . 'expenses', 'refresh');
	}

	function add_staff()
	{
		$users = $this->db->get('user')->result_array();
		foreach ($users as $user) {
			if ($user['email'] == $this->input->post('email')) {
				$this->session->set_flashdata('warning', 'The email address is already registered.');

				redirect(base_url() . 'add_staff', 'refresh');
			}
		}

		$data['name']					=	$this->input->post('name');
		$data['role']					=	$this->input->post('role');
		$data['mobile_number']			=	$this->input->post('mobile_number');
		$data['status']					=	$this->input->post('status');
		$data['remarks']				=	$this->input->post('remarks');
		$data['created_on']				= 	time();
		$data['created_by']				=	$this->session->userdata('user_id');
		$data['timestamp']				=	time();
		$data['updated_by']				=	$this->session->userdata('user_id');

		$this->db->insert('staff', $data);

		if ($this->input->post('email')) {
			$data2['person_id']				=	$this->db->insert_id();
			$data2['email']					=	$this->input->post('email');
			$data2['password']				=	$this->input->post('password') ? password_hash($this->input->post('password'), PASSWORD_DEFAULT) : password_hash(123456, PASSWORD_DEFAULT);
			$data2['user_type']				=	2;
			$data2['status']				=	$this->input->post('status');
			$data2['created_on']			= 	time();
			$data2['created_by']			=	$this->session->userdata('user_id');
			$data2['timestamp']				=	time();
			$data2['updated_by']			=	$this->session->userdata('user_id');

			$this->db->insert('user', $data2);
		}

		$this->session->set_flashdata('success', 'New staff has been added successfully.');

		redirect(base_url() . 'staff', 'refresh');
	}

	function update_staff($staff_id = '')
	{
		$data['name']					=	$this->input->post('name');
		$data['role']					=	$this->input->post('role');
		$data['mobile_number']			=	$this->input->post('mobile_number');
		$data['status']					=	$this->input->post('status');
		$data['remarks']				=	$this->input->post('remarks');
		$data['timestamp']				=	time();
		$data['updated_by']				=	$this->session->userdata('user_id');

		$this->db->where('staff_id', $staff_id);
		$this->db->update('staff', $data);

		if ($this->input->post('email')) {
			if ($this->db->get_where('user', array('user_type' => 2, 'person_id' => $staff_id))->num_rows() > 0) {
				$data2['email']					=	$this->input->post('email');
				$data2['status']				=	$this->input->post('status');
				$data2['timestamp']				=	time();
				$data2['updated_by']			=	$this->session->userdata('user_id');

				$array = array('user_type' => 2, 'person_id' => $staff_id);
				$this->db->where($array);
				$this->db->update('user', $data2);
			} else {
				$data2['person_id']				=	$staff_id;
				$data2['email']					=	$this->input->post('email');
				$data2['password']				=	$this->input->post('password') ? password_hash($this->input->post('password'), PASSWORD_DEFAULT) : password_hash(123456, PASSWORD_DEFAULT);
				$data2['user_type']				=	2;
				$data2['status']				=	$this->input->post('status');
				$data2['created_on']			= 	time();
				$data2['created_by']			=	$this->session->userdata('user_id');
				$data2['timestamp']				=	time();
				$data2['updated_by']			=	$this->session->userdata('user_id');

				$this->db->insert('user', $data2);
			}
		}

		$this->session->set_flashdata('success', 'Staff has been updated successfully.');

		redirect(base_url() . 'staff', 'refresh');
	}

	function deactivate_staff($staff_id = '')
	{
		$data['status']					=	0;
		$data['timestamp']				=	time();
		$data['updated_by']				=	$this->session->userdata('user_id');

		$this->db->where('staff_id', $staff_id);
		$this->db->update('staff', $data);

		if ($this->db->get_where('user', array('user_type' => 2, 'person_id' => $staff_id))->num_rows() > 0) {
			$array = array('user_type' => 2, 'person_id' => $staff_id);
			$this->db->where($array);
			$this->db->update('user', $data);
		}

		$this->session->set_flashdata('success', 'Staff has been deactivated successfully.');

		redirect(base_url() . 'staff', 'refresh');
	}

	function remove_staff($staff_id = '')
	{
		$this->db->where('staff_id', $staff_id);
		$this->db->delete('staff');

		if ($this->db->get_where('user', array('user_type' => 2, 'person_id' => $staff_id))->num_rows() > 0) {
			$array = array('user_type' => 2, 'person_id' => $staff_id);
			$this->db->where($array);
			$this->db->delete('user');
		}

		$this->session->set_flashdata('success', 'Staff has been deleted successfully.');

		redirect(base_url() . 'staff', 'refresh');
	}

	function update_staff_permission($staff_id = '')
	{
		$permission 					= 	$this->input->post('permission');

		$permissions 					=	'';

		if (isset($permission)) {
			foreach ($permission as $key => $value) {
				$permissions			.=	$value . ',';
			}
		}

		$data['permissions']			=	substr(trim($permissions), 0, -1);
		$data['timestamp']				=	time();
		$data['updated_by']				=	$this->session->userdata('user_id');

		$array = array('user_type' => 2, 'person_id' => $staff_id);
		$this->db->where($array);
		$this->db->update('user', $data);

		$this->session->set_flashdata('success', 'Staff permission has been updated successfully.');

		redirect(base_url() . 'staff', 'refresh');
	}

	function add_staff_salary()
	{
		$data['staff_id']				=	$this->input->post('staff_id');
		$data['year']					=	$this->input->post('year');
		$data['month']					=	$this->input->post('month');
		$data['amount']					=	$this->input->post('amount');
		$data['status']					=	$this->input->post('status');
		$data['created_on']				= 	time();
		$data['created_by']				=	$this->session->userdata('user_id');
		$data['timestamp']				=	time();
		$data['updated_by']				=	$this->session->userdata('user_id');

		$this->db->insert('staff_salary', $data);

		$this->session->set_flashdata('success', 'New staff salary has been added successfully.');

		redirect(base_url('single_month_staff_payroll' . '/' . $data['year'] . '/' . $data['month']), 'refresh');
	}

	function update_staff_salary($staff_salary_id = '')
	{
		$data['staff_id']				=	$this->input->post('staff_id');
		$data['year']					=	$this->input->post('year');
		$data['month']					=	$this->input->post('month');
		$data['amount']					=	$this->input->post('amount');
		$data['status']					=	$this->input->post('status');
		$data['timestamp']				=	time();
		$data['updated_by']				=	$this->session->userdata('user_id');

		$this->db->where('staff_salary_id', $staff_salary_id);
		$this->db->update('staff_salary', $data);

		$this->session->set_flashdata('success', 'Staff salary has been updated successfully.');

		redirect(base_url() . 'staff_payroll', 'refresh');
	}

	function remove_staff_salary($staff_salary_id = '')
	{
		$this->db->where('staff_salary_id', $staff_salary_id);
		$this->db->delete('staff_salary');

		$this->session->set_flashdata('success', 'Staff salary has been deleted successfully.');

		redirect(base_url() . 'staff_payroll', 'refresh');
	}

	function generate_date_range_rents()
	{
		$tenant_id 						= 	$this->input->post('tenant_id');
		$start_date						=	strtotime($this->input->post('start'));
		$end_date						=	strtotime($this->input->post('end'));

		$room_id 						=	$this->db->get_where('tenant', array('tenant_id' => $tenant_id))->row()->room_id;
		$room_number					= 	$this->db->get_where('room', array('room_id' => $room_id))->row()->room_number;

		$start_year  					= 	date('Y', $start_date);
		$end_year  						= 	date('Y', $end_date);
		$start_month  					= 	date('n', $start_date);
		$end_month  					= 	date('n', $end_date);
		$start_day 						= 	date('d', $start_date);
		$end_day 						= 	date('d', $end_date);

		$invoice['tenant_name']			=	$this->db->get_where('tenant', array('tenant_id' => $tenant_id))->row()->name;
		$invoice['status']				=	$this->input->post('status');
		$invoice['start_date']			=	strtotime($this->input->post('start'));
		$invoice['end_date']			=	strtotime($this->input->post('end') . '11:59:59 pm');
		$invoice['due_date']			=	strtotime($this->input->post('due_date') . '11:59:59 pm');
		$invoice['invoice_type']		=	0;
		$invoice['tenant_mobile']		=	$this->db->get_where('tenant', array('tenant_id' => $tenant_id))->row()->mobile_number;
		$invoice['room_number']			=	$room_number;
		$invoice['tenant_id']			=	$tenant_id;
		$invoice['late_fee']			=	0;
		$invoice['invoice_number']		=	$start_year . $start_month . rand(1, 9999) . $tenant_id;
		$invoice['created_on']			= 	time();
		$invoice['created_by']			=	$this->session->userdata('user_id');
		$invoice['timestamp']			=	time();
		$invoice['updated_by']			=	$this->session->userdata('user_id');

		$this->db->insert('invoice', $invoice);

		$invoice_id						=	$this->db->insert_id();

		if ($start_year < $end_year) {
			$temp_end_month = $end_month;
			$end_month = 13;
			for ($i = $start_month; $i <= $end_month; $i++) {
				if ($i > 12) {
					$year = $end_year;
					$end_month = $temp_end_month;
					$i = 1;
				} else {
					$year = $start_year;
				}
				$month = date('F', strtotime($year . '-' . $i . '-01'));
				$days = date('t', strtotime($year . '-' . $month));

				if ($i == $start_month) {
					$days = $days - $start_day + 1;
				} elseif ($i == $end_month) {
					$days = $end_day;
				}

				$data['month']			=	$month;
				$data['year']			=	$year;
				$data['amount']			=	$days * $this->db->get_where('room', array('room_id' => $room_id))->row()->daily_rent;
				$data['invoice_id']		=	$invoice_id;
				$data['tenant_id']		=	$tenant_id;
				$data['created_on']		= 	time();
				$data['created_by']		=	$this->session->userdata('user_id');
				$data['timestamp']		=	time();
				$data['updated_by']		=	$this->session->userdata('user_id');
				$data['status']			=	$this->input->post('status');

				$this->db->insert('tenant_rent', $data);
			}
		} else {
			for ($i = $start_month; $i <= $end_month; $i++) {
				$year = $start_year;
				$month = date('F', strtotime($year . '-' . $i . '-01'));
				$days = date('t', strtotime($year . '-' . $month));

				if ($start_month == $end_month) {
					$days = $end_day - $start_day + 1;
				} elseif ($i == $start_month) {
					$days = $days - $start_day + 1;
				} elseif ($i == $end_month) {
					$days = $end_day;
				}

				$data['month']			=	$month;
				$data['year']			=	$year;
				$data['amount']			=	$days * $this->db->get_where('room', array('room_id' => $room_id))->row()->daily_rent;
				$data['invoice_id']		=	$invoice_id;
				$data['tenant_id']		=	$tenant_id;
				$data['created_on']		= 	time();
				$data['created_by']		=	$this->session->userdata('user_id');
				$data['timestamp']		=	time();
				$data['updated_by']		=	$this->session->userdata('user_id');
				$data['status']			=	$this->input->post('status');

				$this->db->insert('tenant_rent', $data);
			}
		}

		$this->session->set_flashdata('success', 'Date range rent has been generated successfully.');

		redirect(base_url() . 'invoices', 'refresh');
	}

	function generate_multiple_months_rent()
	{
		$tenant_id 						= 	$this->input->post('tenant_id');
		$year 							=	$this->input->post('year');
		$months 						=	$this->input->post('months');

		$room_id 						=	$this->db->get_where('tenant', array('tenant_id' => $tenant_id))->row()->room_id;
		$room_number					= 	$this->db->get_where('room', array('room_id' => $room_id))->row()->room_number;

		$invoice['tenant_name']			=	$this->db->get_where('tenant', array('tenant_id' => $tenant_id))->row()->name;
		$invoice['status']				=	$this->input->post('status');
		$invoice['start_date']			=	strtotime($months[0] . ' ' . '01' . ', ' . $year);
		$invoice['end_date']			=	strtotime($months[count($months) - 1] . ' ' . date('t', strtotime($year . '-' . $months[count($months) - 1])) . ', ' . $year . '11:59:59 pm');
		$invoice['due_date']			=	strtotime($this->input->post('due_date') . '11:59:59 pm');
		$invoice['invoice_type']		=	2;
		$invoice['tenant_mobile']		=	$this->db->get_where('tenant', array('tenant_id' => $tenant_id))->row()->mobile_number;
		$invoice['room_number']			=	$room_number;
		$invoice['tenant_id']			=	$tenant_id;
		$invoice['late_fee']			=	0;
		$invoice['invoice_number']		=	$year . date('m', strtotime($months[0])) . rand(1, 9999) . $tenant_id;
		$invoice['created_on']			= 	time();
		$invoice['created_by']			=	$this->session->userdata('user_id');
		$invoice['timestamp']			=	time();
		$invoice['updated_by']			=	$this->session->userdata('user_id');

		$this->db->insert('invoice', $invoice);

		$invoice_id						=	$this->db->insert_id();

		for ($i = 0; $i < sizeof($months); $i++) {
			$data['month']			=	$months[$i];
			$data['year']			=	$year;
			$data['amount']			=	$this->db->get_where('room', array('room_id' => $room_id))->row()->monthly_rent;
			$data['invoice_id']		=	$invoice_id;
			$data['tenant_id']		=	$tenant_id;
			$data['created_on']		= 	time();
			$data['created_by']		=	$this->session->userdata('user_id');
			$data['timestamp']		=	time();
			$data['updated_by']		=	$this->session->userdata('user_id');
			$data['status']			=	$this->input->post('status');

			$this->db->insert('tenant_rent', $data);
		}

		$this->session->set_flashdata('success', 'Single tenant rent has been generated successfully.');

		redirect(base_url() . 'invoices', 'refresh');
	}

	function generate_single_months_rent()
	{
		$tenants 						=	[];
		$year 							= 	$this->input->post('year');
		$month 							= 	$this->input->post('month');

		if ($this->input->post('tenants')[0] == 'All') {
			$active_tenants = $this->db->get_where('tenant', array('status' => 1))->result_array();
			foreach ($active_tenants as $active_tenant) {
				array_push($tenants, $active_tenant['tenant_id']);
			}
		} else {
			$tenants = $this->input->post('tenants');
		}

		for ($i = 0; $i < sizeof($tenants); $i++) {
			$room_id 					=	$this->db->get_where('tenant', array('tenant_id' => $tenants[$i]))->row()->room_id;
			$room_number				= 	$this->db->get_where('room', array('room_id' => $room_id))->row()->room_number;

			$invoice['tenant_name']		=	$this->db->get_where('tenant', array('tenant_id' => $tenants[$i]))->row()->name;
			$invoice['status']			=	$this->input->post('status');
			$invoice['start_date']		=	strtotime($month . ' ' . '01' . ', ' . $year);
			$invoice['end_date']		=	strtotime($month . ' ' . date('t', strtotime($year . '-' . $month)) . ', ' . $year . '11:59:59 pm');
			$invoice['due_date']		=	strtotime($this->input->post('due_date') . '11:59:59 pm');
			$invoice['invoice_type']	=	1;
			$invoice['tenant_mobile']	=	$this->db->get_where('tenant', array('tenant_id' => $tenants[$i]))->row()->mobile_number;
			$invoice['room_number']		=	$room_number;
			$invoice['tenant_id']		=	$tenants[$i];
			$invoice['late_fee']		=	0;
			$invoice['invoice_number']	=	$year . date('m', strtotime($month)) . rand(1, 9999) . $tenants[$i];
			$invoice['created_on']		= 	time();
			$invoice['created_by']		=	$this->session->userdata('user_id');
			$invoice['timestamp']		=	time();
			$invoice['updated_by']		=	$this->session->userdata('user_id');

			$this->db->insert('invoice', $invoice);

			$invoice_id						=	$this->db->insert_id();

			$data['month']			=	$month;
			$data['year']			=	$year;
			$data['amount']			=	$this->db->get_where('room', array('room_id' => $room_id))->row()->monthly_rent;
			$data['invoice_id']		=	$invoice_id;
			$data['tenant_id']		=	$tenants[$i];
			$data['created_on']		= 	time();
			$data['created_by']		=	$this->session->userdata('user_id');
			$data['timestamp']		=	time();
			$data['updated_by']		=	$this->session->userdata('user_id');
			$data['status']			=	$this->input->post('status');

			$this->db->insert('tenant_rent', $data);
		}

		$this->session->set_flashdata('success', 'Monthly rents have been generated successfully.');

		redirect(base_url() . 'invoices', 'refresh');
	}

	function update_invoice($invoice_id = '', $invoice_type = '')
	{
		$data['status']					= 	$this->input->post('status');
		$data['month']					=	$this->input->post('month');
		$data['year']					=	$this->input->post('year');
		$data['amount']					=	$this->input->post('amount');

		$data['timestamp']				=	time();
		$data['updated_by']				=	$this->session->userdata('user_id');

		$this->db->where('tenant_rent_id', $invoice_id);
		$this->db->update('tenant_rent', $data);

		$this->session->set_flashdata('success', 'Rent has been updated successfully.');

		redirect(base_url() . 'invoices', 'refresh');
	}

	function update_invoice_status($invoice_id = '')
	{
		$data['status']					= 	$this->input->post('status');
		$data['late_fee']				=	$this->input->post('late_fee') > 0 ? $this->input->post('late_fee') : 0;
		$data['timestamp']				=	time();
		$data['updated_by']				=	$this->session->userdata('user_id');

		$this->db->where('invoice_id', $invoice_id);
		$this->db->update('invoice', $data);

		$tenant_rents = $this->db->get_where('tenant_rent', array('invoice_id' => $invoice_id))->result_array();
		foreach ($tenant_rents as $tenant_rent) {
			$data2['status']				=	$this->input->post('status');
			$data2['timestamp']			=	time();

			$this->db->where('tenant_rent_id', $tenant_rent['tenant_rent_id']);
			$this->db->update('tenant_rent', $data2);
		}

		$this->session->set_flashdata('success', 'Invoice status has been updated successfully.');

		redirect(base_url() . 'invoices', 'refresh');
	}

	function remove_invoice($invoice_id = '')
	{
		$tenant_rents = $this->db->get_where('tenant_rent', array('invoice_id' => $invoice_id))->result_array();
		foreach ($tenant_rents as $tenant_rent) {
			$this->db->where('invoice_id', $tenant_rent['invoice_id']);
			$this->db->delete('tenant_rent');
		}

		$this->db->where('invoice_id', $invoice_id);
		$this->db->delete('invoice');

		if (file_exists('uploads/invoices/' . $invoice_id . '.pdf'))
			unlink('uploads/invoices/' . $invoice_id . '.pdf');

		$this->session->set_flashdata('success', 'Rent has been deleted successfully.');

		redirect(base_url() . 'invoices', 'refresh');
	}

	function add_notice()
	{
		$data['title']						=	$this->input->post('title');
		$data['notice']						=	$this->input->post('notice');
		$data['created_on']					=	time();
		$data['created_by']					=	$this->session->userdata('user_id');
		$data['timestamp']					=	time();
		$data['updated_by']					=	$this->session->userdata('user_id');

		$this->db->insert('notice', $data);

		$this->session->set_flashdata('success', 'New notice has been added successfully.');

		redirect(base_url() . 'notices', 'refresh');
	}

	function update_notice($notice_id = '')
	{
		$data['title']						=	$this->input->post('title');
		$data['notice']						=	$this->input->post('notice');
		$data['timestamp']					=	time();
		$data['updated_by']					=	$this->session->userdata('user_id');

		$this->db->where('notice_id', $notice_id);
		$this->db->update('notice', $data);

		$this->session->set_flashdata('success', 'Notice has been updated successfully.');

		redirect(base_url() . 'notices', 'refresh');
	}

	function remove_notice($notice_id = '')
	{
		$this->db->where('notice_id', $notice_id);
		$this->db->delete('notice');

		$this->session->set_flashdata('success', 'Notice has been deleted successfully.');

		redirect(base_url() . 'notices', 'refresh');
	}

	function add_ticket()
	{
		$data['subject']					=	$this->input->post('subject');
		$data['ticket_number']				=	$this->random_strings(11);
		$data['status']						=	0;
		$data['tenant_id']					=	($this->session->userdata('user_type') == 3) ? $this->security->xss_clean($this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row()->person_id) : $this->input->post('tenant_id');
		$data['created_on']					=	time();
		$data['created_by']					=	$this->session->userdata('user_id');
		$data['timestamp']					=	time();
		$data['updated_by']					=	$this->session->userdata('user_id');

		$this->db->insert('ticket', $data);

		$data2['ticket_id']					=	$this->db->insert_id();
		$data2['content']					=	$this->input->post('content');
		$data2['created_on']				=	time();
		$data2['created_by']				=	$this->session->userdata('user_id');
		$data2['timestamp']					=	time();
		$data2['updated_by']				=	$this->session->userdata('user_id');

		$this->db->insert('ticket_details', $data2);

		$this->session->set_flashdata('success', 'New ticket has been added successfully.');

		redirect(base_url() . 'tickets', 'refresh');
	}

	private function random_strings($length_of_string)
	{
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

		return substr(str_shuffle($str_result), 0, $length_of_string);
	}

	function update_ticket($ticket_id = '')
	{
		$data['timestamp']					=	time();
		$data['updated_by']					=	$this->session->userdata('user_id');

		$this->db->where('ticket_id', $ticket_id);
		$this->db->update('ticket', $data);

		$data2['ticket_id']					=	$ticket_id;
		$data2['content']					=	$this->input->post('content');
		$data2['created_on']				=	time();
		$data2['created_by']				=	$this->session->userdata('user_id');
		$data2['timestamp']					=	time();
		$data2['updated_by']				=	$this->session->userdata('user_id');

		$this->db->insert('ticket_details', $data2);

		$this->session->set_flashdata('success', 'Reply to ticket has been submitted successfully.');

		redirect(base_url() . 'tickets', 'refresh');
	}

	function close_ticket($ticket_id = '')
	{
		$data['status']						=	1;
		$data['timestamp']					=	time();
		$data['updated_by']					=	$this->session->userdata('user_id');

		$this->db->where('ticket_id', $ticket_id);
		$this->db->update('ticket', $data);

		$this->session->set_flashdata('success', 'Ticket has been closed successfully.');

		redirect(base_url() . 'tickets', 'refresh');
	}

	// Function related to adding id type
	function add_id_type()
	{
		$data['name']					=	$this->input->post('name');
		$data['created_on']				= 	time();
		$data['created_by']				= 	$this->session->userdata('user_id');
		$data['timestamp']				= 	time();
		$data['updated_by']				= 	$this->session->userdata('user_id');

		$this->db->insert('id_type', $data);

		$this->session->set_flashdata('success', 'New ID type has been added successfully.');

		redirect(base_url() . 'id_type_settings', 'refresh');
	}

	// Function related to updating profession
	function update_id_type($id_type_id = '')
	{
		$data['name']					=	$this->input->post('name');
		$data['timestamp']				= 	time();
		$data['updated_by']				= 	$this->session->userdata('user_id');

		$this->db->where('id_type_id', $id_type_id);
		$this->db->update('id_type', $data);

		$this->session->set_flashdata('success', 'ID type has been updated successfully.');

		redirect(base_url() . 'id_type_settings', 'refresh');
	}

	// Function related to website settings
	function update_website_settings()
	{
		if ($this->input->post('system_name')) {
			$data1['content']			=	$this->input->post('system_name');

			$this->db->where('name', 'system_name');
			$this->db->update('setting', $data1);
		}

		if ($this->input->post('currency')) {
			$data2['content']			=	$this->input->post('currency');

			$this->db->where('name', 'currency');
			$this->db->update('setting', $data2);
		}

		if ($this->input->post('tagline')) {
			$data3['content']			=	$this->input->post('tagline');

			$this->db->where('name', 'tagline');
			$this->db->update('setting', $data3);
		}

		if ($this->input->post('address_line_1') && $this->input->post('address_line_2')) {
			$data6['content']			=	$this->input->post('address_line_1') . '<br>' . $this->input->post('address_line_2');

			$this->db->where('name', 'address');
			$this->db->update('setting', $data6);
		}

		$this->session->set_flashdata('success', 'Website settings has been updated successfully.');

		redirect(base_url() . 'website_settings', 'refresh');
	}

	// Function realted to website favicon update
	function update_website_favicon()
	{
		$ext 							= 	pathinfo($_FILES['favicon']['name'], PATHINFO_EXTENSION);

		if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
			$favicon 					= 	$this->db->get_where('setting', array('name' => 'favicon'))->row()->content;

			if (isset($favicon)) unlink('uploads/website/' . $favicon);

			$data['content'] 			= 	$_FILES['favicon']['name'];
			$data['timestamp']			=	time();
			$data['updated_by']			=	$this->session->userdata('user_id');

			move_uploaded_file($_FILES['favicon']['tmp_name'], 'uploads/website/' . $data['content']);

			$this->db->where('name', 'favicon');
			$this->db->update('setting', $data);

			$this->session->set_flashdata('success', 'Website favicon has been updated successfully.');

			redirect(base_url() . 'website_settings', 'refresh');
		} else {
			$this->session->set_flashdata('warning', 'Only supported image types: jpeg, jpg, png');

			redirect(base_url() . 'website_settings', 'refresh');
		}
	}

	// Function realted to website login background update
	function update_website_login_bg()
	{
		$ext 							= 	pathinfo($_FILES['login_bg']['name'], PATHINFO_EXTENSION);

		if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
			$login_bg 					= 	$this->db->get_where('setting', array('name' => 'login_bg'))->row()->content;

			if (isset($login_bg)) unlink('uploads/website/' . $login_bg);

			$data['content'] 			= 	$_FILES['login_bg']['name'];
			$data['timestamp']			=	time();
			$data['updated_by']			=	$this->session->userdata('user_id');

			move_uploaded_file($_FILES['login_bg']['tmp_name'], 'uploads/website/' . $data['content']);

			$this->db->where('name', 'login_bg');
			$this->db->update('setting', $data);

			$this->session->set_flashdata('success', 'Website login background has been updated successfully.');

			redirect(base_url() . 'website_settings', 'refresh');
		} else {
			$this->session->set_flashdata('warning', 'Only supported image types: jpeg, jpg, png');

			redirect(base_url() . 'website_settings', 'refresh');
		}
	}

	// Function related to website settings
	function update_website_smtp()
	{
		if ($this->input->post('smtp_user')) {
			$data1['content']			=	$this->input->post('smtp_user');

			$this->db->where('name', 'smtp_user');
			$this->db->update('setting', $data1);
		}

		if ($this->input->post('smtp_pass')) {
			$data2['content']			=	$this->input->post('smtp_pass');

			$this->db->where('name', 'smtp_pass');
			$this->db->update('setting', $data2);
		}

		$this->session->set_flashdata('success', 'SMTP settings has been updated successfully.');

		redirect(base_url() . 'website_settings', 'refresh');
	}

	// Function related to adding profession
	function add_profession()
	{
		$data['name']					=	$this->input->post('name');
		$data['created_on']				= 	time();
		$data['created_by']				= 	$this->session->userdata('user_id');
		$data['timestamp']				= 	time();
		$data['updated_by']				= 	$this->session->userdata('user_id');

		$this->db->insert('profession', $data);

		$this->session->set_flashdata('success', 'New profession has been added successfully.');

		redirect(base_url() . 'profession_settings', 'refresh');
	}

	// Function related to updating profession
	function update_profession($profession_id = '')
	{
		$data['name']					=	$this->input->post('name');
		$data['timestamp']				= 	time();
		$data['updated_by']				= 	$this->session->userdata('user_id');

		$this->db->where('profession_id', $profession_id);
		$this->db->update('profession', $data);

		$this->session->set_flashdata('success', 'Profession has been updated successfully.');

		redirect(base_url() . 'profession_settings', 'refresh');
	}

	function update_profile_settings($user_id = '')
	{
		$db_password 					=	$this->db->get_where('user', array('user_id' => $user_id))->row()->password;
		$given_password 				=	$this->input->post('old_password');

		$existing_email 				= 	$this->db->get_where('user', array('user_id' => $user_id))->row()->email;

		if (password_verify($given_password, $db_password)) {
			if ($existing_email != $this->input->post('email')) {
				$users = $this->db->get('user')->result_array();
				foreach ($users as $user) {
					if ($user['email'] == $this->input->post('email')) {
						$this->session->set_flashdata('warning', 'The email address is already registered.');

						redirect(base_url() . 'profile_settings', 'refresh');
					}
				}
			}

			$data['email']				=	$this->input->post('email');
			$data['password']			=	password_hash($this->input->post('new_password'), PASSWORD_DEFAULT);

			$this->db->where('user_id', $user_id);
			$this->db->update('user', $data);

			$this->session->set_flashdata('success', 'Your profile has been updated successfully.');

			redirect(base_url() . 'profile_settings', 'refresh');
		} else {
			$this->session->set_flashdata('warning', 'Passwords do not match, Try again.');

			redirect(base_url() . 'profile_settings', 'refresh');
		}
	}
}
