<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_model extends CI_Model
{
    function send_invoice($invoice_id = '')
    {
        $invoice_number         =   $this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->invoice_number;
        $subject                =   'Invoice';
        $page_name              =   'contact';
        $from                   =   $this->db->get_where('setting', array('setting_id' => 7))->row()->content;
        $to                     =   $this->db->get_where('tenant', array('tenant_id' => $this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->tenant_id))->row()->email;
        $message                =   'This is your invoice number ' . $invoice_number;
        $name                   =   $this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->tenant_name;
        $system_name            =   $this->db->get_where('setting', array('setting_id' => 1))->row()->content;

        $data['title']          =   $this->db->get_where('setting', array('setting_id' => 1))->row()->content;
        $data['name']           =   $name;
        $data['message']        =   $message;
        $data['url']            =   base_url();
        $data['copyright']      =   $this->db->get_where('setting', array('setting_id' => 3))->row()->content;

        $body = $this->load->view('email/' . $page_name, $data, TRUE);

        $config['smtp_user']    =     $this->db->get_where('setting', array('setting_id' => 7))->row()->content;
        $config['smtp_pass']    =     $this->db->get_where('setting', array('setting_id' => 8))->row()->content;

        $this->email->initialize($config);

        if ($to) {
            if ($this->email->from($from, $system_name)->reply_to($from)->to($to)->subject($subject)->message($body)->attach('uploads/invoices/' . $invoice_number . '.pdf')->send()) {
                $this->session->set_flashdata('success', 'Invoice emailed successfully.');

                header('Location: ' . base_url('invoices'));
            } else {
                $this->session->set_flashdata('warning', 'Email could not be sent.');

                header('Location: ' . base_url('invoices'));
            }
        } else {
            $this->session->set_flashdata('warning', 'Tenant email address not found.');

            header('Location: ' . base_url('invoices'));
        }
    }
}
