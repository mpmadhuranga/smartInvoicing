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
 * Class Mdl_Clients
 */
class Mdl_Stock extends Response_Model
{
    public $table = 'ip_products_stock';
    public $primary_key = 'ip_products_stock.stock_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_products_stock.stock_create_date DESC');
    }

    public function default_join()
    {
        $this->db->join('ip_products', 'ip_products.product_id = ip_products_stock.stock_product_id');
        $this->db->join('ip_suppliers', 'ip_suppliers.supplier_id = ip_products_stock.stock_suppliers_id','left');
    }



    /**
     * @param int $amount
     * @return mixed
     */
    function get_latest($amount = 10)
    {
        return $this->mdl_suppliers
            ->where('supplier_active', 1)
            ->order_by('supplier_id', 'DESC')
            ->limit($amount)
            ->get()
            ->result();
    }

    /**
     * @param $input
     * @return string
     */


    function convert_date($input)
    {
        $this->load->helper('date_helper');

        if ($input == '') {
            return '';
        }

        return date_to_mysql($input);
    }

    public function db_array()
    {
        $db_array = parent::db_array();

//        if (!isset($db_array['supplier_active'])) {
        $db_array['user_id'] = $this->session->userdata('user_id');
        $db_array['buying_price'] = $this->input->post('stock_bp');
//        }

        return $db_array;
    }
    public function validation_rules()
    {
        return array(
            'stock_product_id' => array(
                'field' => 'stock_product_id',
                'label' => trans('Product'),
                'rules' => 'required'
            ),
            'stock_open_qty' => array(
                'field' => 'stock_open_qty',
                'label' => trans('Opening balance'),
                'rules' => 'required'
            ),
            'stock_qty' => array(
                'field' => 'stock_qty'
            ),
            'stock_suppliers_id' => array(
                'field' => 'stock_suppliers_id',
                'label' => trans('Suppliers'),
                'rules' => 'required'
            ),
            'buying_price' => array(
                'field' => 'buying_price',
                'label' => trans('buyp'),
                'rules' => ''
            )
        );
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        parent::delete($id);

        $this->load->helper('orphan');
        delete_orphans();
    }

    public function get_stock_qty($product_id)
    {
        $sql = "SELECT SUM(stock_qty) AS QT 
FROM `ip_products_stock` JOIN `ip_products` ON `ip_products`.`product_id` = `ip_products_stock`.`stock_product_id` 
LEFT JOIN `ip_suppliers` ON `ip_suppliers`.`supplier_id` = `ip_products_stock`.`stock_suppliers_id` 
WHERE `stock_product_id` = '$product_id' AND `stock_qty` != 0 ORDER BY `ip_products_stock`.`stock_create_date` DESC";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }
}
