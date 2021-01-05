<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Landlord extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->output->set_header("X-Frame-Options: sameorigin");
		$this->output->set_header("X-XSS-Protection: 1; mode=block");
		$this->output->set_header("X-Content-Type-Options: nosniff");
		$this->output->set_header("Strict-Transport-Security: max-age=31536000");
	}

	public function index()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'dashboard'))->row()->module_id, $this->session->userdata('permissions'))) {
			$page_data['page_title']	=	'Dashboard';
			$page_data['page_name']		=	'dashboard';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function login()
	{
		$this->load->view('login');
	}

	function add_room()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'rooms'))->row()->module_id, $this->session->userdata('permissions'))) {
			$page_data['page_title']	=	'Add Room';
			$page_data['page_name'] 	= 	'add_room';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function rooms($param1 = '', $param2 = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'rooms'))->row()->module_id, $this->session->userdata('permissions'))) {
			if ($param1 == 'add') $this->model->add_room();
			elseif ($param1 == 'update') $this->model->update_room($param2);
			elseif ($param1 == 'remove') $this->model->remove_room($param2);
			elseif ($param1 == 'assign_tenant') $this->model->assign_tenant($param2);
			elseif ($param1 == 'vacant') $this->model->vacant_room($param2);

			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Rooms';
			$page_data['page_name'] 	= 	'rooms';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function occupied_rooms()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'rooms'))->row()->module_id, $this->session->userdata('permissions'))) {
			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Occupied Rooms';
			$page_data['page_name'] 	= 	'occupied_rooms';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function unoccupied_rooms()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'rooms'))->row()->module_id, $this->session->userdata('permissions'))) {
			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Unoccupied Rooms';
			$page_data['page_name'] 	= 	'unoccupied_rooms';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function add_tenant()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'tenants'))->row()->module_id, $this->session->userdata('permissions'))) {
			$page_data['page_title']	=	'Add Tenants';
			$page_data['page_name'] 	= 	'add_tenant';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function tenants($param1 = '', $param2 = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'tenants'))->row()->module_id, $this->session->userdata('permissions'))) {
			if ($param1 == 'add') $this->model->add_tenant();
			elseif ($param1 == 'change_image') $this->model->change_tenant_image($param2);
			elseif ($param1 == 'change_id_image') $this->model->change_tenant_id_image($param2);
			elseif ($param1 == 'update') $this->model->update_tenant($param2);
			elseif ($param1 == 'deactivate') $this->model->deactivate_tenant($param2);
			elseif ($param1 == 'remove') $this->model->remove_tenant($param2);

			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Tenants';
			$page_data['page_name'] 	= 	'tenants';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function active_tenants()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'tenants'))->row()->module_id, $this->session->userdata('permissions'))) {
			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Active Tenants';
			$page_data['page_name'] 	= 	'active_tenants';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function inactive_tenants()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'tenants'))->row()->module_id, $this->session->userdata('permissions'))) {
			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Inactive Tenants';
			$page_data['page_name'] 	= 	'inactive_tenants';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function add_utility_bill()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'utility_bills'))->row()->module_id, $this->session->userdata('permissions'))) {
			$page_data['page_title']	=	'Add Utility Bill';
			$page_data['page_name'] 	= 	'add_utility_bill';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function utility_bills($param1 = '', $param2 = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'utility_bills'))->row()->module_id, $this->session->userdata('permissions'))) {
			if ($param1 == 'add') $this->model->add_utility_bill();
			elseif ($param1 == 'update') $this->model->update_utility_bill($param2);
			elseif ($param1 == 'remove') $this->model->remove_utility_bill($param2);
			elseif ($param1 == 'change_image') $this->model->change_utility_image($param2);

			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Utility Bills';
			$page_data['page_name'] 	= 	'utility_bills';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function utility_bill_categories($param1 = '', $param2 = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'utility_bills'))->row()->module_id, $this->session->userdata('permissions'))) {
			if ($param1 == 'add') $this->model->add_utility_bill_category();
			elseif ($param1 == 'update') $this->model->update_utility_bill_category($param2);
			elseif ($param1 == 'remove') $this->model->remove_utility_bill_category($param2);

			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Utility Bill Categories';
			$page_data['page_name'] 	= 	'utility_bill_categories';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function add_expense()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'expenses'))->row()->module_id, $this->session->userdata('permissions'))) {
			$page_data['page_title']	=	'Add Expense';
			$page_data['page_name'] 	= 	'add_expense';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function expenses($param1 = '', $param2 = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'expenses'))->row()->module_id, $this->session->userdata('permissions'))) {
			if ($param1 == 'add') $this->model->add_expense();
			elseif ($param1 == 'update') $this->model->update_expense($param2);
			elseif ($param1 == 'remove') $this->model->remove_expense($param2);

			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Expenses';
			$page_data['page_name'] 	= 	'expenses';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function add_staff()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'staff'))->row()->module_id, $this->session->userdata('permissions'))) {
			$page_data['page_title']	=	'Add Staff';
			$page_data['page_name'] 	= 	'add_staff';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function staff($param1 = '', $param2 = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'staff'))->row()->module_id, $this->session->userdata('permissions'))) {
			if ($param1 == 'add') $this->model->add_staff();
			elseif ($param1 == 'update') $this->model->update_staff($param2);
			elseif ($param1 == 'deactivate') $this->model->deactivate_staff($param2);
			elseif ($param1 == 'remove') $this->model->remove_staff($param2);
			elseif ($param1 == 'permission') $this->model->update_staff_permission($param2);

			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Staff';
			$page_data['page_name'] 	= 	'staff';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function add_staff_payroll()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'staff_payroll'))->row()->module_id, $this->session->userdata('permissions'))) {
			$page_data['page_title']	=	'Add Staff Payroll';
			$page_data['page_name'] 	= 	'add_staff_payroll';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function staff_payroll($param1 = '', $param2 = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'staff_payroll'))->row()->module_id, $this->session->userdata('permissions'))) {
			if ($param1 == 'add') $this->model->add_staff_salary();
			elseif ($param1 == 'update') $this->model->update_staff_salary($param2);
			elseif ($param1 == 'remove') $this->model->remove_staff_salary($param2);

			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Staff Payroll';
			$page_data['page_name'] 	= 	'staff_payroll';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function single_month_staff_payroll($year = '', $month = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'staff_payroll'))->row()->module_id, $this->session->userdata('permissions'))) {
			$page_data['year']			=	$year;
			$page_data['month']			=	$month;

			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Single Month Staff Payroll';
			$page_data['page_name'] 	= 	'single_month_staff_payroll';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function generate_invoice($param = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'generate_invoice'))->row()->module_id, $this->session->userdata('permissions'))) {
			if ($param == 'range') $this->model->generate_date_range_rents();
			elseif ($param == 'multiple') $this->model->generate_multiple_months_rent();
			elseif ($param == 'single') $this->model->generate_single_months_rent();

			$page_data['page_title']	=	'Generate Invoice';
			$page_data['page_name'] 	=	'generate_invoice';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function monthly_invoices()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'invoices'))->row()->module_id, $this->session->userdata('permissions'))) {
			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Monthly Invoices';
			$page_data['page_name'] 	=	'monthly_invoices';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function single_month_invoices($year = '', $month = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'invoices'))->row()->module_id, $this->session->userdata('permissions'))) {
			$page_data['year']			=	$year;
			$page_data['month']			=	$month;

			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Single Month Invoices';
			$page_data['page_name'] 	=	'single_month_invoices';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function tenant_invoices()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'invoices'))->row()->module_id, $this->session->userdata('permissions')) && (count($this->db->get('tenant')->result_array()) > 0)) {
			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Tenant Invoices';
			$page_data['page_name'] 	=	'tenant_invoices';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function single_tenant_invoices($tenant_id = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'invoices'))->row()->module_id, $this->session->userdata('permissions')) && (count($this->db->get('tenant')->result_array()) > 0)) {
			$page_data['tenant_id']		=	$tenant_id;

			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Single Tenant Invoices';
			$page_data['page_name'] 	=	'single_tenant_invoices';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function invoices($param1 = '', $param2 = '', $param3 = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'invoices'))->row()->module_id, $this->session->userdata('permissions'))) {
			if ($param1 == 'update') $this->model->update_invoice($param2, $param3);
			if ($param1 == 'update_status') $this->model->update_invoice_status($param2);
			elseif ($param1 == 'remove') $this->model->remove_invoice($param2);

			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'All Invoices';
			$page_data['page_name'] 	=	'invoices';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function paid_invoices()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'invoices'))->row()->module_id, $this->session->userdata('permissions'))) {
			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Paid Invoices';
			$page_data['page_name'] 	=	'paid_invoices';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function unpaid_invoices()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'invoices'))->row()->module_id, $this->session->userdata('permissions'))) {
			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Unpaid Invoices';
			$page_data['page_name'] 	=	'unpaid_invoices';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function generate_invoice_pdf($param = '')
	{
		$page_data['invoice_id'] = $param;
		$this->load->view('generate_invoice_pdf', $page_data);
		$html = $this->output->get_output();
		$this->load->library('pdf');
		$this->pdf->loadHtml($html);
		$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->render();

		// $this->pdf->stream("mypdf.pdf", array("Attachment" => 0));
		// exit(0);

		$pdf = $this->pdf->output();
		$file_location = $_SERVER['DOCUMENT_ROOT'] . '/uploads/invoices/' . $this->db->get_where('invoice', array('invoice_id' => $param))->row()->invoice_number . '.pdf';
		file_put_contents($file_location, $pdf);
	}

	function email_invoice($param = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		$this->email_model->send_invoice($param);
	}

	function invoice($param = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'invoices'))->row()->module_id, $this->session->userdata('permissions'))) {

			$page_data['invoice_id']	=	$param;
			$page_data['page_title']	=	'Invoice';
			$page_data['page_name'] 	=	'invoice';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function add_notice()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'notices'))->row()->module_id, $this->session->userdata('permissions'))) {
			$page_data['page_title']	=	'Add Notice';
			$page_data['page_name'] 	= 	'add_notice';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function notices($param1 = '', $param2 = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'notices'))->row()->module_id, $this->session->userdata('permissions'))) {
			if ($param1 == 'add' && $this->session->userdata('user_type') != 3) $this->model->add_notice();
			elseif ($param1 == 'update' && $this->session->userdata('user_type') != 3) $this->model->update_notice($param2);
			elseif ($param1 == 'remove' && $this->session->userdata('user_type') != 3) $this->model->remove_notice($param2);

			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Notices';
			$page_data['page_name'] 	= 	'notices';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function add_ticket()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'tickets'))->row()->module_id, $this->session->userdata('permissions'))) {
			$page_data['page_title']	=	'Add Ticket';
			$page_data['page_name'] 	= 	'add_ticket';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function tickets($param1 = '', $param2 = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'tickets'))->row()->module_id, $this->session->userdata('permissions'))) {
			if ($param1 == 'add') $this->model->add_ticket();
			elseif ($param1 == 'update') $this->model->update_ticket($param2);
			elseif ($param1 == 'close') $this->model->close_ticket($param2);

			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Tickets';
			$page_data['page_name'] 	= 	'tickets';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function open_tickets()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'tickets'))->row()->module_id, $this->session->userdata('permissions'))) {
			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Open Tickets';
			$page_data['page_name'] 	= 	'open_tickets';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function closed_tickets()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'tickets'))->row()->module_id, $this->session->userdata('permissions'))) {
			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Closed Tickets';
			$page_data['page_name'] 	= 	'closed_tickets';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function account()
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'account'))->row()->module_id, $this->session->userdata('permissions'))) {
			$this->input->post('year') ? $page_data['selected_year'] = $this->input->post('year') : $page_data['selected_year'] = date('Y');

			$page_data['page_title']	=	'Account';
			$page_data['page_name'] 	=	'account';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function website_settings($param = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'settings'))->row()->module_id, $this->session->userdata('permissions'))) {
			if ($param == 'update') $this->model->update_website_settings();
			if ($param == 'update_favicon') $this->model->update_website_favicon();
			if ($param == 'login_bg') $this->model->update_website_login_bg();
			if ($param == 'update_smtp') $this->model->update_website_smtp();

			$page_data['page_title']	=	'Website Settings';
			$page_data['page_name'] 	=	'website_settings';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function profession_settings($param1 = '', $param2 = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'settings'))->row()->module_id, $this->session->userdata('permissions'))) {
			if ($param1 == 'add') $this->model->add_profession();
			elseif ($param1 == 'update') $this->model->update_profession($param2);

			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'Profession Settings';
			$page_data['page_name'] 	=	'profession_settings';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function id_type_settings($param1 = '', $param2 = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if (in_array($this->db->get_where('module', array('module_name' => 'settings'))->row()->module_id, $this->session->userdata('permissions'))) {
			if ($param1 == 'add') $this->model->add_id_type();
			elseif ($param1 == 'update') $this->model->update_id_type($param2);

			$page_data['navbar_status']	=	'aside-collapsed';
			$page_data['page_title']	=	'ID Type Settings';
			$page_data['page_name'] 	=	'id_type_settings';
			$this->load->view('index', $page_data);
		} else {
			$page_data['page_title']	=	'Permission Denied';
			$page_data['page_name'] 	= 	'permission_denied';
			$this->load->view('index', $page_data);
		}
	}

	function profile_settings($param1 = '', $param2 = '')
	{
		if (!$this->session->userdata('user_type'))
			redirect(base_url() . 'login', 'refresh');

		if ($param1 == 'update') $this->model->update_profile_settings($param2);

		$page_data['page_title']	=	'Profile Settings';
		$page_data['page_name'] 	=	'profile_settings';
		$this->load->view('index', $page_data);
	}
}
