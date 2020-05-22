<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * InvoicePlane
 *
 * @author InvoicePlane Developers & Contributors
 * @copyright Copyright (c) 2012 - 2018 InvoicePlane.com
 * @license https://invoiceplane.com/license.txt
 * @link https://invoiceplane.com
 */

/**
 * Class Clients
 */
class Cheque extends Admin_Controller
{

    /**
     * Clients constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_cheque');
    }

    public function index()
    {
        // Display active clients by default
        redirect('cheque/status/active');
    }

    /**
     *
     * @param string $status
     * @param int $page
     */
    public function status($status = 'active', $page = 0)
    {
        $this->load->model('cheque/mdl_cheque');
        $this->load->model('suppliers/mdl_suppliers');

        $this->layout->set(array(
            'stock' => $this->mdl_cheque->allcheques(),
            'supplier' => $this->mdl_suppliers->get()
                ->result()
        ));
        $this->layout->buffer('content', 'cheque/index');
        $this->layout->render();
    }

    /**
     *
     * @param null $id
     */
    public function form($id = null)
    {
        $this->load->model('products/mdl_products');
        $this->load->model('suppliers/mdl_suppliers');
        if ($this->input->post('btn_cancel')) {
            redirect('cheque');
        }

        if ($this->mdl_cheque->run_validation()) {
            $id = $this->mdl_cheque->save($id);
            redirect('cheque/form');
            return;
            // if ($result !== true) {
            // $this->session->set_flashdata('alert_error', $result);
            // $this->session->set_flashdata('alert_success', null);
            // redirect('stock/form/' . $id);
            // return;
            // } else {
            // redirect('stock/view/' . $id);
            // }
        }

        if ($id and ! $this->input->post('btn_submit')) {
            if (! $this->mdl_stock->prep_form($id)) {
                show_404();
            }
        }

        $this->layout->set(array(
            'product' => $this->mdl_products->get()
                ->result(),
            'supplier' => $this->mdl_suppliers->get()
                ->result()
        ));

        $this->layout->buffer('content', 'cheque/form');
        $this->layout->render();
    }

    public function edit($id = null)
    {
        if ($this->input->post('cheque_id') != '') {
            $this->db->where('cheque_id', $this->input->post('cheque_id'));
            $this->db->set('supplier_id', $this->input->post('stock_suppliers_id'));
            $this->db->set('added_date', date_to_mysql($this->input->post('from_date')));
            $this->db->set('amount', $this->input->post('amount'));
            $this->db->set('check_no', $this->input->post('chequeno'));
            $this->db->set('clear', $this->input->post('clear'));
            $this->db->update('ip_cheques');
            $this->session->set_flashdata('alert_success', null);
            redirect('cheque/status/active');
        }
        $this->load->model('suppliers/mdl_suppliers');
        $cheque = $this->mdl_cheque->where('cheque_id', $id)
            ->get()
            ->row();
            $sup = $this->mdl_suppliers->where('supplier_id', $cheque->supplier_id)
            ->get()
            ->row();
        $this->layout->set(array(
            'checkid' => $id,
            'addedate' => $cheque->added_date,
            'amount' => $cheque->amount,
            'checkno' => $cheque->check_no,
            'supplierid' => $cheque->supplier_id,
            'suppliername' => $sup->supplier_name,
            'clear' => $cheque->clear,
            'supplier' => $this->mdl_suppliers->get()
                ->result()
        ));

        $this->layout->buffer('content', 'cheque/edit');
        $this->layout->render();
    }

    public function search()
    {
        $this->load->model('suppliers/mdl_suppliers');
        $stock_product_id = $this->input->post('stock_product_id');
        $stock_suppliers_id = $this->input->post('stock_suppliers_id');

        if ($stock_suppliers_id == 0) {
            $stock = $this->mdl_stock->where('stock_product_id = "' . $stock_product_id . '"')
                ->order_by('stock_create_date')
                ->get()
                ->result();
        }

        if ($stock_product_id == 0) {
            $stock = $this->mdl_stock->where('stock_suppliers_id = "' . $stock_suppliers_id . '" ')
                ->order_by('stock_create_date')
                ->get()
                ->result();
        }

        if ($stock_suppliers_id != 0 && $stock_product_id != 0) {
            $stock = $this->mdl_stock->where('stock_product_id = "' . $stock_product_id . '"')
                ->where('stock_suppliers_id = "' . $stock_suppliers_id . '" ')
                ->order_by('stock_create_date')
                ->get()
                ->result();
        }

        if ($stock_suppliers_id == 0 && $stock_product_id == 0) {
            $stock = $this->mdl_stock->order_by('stock_create_date')
                ->get()
                ->result();
        }

        $data = [
            'stock' => $stock
        ];
        $this->layout->load_view('cheque/partial_cheque_table', $data);
    }

    /**
     *
     * @param int $suppliers_id
     */
    public function view($suppliers_id)
    {
        // $this->load->model('clients/mdl_client_notes');
        $suppliers = $this->mdl_suppliers->where('ip_suppliers.supplier_id', $suppliers_id)
            ->get()
            ->row();

        if (! $suppliers) {
            show_404();
        }

        $this->layout->set(array(
            'supplier' => $suppliers
        ));

        $this->layout->buffer(array(
            array(
                'content',
                'suppliers/view'
            )
        ));

        $this->layout->render();
    }

    /**
     *
     * @param int $client_id
     */
    public function delete($cheque_id)
    {
        $this->mdl_cheque->delete($cheque_id);
        redirect('cheque');
    }
    
    public function editab($cheque_id)
    {
        $this->db->where('cheque_id', $cheque_id);
        $this->db->set('clear', $this->input->post('clear'));
        $this->db->update('ip_cheques');
        $this->session->set_flashdata('alert_success', null);
        redirect('cheque');
    }
}
