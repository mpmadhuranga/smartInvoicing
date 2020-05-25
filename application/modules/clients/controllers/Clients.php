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
class Clients extends Admin_Controller
{

    /**
     * Clients constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_clients');
        $this->load->model('suppliers/mdl_suppliers');
        $this->load->model('mdl_client_product');
        $this->load->database();
    }

    public function index()
    {
        // Display active clients by default
        redirect('clients/status/active');
    }

    /**
     *
     * @param string $status
     * @param int $page
     */
    public function status($status = 'active', $page = 0)
    {
        if (is_numeric(array_search($status, array(
            'active',
            'inactive'
        )))) {
            $function = 'is_' . $status;
            $this->mdl_clients->$function();
        }

        $this->mdl_clients->with_total_balance()->paginate(site_url('clients/status/' . $status), $page);
        $clients = $this->mdl_clients->result();

        $this->layout->set(array(
            'records' => $clients,
            'filter_display' => true,
            'filter_placeholder' => trans('filter_clients'),
            'filter_method' => 'filter_clients'
        ));

        $this->layout->buffer('content', 'clients/index');
        $this->layout->render();
    }

    public function statusproduct($page = 0)
    {


        $this->mdl_client_product->paginate(site_url('clients/statusproduct'), $page);
        $clients = $this->mdl_client_product->result();
        $this->load->model('mdl_clients');
        $cli = $this->mdl_clients->all_clients();
        $this->load->model('products/mdl_products');
        $products = $this->mdl_products->allproducts();

        $this->layout->set(array(
            'records' => $clients,
            'clients' => $cli,
            'products' => $products,
            'filter_display' => true,
            'filter_placeholder' => trans('filter_clients'),
            'filter_method' => 'filter_clients'
        ));

        $this->layout->buffer('content', 'clients/statusproduct');
        $this->layout->render();
    }

    public function searchdata()
    {
        $this->load->model('mdl_client_product');
        $cli = $this->input->post('stock_client_id');
        $pro = $this->input->post('stock_product_id');

        if ($cli === '0' && $pro !== '0') {
            $this->db->select('c.client_name as clientname, p.product_name as productname, cp.sel_price as sellingprice,c.client_id as client_id,cp.idip_client_product as icp_id');
            $this->db->from('ip_client_product cp');
            $this->db->join('ip_products p', 'cp.product_id = p.product_id');
            $this->db->join('ip_clients c', 'cp.client_id = c.client_id');
            $this->db->where('p.product_id = "' . $pro . '"');
            $this->db->order_by('cp.idip_client_product DESC');
            $query = $this->db->get();
            $result = $query->result();
            $clients = $result;
        }else if ($pro === '0' && $cli !== '0') {
            $this->db->select('c.client_name as clientname, p.product_name as productname, cp.sel_price as sellingprice,c.client_id as client_id,cp.idip_client_product as icp_id');
            $this->db->from('ip_client_product cp');
            $this->db->join('ip_products p', 'cp.product_id = p.product_id');
            $this->db->join('ip_clients c', 'cp.client_id = c.client_id');
            $this->db->where('c.client_id = "' . $cli . '"');
            $this->db->order_by('cp.idip_client_product DESC');
            $query = $this->db->get();
            $result = $query->result();
            $clients = $result;
        }else if($cli !== '0' && $pro !== '0'){
            $this->db->select('c.client_name as clientname, p.product_name as productname, cp.sel_price as sellingprice,c.client_id as client_id,cp.idip_client_product as icp_id');
            $this->db->from('ip_client_product cp');
            $this->db->join('ip_products p', 'cp.product_id = p.product_id');
            $this->db->join('ip_clients c', 'cp.client_id = c.client_id');
            $this->db->where('p.product_id = "'.$pro.'"');
            $this->db->where('c.client_id = "' . $cli . '"');
            $this->db->order_by('cp.idip_client_product DESC');
            $query = $this->db->get();
            $result = $query->result();
            $clients = $result;
        }else if($cli === '0' && $pro === '0'){
            $this->db->select('c.client_name as clientname, p.product_name as productname, cp.sel_price as sellingprice,c.client_id as client_id,cp.idip_client_product as icp_id');
            $this->db->from('ip_client_product cp');
            $this->db->join('ip_products p', 'cp.product_id = p.product_id');
            $this->db->join('ip_clients c', 'cp.client_id = c.client_id');
            $this->db->order_by('cp.idip_client_product DESC');
            $query = $this->db->limit(15)->get();
            $result = $query->result();
            $clients = $result;
        }

        $data = [
            'client' => $clients
        ];
        echo json_encode($data);
    }

    public function formcpc($status = 'active', $page = 0)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('clients');
        }

        $client_id = $this->input->post('client_id');
        $product_id = $this->input->post('product_id');
        $pro_sel_price = $this->input->post('product_price');

        $db_array = array(
            'product_id' => $product_id,
            'client_id' => $client_id,
            'sel_price' => $pro_sel_price
        );

        if ($this->input->post('btn_submit')) {
            $status = $this->mdl_client_product->pro_check($product_id,$client_id);
            $idd=0;
            foreach ($status as $st){
                $idd=$st->idip_client_product;
            }
            if($status){
                $products = $this->mdl_client_product->update($idd,$db_array);
            }else if(!$status){
                $this->mdl_client_product->save_client_details($db_array);
            }
            redirect("clients/statusproduct");
        }

        if (is_numeric(array_search($status, array(
            'active',
            'inactive'
        )))) {
            $function = 'is_' . $status;
            $this->mdl_clients->$function();
        }

        $this->mdl_clients->with_total_balance()->paginate(site_url('clients/status/' . $status), $page);
        // $clients = $this->mdl_clients->result();
        $clients = $this->mdl_clients->all_clients();

        $this->load->model('products/mdl_products');
        $this->mdl_products->paginate(site_url('products/index'), $page);
        $products = $this->mdl_products->result_with_qty();

        $this->layout->set(array(
            'records' => $clients,
            'products' => $products,
            'filter_display' => true,
            'filter_placeholder' => trans('filter_clients'),
            'filter_method' => 'filter_clients'
        ));

        $this->layout->buffer('content', 'clients/formcpc');
        $this->layout->render();
    }

    public function all_products()
    {
        $this->load->model('suppliers/mdl_suppliers');
        $suppliers = $this->mdl_suppliers->all_suppliers();

        $this->load->model('products/mdl_products');
        $products = $this->mdl_products->result_with_qty();

        $data = array(
            'suppliers' => $suppliers,
            'products' => $products,
            'filter_display' => true,
            'filter_placeholder' => trans('filter_clients'),
            'filter_method' => 'filter_clients'
        );

        echo json_encode($data);
    }

    public function formupdate($id, $page = 0)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('clients/statusproduct');
        }

        $client_id = $this->input->post('client_id');
        $product_id = $this->input->post('product_id');
        $pro_sel_price = $this->input->post('product_price');

        $db_array = array(
            'product_id' => $product_id,
            'client_id' => $client_id,
            'sel_price' => $pro_sel_price
        );

        if ($this->input->post('btn_submit')) {
            $this->mdl_client_product->update($id, $db_array);
            redirect('clients/statusproduct');
        }

        $details = $this->mdl_client_product->get_details_by_id($id);


        $this->load->model('mdl_clients');
        $clients = $this->mdl_clients->all_clients();
        $this->load->model('products/mdl_products');
        $products = $this->mdl_products->allproducts();

        $this->layout->set(array(
            'records' => $clients,
            'products' => $products,
            'product_id' => $details->product_id,
            'client_id' => $details->client_id,
            'sel_price' => $details->sel_price
        ));

        $this->layout->buffer('content', 'clients/formupdate');
        $this->layout->render();
    }

    /**
     *
     * @param null $id
     */
    public function form($id = null)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('clients');
        }

        $new_client = false;

        // Set validation rule based on is_update
        if ($this->input->post('is_update') == 0 && $this->input->post('client_name') != '') {
            $check = $this->db->get_where('ip_clients', array(
                'client_name' => $this->input->post('client_name'),
                'client_surname' => $this->input->post('client_surname')
            ))
                ->result();

            if (! empty($check)) {
                $this->session->set_flashdata('alert_error', trans('client_already_exists'));
                redirect('clients/form');
            } else {
                $new_client = true;
            }
        }

        if ($this->mdl_clients->run_validation()) {
            $id = $this->mdl_clients->save($id);

            if ($new_client) {
                $this->load->model('user_clients/mdl_user_clients');
                $this->mdl_user_clients->get_users_all_clients();
            }

            $this->load->model('custom_fields/mdl_client_custom');
            $result = $this->mdl_client_custom->save_custom($id, $this->input->post('custom'));

            if ($result !== true) {
                $this->session->set_flashdata('alert_error', $result);
                $this->session->set_flashdata('alert_success', null);
                redirect('clients/form/' . $id);
                return;
            } else {
                redirect('clients/view/' . $id);
            }
        }

        if ($id and ! $this->input->post('btn_submit')) {
            if (! $this->mdl_clients->prep_form($id)) {
                show_404();
            }

            $this->load->model('custom_fields/mdl_client_custom');
            $this->mdl_clients->set_form_value('is_update', true);

            $client_custom = $this->mdl_client_custom->where('client_id', $id)->get();

            if ($client_custom->num_rows()) {
                $client_custom = $client_custom->row();

                unset($client_custom->client_id, $client_custom->client_custom_id);

                foreach ($client_custom as $key => $val) {
                    $this->mdl_clients->set_form_value('custom[' . $key . ']', $val);
                }
            }
        } elseif ($this->input->post('btn_submit')) {
            if ($this->input->post('custom')) {
                foreach ($this->input->post('custom') as $key => $val) {
                    $this->mdl_clients->set_form_value('custom[' . $key . ']', $val);
                }
            }
        }

        $this->load->model('custom_fields/mdl_custom_fields');
        $this->load->model('custom_values/mdl_custom_values');
        $this->load->model('custom_fields/mdl_client_custom');

        $custom_fields = $this->mdl_custom_fields->by_table('ip_client_custom')
            ->get()
            ->result();
        $custom_values = [];
        foreach ($custom_fields as $custom_field) {
            if (in_array($custom_field->custom_field_type, $this->mdl_custom_values->custom_value_fields())) {
                $values = $this->mdl_custom_values->get_by_fid($custom_field->custom_field_id)->result();
                $custom_values[$custom_field->custom_field_id] = $values;
            }
        }

        $fields = $this->mdl_client_custom->get_by_clid($id);

        foreach ($custom_fields as $cfield) {
            foreach ($fields as $fvalue) {
                if ($fvalue->client_custom_fieldid == $cfield->custom_field_id) {
                    // TODO: Hackish, may need a better optimization
                    $this->mdl_clients->set_form_value('custom[' . $cfield->custom_field_id . ']', $fvalue->client_custom_fieldvalue);
                    break;
                }
            }
        }

        $this->load->helper('country');
        $this->load->helper('custom_values');

        $this->layout->set(array(
            'custom_fields' => $custom_fields,
            'custom_values' => $custom_values,
            'countries' => get_country_list(trans('cldr')),
            'selected_country' => $this->mdl_clients->form_value('client_country') ?: get_setting('default_country'),
            'languages' => get_available_languages()
        ));

        $this->layout->buffer('content', 'clients/form');
        $this->layout->render();
    }

    /**
     *
     * @param int $client_id
     */
    public function view($client_id)
    {
        $this->load->model('clients/mdl_client_notes');
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('payments/mdl_payments');
        $this->load->model('custom_fields/mdl_custom_fields');
        $this->load->model('custom_fields/mdl_client_custom');

        $client = $this->mdl_clients->with_total()
            ->with_total_balance()
            ->with_total_paid()
            ->where('ip_clients.client_id', $client_id)
            ->get()
            ->row();

        $custom_fields = $this->mdl_client_custom->get_by_client($client_id)->result();

        $this->mdl_client_custom->prep_form($client_id);

        if (! $client) {
            show_404();
        }

        $this->layout->set(array(
            'client' => $client,
            'client_notes' => $this->mdl_client_notes->where('client_id', $client_id)
                ->get()
                ->result(),
            'invoices' => $this->mdl_invoices->by_client($client_id)
                ->limit(20)
                ->get()
                ->result(),
            'quotes' => $this->mdl_quotes->by_client($client_id)
                ->limit(20)
                ->get()
                ->result(),
            'payments' => $this->mdl_payments->by_client($client_id)
                ->limit(20)
                ->get()
                ->result(),
            'custom_fields' => $custom_fields,
            'quote_statuses' => $this->mdl_quotes->statuses(),
            'invoice_statuses' => $this->mdl_invoices->statuses()
        ));

        $this->layout->buffer(array(
            array(
                'invoice_table',
                'invoices/partial_invoice_table'
            ),
            array(
                'quote_table',
                'quotes/partial_quote_table'
            ),
            array(
                'payment_table',
                'payments/partial_payment_table'
            ),
            array(
                'partial_notes',
                'clients/partial_notes'
            ),
            array(
                'content',
                'clients/view'
            )
        ));

        $this->layout->render();
    }

    /**
     *
     * @param int $client_id
     */
    public function delete($client_id)
    {
        $this->mdl_clients->delete($client_id);
        redirect('clients');
    }

    public function deletepro($id)
    {
        $this->mdl_client_product->delete($id);
        redirect('clients/statusproduct');
    }
}
