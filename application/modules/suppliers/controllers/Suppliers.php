<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * InvoicePlane
 *
 * @author		InvoicePlane Developers & Contributors
 * @copyright	Copyright (c) 2012 - 2018 InvoicePlane.com
 * @license		https://invoiceplane.com/license.txt
 * @link		https://invoiceplane.com
 */

/**
 * Class Clients
 */
class Suppliers extends Admin_Controller
{
    /**
     * Clients constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_suppliers');
    }

    public function index()
    {
        // Display active clients by default
        redirect('suppliers/status/active');
    }

    /**
     * @param string $status
     * @param int $page
     */
    public function status($status = 'active', $page = 0)
    {
        if (is_numeric(array_search($status, array('active', 'inactive')))) {
            $function = 'is_' . $status;
            $this->mdl_suppliers->$function();
        }

        $this->mdl_suppliers->with_total_balance()->paginate(site_url('suppliers/status/' . $status), $page);
        $suppliers = $this->mdl_suppliers->result();

       // print_r($suppliers);die();

        $this->layout->set(
            array(
                'records' => $suppliers,
                'filter_display' => true,
                'filter_placeholder' => trans('filter_suppliers'),
                'filter_method' => 'filter_suppliers'
            )
        );

        $this->layout->buffer('content', 'suppliers/index');
        $this->layout->render();
    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('suppliers');
        }
        
        if($id!=23){
            
              $new_suppliers = false;

        // Set validation rule based on is_update
        if ($this->input->post('is_update') == 0 && $this->input->post('suppliers_name') != '') {
            $check = $this->db->get_where('ip_suppliers', array(
                'supplier_name' => $this->input->post('supplier_name')
            ))->result();

            if (!empty($check)) {
                $this->session->set_flashdata('alert_error', trans('client_already_exists'));
                redirect('suppliers/form');
            } else {
                $new_suppliers = true;
            }
        }

        if ($this->mdl_suppliers->run_validation()) {
            $id = $this->mdl_suppliers->save($id);
              redirect('suppliers/status/active');
            
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_suppliers->prep_form($id)) {
                show_404();
            }

       }
            
        }

      
//         elseif ($this->input->post('btn_submit')) {
//            if ($this->input->post('custom')) {
//                foreach ($this->input->post('custom') as $key => $val) {
//                    $this->mdl_suppliers->set_form_value('custom[' . $key . ']', $val);
//                }
//            }
//        }


        $this->load->helper('country');


        $this->layout->set(
            array(
                'countries' => get_country_list(trans('cldr')),
                'selected_country' => $this->mdl_suppliers->form_value('client_country') ?: get_setting('default_country'),
            )
        );

        $this->layout->buffer('content', 'suppliers/form');
        $this->layout->render();
    }

    /**
     * @param int $suppliers_id
     */
    public function view($suppliers_id)
    {
        //$this->load->model('clients/mdl_client_notes');

        $suppliers = $this->mdl_suppliers
            ->where('ip_suppliers.supplier_id', $suppliers_id)
            ->get()->row();

        if (!$suppliers) {
            show_404();
        }

        $this->layout->set(
            array(
                'supplier' => $suppliers
            )
        );

        $this->layout->buffer(
            array(
                array(
                    'content',
                    'suppliers/view'
                )
            )
        );

        $this->layout->render();
    }

    /**
     * @param int $client_id
     */
    public function delSuppliers($suppliers_id)
    {
        $this->mdl_suppliers->delete($suppliers_id);
        redirect('suppliers/status/active');
    }

}
