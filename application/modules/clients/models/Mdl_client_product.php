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
 * Class Mdl_Invoice_Tax_Rates
 */
class Mdl_client_product extends Response_Model
{
    public $table = 'ip_client_product';
    public $primary_key = 'ip_client_product.idip_client_product';

    function __construct() {
        parent::__construct();
    }


    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS 
        ip_clients.client_name, ip_products.product_name, ip_client_product.sel_price,ip_clients.client_id,ip_client_product.idip_client_product as icp_id', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_client_product.idip_client_product DESC');
    }

    public function default_join()
    {
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_client_product.client_id');
        $this->db->join('ip_products', 'ip_products.product_id = ip_client_product.product_id');
    }

    //    public function result()
//    {
//        $sql = 'select c.client_name as clientname, p.product_name as productname, cp.sel_price as sellingprice,c.client_id as client_id,cp.idip_client_product as icp_id
//from ip_clients c, ip_products p, ip_client_product cp
//where cp.product_id = p.product_id and cp.client_id = c.client_id';
//        $query = $this->db->query($sql);
//        return $result = $query->result();
//    }

    /**
     * @param null $id
     * @param null $db_array
     * @return void
     */
    public function save_client_details($db_array)
    {
        $this->db->insert('ip_client_product', $db_array);
    }

    public function delete($id)
    {
        $this->db->where('idip_client_product', $id);
        $this->db->delete('ip_client_product');
    }

    public function update($id,$db_array)
    {
        $this->db->where('idip_client_product', $id);
        $this->db->update('ip_client_product', $db_array);
    }
    
    public function pro_check($product_id,$client_id)
    {
        $sql = "select idip_client_product,product_id,client_id
from ip_client_product
where product_id=$product_id and client_id =$client_id";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function get_details_by_id($id)
    {
        $sql = "select idip_client_product,product_id,client_id,sel_price
from ip_client_product
where idip_client_product=$id";
        $query = $this->db->query($sql);
        return $result = $query->row();
    }
    
    public function updatepro($id,$sel_price)
    {
        $this->db->where('idip_client_product', $id);
        $this->db->update('sel_price', $sel_price);
    }
    
    public function resultss($pro,$cli)
    {
        $sql = "select c.client_name as clientname, p.product_name as productname, cp.sel_price as sellingprice,c.client_id as client_id,cp.idip_client_product as icp_id
from ip_clients c, ip_products p, ip_client_product cp
where cp.product_id = p.product_id and cp.client_id = c.client_id and c.client_id=$cli and p.product_id=$pro";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function cli_check($client_id)
    {
        $sql = "select client_id
from ip_client_product
where client_id =$client_id";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function check_client_product($client_id,$product_id)
    {
        $sql = "select client_id
from ip_client_product
where client_id =$client_id AND product_id=$product_id";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function resjoin($client_id)
    {
        $this->db->select("sum(s.stock_qty) as stqty,c.client_name as clientname,p.product_sku as product_sku,f.family_name as family_name,f.family_id as family_id, p.product_id as product_id,p.product_name as product_name,p.product_description as product_description, cp.sel_price as product_price,c.client_id as client_id,cp.idip_client_product as icp_id");
        $this->db->from("ip_products_stock s");
        $this->db->join("ip_clients c", "c.client_id='$client_id'");
        $this->db->join("ip_client_product cp", "cp.product_id=s.stock_product_id and cp.client_id='$client_id'");
        $this->db->join("ip_products p", "p.product_id = cp.product_id");
        $this->db->join("ip_families f", "p.family_id=f.family_id");
        $this->db->group_by("p.product_id");
        $this->db->order_by("p.product_name");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function resjoinpn($client_id,$pro)
    {
        $sql = "select sum(ps.stock_qty) as stqty,c.client_name as clientname,p.product_sku as product_sku,f.family_name as family_name,f.family_id as family_id, p.product_id as product_id,p.product_name as product_name,p.product_description as product_description, cp.sel_price as product_price,c.client_id as client_id,cp.idip_client_product as icp_id
from ip_clients c, ip_products p, ip_client_product cp,ip_families f,ip_products_stock ps
where cp.product_id = p.product_id and cp.product_id=ps.stock_product_id and cp.client_id =$client_id and c.client_id=$client_id and p.family_id=f.family_id and p.product_name like '$pro%' group by p.product_id";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function resjoinpns($pro)
    {
        $sql = "select sum(ps.stock_qty) as stqty,p.product_sku as product_sku,f.family_name as family_name,f.family_id as family_id, p.product_id as product_id,p.product_name as product_name,p.product_description as product_description, p.product_price as product_price
from  ip_products p,ip_families f,ip_products_stock ps
where p.product_id=ps.stock_product_id and p.family_id=f.family_id and p.product_name like '$pro%' group by p.product_id";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function wherein($client_id,$product_id)
    {
         $sql = "select c.client_name as clientname,p.product_sku as product_sku,f.family_name as family_name, p.product_id as product_id,p.product_name as product_name,p.product_description as product_description, cp.sel_price as product_price,c.client_id as client_id,cp.idip_client_product as icp_id
from ip_clients c, ip_products p, ip_client_product cp,ip_families f
where cp.product_id = p.product_id and cp.client_id = $client_id and c.client_id=$client_id and p.family_id=f.family_id and p.product_id=$product_id";
            $query = $this->db->query($sql);
            return $query->row_array();
    }
    
    public function wherein_products($product_id)
    {
            $sql = "select p.product_sku as product_sku,f.family_name as family_name, p.product_id as product_id,p.product_name as product_name,p.product_description as product_description, p.product_price as product_price
from ip_products p,ip_families f
where p.family_id=f.family_id and p.product_id=$product_id";
            $query = $this->db->query($sql);
            return $query->row_array();
    }

    public function get_clients()
    {
        $sql = 'select c.client_name as clientname, p.product_name as productname, cp.sel_price as sellingprice,c.client_id as client_id,cp.idip_client_product as icp_id
from ip_clients c, ip_products p, ip_client_product cp
where cp.product_id = p.product_id and cp.client_id = c.client_id';
        $query = $this->db->query($sql);
        return $result = $query->result();
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

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'sumex_invoice' => array(
                'field' => 'sumex_invoice',
                'label' => trans('invoice'),
                'rules' => 'required'
            ),
            'sumex_reason' => array(
                'field' => 'sumex_reason',
                'label' => trans('reason'),
                'rules' => 'required|greater_than_equal_to[0]|less_than_equal_to[5]'
            ),
            'sumex_diagnosis' => array(
                'field' => 'sumex_diagnosis',
                'label' => trans('diagnosis')
            ),
            'sumex_observations' => array(
                'field' => 'sumex_observations',
                'label' => trans('sumex_observations')
            ),
            'sumex_treatmentstart' => array(
                'field' => 'sumex_treatmentstart',
                'label' => trans('start'),
                'rules' => 'required'
            ),
            'sumex_treatmentend' => array(
                'field' => 'sumex_treatmentend',
                'label' => trans('end'),
                'rules' => 'required'
            ),
            'sumex_casedate' => array(
                'field' => 'sumex_casedate',
                'label' => trans('case_date'),
                'rules' => 'required'
            ),
            'sumex_casenumber' => array(
                'field' => 'sumex_casenumber',
                'label' => trans('case_number')
            )
        );
    }

}
