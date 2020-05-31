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
 * Class Mdl_Reports
 */
class Mdl_Reports extends CI_Model
{

    /**
     *
     * @param null $from_date
     * @param null $to_date
     * @return mixed
     */
    public function sales_by_client($from_date = null, $to_date = null)
    {
        $this->db->select('client_name, client_surname, CONCAT(client_name," ", client_surname) AS client_namesurname');

        if ($from_date and $to_date) {

            $from_date = date_to_mysql($from_date);
            $to_date = date_to_mysql($to_date);

            $this->db->select("
            (
                SELECT COUNT(*) FROM ip_invoices
                    WHERE ip_invoices.client_id = ip_clients.client_id 
                        AND invoice_date_created >= " . $this->db->escape($from_date) . "
                        AND invoice_date_created <= " . $this->db->escape($to_date) . "
            ) AS invoice_count");

            $this->db->select("
            (
                SELECT SUM(invoice_item_subtotal) FROM ip_invoice_amounts
                    WHERE ip_invoice_amounts.invoice_id IN
                    (
                        SELECT invoice_id FROM ip_invoices
                            WHERE ip_invoices.client_id = ip_clients.client_id
                                AND invoice_date_created >= " . $this->db->escape($from_date) . "
                                AND invoice_date_created <= " . $this->db->escape($to_date) . "
                    )
            ) AS sales");

            $this->db->select("
            (
                SELECT SUM(invoice_total) FROM ip_invoice_amounts
                    WHERE ip_invoice_amounts.invoice_id IN
                    (
                        SELECT invoice_id FROM ip_invoices
                            WHERE ip_invoices.client_id = ip_clients.client_id
                                AND invoice_date_created >= " . $this->db->escape($from_date) . "
                                AND invoice_date_created <= " . $this->db->escape($to_date) . "
                    )
            ) AS sales_with_tax");

            $this->db->where('
                client_id IN
                (
                    SELECT client_id FROM ip_invoices
                        WHERE invoice_date_created >=' . $this->db->escape($from_date) . '
                            AND invoice_date_created <= ' . $this->db->escape($to_date) . '
                )');
        } else {

            $this->db->select('
            (
                SELECT COUNT(*) FROM ip_invoices
                    WHERE ip_invoices.client_id = ip_clients.client_id
            ) AS invoice_count');

            $this->db->select('
            (
                SELECT SUM(invoice_item_subtotal) FROM ip_invoice_amounts 
                    WHERE ip_invoice_amounts.invoice_id IN
                    (
                        SELECT invoice_id FROM ip_invoices
                            WHERE ip_invoices.client_id = ip_clients.client_id
                    )
            ) AS sales');

            $this->db->select('
            (
                SELECT SUM(invoice_total) FROM ip_invoice_amounts 
                    WHERE ip_invoice_amounts.invoice_id IN
                    (
                        SELECT invoice_id FROM ip_invoices
                            WHERE ip_invoices.client_id = ip_clients.client_id
                    )
            ) AS sales_with_tax');

            $this->db->where('client_id IN (SELECT client_id FROM ip_invoices)');
        }

        $this->db->order_by('client_namesurname');

        return $this->db->get('ip_clients')->result();
    }

    public function invoice_by_date($from_date, $to_date, $client_id, $invoice_status_id)
    {
        if ($invoice_status_id == 3) {
            $sql = "select c.client_name as clientname, i.invoice_id as invoice, i.invoice_date_created as created,i.invoice_date_due as duedate,am.invoice_item_subtotal as amount,am.invoice_balance as balance from ip_clients c, ip_invoices i, ip_invoice_amounts am where c.client_id = $client_id and i.client_id=$client_id and am.invoice_id = i.invoice_id and am.invoice_item_subtotal=am.invoice_balance and i.invoice_date_due <= CURDATE()";
            $query = $this->db->query($sql);
            return $result = $query->result();
        } else if ($invoice_status_id == 0) {
            $sql = "select c.client_name as clientname, i.invoice_id as invoice, i.invoice_date_created as created,i.invoice_date_due as duedate,am.invoice_item_subtotal as amount,am.invoice_balance as balance from ip_clients c, ip_invoices i, ip_invoice_amounts am where c.client_id = $client_id and i.client_id=$client_id and am.invoice_id = i.invoice_id and i.invoice_date_created BETWEEN '$from_date'  and '$to_date'";
            $query = $this->db->query($sql);
            return $result = $query->result();
        } else if ($invoice_status_id == 1) {
            $sql = "select c.client_name as clientname, i.invoice_id as invoice, i.invoice_date_created as created,i.invoice_date_due as duedate,am.invoice_item_subtotal as amount,am.invoice_balance as balance from ip_clients c, ip_invoices i, ip_invoice_amounts am where c.client_id = $client_id and i.client_id=$client_id and am.invoice_id = i.invoice_id and i.invoice_status_id=$invoice_status_id and i.invoice_date_created BETWEEN '$from_date'  and '$to_date'";
            $query = $this->db->query($sql);
            return $result = $query->result();
        } else if ($invoice_status_id == 4) {
            $sql = "select c.client_name as clientname, i.invoice_id as invoice, i.invoice_date_created as created,i.invoice_date_due as duedate,am.invoice_item_subtotal as amount,am.invoice_balance as balance from ip_clients c, ip_invoices i, ip_invoice_amounts am where c.client_id = $client_id and i.client_id=$client_id and am.invoice_id = i.invoice_id and i.invoice_status_id=$invoice_status_id and i.invoice_date_created BETWEEN '$from_date'  and '$to_date'";
            $query = $this->db->query($sql);
            return $result = $query->result();
        } else if ($invoice_status_id == 2) {
            $sql = "select c.client_name as clientname, i.invoice_id as invoice, i.invoice_date_created as created,i.invoice_date_due as duedate,am.invoice_item_subtotal as amount,am.invoice_balance as balance from ip_clients c, ip_invoices i, ip_invoice_amounts am where c.client_id = $client_id and i.client_id=$client_id and am.invoice_id = i.invoice_id and i.invoice_status_id=$invoice_status_id and i.invoice_date_created BETWEEN '$from_date'  and '$to_date'";
            $query = $this->db->query($sql);
            return $result = $query->result();
        }
    }
    
      public function overdue_invoice_by_date($from_date, $to_date, $client_id)
    {

        
   
            $sql = "select c.client_name as clientname, i.invoice_number as invoice, i.invoice_date_created as created,i.invoice_date_due as duedate,am.invoice_item_subtotal as amount,am.invoice_balance as balance from ip_clients c, ip_invoices i, ip_invoice_amounts am where c.client_id = $client_id and i.client_id=$client_id and am.invoice_id = i.invoice_id and (i.invoice_status_id=2 or i.invoice_status_id=6) and i.invoice_date_created BETWEEN '$from_date'  and '$to_date'";
      
        $query = $this->db->query($sql);
        return $result = $query->result();
    }
    
    public function inventory_all_report($from_date, $to_date)
    {
        $mysql_fromdate = date('Y-m-d', strtotime($from_date));
        $mysql_todate = date('Y-m-d', strtotime($to_date));
        
        $this->db->select("it.item_name as productname,i.invoice_number as invoice_number,i.invoice_id as invoice_id,i.invoice_date_created as created,c.client_name as clientname,it.item_quantity as qty,p.product_sku as product_sku");
        $this->db->from("ip_invoices i");
        $this->db->join("ip_invoice_items it", "i.invoice_id=it.invoice_id");
        $this->db->join("ip_products p", "p.product_id=it.item_product_id");
        $this->db->join("ip_clients c", "i.client_id=c.client_id");
        $this->db->where("i.invoice_date_created BETWEEN '$mysql_fromdate' and '$mysql_todate' and i.invoice_status_id=2");
        $this->db->order_by('i.invoice_date_created');
        $this->db->group_by('it.item_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    public function inventory_pro_report($from_date, $to_date,$pro_id)
    {
        $mysql_fromdate = date('Y-m-d', strtotime($from_date));
        $mysql_todate = date('Y-m-d', strtotime($to_date));
        
        $this->db->select("it.item_name as productname,i.invoice_number as invoiceid,i.invoice_date_created as created,c.client_name as clientname,it.item_quantity as qty,p.product_sku as product_sku");
        $this->db->from("ip_invoices i");
        $this->db->join("ip_invoice_items it", "i.invoice_id=it.invoice_id");
        $this->db->join("ip_products p", "p.product_id=it.item_product_id");
        $this->db->join("ip_clients c", "i.client_id=c.client_id");
        $this->db->where("i.invoice_date_created BETWEEN '$mysql_fromdate'  and '$mysql_todate' and p.product_id = '$pro_id' and i.invoice_status_id=2");
        $this->db->order_by('i.invoice_date_created');
        // $this->db->group_by('p.product_id');
        $this->db->group_by('it.item_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    public function stock_all_report()
    {
        $this->db->select("sum(ps.buying_price*ps.stock_qty) as bpsum,p.product_sku as product_sku,p.product_description as product_description,p.product_name as productname,ps.stock_create_date as created,s.supplier_name as supname,sum(ps.stock_qty) as qty");
        $this->db->from("ip_products_stock ps");
        $this->db->join("ip_products p", "p.product_id=ps.stock_product_id");
        $this->db->join("ip_suppliers s", "s.supplier_id=ps.stock_suppliers_id");
        $this->db->order_by('p.product_name');
        $this->db->group_by('p.product_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    public function stock_pro_report($pro_id)
    {
        $this->db->select("sum(ps.buying_price*ps.stock_qty) as bpsum,p.product_sku as product_sku,p.product_description as product_description,p.product_name as productname,ps.stock_create_date as created,s.supplier_name as supname,sum(ps.stock_qty) as qty");
        $this->db->from("ip_products_stock ps");
        $this->db->join("ip_products p", "p.product_id=ps.stock_product_id");
        $this->db->join("ip_suppliers s", "s.supplier_id=ps.stock_suppliers_id");
        $this->db->where("p.product_id = '$pro_id'");
        $this->db->order_by('p.product_name');
        $this->db->group_by('p.product_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    public function profit_by_date_new($from_date, $to_date)
    {
        
        
        
        //get stock prices

        $stock_prices=array();//stock price array
        
        $sql = "select stock_product_id,buying_price from ip_products_stock  GROUP BY stock_product_id";
        $query = $this->db->query($sql);
        $query1=$query->result();

        foreach ($query1 as $value) {
            $value1 = $value->stock_product_id;

            $sql1 = "select * from ip_products_stock where stock_product_id=$value1";
            $query2 = $this->db->query($sql1);
            $bp=$query2->last_row();
            $bpp=$bp->buying_price;
            
            array_push($stock_prices,array("id" => $value1,"price" => $bpp));
            
        }
        //get client ids

        $client = "select client_id  from ip_invoices where invoice_date_created BETWEEN '$from_date'  and '$to_date' and (invoice_status_id=2 or invoice_status_id=4)    GROUP BY client_id";
        $clientid = $this->db->query($client);
        $clientids=$clientid->result();

        //get invoice items

        $this->db->select("c.client_id,c.client_name,i.item_product_id,i.item_quantity,i.item_price,i.item_date");
        $this->db->from("ip_invoice_items i");
        $this->db->join("ip_invoices inv", "i.invoice_id=inv.invoice_id");
        $this->db->join("ip_clients c", "c.client_id=inv.client_id" );
        $this->db->where("i.item_date BETWEEN '$from_date'  and '$to_date' and (inv.invoice_status_id=2 or inv.invoice_status_id=4) " );
        $query3 = $this->db->get();
        $result = $query3->result();
     
        $report_array=array();
        $client_name="";
        $selling_price=0;
        $buying_price=0;
        $profit=0;

        foreach($clientids as $value){

           
            foreach($result as $value1){

                if(($value1->client_id)==($value->client_id)){

                    $client_name=$value1->client_name;
                    $selling_price+=($value1->item_quantity)*($value1->item_price);


                    foreach($stock_prices as $value2)
                    {
                      
                        if($value2["id"]==($value1->item_product_id)){
                            $buying_price+=($value1->item_quantity)*$value2["price"];

                        }

                    
                    }



                }
    
    
            }

            $profit=$selling_price-$buying_price;
            array_push($report_array,array("client_name" => $client_name,"selling_amount"=>$selling_price,"buying_amount"=>$buying_price,"profit"=>$profit));
        
        $client_name="";
        $selling_price=0;
        $buying_price=0;
        $profit=0;

        }

        return $report_array;
        
        
        
    }

    public function profit_by_date($from_date, $to_date)
    {
        $sql = "select sum(invoice_item_subtotal) as sellingsubtotal from ip_invoice_amounts 
                where invoice_date_added BETWEEN '$from_date'  and '$to_date'";
        $query = $this->db->query($sql);
        return $result = $query->row_array();
    }

    public function sales_by_month($from_date, $to_date)
    {
         $sql = "select sum(invoice_item_subtotal) as sellingsubtotal, MONTH(invoice_date_added) as months
from ip_invoice_amounts where invoice_date_added BETWEEN '$from_date'  and '$to_date'
GROUP BY MONTH(invoice_date_added)";
        $query = $this->db->query($sql);
        return $result = $query->result_array();
    }
    
    public function profit_by_datea($from_date, $to_date)
    {
        $sql = "select sum(payment_amount) as paidamount  from   ip_payments 
where payment_date BETWEEN '$from_date'  and '$to_date'";
        $query = $this->db->query($sql);
        //         return $result = $query->result();
        return $result = $query->row_array();
    }

    public function receives_by_months($from_date, $to_date)
    {
         $sql = "select sum(payment_amount) as paidamount, MONTH(payment_date) as months  from   ip_payments 
where payment_date BETWEEN '$from_date'  and '$to_date' GROUP BY MONTH(payment_date) ORDER BY payment_date";
        $query = $this->db->query($sql);
        return $result = $query->result();
    }
    
    public function profit_by_dateab($from_date, $to_date)
    {
        $sql = "select sum(buying_price * stock_open_qty) as buyingsubtotal from ip_products_stock 
where stock_create_date BETWEEN '$from_date'  and '$to_date'";
        $query = $this->db->query($sql);
        return $result = $query->row_array();
    }

    public function stock_sum_by_months($from_date, $to_date)
    {
        $sql = "select sum(buying_price * stock_open_qty) as buyingsubtotal, MONTH(stock_create_date) as months from ip_products_stock 
where stock_create_date BETWEEN '$from_date'  and '$to_date' GROUP BY MONTH(stock_create_date)  ORDER BY stock_create_date";
        $query = $this->db->query($sql);
        return $result = $query->result_array();
    }
    
     public function profit_by_dateabc($from_date, $to_date)
    {
        $sql = "select sum(p.product_price * i.item_quantity) as buyingsubtotal 
from ip_products p, ip_invoice_items i,ip_invoice_amounts am where i.invoice_id=am.invoice_id and p.product_id=i.item_product_id    and i.item_date BETWEEN '$from_date'  and '$to_date'";
        $query = $this->db->query($sql);
        return $result = $query->row_array();
    }
    

    public function expenses_by_date($from_date, $to_date)
    {
        $sql = "SELECT sum(task_price) as expenses FROM ip_tasks 
WHERE task_finish_date BETWEEN '$from_date'  and '$to_date'";
        $query = $this->db->query($sql);
        return $result = $query->row_array();
    }

    public function expenses_by_months($from_date, $to_date)
    {
        $sql = "SELECT sum(task_price) as expenses, MONTH(task_finish_date) as months FROM ip_tasks 
WHERE task_finish_date BETWEEN '$from_date'  and '$to_date' GROUP BY MONTH(task_finish_date)";
        $query = $this->db->query($sql);
        return $result = $query->result_array();
    }

    /**
     *
     * @param null $from_date
     * @param null $to_date
     * @return mixed
     */
     public function payment_history($from_date = null, $to_date = null,$client_id=null)
    {
        $this->load->model('payments/mdl_payments');

        if ($from_date and $to_date) {
            $from_date = date_to_mysql($from_date);
            $to_date = date_to_mysql($to_date);

            $this->mdl_payments->where('payment_date >=', $from_date);
            $this->mdl_payments->where('payment_date <=', $to_date);

            
        }


        if($client_id!='select_client'){
            $this->mdl_payments->where('ip_clients.client_id =', $client_id);
        }

        return $this->mdl_payments->get()->result();
    }

    /**
     *
     * @return mixed
     */
    public function invoice_aging()
    {
        $this->db->select('client_name, client_surname');

        $this->db->select('
        (
            SELECT SUM(invoice_balance) FROM ip_invoice_amounts 
                WHERE invoice_id IN
                (
                    SELECT invoice_id FROM ip_invoices
                        WHERE ip_invoices.client_id = ip_clients.client_id 
                            AND invoice_date_due <= DATE_SUB(NOW(),INTERVAL 1 DAY) 
                            AND invoice_date_due >= DATE_SUB(NOW(), INTERVAL 15 DAY)
                )
        ) AS range_1', false);

        $this->db->select('
        (
            SELECT SUM(invoice_balance) FROM ip_invoice_amounts 
                WHERE invoice_id IN
                (
                    SELECT invoice_id FROM ip_invoices
                        WHERE ip_invoices.client_id = ip_clients.client_id 
                            AND invoice_date_due <= DATE_SUB(NOW(),INTERVAL 16 DAY) 
                            AND invoice_date_due >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                )
        ) AS range_2', false);

        $this->db->select('
        (
            SELECT SUM(invoice_balance) FROM ip_invoice_amounts 
                WHERE invoice_id IN
                (
                    SELECT invoice_id FROM ip_invoices
                        WHERE ip_invoices.client_id = ip_clients.client_id 
                            AND invoice_date_due <= DATE_SUB(NOW(),INTERVAL 31 DAY)
                )
        ) AS range_3', false);

        $this->db->select('
        (
            SELECT SUM(invoice_balance) FROM ip_invoice_amounts 
                WHERE invoice_id IN
                (
                    SELECT invoice_id FROM ip_invoices
                        WHERE ip_invoices.client_id = ip_clients.client_id 
                            AND invoice_date_due <= DATE_SUB(NOW(), INTERVAL 1 DAY)
                )
        ) AS total_balance', false);

        $this->db->having('range_1 >', 0);
        $this->db->or_having('range_2 >', 0);
        $this->db->or_having('range_3 >', 0);
        $this->db->or_having('total_balance >', 0);

        return $this->db->get('ip_clients')->result();
    }

    /**
     *
     * @param null $from_date
     * @param null $to_date
     * @param null $minQuantity
     * @param null $maxQuantity
     * @param bool $taxChecked
     * @return mixed
     */
    public function sales_by_year($from_date = null, $to_date = null, $minQuantity = null, $maxQuantity = null, $taxChecked = false)
    {
        if ($minQuantity == "") {
            $minQuantity = 0;
        }

        if ($from_date == "") {
            $from_date = date("Y-m-d");
        } else {
            $from_date = date_to_mysql($from_date);
        }

        if ($to_date == "") {
            $to_date = date("Y-m-d");
        } else {
            $to_date = date_to_mysql($to_date);
        }

        $from_date_year = intval(substr($from_date, 0, 4));
        $to_date_year = intval(substr($to_date, 0, 4));

        $this->db->select('client_name as Name');
        $this->db->select('client_name');
        $this->db->select('client_surname');
        $this->db->select('CONCAT(client_name," ", client_surname) AS client_namesurname');

        if ($taxChecked == false) {

            if ($maxQuantity) {

                $this->db->select('client_id');
                $this->db->select('client_vat_id AS VAT_ID');
                $this->db->select('
                (
                    SELECT SUM(amounts.invoice_item_subtotal) FROM ip_invoice_amounts amounts
                        WHERE amounts.invoice_id IN
                        (
                            SELECT inv.invoice_id FROM ip_invoices inv
                                WHERE inv.client_id=ip_clients.client_id
                                    AND ' . $this->db->escape($from_date) . '<= inv.invoice_date_created
                                    AND ' . $this->db->escape($to_date) . '>= inv.invoice_date_created
                        )
                ) AS total_payment', false);

                for ($index = $from_date_year; $index <= $to_date_year; $index ++) {
                    $this->db->select('
                    (
                        SELECT SUM(invoice_item_subtotal) FROM ip_invoice_amounts
                            WHERE invoice_id IN
                            (
                                SELECT invoice_id FROM ip_invoices inv
                                    WHERE inv.client_id=ip_clients.client_id 
                                        AND ' . $this->db->escape($from_date) . '<= inv.invoice_date_created 
                                        AND ' . $this->db->escape($to_date) . '>= inv.invoice_date_created 
                                        AND
                                        (
                                            inv.invoice_date_created LIKE \'%' . $index . '-01-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-02-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-03-%\'
                                        )
                            )
                    ) AS payment_t1_' . $index . '', false);

                    $this->db->select('
                    (
                        SELECT SUM(invoice_item_subtotal) FROM ip_invoice_amounts
                            WHERE invoice_id IN
                            (
                                SELECT invoice_id FROM ip_invoices inv
                                    WHERE inv.client_id=ip_clients.client_id 
                                        AND ' . $this->db->escape($from_date) . '<= inv.invoice_date_created 
                                        AND ' . $this->db->escape($to_date) . '>= inv.invoice_date_created 
                                        AND
                                        (
                                            inv.invoice_date_created LIKE \'%' . $index . '-04-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-05-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-06-%\'
                                        )
                            )
                    ) AS payment_t2_' . $index . '', false);

                    $this->db->select('
                    (
                        SELECT SUM(invoice_item_subtotal) FROM ip_invoice_amounts
                            WHERE invoice_id IN
                            (
                                SELECT invoice_id FROM ip_invoices inv
                                    WHERE inv.client_id=ip_clients.client_id 
                                        AND ' . $this->db->escape($from_date) . '<= inv.invoice_date_created 
                                        AND ' . $this->db->escape($to_date) . '>= inv.invoice_date_created 
                                        AND
                                        (
                                            inv.invoice_date_created LIKE \'%' . $index . '-07-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-08-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-09-%\'
                                        )
                            )
                    ) AS payment_t3_' . $index . '', false);

                    $this->db->select('
                    (
                        SELECT SUM(invoice_item_subtotal) FROM ip_invoice_amounts
                            WHERE invoice_id IN
                            (
                                SELECT invoice_id FROM ip_invoices inv
                                    WHERE inv.client_id=ip_clients.client_id 
                                        AND ' . $this->db->escape($from_date) . '<= inv.invoice_date_created 
                                        AND ' . $this->db->escape($to_date) . '>= inv.invoice_date_created 
                                        AND
                                        (
                                            inv.invoice_date_created LIKE \'%' . $index . '-10-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-11-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-12-%\'
                                        )
                            )
                    ) AS payment_t4_' . $index . '', false);
                }

                $this->db->where('
                (
                    SELECT SUM(amounts.invoice_item_subtotal) FROM ip_invoice_amounts amounts 
                        WHERE amounts.invoice_id IN 
                        (
                            SELECT inv.invoice_id FROM ip_invoices inv
                                WHERE inv.client_id=ip_clients.client_id 
                                    AND ' . $this->db->escape($from_date) . ' <= inv.invoice_date_created 
                                    AND ' . $this->db->escape($to_date) . ' >= inv.invoice_date_created 
                                    AND ' . $minQuantity . ' <= 
                                    (
                                        SELECT SUM(amounts2.invoice_item_subtotal) FROM ip_invoice_amounts amounts2 
                                            WHERE amounts2.invoice_id IN 
                                            (
                                                SELECT inv2.invoice_id FROM ip_invoices inv2 
                                                    WHERE inv2.client_id=ip_clients.client_id 
                                                        AND ' . $this->db->escape($from_date) . ' <= inv2.invoice_date_created 
                                                        AND ' . $this->db->escape($to_date) . ' >= inv2.invoice_date_created
                                            )
                                    ) AND ' . $maxQuantity . ' >= 
                                    (
                                        SELECT SUM(amounts3.invoice_item_subtotal) FROM ip_invoice_amounts amounts3 
                                            WHERE amounts3.invoice_id IN 
                                            (
                                                SELECT inv3.invoice_id FROM ip_invoices inv3 
                                                    WHERE inv3.client_id=ip_clients.client_id 
                                                        AND ' . $this->db->escape($from_date) . ' <= inv3.invoice_date_created 
                                                        AND ' . $this->db->escape($to_date) . ' >= inv3.invoice_date_created
                                            )
                                    )
                        )
                ) <>0');
            } else {

                $this->db->select('client_id');
                $this->db->select('client_vat_id AS VAT_ID');
                $this->db->select('client_name as Name');

                $this->db->select('
                (
                    SELECT SUM(amounts.invoice_item_subtotal) FROM ip_invoice_amounts amounts 
                        WHERE amounts.invoice_id IN 
                        (
                            SELECT inv.invoice_id FROM ip_invoices inv 
                                WHERE inv.client_id=ip_clients.client_id 
                                    AND ' . $this->db->escape($from_date) . '<= inv.invoice_date_created 
                                    AND ' . $this->db->escape($to_date) . '>= inv.invoice_date_created
                        )
                ) AS total_payment', false);

                for ($index = $from_date_year; $index <= $to_date_year; $index ++) {

                    $this->db->select('
                    (
                        SELECT SUM(invoice_item_subtotal) FROM ip_invoice_amounts 
                            WHERE invoice_id IN 
                            (
                                SELECT invoice_id FROM ip_invoices inv
                                    WHERE inv.client_id=ip_clients.client_id 
                                        AND ' . $this->db->escape($from_date) . '<= inv.invoice_date_created 
                                        AND ' . $this->db->escape($to_date) . '>= inv.invoice_date_created 
                                        AND 
                                        (
                                            inv.invoice_date_created LIKE \'%' . $index . '-01-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-02-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-03-%\'
                                        )
                            )
                    ) AS payment_t1_' . $index . '', false);

                    $this->db->select('
                    (
                        SELECT SUM(invoice_item_subtotal) FROM ip_invoice_amounts 
                            WHERE invoice_id IN 
                            (
                                SELECT invoice_id FROM ip_invoices inv
                                    WHERE inv.client_id=ip_clients.client_id 
                                        AND ' . $this->db->escape($from_date) . '<= inv.invoice_date_created 
                                        AND ' . $this->db->escape($to_date) . '>= inv.invoice_date_created 
                                        AND 
                                        (
                                            inv.invoice_date_created LIKE \'%' . $index . '-04-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-05-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-06-%\'
                                        )
                            )
                    ) AS payment_t2_' . $index . '', false);

                    $this->db->select('
                    (
                        SELECT SUM(invoice_item_subtotal) FROM ip_invoice_amounts 
                            WHERE invoice_id IN 
                            (
                                SELECT invoice_id FROM ip_invoices inv
                                    WHERE inv.client_id=ip_clients.client_id 
                                        AND ' . $this->db->escape($from_date) . '<= inv.invoice_date_created 
                                        AND ' . $this->db->escape($to_date) . '>= inv.invoice_date_created 
                                        AND 
                                        (
                                            inv.invoice_date_created LIKE \'%' . $index . '-07-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-08-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-09-%\'
                                        )
                            )
                    ) AS payment_t3_' . $index . '', false);

                    $this->db->select('
                    (
                        SELECT SUM(invoice_item_subtotal) FROM ip_invoice_amounts 
                            WHERE invoice_id IN 
                            (
                                SELECT invoice_id FROM ip_invoices inv
                                    WHERE inv.client_id=ip_clients.client_id 
                                        AND ' . $this->db->escape($from_date) . '<= inv.invoice_date_created 
                                        AND ' . $this->db->escape($to_date) . '>= inv.invoice_date_created 
                                        AND 
                                        (
                                            inv.invoice_date_created LIKE \'%' . $index . '-10-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-11-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-12-%\'
                                        )
                            )
                    ) AS payment_t4_' . $index . '', false);
                }

                $this->db->where('
                (
                    SELECT SUM(amounts.invoice_item_subtotal) FROM ip_invoice_amounts amounts 
                        WHERE amounts.invoice_id IN 
                        (
                            SELECT inv.invoice_id FROM ip_invoices inv 
                                WHERE inv.client_id=ip_clients.client_id 
                                    AND ' . $this->db->escape($from_date) . ' <= inv.invoice_date_created 
                                    AND ' . $this->db->escape($to_date) . ' >= inv.invoice_date_created 
                                    AND ' . $minQuantity . ' <= 
                                    (
                                        SELECT SUM(amounts2.invoice_item_subtotal) FROM ip_invoice_amounts amounts2 
                                            WHERE amounts2.invoice_id IN 
                                            (
                                                SELECT inv2.invoice_id FROM ip_invoices inv2 
                                                WHERE inv2.client_id=ip_clients.client_id 
                                                    AND ' . $this->db->escape($from_date) . ' <= inv2.invoice_date_created 
                                                    AND ' . $this->db->escape($to_date) . ' >= inv2.invoice_date_created
                                            )
                                    )
                        )
                ) <>0');
            }
        } else if ($taxChecked == true) {

            if ($maxQuantity) {

                $this->db->select('client_id');
                $this->db->select('client_vat_id AS VAT_ID');
                $this->db->select('client_name as Name');

                $this->db->select('
                (
                    SELECT SUM(amounts.invoice_total) FROM ip_invoice_amounts amounts 
                        WHERE amounts.invoice_id IN 
                        (
                            SELECT inv.invoice_id FROM ip_invoices inv 
                                WHERE inv.client_id=ip_clients.client_id 
                                    AND ' . $this->db->escape($from_date) . '<= inv.invoice_date_created 
                                    AND ' . $this->db->escape($to_date) . '>= inv.invoice_date_created
                        )
                ) AS total_payment', false);

                for ($index = $from_date_year; $index <= $to_date_year; $index ++) {

                    $this->db->select('
                    (
                        SELECT SUM(invoice_total) FROM ip_invoice_amounts 
                            WHERE invoice_id IN 
                            (
                                SELECT invoice_id FROM ip_invoices inv 
                                    WHERE inv.client_id=ip_clients.client_id 
                                        AND ' . $this->db->escape($from_date) . '<= inv.invoice_date_created 
                                        AND ' . $this->db->escape($to_date) . '>= inv.invoice_date_created 
                                        AND 
                                        (
                                            inv.invoice_date_created LIKE \'%' . $index . '-01-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-02-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-03-%\'
                                        )
                            )
                    ) AS payment_t1_' . $index . '', false);

                    $this->db->select('
                    (
                        SELECT SUM(invoice_total) FROM ip_invoice_amounts 
                            WHERE invoice_id IN 
                            (
                                SELECT invoice_id FROM ip_invoices inv 
                                    WHERE inv.client_id=ip_clients.client_id 
                                        AND ' . $this->db->escape($from_date) . '<= inv.invoice_date_created 
                                        AND ' . $this->db->escape($to_date) . '>= inv.invoice_date_created 
                                        AND 
                                        (
                                            inv.invoice_date_created LIKE \'%' . $index . '-04-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-05-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-06-%\'
                                        )
                            )
                    ) AS payment_t2_' . $index . '', false);

                    $this->db->select('
                    (
                        SELECT SUM(invoice_total) FROM ip_invoice_amounts 
                            WHERE invoice_id IN 
                            (
                                SELECT invoice_id FROM ip_invoices inv 
                                    WHERE inv.client_id=ip_clients.client_id 
                                        AND ' . $this->db->escape($from_date) . '<= inv.invoice_date_created 
                                        AND ' . $this->db->escape($to_date) . '>= inv.invoice_date_created 
                                        AND 
                                        (
                                            inv.invoice_date_created LIKE \'%' . $index . '-07-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-08-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-09-%\'
                                        )
                            )
                    ) AS payment_t3_' . $index . '', false);

                    $this->db->select('
                    (
                        SELECT SUM(invoice_total) FROM ip_invoice_amounts 
                            WHERE invoice_id IN 
                            (
                                SELECT invoice_id FROM ip_invoices inv 
                                    WHERE inv.client_id=ip_clients.client_id 
                                        AND ' . $this->db->escape($from_date) . '<= inv.invoice_date_created 
                                        AND ' . $this->db->escape($to_date) . '>= inv.invoice_date_created 
                                        AND 
                                        (
                                            inv.invoice_date_created LIKE \'%' . $index . '-10-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-11-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-12-%\'
                                        )
                            )
                    ) AS payment_t4_' . $index . '', false);
                }

                $this->db->where('
                (
                    SELECT SUM(amounts.invoice_total) FROM ip_invoice_amounts amounts 
                        WHERE amounts.invoice_id IN 
                        (
                            SELECT inv.invoice_id FROM ip_invoices inv 
                                WHERE inv.client_id=ip_clients.client_id 
                                    AND ' . $this->db->escape($from_date) . ' <= inv.invoice_date_created 
                                    AND ' . $this->db->escape($to_date) . ' >= inv.invoice_date_created 
                                    AND ' . $minQuantity . ' <= 
                                    (
                                        SELECT SUM(amounts2.invoice_total) FROM ip_invoice_amounts amounts2 
                                            WHERE amounts2.invoice_id IN 
                                            (
                                                SELECT inv2.invoice_id FROM ip_invoices inv2 
                                                    WHERE inv2.client_id=ip_clients.client_id 
                                                        AND ' . $this->db->escape($from_date) . ' <= inv2.invoice_date_created 
                                                        AND ' . $this->db->escape($to_date) . ' >= inv2.invoice_date_created
                                            )
                                    ) AND ' . $maxQuantity . ' >= 
                                    (
                                        SELECT SUM(amounts3.invoice_total) FROM ip_invoice_amounts amounts3 
                                            WHERE amounts3.invoice_id IN 
                                            (
                                                SELECT inv3.invoice_id FROM ip_invoices inv3 
                                                    WHERE inv3.client_id=ip_clients.client_id 
                                                        AND ' . $this->db->escape($from_date) . ' <= inv3.invoice_date_created 
                                                        AND ' . $this->db->escape($to_date) . ' >= inv3.invoice_date_created
                                            )
                                    )
                        )
                ) <>0');
            } else {

                $this->db->select('client_id');
                $this->db->select('client_vat_id AS VAT_ID');
                $this->db->select('client_name as Name');

                $this->db->select('
                (
                    SELECT SUM(amounts.invoice_total) FROM ip_invoice_amounts amounts 
                        WHERE amounts.invoice_id IN 
                        (
                            SELECT inv.invoice_id FROM ip_invoices inv 
                                WHERE inv.client_id=ip_clients.client_id 
                                    AND ' . $this->db->escape($from_date) . '<= inv.invoice_date_created 
                                    AND ' . $this->db->escape($to_date) . '>= inv.invoice_date_created
                        )
                ) AS total_payment', false);

                for ($index = $from_date_year; $index <= $to_date_year; $index ++) {

                    $this->db->select('
                    (
                        SELECT SUM(invoice_total) FROM ip_invoice_amounts 
                            WHERE invoice_id IN 
                            (
                                SELECT invoice_id FROM ip_invoices inv 
                                    WHERE inv.client_id=ip_clients.client_id 
                                        AND ' . $this->db->escape($from_date) . '<= inv.invoice_date_created 
                                        AND ' . $this->db->escape($to_date) . '>= inv.invoice_date_created 
                                        AND 
                                        (
                                            inv.invoice_date_created LIKE \'%' . $index . '-01-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-02-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-03-%\'
                                        )
                            )
                    ) AS payment_t1_' . $index . '', false);

                    $this->db->select('
                    (
                        SELECT SUM(invoice_total) FROM ip_invoice_amounts 
                            WHERE invoice_id IN 
                            (
                                SELECT invoice_id FROM ip_invoices inv 
                                    WHERE inv.client_id=ip_clients.client_id 
                                        AND ' . $this->db->escape($from_date) . '<= inv.invoice_date_created 
                                        AND ' . $this->db->escape($to_date) . '>= inv.invoice_date_created 
                                        AND 
                                        (
                                            inv.invoice_date_created LIKE \'%' . $index . '-04-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-05-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-06-%\'
                                        )
                            )
                    ) AS payment_t2_' . $index . '', false);

                    $this->db->select('
                    (
                        SELECT SUM(invoice_total) FROM ip_invoice_amounts 
                            WHERE invoice_id IN 
                            (
                                SELECT invoice_id FROM ip_invoices inv 
                                    WHERE inv.client_id=ip_clients.client_id 
                                        AND ' . $this->db->escape($from_date) . '<= inv.invoice_date_created 
                                        AND ' . $this->db->escape($to_date) . '>= inv.invoice_date_created 
                                        AND 
                                        (
                                            inv.invoice_date_created LIKE \'%' . $index . '-07-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-08-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-09-%\'
                                        )
                            )
                    ) AS payment_t3_' . $index . '', false);

                    $this->db->select('
                    (
                        SELECT SUM(invoice_total) FROM ip_invoice_amounts 
                            WHERE invoice_id IN 
                            (
                                SELECT invoice_id FROM ip_invoices inv 
                                    WHERE inv.client_id=ip_clients.client_id 
                                        AND ' . $this->db->escape($from_date) . '<= inv.invoice_date_created 
                                        AND ' . $this->db->escape($to_date) . '>= inv.invoice_date_created 
                                        AND 
                                        (
                                            inv.invoice_date_created LIKE \'%' . $index . '-10-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-11-%\' 
                                            OR inv.invoice_date_created LIKE \'%' . $index . '-12-%\'
                                        )
                            )
                    ) AS payment_t4_' . $index . '', false);
                }

                $this->db->where('
                (
                    SELECT SUM(amounts.invoice_total) FROM ip_invoice_amounts amounts 
                        WHERE amounts.invoice_id IN 
                        (
                            SELECT inv.invoice_id FROM ip_invoices inv 
                                WHERE inv.client_id=ip_clients.client_id 
                                    AND ' . $this->db->escape($from_date) . ' <= inv.invoice_date_created 
                                    AND ' . $this->db->escape($to_date) . ' >= inv.invoice_date_created 
                                    AND ' . $minQuantity . ' <= 
                                    (
                                        SELECT SUM(amounts2.invoice_total) FROM ip_invoice_amounts amounts2 
                                            WHERE amounts2.invoice_id IN 
                                            (
                                                SELECT inv2.invoice_id FROM ip_invoices inv2 
                                                    WHERE inv2.client_id=ip_clients.client_id 
                                                        AND ' . $this->db->escape($from_date) . ' <= inv2.invoice_date_created 
                                                        AND ' . $this->db->escape($to_date) . ' >= inv2.invoice_date_created
                                            )
                                    )
                        )
                ) <>0');
            }
        }

        $this->db->order_by('client_namesurname');
        return $this->db->get('ip_clients')->result();
    }


    //search client with invoices
    
    
     public function searchClients()
    {

        $sdate = date('Y-m-d');
        $edate = strtotime ( '-6 month' , strtotime ( $sdate ) ) ;
        $edate = date ( 'Y-m-d' , $edate );

        $this->db->select("c.client_id,c.client_name,c.client_surname");
        $this->db->from("ip_invoices inv");
        $this->db->join("ip_clients c", "c.client_id=inv.client_id" );
        $this->db->where("inv.invoice_date_created BETWEEN '$edate'  and '$sdate' and (inv.invoice_status_id=2 OR inv.invoice_status_id=4)  " );
        $this->db->group_by('c.client_id');
         $this->db->order_by('c.client_name', 'ASC');
        $query = $this->db->get();
        $result = $query->result();

                
        return $result;
    }
    
    

    public function invoices_byclient($client)
    {



        $sdate = date('Y-m-d');
        $edate = strtotime ( '-6 month' , strtotime ( $sdate ) ) ;
        $edate = date ( 'Y-m-d' , $edate );

       
        $sql = "select * from ip_invoices  where invoice_date_created BETWEEN '$edate' AND '$sdate' AND  client_id=$client AND (invoice_status_id=2 OR invoice_status_id=4)" ;
        $query = $this->db->query($sql);
        //         return $result = $query->result();
        return $result = $query->result();

    }


    public function invoice_items_byinvoice($invoiceid)
    {
        $sql = "select * from ip_invoice_items  where invoice_id=$invoiceid";
        $query = $this->db->query($sql);
        //         return $result = $query->result();
        return $result = $query->result();
    }


    public function save_credit_notes($clientid,$invoiceid,$invoice_item,$qty)
    {
        $date=date('Y-m-d');
        $supplier_id=23;
        $userid=$this->session->userdata('user_id');

        //update stock
        $sql1 = "select * from ip_products_stock where stock_product_id=$invoice_item";
        $query1 = $this->db->query($sql1);
        $bp=$query1->last_row();
        $bpp=$bp->buying_price;
        

        //add to stock
        $sql="INSERT INTO ip_products_stock (stock_product_id,stock_open_qty,stock_qty,stock_suppliers_id,stock_create_date,user_id,buying_price) VALUES ($invoice_item, $qty,$qty,$supplier_id,'$date',$userid,$bpp)";
        $query = $this->db->query($sql);
        


        
        //$sql = "select * from ip_invoice_items  where invoice_id=$invoiceid";
        $sql="INSERT INTO ip_invoice_credit_note (client_id,invoice_id,invoice_item_id,qty,date_added) VALUES ($clientid,$invoiceid, $invoice_item,$qty,'$date')";
        $query = $this->db->query($sql);
        return $result = $query->result();
       


    }
    
    
    
    public function allcreditnotes()
    {
        $this->db->select("c.client_name,inv.invoice_number,p.product_name,cn.qty,(cn.qty*i.item_price) as amount,cn.date_added");
        $this->db->from("ip_invoice_credit_note cn");
        $this->db->join("ip_invoice_items i", "cn.invoice_item_id=i.item_product_id AND cn.invoice_id=i.invoice_id");
        $this->db->join("ip_invoices inv", "cn.invoice_id=inv.invoice_id");
        $this->db->join("ip_clients c", "c.client_id=cn.client_id" );
        $this->db->join("ip_products p", "p.product_id=cn.invoice_item_id" );
        //$this->db->where("i.item_date BETWEEN '$from_date'  and '$to_date' and inv.invoice_status_id=2   " );
        //$this->db->order_by('c.client_name');
        //$this->db->group_by('c.client_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;

    }
    
    



}
