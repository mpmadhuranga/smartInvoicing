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
 * Class Ajax
 */
class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function name_query()
    {
        // Load the model & helper
        $this->load->model('products/mdl_products');
        //$this->load->model('products/mdl_products_cli');

        $response = [];

        // Get the post input
        $query = $this->input->get('query');
        $permissiveSearchClients = $this->input->get('permissive_search_products');

        if (empty($query)) {
            echo json_encode($response);
            exit;
        }

        // Search for chars "in the middle" of clients names
        $permissiveSearchClients ? $moreClientsQuery = '%' : $moreClientsQuery = '';

        // Search for clients
        $escapedQuery = $this->db->escape_str($query);
        $escapedQuery = str_replace("%", "", $escapedQuery);
        $products = $this->mdl_products
            ->having('product_name LIKE \'' . $moreClientsQuery . $escapedQuery . '%\'')
            ->or_having('provider_name LIKE \'' . $moreClientsQuery . $escapedQuery . '%\'')
            ->order_by('product_name')
            ->get()
            ->result();

        foreach ($products as $productsRow) {
            $response[] = [
                'id' => $productsRow->product_id,
                'text' => $productsRow->product_name . " - " . $productsRow->product_sku,
            ];
        }

        // Return the results
        echo json_encode($response);
    }

    public function modal_product_lookups()
    {
        $filter_product = $this->input->get('filter_product');
        $filter_family = $this->input->get('filter_family');
        $reset_table = $this->input->get('reset_table');

        $this->load->model('mdl_products');
        $this->load->model('families/mdl_families');
        $this->load->model('clients/mdl_client_product');

        if (!empty($filter_family)) {
            $this->mdl_products->by_family($filter_family);
        }

        if (!empty($filter_product)) {
            $this->mdl_products->by_product($filter_product);
        }

        $client_id = $this->input->post('client_id');

        $products = $this->mdl_products->def_pro();

        $products_clients = $this->mdl_client_product->resjoin($client_id);

        $families = $this->mdl_families->get()->result();

        foreach ($products_clients as $values) {
            foreach ($products as $value) {
                if ($value->product_id === $values->product_id) {
                    $value->product_price = $values->product_price;
                }
            }
        }

        $default_item_tax_rate = get_setting('default_item_tax_rate');
        $default_item_tax_rate = $default_item_tax_rate !== '' ?: 0;

        $data = array(
            'products' => $products,
            'families' => $families,
            'cli_id' => $client_id,
            'filter_product' => $filter_product,
            'filter_family' => $filter_family,
            'default_item_tax_rate' => $default_item_tax_rate,
        );

        if ($filter_product || $filter_family || $reset_table) {
            $this->layout->load_view('products/partial_product_table_modal', $data);
        } else {
            $this->layout->load_view('products/modal_product_lookups', $data);
        }
    }

    public function checksku()
    {
        $this->load->model('invoices/mdl_invoices');

        $sku = $this->input->post('sku');
        $status = $this->mdl_invoices->sku_check($sku);
        $productsku = $status['product_sku'];
        if ($productsku) {
            $response = [
                'success' => 1,
                'sku' => $sku
            ];
        }

        echo json_encode($response);
    }

    public function modal_product_lookups_pn()
    {
        $filter_product = $this->input->get('filter_product');
        $filter_family = $this->input->get('filter_family');
        $reset_table = $this->input->get('reset_table');

        $this->load->model('mdl_products');
        $this->load->model('families/mdl_families');
        $this->load->model('clients/mdl_client_product');

        if (!empty($filter_family)) {
//            $this->mdl_products->by_family($filter_family);
        }

        if (!empty($filter_product)) {
//            $this->mdl_products->by_product($filter_product);
        }

        $client_id = $this->input->get('client_id');
        $products = $this->mdl_client_product->resjoinpn($client_id, $filter_product);
        $status = $this->mdl_client_product->cli_check($client_id);
        if (!$status) {
            $products = $this->mdl_client_product->resjoinpns($filter_product);
        }
//        $products = $this->mdl_products->get()->result();

        $families = $this->mdl_families->get()->result();

        $default_item_tax_rate = get_setting('default_item_tax_rate');
        $default_item_tax_rate = $default_item_tax_rate !== '' ?: 0;

        $data = array(
            'products' => $products,
            'cli_id' => $client_id,
            'families' => $families,
            'filter_product' => $filter_product,
            'filter_family' => $filter_family,
            'default_item_tax_rate' => $default_item_tax_rate,
        );

        if ($filter_product || $filter_family || $reset_table) {
            $this->layout->load_view('products/partial_product_table_modal', $data);
        } else {
            $this->layout->load_view('products/modal_product_lookups', $data);
        }
    }

    public function modal_product_sup()
    {
        $filter_product = $this->input->get('filter_product');
        $filter_family = $this->input->get('filter_family');
        $reset_table = $this->input->get('reset_table');

        $this->load->model('mdl_products');
        $this->load->model('families/mdl_families');
//        $this->load->model('clients/mdl_client_product');

        if (!empty($filter_family)) {
            $this->mdl_products->by_family($filter_family);
        }

        if (!empty($filter_product)) {
            $this->mdl_products->by_product($filter_product);
        }

        $products = $this->mdl_products->get()->result();
        $client_id = $this->input->post('client_id');
        $families = $this->mdl_families->get()->result();

        $default_item_tax_rate = get_setting('default_item_tax_rate');
        $default_item_tax_rate = $default_item_tax_rate !== '' ?: 0;

        $data = array(
            'products' => $products,
            'families' => $families,
            'filter_product' => $filter_product,
            'filter_family' => $filter_family,
            'default_item_tax_rate' => $default_item_tax_rate,
        );

        if ($filter_product || $filter_family || $reset_table) {
            $this->layout->load_view('products/partial_product_table_modal_sup', $data);
        } else {
            $this->layout->load_view('products/modal_product_lookups_sup', $data);
        }
    }

    public function process_product_selections()
    {
        $this->load->model('mdl_products');
        $this->load->model('clients/mdl_client_product');

        $products = array();
        $products = $this->mdl_products->where_in('product_id', $this->input->post('product_ids'))->get()->result_array();
        $client_id = $this->input->post('client_id');


        $products_arr = array();
        foreach ($products as $product) {
            $product_id = $product['product_id'];
            $status = $this->mdl_client_product->check_client_product($client_id, $product_id);

            if (!$status) {
                $result = $this->mdl_client_product->wherein_products($product_id);
                array_push($products_arr, array(
                    'product_sku' => $result['product_sku'],
                    'family_name' => $result['family_name'],
                    'product_id' => $result['product_id'],
                    'product_name' => $result['product_name'],
                    'product_description' => $result['product_description'],
                    'product_price' => $result['product_price'],
                    'client_id' => $client_id,
                ));
            } else {
                $result = $this->mdl_client_product->wherein($client_id, $product_id);

                array_push($products_arr, array(
                    'product_sku' => $result['product_sku'],
                    'family_name' => $result['family_name'],
                    'product_id' => $result['product_id'],
                    'product_name' => $result['product_name'],
                    'product_description' => $result['product_description'],
                    'product_price' => $result['product_price'],
                    'client_id' => $client_id,
                    'icp_id' => $result['icp_id']
                ));
            }
        }
        echo json_encode($products_arr);
    }

    public function process_product_selections_sup()
    {
        $this->load->model('mdl_products');
//        $this->load->model('clients/mdl_client_product');

        $products = array();
        $products = $this->mdl_products->where_in('product_id', $this->input->post('product_ids'))->get()->result_array();
//        $client_id=$this->input->post('client_id');


        $products_arr = array();
        foreach ($products as $product) {
            $product_id = $product['product_id'];
//            $client_id = $product['client_id'];
            $result = $this->mdl_products->wherein($product_id);
            array_push($products_arr, array(
//                'clientname'=>$result['clientname'],
                'product_sku' => $result['product_sku'],
                'family_name' => $result['family_name'],
                'product_id' => $result['product_id'],
                'product_name' => $result['product_name'],
                'product_description' => $result['product_description'],
                'product_price' => $result['product_price'],
//                'client_id'=>$result['client_id'],
//                'icp_id'=>$result['icp_id']
            ));
        }
        echo json_encode($products_arr);
    }


    function console_log($data)
    {
        echo '<script>';
        echo 'console.log(' . json_encode($data) . ')';
        echo '</script>';
    }

    public function search_products()
    {
        $this->load->model('mdl_products');
        $product_families_id = $this->input->post('product_families_id');
        $product_id = $this->input->post('product_id');

        if($product_id === '0' && $product_families_id !== '0'){
            $products = $this->mdl_products->search_by_family($product_families_id)->get()->result();
        }else if($product_families_id === '0' && $product_id !== '0'){
            $products = $this->mdl_products->search_product_id($product_id)->get()->result();
        }else if($product_id === '0' && $product_families_id === '0'){
            $products = $this->mdl_products->limit(15)->get()->result();
        }else{
            $products = $this->mdl_products->search_product_id($product_id,$product_families_id)->get()->result();
          }

        $data = array(
            'products' => $products
        );

        $this->layout->load_view('products/partial_products_table', $data);
    }


}
