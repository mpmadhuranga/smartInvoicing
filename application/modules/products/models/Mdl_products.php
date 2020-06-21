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
 * Class Mdl_Products
 */
class Mdl_Products extends Response_Model
{
    public $table = 'ip_products';
    public $primary_key = 'ip_products.product_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *,sum(ip_products_stock.stock_qty) as pro_qty', false);
    }
    
    public function sku_check($sku)
    {
        $sql = "SELECT count(product_sku) as skucount FROM ip_products WHERE product_sku='$sku'";
        $query = $this->db->query($sql);
        return $result = $query->row_array();
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_families.family_name, ip_products.product_name');
        $this->db->group_by('ip_products.product_name');
    }

    public function default_join()
    {
        $this->db->join('ip_families', 'ip_families.family_id = ip_products.family_id', 'left');
        $this->db->join('ip_units', 'ip_units.unit_id = ip_products.unit_id', 'left');
        $this->db->join('ip_tax_rates', 'ip_tax_rates.tax_rate_id = ip_products.tax_rate_id', 'left');
        $this->db->join('ip_products_stock', 'ip_products_stock.stock_product_id = ip_products.product_id', 'left');
    }

    public function by_product($match)
    {
        $this->db->group_start();
        $this->db->like('ip_products.product_sku', $match);
        $this->db->or_like('ip_products.product_name', $match);
        $this->db->or_like('ip_products.product_description', $match);
        $this->db->group_end();
    }

    public function by_family($match)
    {
        $this->db->where('ip_products.family_id', $match);
    }

    public function by_product_id($match)
    {
         $this->db->where('ip_products.product_id', $match);
    }

    public function search_product_id($match)
    {
         $this->db->where('ip_products.product_id', $match);
         return $this;
    }

    public function search_by_family($match)
    {
        $this->db->where('ip_products.family_id', $match);
        return $this;
    }

    public function search_by_family_product_id($id,$family_id)
    {
        $this->db->where('ip_products.product_id', $id);
        $this->db->where('ip_products.family_id', $family_id);
        return $this;
    }

    public function result_with_qty()
    {
        $sql = 'SELECT SUM(ip_products_stock.stock_qty) as product_qty,product_id, ip_products.family_id, product_sku, product_name, product_description, product_price, purchase_price, provider_name, ip_products.tax_rate_id, ip_products.unit_id, product_tariff, ip_families.family_name, ip_units.unit_name FROM ip_products LEFT JOIN ip_products_stock ON ip_products.product_id = ip_products_stock.stock_product_id 
LEFT JOIN ip_families ON ip_families.family_id = ip_products.family_id 
LEFT JOIN ip_units ON ip_units.unit_id = ip_products.unit_id 
LEFT JOIN ip_tax_rates ON ip_tax_rates.tax_rate_id = ip_products.tax_rate_id 
GROUP BY ip_products.product_id';
        $query = $this->db->query($sql);
        return $result = $query->result();
        //  print_r($result);
    }

    public function update_quantity($value,$id){
        $data = array(
            'product_qty' => $value,
        );

        $this->db->where('product_id', $id);
        $this->db->update('ip_products', $data);
    }

    public function wherein($product_id)
    {
        $sql = "select p.product_sku as product_sku,f.family_name as family_name, p.product_id as product_id,p.product_name as product_name,p.product_description as product_description, p.product_price as product_price
from ip_products p,ip_families f
where p.family_id=f.family_id and p.product_id=$product_id";
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    
    public function def_pro()
    {
        $this->db->select('sum(s.stock_qty) as stqty,p.product_sku as product_sku,p.product_id as product_id,f.family_name as family_name,p.product_name as product_name,p.product_description as product_description, p.product_price as product_price');
        $this->db->from('ip_products_stock s');
        $this->db->join('ip_products p', 'p.product_id = s.stock_product_id');
        $this->db->join('ip_families f', 'p.family_id=f.family_id');
        $this->db->group_by('p.product_id');
        $this->db->order_by('p.product_name');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    public function allproducts()
    {
        $sql = "SELECT * from ip_products order by product_name";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function search_by_product_id($id)
    {
        $this->db->select('*');
        $this->db->from('ip_products');
        $this->db->where('product_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'product_sku' => array(
                'field' => 'product_sku',
                'label' => trans('product_sku'),
                'rules' => ''
            ),
            'product_name' => array(
                'field' => 'product_name',
                'label' => trans('product_name'),
                'rules' => 'required'
            ),
            'product_description' => array(
                'field' => 'product_description',
                'label' => trans('product_description'),
                'rules' => ''
            ),
            'product_price' => array(
                'field' => 'product_price',
                'label' => trans('product_price'),
                'rules' => 'required'
            ),
            'purchase_price' => array(
                'field' => 'purchase_price',
                'label' => trans('purchase_price'),
                'rules' => ''
            ),
            'provider_name' => array(
                'field' => 'provider_name',
                'label' => trans('provider_name'),
                'rules' => ''
            ),
            'product_qty' => array(
                'field' => 'product_qty',
                'label' => trans('product_qty'),
                'rules' => ''
            ),
            'family_id' => array(
                'field' => 'family_id',
                'label' => trans('family'),
                'rules' => 'numeric'
            ),
            'unit_id' => array(
                'field' => 'unit_id',
                'label' => trans('unit'),
                'rules' => 'numeric'
            ),
            'tax_rate_id' => array(
                'field' => 'tax_rate_id',
                'label' => trans('tax_rate'),
                'rules' => 'numeric'
            ),
            'product_tariff' => array(
                'field' => 'product_tariff',
                'label' => trans('product_tariff'),
                'rules' => ''
            ),
            'min_qty' => array(
                'field' => 'min_qty',
                'label' => trans('min_qty'),
                'rules' => ''
            ),
        );
    }

    /**
     * @return array
     */
    public function db_array()
    {
        $db_array = parent::db_array();

        $db_array['product_price'] = (empty($db_array['product_price']) ? null : standardize_amount($db_array['product_price']));
        $db_array['purchase_price'] = (empty($db_array['purchase_price']) ? null : standardize_amount($db_array['purchase_price']));
        $db_array['family_id'] = (empty($db_array['family_id']) ? null : $db_array['family_id']);
        $db_array['unit_id'] = (empty($db_array['unit_id']) ? null : $db_array['unit_id']);
        $db_array['tax_rate_id'] = (empty($db_array['tax_rate_id']) ? null : $db_array['tax_rate_id']);
        $db_array['min_qty'] = (empty($db_array['min_qty']) ? null : $db_array['min_qty']);
        $db_array['added_date'] = date("Y-m-d");
        // $db_array['product_qty'] = (empty($db_array['product_qty']) ? null : $db_array['product_qty']);

        return $db_array;
    }

}
