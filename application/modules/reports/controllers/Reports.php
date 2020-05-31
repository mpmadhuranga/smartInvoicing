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
 * Class Reports
 */
class Reports extends Admin_Controller
{
    /**
     * Reports constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_reports');
    }

    public function sales_by_client()
    {
        if ($this->input->get('btn_submit')) {
            $data = array(
                'results' => $this->mdl_reports->sales_by_client($this->input->get('from_date'), $this->input->get('to_date')),
                'from_date' => $this->input->get('from_date'),
                'to_date' => $this->input->get('to_date'),
            );

            $html = $this->load->view('reports/sales_by_client', $data, true);

            $this->load->helper('mpdf');

            pdf_create($html, trans('sales_by_client'), true);
        }

        $this->layout->buffer('content', 'reports/sales_by_client_index')->render();
    }



    public function payment_history()
    {
        $this->load->model('clients/mdl_clients');

        if ($this->input->get('btn_submit')) {



            $data = array(
                'results' => $this->mdl_reports->payment_history($this->input->get('from_date'), $this->input->get('to_date'),$this->input->get('client_id')),
                'from_date' => $this->input->get('from_date'),
                'to_date' => $this->input->get('to_date'),


            );

            $html = $this->load->view('reports/payment_history', $data, true);

            $this->load->helper('mpdf');

            pdf_create($html, trans('payment_history'), true);
        }

        $this->layout->set(
            array(
                'clients' => $this->mdl_clients->all_clients(),

            )
        );

        $this->layout->buffer('content', 'reports/payment_history_index')->render();
    }


    public function invoice_aging()
    {
        if ($this->input->get('btn_submit')) {
            $data = array(
                'results' => $this->mdl_reports->invoice_aging()
            );

            $html = $this->load->view('reports/invoice_aging', $data, true);

            $this->load->helper('mpdf');

            pdf_create($html, trans('invoice_aging'), true);
        }

        $this->layout->buffer('content', 'reports/invoice_aging_index')->render();
    }

    public function sales_by_year()
    {

        if ($this->input->get('btn_submit')) {
            $data = array(
                'results' => $this->mdl_reports->sales_by_year($this->input->get('from_date'), $this->input->get('to_date'), $this->input->get('minQuantity'), $this->input->get('maxQuantity'), $this->input->get('checkboxTax')),
                'from_date' => $this->input->get('from_date'),
                'to_date' => $this->input->get('to_date'),
            );

            $html = $this->load->view('reports/sales_by_year', $data, true);

            $this->load->helper('mpdf');

            pdf_create($html, trans('sales_by_date'), true);
        }

        $this->layout->buffer('content', 'reports/sales_by_year_index')->render();
    }

    public function invoice_by_date()
    {

        if ($this->input->get('btn_submit')) {
            $fd = new DateTime($this->input->get('from_date'));
            $td = new DateTime($this->input->get('to_date'));

            $from = $fd->format('Y-m-d');
            $to = $td->format('Y-m-d');

            $data = array(
                'results' => $this->mdl_reports->invoice_by_date($from, $to, $this->input->get('client_id'), $this->input->get('status_id')),
                'from_date' => $from,
                'to_date' => $to,
            );

            $html = $this->load->view('reports/invoice_by_date', $data, true);

            $this->load->helper('mpdf');

            pdf_create($html, trans('invoice_by_date'), true);
        }

        $status='active';
        $this->load->model('clients/mdl_clients');
        $this->mdl_clients->with_total_balance()->paginate(site_url('clients/status/' . $status));
        $clients = $this->mdl_clients->result();

//        $this->load->model('invoices/mdl_invoices');
//        $this->mdl_products->paginate(site_url('products/index'));
//        $products = $this->mdl_products->result_with_qty();

        $this->layout->set(
            array(
                'records' => $clients,
//                'products' => $products,
                'filter_display' => true,
                'filter_placeholder' => trans('filter_clients'),
                'filter_method' => 'filter_clients'
            )
        );

        $this->layout->buffer('content', 'reports/invoice_by_date_index')->render();
    }


      public function overdue_invoice_by_date()
    {

        if ($this->input->get('btn_submit')) {
            $fd = new DateTime($this->input->get('from_date'));
            $td = new DateTime($this->input->get('to_date'));

            $from = $fd->format('Y-m-d');
            $to = $td->format('Y-m-d');

            $data = array(
                'results' => $this->mdl_reports->overdue_invoice_by_date($from, $to, $this->input->get('client_id')),
                'from_date' => $from,
                'to_date' => $to,
            );

            $html = $this->load->view('reports/overdue_invoice_by_date', $data, true);

            $this->load->helper('mpdf');

            pdf_create($html, 'Overdue Invoices', true);
        }

        $status='active';
        $this->load->model('clients/mdl_clients');
        $this->mdl_clients->with_total_balance()->paginate(site_url('clients/status/' . $status));
        $clients = $this->mdl_clients->result();

//        $this->load->model('invoices/mdl_invoices');
//        $this->mdl_products->paginate(site_url('products/index'));
//        $products = $this->mdl_products->result_with_qty();

        $this->layout->set(
            array(
                'records' => $clients,
//                'products' => $products,
                'filter_display' => true,
                'filter_placeholder' => trans('filter_clients'),
                'filter_method' => 'filter_clients'
            )
        );

        $this->layout->buffer('content', 'reports/overdue_invoices_bydate_index')->render();
    }



    //credit_note

    public function credit_note()
    {
        $this->load->model('reports/mdl_reports');
        $clients=$this->mdl_reports->searchClients();

        $status='active';
        $this->load->model('clients/mdl_clients');
        $this->mdl_clients->with_total_balance()->paginate(site_url('clients/status/' . $status));
       // $clients = $this->mdl_clients->result();

//        $this->load->model('invoices/mdl_invoices');
//        $this->mdl_products->paginate(site_url('products/index'));
//        $products = $this->mdl_products->result_with_qty();

        $this->layout->set(
            array(
                'records' => $clients,
//                'products' => $products,
                'filter_display' => true,
                'filter_placeholder' => trans('filter_clients'),
                'filter_method' => 'filter_clients'
            )
        );

        $this->layout->buffer('content', 'reports/credit_note')->render();

    }




    public function view_credit_notes()
    {
        $this->load->model('clients/mdl_clients');
        $cli = $this->mdl_clients->all_clients();


        $this->load->model('reports/mdl_reports');
        $this->load->model('suppliers/mdl_suppliers');

        $this->layout->set(array(
            'stock' => $this->mdl_reports->allcreditnotes(),
            'clients' => $cli
        ));
        $this->layout->buffer('content', 'reports/index');
        $this->layout->render();
    }



    public function load_invoices()
    {

        $clientid = $this->input->post('client_id');

        $this->load->model('reports/mdl_reports');
        $invresponse=$this->mdl_reports->invoices_byclient($clientid);

       echo json_encode($invresponse);
    }



    public function load_invoice_items()
    {

        $invoiceid = $this->input->post('invoice_id');

        $this->load->model('reports/mdl_reports');
        $invresponse=$this->mdl_reports->invoice_items_byinvoice($invoiceid);

       echo json_encode($invresponse);
    }


    public function save_invoice_credit_notes()
    {
        $clientid = $this->input->post('client_id');
        $invoiceid = $this->input->post('invoice_id');
        $qty = $this->input->post('qty');
        $invoice_item_id = $this->input->post('invoice_item_id');

        $this->load->model('reports/mdl_reports');
        $invresponse=$this->mdl_reports->save_credit_notes($clientid,$invoiceid,$invoice_item_id,$qty);

       echo json_encode($invresponse);
    }


    //credit note



    public function profit_report()
    {

            $fd = new DateTime($this->input->get('from_date'));
            $td = new DateTime($this->input->get('to_date'));

             $from = $fd->format('Y-m-d');
             $to = $td->format('Y-m-d');

            $from_six =  date("Y-m-d", strtotime("-6 months"));
            $to_six =  date("Y-m-d");

        $sales_months = $this->mdl_reports->sales_by_month($from_six, $to_six);
        $receives_months = $this->mdl_reports->receives_by_months($from_six, $to_six);
        $stock_months = $this->mdl_reports->stock_sum_by_months($from_six, $to_six);
        $expenses_months =$this->mdl_reports->expenses_by_months($from_six, $to_six);
//
//        print_r($receives_months);
//        print_r($expenses_months);
//        print_r($stock_months);

        $ret = array();
        foreach ($receives_months as $key => $value) {
            //print_r($value);
            if($value->months === $stock_months[$key]['months']){
                $ret[$key] = array('month'=>$value->months,'value'=>($value->paidamount - $stock_months[$key]['buyingsubtotal']));
            }
        }

        $profit_months = array();
        foreach ($ret as $key =>$values) {
        foreach ($expenses_months as $keys =>$value_ex) {
                if($values['month'] === $value_ex['months'] ){
                    $values['value'] = $values['value'] - $value_ex['expenses'];
                }
            }
            $profit_months[$key] = $values;
        }

            $this->layout->set(
                array(
                    'profit_months' => json_encode($profit_months),
                    'results' => $this->mdl_reports->profit_by_date($from, $to),
                    'resultsa' => $this->mdl_reports->profit_by_datea($from, $to),
                    'resultsab' => $this->mdl_reports->profit_by_dateab($from, $to),
                    'resultss' => $this->mdl_reports->expenses_by_date($from, $to),
                    'from_date' => $from,
                    'to_date' => $to,
                )
            );

        $this->layout->buffer('content', 'reports/profit_report_index')->render();
    }

    public function profit_report_pdf(){
        if ($this->input->get('btn_submit')) {
            $fd = new DateTime($this->input->get('from_date'));
            $td = new DateTime($this->input->get('to_date'));

            $from = $fd->format('Y-m-d');
            $to = $td->format('Y-m-d');

            // $resab=null;

            // $buyt=$this->mdl_reports->profit_by_dateab($from, $to);
            // $bt=floatval($buyt['buyingsubtotal']);
            // if($bt==0.00){
            //     $resab=$this->mdl_reports->profit_by_dateabc($from, $to);
            // }else{
            $resab=$this->mdl_reports->profit_by_dateab($from, $to);
            // }

            $data = array(
                'results' => $this->mdl_reports->profit_by_date($from, $to),
                'resultsa' => $this->mdl_reports->profit_by_datea($from, $to),
                'resultsab' => $resab,
                'resultss' => $this->mdl_reports->expenses_by_date($from, $to),
                'from_date' => $from,
                'to_date' => $to,
            );

            $html = $this->load->view('reports/profit_report', $data, true);

            $this->load->helper('mpdf');

            pdf_create($html, trans('invoice_by_date'), true);
        }
    }

        public function profit_report_new()
    {

        if ($this->input->get('btn_submit')) {
            $fd = new DateTime($this->input->get('from_date'));
            $td = new DateTime($this->input->get('to_date'));

            $from = $fd->format('Y-m-d');
            $to = $td->format('Y-m-d');

            $data = array(
                'results' => $this->mdl_reports->profit_by_date_new($from, $to),
                'from_date' => $from,
                'to_date' => $to,
            );

            $html = $this->load->view('reports/profit_report_new', $data, true);

            $this->load->helper('mpdf');

            pdf_create($html, trans('invoice_by_date'), true);
        }


            $status='active';
            $this->load->model('clients/mdl_clients');
            $this->mdl_clients->with_total_balance()->paginate(site_url('clients/status/' . $status));
            $clients = $this->mdl_clients->result();

            //        $this->load->model('invoices/mdl_invoices');
            //        $this->mdl_products->paginate(site_url('products/index'));
            //        $products = $this->mdl_products->result_with_qty();

            $this->layout->set(
                array(
                    'records' => $clients,
                    //                'products' => $products,
                    'filter_display' => true,
                    'filter_placeholder' => trans('filter_clients'),
                    'filter_method' => 'filter_clients'
                )
                );

            $this->layout->buffer('content', 'reports/profit_report_new_index')->render();


    }

    public function stock_report()
    {
//        if ($this->input->get('btn_submit')) {
            $result=null;
            if($this->input->get('product_id')!=0){
                $result=$this->mdl_reports->stock_pro_report($this->input->get('product_id'));
            }else{
                $result=$this->mdl_reports->stock_all_report();
            }
//            $data = array(
//                'results' => $result,
//            );
            $this->layout->set(
                [
                    'stock_data'=> $result
                ]
            );

//            $this->layout->buffer('content', 'reports/stock_report_index');
//            $this->layout->render();

            //$html = $this->load->view('reports/stock_report', $data, true);

//            $this->load->helper('mpdf');
//
//            pdf_create($html, trans('stock_report'), true);
//        }
        $this->layout->buffer('content', 'reports/stock_report_index')->render();
    }

    public function stock_report_export_pdf()
    {
           $result=$this->mdl_reports->stock_all_report();

           $data = array(
                'results' => $result,
            );

            $html = $this->load->view('reports/stock_report', $data, true);
            $this->load->helper('mpdf');
            pdf_create($html, trans('stock_report'), true);

    }

    public function inventory_report()
    {

        $this->load->model('products/mdl_products');
        $products = $this->mdl_products->result_with_qty();

        if ($this->input->post('btn_submit')) {
            $result=null;
            if($this->input->post('product_id')==0){
                $result=$this->mdl_reports->inventory_all_report($this->input->post('from_date'), $this->input->post('to_date'));
            }else if($this->input->post('product_id')!=0){
                $result=$this->mdl_reports->inventory_pro_report($this->input->post('from_date'), $this->input->post('to_date'),$this->input->post('product_id'));
            }


            $this->layout->set(
                [
                    'results' => $result,
                    'products' => $products,
                    'from_date' => $this->input->post('from_date'),
                    'to_date' => $this->input->post('to_date'),
                    'product_id' => $this->input->post('product_id'),
                ]
            );

//            $html = $this->load->view('reports/inventory_report', $data, true);
//
////            $this->load->helper('mpdf');
////
////            pdf_create($html, trans('inventory_report'), true);
        }else{
            $this->layout->set(
                [
                    'products' => $products,
                    'product_id' => 0,
                ]
            );
        }

        $this->layout->buffer('content', 'reports/inventory_report_index')->render();
    }





}
