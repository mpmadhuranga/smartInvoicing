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
class Mdl_Cheque extends Response_Model
{
    public $table = 'ip_cheques';
    public $primary_key = 'ip_cheques.cheque_id';

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

        $db_array['supplier_id'] = $this->input->post('stock_suppliers_id');
        $db_array['added_date'] = date_to_mysql($this->input->post('from_date'));
        $db_array['amount'] = $this->input->post('amount');
        $db_array['check_no'] = $this->input->post('chequeno');
        $db_array['clear'] = $this->input->post('clear');

        return $db_array;
    }
    public function validation_rules()
    {
        return array(
            'supplier_id' => array(
                'field' => 'stock_suppliers_id',
                'label' => trans('Supplier'),
                'rules' => 'required'
            ),
            'added_date' => array(
                'field' => 'from_date',
                'label' => trans('date'),
                'rules' => 'required'
            ),
            'amount' => array(
                'field' => 'amount',
                'label' => trans('amount'),
                'rules' => 'required'
            ),
            'check_no' => array(
                'field' => 'chequeno',
                'label' => trans('chequeno'),
                'rules' => ''
            ),
            'clear' => array(
                'field' => 'clear',
                'label' => trans('cleared'),
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
    
    public function allcheques()
    {
        $this->db->select('c.cheque_id as cheque_id,s.supplier_name as supplier_name,c.added_date as added_date,c.amount as amount,c.check_no as check_no,c.clear as clear');
        $this->db->from('ip_cheques c');
        $this->db->join('ip_suppliers s', 'c.supplier_id = s.supplier_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
}
