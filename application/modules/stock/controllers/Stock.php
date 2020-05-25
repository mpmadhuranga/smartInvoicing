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
class Stock extends Admin_Controller
{
    /**
     * Clients constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_stock');
        $this->load->model('mdl_stock_new');
        $this->load->model('products/mdl_products');
        $this->load->model('suppliers/mdl_suppliers');
    }

//    public function index()
//    {
//        // Display active clients by default
//        redirect('stock/status/active');
//    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {
        $this->mdl_stock->paginate(site_url('stock/index'), $page);
        $stock = $this->mdl_stock->result();

           $this->layout->set(
            array(
                'product' => $this->mdl_products->result_with_qty(),
                'supplier' => $this->mdl_suppliers->get()->result(),
                'stock' => $stock
                )
        );
        $this->layout->buffer('content', 'stock/index');
        $this->layout->render();
    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {
        $this->load->model('products/mdl_products');
        $this->load->model('suppliers/mdl_suppliers');
        if ($this->input->post('btn_cancel')) {
            redirect('stock');
        }

         if ($this->mdl_stock->run_validation()) {
            $ids = $this->mdl_stock->save($id);
            $this->db->where('stock_id', $ids);
            $this->db->set('stock_qty', $this->input->post('stock_open_qty'));
            $this->db->set('stock_create_date', gmdate('y-m-d'));
            $this->db->update('ip_products_stock');
            
            if ($this->mdl_stock_new->run_validation()) {                
                    $stock = $this->mdl_stock_new->get_qty($this->input->post('stock_product_id'));
                    $pre_qty=$stock['stock_qty'];
                    $updateQty = $pre_qty + $this->input->post('stock_open_qty');
                    $this->db->where('stock_product_id', $this->input->post('stock_product_id'));
                    $this->db->set('stock_qty', $updateQty);
                    $this->db->update('ip_products_stock_new');
                    
                    if($stock==null){
                        $idss = $this->mdl_stock_new->save($id);
                        $this->db->where('stock_id', $idss);
                        $this->db->set('stock_qty', $this->input->post('stock_open_qty'));
                        $this->db->set('stock_updated_date', gmdate('y-m-d'));
                        $this->db->update('ip_products_stock_new');
                    }
                }
            
             redirect('stock/form');
             return;
//            if ($result !== true) {
//                $this->session->set_flashdata('alert_error', $result);
//                $this->session->set_flashdata('alert_success', null);
//                redirect('stock/form/' . $id);
//                return;
//            } else {
//                redirect('stock/view/' . $id);
//            }
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_stock->prep_form($id)) {
                show_404();
            }
       }

        $this->layout->set(
            array(
                'product' => $this->mdl_products->get()->result(),
                'supplier' => $this->mdl_suppliers->get()->result(),
            )
        );

        $this->layout->buffer('content', 'stock/form');
        $this->layout->render();
    }
    
    public function edit($id = null)
    {
        if($this->input->post('stock_id') !=''){
                $this->db->where('stock_id', $this->input->post('stock_id'));
                $this->db->set('stock_open_qty', $this->input->post('stock_open_qty'));
                $this->db->update('ip_products_stock');
                $this->session->set_flashdata('alert_success', null);
                redirect('stock/index');
        }
        $product = $this->mdl_stock->where('stock_id', $id)->get()->row();
        $this->layout->set(
            array(
                'qty' => $product->stock_open_qty,
                'id' => $id
            )
        );

        $this->layout->buffer('content', 'stock/edit');
        $this->layout->render();
    }
    public function search()
    {
        $this->load->model('suppliers/mdl_suppliers');
        $stock_product_id = $this->input->post('stock_product_id');
        $stock_suppliers_id = $this->input->post('stock_suppliers_id');
        
        if( $stock_suppliers_id === '0' && $stock_product_id !== '0'){
            $stock = $this->mdl_stock
            ->where('stock_product_id = "'.$stock_product_id.'"')
            ->order_by('stock_create_date')
            ->get()
            ->result();
        }else if($stock_product_id === '0' && $stock_suppliers_id !== '0'){
            $stock = $this->mdl_stock
            ->where('stock_suppliers_id = "'.$stock_suppliers_id.'" ')
            ->order_by('stock_create_date')
            ->get()
            ->result();
        }else  if($stock_suppliers_id !== '0' && $stock_product_id !== '0'){
            $stock = $this->mdl_stock
            ->where('stock_product_id = "'.$stock_product_id.'"')
            ->where('stock_suppliers_id = "'.$stock_suppliers_id.'" ')
            ->order_by('stock_create_date')
            ->get()
            ->result();
        }else if($stock_suppliers_id === '0' && $stock_product_id === '0'){
            $stock = $this->mdl_stock
            ->get()
            ->result();
        }
        
        $data = [
               'stock' => $stock
             ];
      $this->layout->load_view('stock/partial_stock_table', $data);
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
    public function delete($suppliers_id)
    {
        $this->mdl_stock->delete($suppliers_id);
        redirect('stock');
    }

}
