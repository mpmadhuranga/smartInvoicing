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
 * Class Mdl_Invoices
 */
class Mdl_Invoices extends Response_Model
{

    public $table = 'ip_invoices';

    public $primary_key = 'ip_invoices.invoice_id';

    public $date_modified_field = 'invoice_date_modified';

    /**
     *
     * @return array
     */
    public function statuses()
    {
        return array(
            '1' => array(
                'label' => trans('draft'),
                'class' => 'draft',
                'href' => 'invoices/status/draft'
            ),
            '2' => array(
                'label' => trans('sent'),
                'class' => 'sent',
                'href' => 'invoices/status/sent'
            ),
            '3' => array(
                'label' => trans('viewed'),
                'class' => 'viewed',
                'href' => 'invoices/status/viewed'
            ),
            '4' => array(
                'label' => trans('paid'),
                'class' => 'paid',
                'href' => 'invoices/status/paid'
            ),
            '5' => array(
                'label' => trans('canceled'),
                'class' => 'canceled',
                'href' => 'invoices/status/canceled'
            ),
            '6' => array(
                'label' => trans('partial'),
                'class' => 'viewed',
                'href' => 'invoices/status/partial'
            )
        );
    }

    public function default_select()
    {
        $this->db->select("
            SQL_CALC_FOUND_ROWS
            ip_quotes.*,
            ip_users.*,
            ip_clients.*,
            ip_invoice_sumex.*,
            ip_invoice_amounts.invoice_amount_id,
            IFnull(ip_invoice_amounts.invoice_item_subtotal, '0.00') AS invoice_item_subtotal,
            IFnull(ip_invoice_amounts.invoice_item_tax_total, '0.00') AS invoice_item_tax_total,
            IFnull(ip_invoice_amounts.invoice_tax_total, '0.00') AS invoice_tax_total,
            IFnull(ip_invoice_amounts.invoice_total, '0.00') AS invoice_total,
            IFnull(ip_invoice_amounts.invoice_paid, '0.00') AS invoice_paid,
            IFnull(ip_invoice_amounts.invoice_balance, '0.00') AS invoice_balance,
            ip_invoice_amounts.invoice_sign AS invoice_sign,
            (CASE WHEN ip_invoices.invoice_status_id NOT IN (1,4) AND DATEDIFF(NOW(), invoice_date_due) > 0 THEN 1 ELSE 0 END) is_overdue,
            DATEDIFF(NOW(), invoice_date_due) AS days_overdue,
            (CASE (SELECT COUNT(*) FROM ip_invoices_recurring WHERE ip_invoices_recurring.invoice_id = ip_invoices.invoice_id and ip_invoices_recurring.recur_next_date <> '0000-00-00') WHEN 0 THEN 0 ELSE 1 END) AS invoice_is_recurring,
            ip_invoices.*", false);
    }

    public function dashboard_invoice()
    {
        $sql = "SELECT ip_quotes.*, ip_users.*, 
ip_clients.*, ip_invoice_sumex.*, ip_invoice_amounts.invoice_amount_id, 
IFnull(ip_invoice_amounts.invoice_item_subtotal, '0.00') AS invoice_item_subtotal,
 IFnull(ip_invoice_amounts.invoice_item_tax_total, '0.00') AS invoice_item_tax_total, 
 IFnull(ip_invoice_amounts.invoice_tax_total, '0.00') AS invoice_tax_total, 
 IFnull(ip_invoice_amounts.invoice_total, '0.00') AS invoice_total, IFnull(ip_invoice_amounts.invoice_paid, '0.00') 
 AS invoice_paid, IFnull(ip_invoice_amounts.invoice_balance, '0.00') AS invoice_balance, ip_invoice_amounts.invoice_sign 
 AS invoice_sign, (CASE WHEN ip_invoices.invoice_status_id NOT IN (1, 4) AND DATEDIFF(NOW(), invoice_date_due) > 0 THEN 1 ELSE 0 END) is_overdue, DATEDIFF(NOW(), invoice_date_due) AS days_overdue, (CASE (SELECT COUNT(*) 
 FROM ip_invoices_recurring WHERE ip_invoices_recurring.invoice_id = ip_invoices.invoice_id and ip_invoices_recurring.recur_next_date <> '0000-00-00') WHEN 0 THEN 0 ELSE 1 END) AS invoice_is_recurring, ip_invoices.* 
 FROM `ip_invoices` JOIN `ip_clients` ON `ip_clients`.`client_id` = `ip_invoices`.`client_id` JOIN `ip_users` ON `ip_users`.`user_id` = `ip_invoices`.`user_id` 
 LEFT JOIN `ip_invoice_amounts` ON `ip_invoice_amounts`.`invoice_id` = `ip_invoices`.`invoice_id` LEFT JOIN `ip_invoice_sumex` ON `sumex_invoice` = `ip_invoices`.`invoice_id` 
 LEFT JOIN `ip_quotes` ON `ip_quotes`.`invoice_id` = `ip_invoices`.`invoice_id` ORDER BY `ip_invoices`.`invoice_number` DESC LIMIT 10";

        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_invoices.invoice_number DESC');
    }

    public function default_join()
    {
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id');
        $this->db->join('ip_users', 'ip_users.user_id = ip_invoices.user_id');
        $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');
        $this->db->join('ip_invoice_sumex', 'sumex_invoice = ip_invoices.invoice_id', 'left');
        $this->db->join('ip_quotes', 'ip_quotes.invoice_id = ip_invoices.invoice_id', 'left');
    }

    /**
     *
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'client_id' => array(
                'field' => 'client_id',
                'label' => trans('client'),
                'rules' => 'required'
            ),
            'invoice_date_created' => array(
                'field' => 'invoice_date_created',
                'label' => trans('invoice_date'),
                'rules' => 'required'
            ),
            'invoice_time_created' => array(
                'rules' => 'required'
            ),
            'invoice_group_id' => array(
                'field' => 'invoice_group_id',
                'label' => trans('invoice_group'),
                'rules' => 'required'
            ),
            'invoice_password' => array(
                'field' => 'invoice_password',
                'label' => trans('invoice_password')
            ),
            'user_id' => array(
                'field' => 'user_id',
                'label' => trans('user'),
                'rule' => 'required'
            ),
            'payment_method' => array(
                'field' => 'payment_method',
                'label' => trans('payment_method')
            )
        );
    }

    /**
     *
     * @return array
     */
    public function validation_rules_save_invoice()
    {
        return array(
            'invoice_number' => array(
                'field' => 'invoice_number',
                'label' => trans('invoice') . ' #',
                'rules' => 'is_unique[ip_invoices.invoice_number' . (($this->id) ? '.invoice_id.' . $this->id : '') . ']'
            ),
            'invoice_date_created' => array(
                'field' => 'invoice_date_created',
                'label' => trans('date'),
                'rules' => 'required'
            ),
            'invoice_date_due' => array(
                'field' => 'invoice_date_due',
                'label' => trans('due_date'),
                'rules' => 'required'
            ),
            'invoice_time_created' => array(
                'rules' => 'required'
            ),
            'invoice_password' => array(
                'field' => 'invoice_password',
                'label' => trans('invoice_password')
            )
        );
    }

    /**
     *
     * @param null $db_array
     * @param bool $include_invoice_tax_rates
     * @return int|null
     */
    public function create($db_array = null, $include_invoice_tax_rates = true)
    {
        $invoice_id = parent::save(null, $db_array);

        $inv = $this->where('ip_invoices.invoice_id', $invoice_id)
            ->get()
            ->row();
        $invoice_group = $inv->invoice_group_id;

        // Create an invoice amount record
        $db_array = array(
            'invoice_id' => $invoice_id
        );

        $this->db->insert('ip_invoice_amounts', $db_array);

        if ($include_invoice_tax_rates) {
            // Create the default invoice tax record if applicable
            if (get_setting('default_invoice_tax_rate')) {
                $db_array = array(
                    'invoice_id' => $invoice_id,
                    'tax_rate_id' => get_setting('default_invoice_tax_rate'),
                    'include_item_tax' => get_setting('default_include_item_tax', 0),
                    'invoice_tax_rate_amount' => 0
                );

                $this->db->insert('ip_invoice_tax_rates', $db_array);
            }
        }

        if ($invoice_group !== '0') {
            $this->load->model('invoice_groups/mdl_invoice_groups');
            $invgroup = $this->mdl_invoice_groups->where('invoice_group_id', $invoice_group)
                ->get()
                ->row();
            if (preg_match("/sumex/i", $invgroup->invoice_group_name)) {
                // If the Invoice Group includes "Sumex", make the invoice a Sumex one
                $db_array = array(
                    'sumex_invoice' => $invoice_id
                );
                $this->db->insert('ip_invoice_sumex', $db_array);
            }
        }

        return $invoice_id;
    }

    /**
     * Copies invoice items, tax rates, etc from source to target
     *
     * @param int $source_id
     * @param int $target_id
     * @param bool $copy_recurring_items_only
     */
    public function copy_invoice($source_id, $target_id, $copy_recurring_items_only = false)
    {
        $this->load->model('invoices/mdl_items');
        $this->load->model('invoices/mdl_invoice_tax_rates');

        // Copy the items
        $invoice_items = $this->mdl_items->where('invoice_id', $source_id)
            ->get()
            ->result();

        foreach ($invoice_items as $invoice_item) {
            $db_array = array(
                'invoice_id' => $target_id,
                'item_tax_rate_id' => $invoice_item->item_tax_rate_id,
                'item_product_id' => $invoice_item->item_product_id,
                'item_task_id' => $invoice_item->item_task_id,
                'item_name' => $invoice_item->item_name,
                'item_description' => $invoice_item->item_description,
                'item_quantity' => $invoice_item->item_quantity,
                'item_price' => $invoice_item->item_price,
                'item_discount_amount' => $invoice_item->item_discount_amount,
                'item_order' => $invoice_item->item_order,
                'item_is_recurring' => $invoice_item->item_is_recurring,
                'item_product_unit' => $invoice_item->item_product_unit,
                'item_product_unit_id' => $invoice_item->item_product_unit_id
            );

            if (! $copy_recurring_items_only || $invoice_item->item_is_recurring) {
                $this->mdl_items->save(null, $db_array);
            }
        }

        // Copy the tax rates
        $invoice_tax_rates = $this->mdl_invoice_tax_rates->where('invoice_id', $source_id)
            ->get()
            ->result();

        foreach ($invoice_tax_rates as $invoice_tax_rate) {
            $db_array = array(
                'invoice_id' => $target_id,
                'tax_rate_id' => $invoice_tax_rate->tax_rate_id,
                'include_item_tax' => $invoice_tax_rate->include_item_tax,
                'invoice_tax_rate_amount' => $invoice_tax_rate->invoice_tax_rate_amount
            );

            $this->mdl_invoice_tax_rates->save(null, $db_array);
        }

        // Copy the custom fields
        $this->load->model('custom_fields/mdl_invoice_custom');
        $custom_fields = $this->mdl_invoice_custom->where('invoice_id', $source_id)
            ->get()
            ->result();

        $form_data = array();
        foreach ($custom_fields as $field) {
            $form_data[$field->invoice_custom_fieldid] = $field->invoice_custom_fieldvalue;
        }
        $this->mdl_invoice_custom->save_custom($target_id, $form_data);
    }

    /**
     * Copies invoice items, tax rates, etc from source to target
     *
     * @param int $source_id
     * @param int $target_id
     */
    public function copy_credit_invoice($source_id, $target_id)
    {
        $this->load->model('invoices/mdl_items');
        $this->load->model('invoices/mdl_invoice_tax_rates');

        $invoice_items = $this->mdl_items->where('invoice_id', $source_id)
            ->get()
            ->result();

        foreach ($invoice_items as $invoice_item) {
            $db_array = array(
                'invoice_id' => $target_id,
                'item_tax_rate_id' => $invoice_item->item_tax_rate_id,
                'item_product_id' => $invoice_item->item_product_id,
                'item_task_id' => $invoice_item->item_task_id,
                'item_name' => $invoice_item->item_name,
                'item_description' => $invoice_item->item_description,
                'item_quantity' => $invoice_item->item_quantity * - 1,
                'item_price' => $invoice_item->item_price,
                'item_discount_amount' => $invoice_item->item_discount_amount,
                'item_order' => $invoice_item->item_order,
                'item_is_recurring' => $invoice_item->item_is_recurring,
                'item_product_unit' => $invoice_item->item_product_unit,
                'item_product_unit_id' => $invoice_item->item_product_unit_id
            );

            $this->mdl_items->save(null, $db_array);
        }

        $invoice_tax_rates = $this->mdl_invoice_tax_rates->where('invoice_id', $source_id)
            ->get()
            ->result();

        foreach ($invoice_tax_rates as $invoice_tax_rate) {
            $db_array = array(
                'invoice_id' => $target_id,
                'tax_rate_id' => $invoice_tax_rate->tax_rate_id,
                'include_item_tax' => $invoice_tax_rate->include_item_tax,
                'invoice_tax_rate_amount' => - $invoice_tax_rate->invoice_tax_rate_amount
            );

            $this->mdl_invoice_tax_rates->save(null, $db_array);
        }

        // Copy the custom fields
        $this->load->model('custom_fields/mdl_invoice_custom');
        $custom_fields = $this->mdl_invoice_custom->where('invoice_id', $source_id)
            ->get()
            ->result();

        $form_data = array();
        foreach ($custom_fields as $field) {
            $form_data[$field->invoice_custom_fieldid] = $field->invoice_custom_fieldvalue;
        }
        $this->mdl_invoice_custom->save_custom($target_id, $form_data);
    }

    public function product_id($target_id)
    {
        $sql = "select item_product_id as productid, item_quantity as qty from ip_invoice_items am where invoice_id=$target_id";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result['productid'];
    }

    public function product_qty($target_id)
    {
        $sql = "select item_product_id as productid, item_quantity as qty from ip_invoice_items am where invoice_id=$target_id";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function product_notif()
    {
        $this->db->select('sum(s.stock_qty) as qty,p.product_name as productname,p.min_qty as mq,p.product_id as pid');
        $this->db->from('ip_products_stock s');
        $this->db->join('ip_products p', 's.stock_product_id=p.product_id');
        $this->db->join('ip_suppliers sp', 's.stock_suppliers_id=sp.supplier_id');
        $this->db->group_by('p.product_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function quote_notif()
    {
        $this->db->select('sum(ps.stock_qty) as qty,qi.item_name as productname,qi.item_quantity as mq,qi.item_product_id as pid');
        $this->db->from('ip_quotes q');
        $this->db->join('ip_quote_items qi', 'qi.quote_id=q.quote_id');
        $this->db->join('ip_products_stock ps', 'ps.stock_product_id=qi.item_product_id');
        $this->db->where('q.quote_status_id=4');
        $this->db->group_by('q.quote_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    public function get_all_inv()
    {
        $this->db->select("ip_quotes.*,
            ip_users.*,
            ip_clients.*,
            ip_invoice_sumex.*,
            ip_invoice_amounts.invoice_amount_id,
            IFnull(ip_invoice_amounts.invoice_item_subtotal, '0.00') AS invoice_item_subtotal,
            IFnull(ip_invoice_amounts.invoice_item_tax_total, '0.00') AS invoice_item_tax_total,
            IFnull(ip_invoice_amounts.invoice_tax_total, '0.00') AS invoice_tax_total,
            IFnull(ip_invoice_amounts.invoice_total, '0.00') AS invoice_total,
            IFnull(ip_invoice_amounts.invoice_paid, '0.00') AS invoice_paid,
            IFnull(ip_invoice_amounts.invoice_balance, '0.00') AS invoice_balance,
            ip_invoice_amounts.invoice_sign AS invoice_sign,
            (CASE WHEN ip_invoices.invoice_status_id NOT IN (1,4) AND DATEDIFF(NOW(), invoice_date_due) > 0 THEN 1 ELSE 0 END) is_overdue,
            DATEDIFF(NOW(), invoice_date_due) AS days_overdue,
            (CASE (SELECT COUNT(*) FROM ip_invoices_recurring WHERE ip_invoices_recurring.invoice_id = ip_invoices.invoice_id and ip_invoices_recurring.recur_next_date <> '0000-00-00') WHEN 0 THEN 0 ELSE 1 END) AS invoice_is_recurring,
            ip_invoices.*",false);
        $this->db->from('ip_invoices');
        $this->db->join('ip_clients', 'ip_clients.client_id = ip_invoices.client_id');
        $this->db->join('ip_users', 'ip_users.user_id = ip_invoices.user_id');
        $this->db->join('ip_invoice_amounts', 'ip_invoice_amounts.invoice_id = ip_invoices.invoice_id', 'left');
        $this->db->join('ip_invoice_sumex', 'sumex_invoice = ip_invoices.invoice_id', 'left');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function qty_check($invoice_no)
    {
        $sql = "select invoice_status_id
from ip_invoices
where invoice_number=$invoice_no";
        $query = $this->db->query($sql);
        return $result = $query->row_array();
    }

    public function qty_get($invoice_id, $item_id)
    {

        $sql = "select item_quantity
from ip_invoice_items
where invoice_id=$invoice_id and item_product_id=$item_id";
        $query = $this->db->query($sql);

        if($query->num_rows() > 0){

            return $result = $query->row_array();
        }else{
            
            return 0;
        }
      
        
    }
    
    public function stock_qty_get($stpro_id)
    {
        $sql = "select sum(stock_qty) as st_qty
from ip_products_stock
where stock_product_id=$stpro_id";

        $query = $this->db->query($sql);
        return $result = $query->row_array();
    }
    
        public function checkstatus($invoice_id)
    {
        $sql = "select invoice_status_id
from ip_invoices
where invoice_id=$invoice_id";
        $query = $this->db->query($sql);
        return $result = $query->row_array();
    }
    
    public function checkqty($item_id)
    {
        $sql = "select invoice_id
from ip_invoice_items
where item_id=$item_id";
        $query = $this->db->query($sql);
        return $result = $query->row_array();
    }
    
    public function getitemqty($item_id)
    {
        $sql = "select item_quantity,item_product_id
from ip_invoice_items
where item_id=$item_id";
        $query = $this->db->query($sql);
        return $result = $query->row_array();
    }
    
    public function getusername($user_id)
    {
        $sql = "select user_name
from ip_users
where user_id=$user_id";
        $query = $this->db->query($sql);
        return $result = $query->row_array();
    }

    public function updateprice($price, $invid, $itmid)
    {
        $data = array(
            'item_price' => $price
        );

        $this->db->where('item_id', $itmid);
        $this->db->where('invoice_id', $invid);
        $this->db->update('ip_invoice_items', $data);
    }

    public function updatepm($pm, $invnumber)
    {
        $datas = array(
            'payment_method' => 1
        );

        $this->db->where('invoice_number', $invnumber);
        $this->db->update('ip_invoices', $datas);
    }

    public function stat()
    {
        return array(
            '1' => array(
                'label' => trans('not_started'),
                'class' => 'draft'
            )
        );
    }

    /**
     *
     * @return array
     */
    public function db_array()
    {
        $db_array = parent::db_array();

        // Get the client id for the submitted invoice
        $this->load->model('clients/mdl_clients');

        // Check if is SUMEX
        $this->load->model('invoice_groups/mdl_invoice_groups');

        $db_array['invoice_date_created'] = date_to_mysql($db_array['invoice_date_created']);
        $db_array['invoice_date_due'] = $this->get_date_due($db_array['invoice_date_created']);
        // $db_array['invoice_date_due'] = $this->get_date_due($db_array['invoice_date_created']);
        $db_array['invoice_terms'] = get_setting('default_invoice_terms');

        if (! isset($db_array['invoice_status_id'])) {
            $db_array['invoice_status_id'] = 1;
        }

        $generate_invoice_number = get_setting('generate_invoice_number_for_draft');

        if ($db_array['invoice_status_id'] === 1 && $generate_invoice_number == 1) {
            $db_array['invoice_number'] = $this->get_invoice_number($db_array['invoice_group_id']);
        } else if ($db_array['invoice_status_id'] != 1) {
            $db_array['invoice_number'] = $this->get_invoice_number($db_array['invoice_group_id']);
        } else {
            $db_array['invoice_number'] = '';
        }

        // Set default values
        $db_array['payment_method'] = (empty($db_array['payment_method']) ? 0 : $db_array['payment_method']);

        // Generate the unique url key
        $db_array['invoice_url_key'] = $this->get_url_key();

        return $db_array;
    }

    /**
     *
     * @param
     *            $invoice
     * @return mixed
     */
    public function get_payments($invoice)
    {
        $this->load->model('payments/mdl_payments');

        $this->db->where('invoice_id', $invoice->invoice_id);
        $payment_results = $this->db->get('ip_payments');

        if ($payment_results->num_rows()) {
            return $invoice;
        }

        $invoice->payments = $payment_results->result();

        return $invoice;
    }

    /**
     *
     * @param string $invoice_date_created
     * @return string
     */
    public function get_date_due($invoice_date_created)
    {
        $invoice_date_due = new DateTime($invoice_date_created);
        // $invoice_date_due->add(new DateInterval('P' . get_setting('invoices_due_after') . 'D'));
        return $invoice_date_due->format('Y-m-d');
    }

    /**
     *
     * @param
     *            $invoice_group_id
     * @return mixed
     */
    public function get_invoice_number($invoice_group_id)
    {
        $this->load->model('invoice_groups/mdl_invoice_groups');
        return $this->mdl_invoice_groups->generate_invoice_number($invoice_group_id);
    }

    /**
     *
     * @return string
     */
    public function get_url_key()
    {
        $this->load->helper('string');
        return random_string('alnum', 32);
    }

    /**
     *
     * @param
     *            $invoice_id
     * @return mixed
     */
    public function get_invoice_group_id($invoice_id)
    {
        $invoice = $this->get_by_id($invoice_id);
        return $invoice->invoice_group_id;
    }

    /**
     *
     * @param int $parent_invoice_id
     * @return mixed
     */
    public function get_parent_invoice_number($parent_invoice_id)
    {
        $parent_invoice = $this->get_by_id($parent_invoice_id);
        return $parent_invoice->invoice_number;
    }

    /**
     *
     * @return mixed
     */
    public function get_custom_values($id)
    {
        $this->load->module('custom_fields/Mdl_invoice_custom');
        return $this->invoice_custom->get_by_invid($id);
    }

    /**
     *
     * @param int $invoice_id
     */
    public function delete($invoice_id)
    {
        parent::delete($invoice_id);

        $this->load->helper('orphan');
        delete_orphans();
    }

    // Used from the guest module, excludes draft and paid
    public function is_open()
    {
        $this->filter_where_in('invoice_status_id', array(
            2,
            3
        ));
        return $this;
    }

    // Used to check if the invoice is Sumex
    public function is_sumex()
    {
        $this->where('sumex_id is NOT NULL', null, false);
        return $this;
    }

    public function guest_visible()
    {
        $this->filter_where_in('invoice_status_id', array(
            2,
            3,
            4
        ));
        return $this;
    }

    public function is_draft()
    {
        $this->filter_where('invoice_status_id', 1);
        return $this;
    }

    public function is_sent()
    {
        $this->filter_where('invoice_status_id', 2);
        return $this;
    }

    public function is_viewed()
    {
        $this->filter_where('invoice_status_id', 3);
        return $this;
    }

    public function is_paid()
    {
        $this->filter_where('invoice_status_id', 4);
        return $this;
    }

    public function is_partially_paid()
    {
        $this->filter_where('invoice_status_id', 6);
        return $this;
    }

    public function is_overdue()
    {
        $this->filter_having('is_overdue', 1);
        return $this;
    }

    public function is_cancelled()
    {
        $this->filter_having('invoice_status_id', 5);
        return $this;
    }

    public function by_client($client_id)
    {
        $this->filter_where('ip_invoices.client_id', $client_id);
        return $this;
    }

    public function by_date($to_date,$from_date)
    {
        $this->filter_where('ip_invoices.invoice_date_created >=', $from_date);
        $this->filter_where('ip_invoices.invoice_date_created <=', $to_date);
        return $this;
    }

    /**
     *
     * @param
     *            $invoice_id
     */
    public function mark_viewed($invoice_id)
    {
        $invoice = $this->get_by_id($invoice_id);

        if (! empty($invoice)) {
            if ($invoice->invoice_status_id == 2) {
                $this->db->where('invoice_id', $invoice_id);
                $this->db->where('invoice_id', $invoice_id);
                $this->db->set('invoice_status_id', 3);
                $this->db->update('ip_invoices');
            }

            // Set the invoice to read-only if feature is not disabled and setting is view
            if ($this->config->item('disable_read_only') == false && get_setting('read_only_toggle') == 3) {
                $this->db->where('invoice_id', $invoice_id);
                $this->db->set('is_read_only', 1);
                $this->db->update('ip_invoices');
            }
        }
    }

    /**
     *
     * @param
     *            $invoice_id
     */
    public function mark_sent($invoice_id)
    {
        $invoice = $this->mdl_invoices->get_by_id($invoice_id);

        if (! empty($invoice)) {
            if ($invoice->invoice_status_id == 1) {
                // Generate new invoice number if applicable
                $invoice_number = $invoice->invoice_number;

                // Set new date and save
                $this->db->where('invoice_id', $invoice_id);
                $this->db->set('invoice_status_id', 2);
                $this->db->set('invoice_number', $invoice_number);
                $this->db->update('ip_invoices');
            }

            // Set the invoice to read-only if feature is not disabled and setting is sent
            if ($this->config->item('disable_read_only') == false && get_setting('read_only_toggle') == 2) {
                $this->db->where('invoice_id', $invoice_id);
                $this->db->set('is_read_only', 1);
                $this->db->update('ip_invoices');
            }
        }
    }

    /**
     *
     * @param
     *            $invoice_id
     */
    public function generate_invoice_number_if_applicable($invoice_id)
    {
        $invoice = $this->mdl_invoices->get_by_id($invoice_id);

        if (! empty($invoice)) {
            if ($invoice->invoice_status_id == 1) {
                // Generate new invoice number if applicable
                if (get_setting('generate_invoice_number_for_draft') == 0) {
                    $invoice_number = $this->get_invoice_number($invoice->invoice_group_id);

                    // Set new invoice number and save
                    $this->db->where('invoice_id', $invoice_id);
                    $this->db->set('invoice_number', $invoice_number);
                    $this->db->update('ip_invoices');
                }
            }
        }
    }
}
