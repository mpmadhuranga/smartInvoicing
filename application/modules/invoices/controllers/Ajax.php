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
 * Class Ajax
 */
class Ajax extends Admin_Controller
{

    public $ajax_controller = true;

    public function save()
    {
        $this->load->model('invoices/mdl_items');
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('units/mdl_units');
        $this->load->model('invoices/mdl_invoice_sumex');

        $invoice_id = $this->input->post('invoice_id');
        $invoice_no = $this->input->post('invoice_number');
        $pay_m = $this->input->post('payment_method');
        $this->mdl_invoices->set_id($invoice_id);
        if ($this->mdl_invoices->run_validation('validation_rules_save_invoice')) {
            $items = json_decode($this->input->post('items'));
            $invoice_status = $this->input->post('invoice_status_id');
            $invoice_date_created = $this->input->post('invoice_date_created');
            $original_status_id = $this->input->post('ori_st_id');
            $this->check_quantity($invoice_no, $items, $invoice_status);
            foreach ($items as $item) {
                // Check if an item has either a quantity + price or name or description
                if (! empty($item->item_name)) {
                    // $item->client_id;
                    $item->item_quantity = ($item->item_quantity ? standardize_amount($item->item_quantity) : floatval(0));
                    $item->item_price = ($item->item_quantity ? standardize_amount($item->item_price) : floatval(0));
                    $item->item_discount_amount = ($item->item_discount_amount) ? standardize_amount($item->item_discount_amount) : null;
                    $item->item_product_id = ($item->item_product_id ? $item->item_product_id : null);
                    // if (property_exists($item, 'item_date')) {
                    // $item->item_date = ($item->item_date ? date_to_mysql($item->item_date) : null);
                    // }
                    $item->item_product_unit_id = ($item->item_product_unit_id ? $item->item_product_unit_id : null);
                    $item->item_product_unit = $this->mdl_units->get_name($item->item_product_unit_id, $item->item_quantity);
                    $item_id = ($item->item_id) ?: null;

                    $this->load->model('products/mdl_products');
                    $this->load->model('stock/mdl_stock');
                    $stockSum = $this->mdl_stock->get_stock_qty($item->item_product_id);
                    $new_qty = $stockSum[0]->QT - $item->item_quantity;
                    $status = $this->mdl_invoices->qty_check($invoice_no);
                    $invst = 0;
                    $invst = $status['invoice_status_id'];

                    if ($invst == 12) {
                   //     $this->mdl_invoices->updateprice($item->item_price, $item->invoice_id, $item->item_id);
                    //    $this->mdl_invoices->updatepm($pay_m, $invoice_no);
                    } else if ($invst != 2 && $invoice_status == 2) {
                        $this->load->model('products/mdl_products');
                        $this->load->model('stock/mdl_stock');
                        $this->mdl_products->by_product_id($item->item_product_id);
                        $products = $this->mdl_products->get()->result();
                        $stockSum = $this->mdl_stock->get_stock_qty($item->item_product_id);

                        $new_qty = $stockSum[0]->QT - $item->item_quantity;

                        if(($stockSum[0]->QT)==null){
                        $new_qty = 0 - $item->item_quantity;
                        }


                        if ($new_qty < 0) {
                            $response = [
                                'success' => 0,
                                'validation_errors' => "Quantity More than the Stock."
                            ];

                            echo json_encode($response);
                            exit();
                        } else {

                            $stock = $this->mdl_stock->where('stock_product_id = "' . $item->item_product_id . '" AND stock_qty !=0 ')
                                ->order_by('stock_create_date')
                                ->get()
                                ->result();

                            $qty = $item->item_quantity;
                            $checkstep=0;
                            foreach ($stock as $itemStock) {
                                $checkstep++;
                                if ($itemStock->stock_qty >= $qty) {
                                    $updateQty = ($itemStock->stock_qty - $qty);
                                    $this->db->where('stock_id', $itemStock->stock_id);
                                    $this->db->set('stock_qty', $updateQty);
                                    $this->db->update('ip_products_stock');
                                    $qty = $item->item_quantity - $itemStock->stock_qty;
                                    break;
                                } else {
                                    $this->db->where('stock_id', $itemStock->stock_id);
                                    $this->db->set('stock_qty', 0);
                                    $this->db->update('ip_products_stock');
                                    $qty = $qty - $itemStock->stock_qty;
                                }
                            }


                            if($checkstep==0){


                                $stockk = $this->mdl_stock->where('stock_product_id = "' . $item->item_product_id . '" ')
                                ->order_by('stock_id','DESC')
                                ->limit(1)
                                ->get()
                                ->result();

                                foreach ($stockk as $itemStockk) {
                                   
                                        $this->db->where('stock_id', $itemStockk->stock_id);
                                        $this->db->set('stock_qty', ($itemStockk->stock_qty-$qty));
                                        $this->db->update('ip_products_stock');
                                       
                                    
                                }


                            }




                        }
                    } else if ($invst == 2 && $invoice_status == 2) {
                        $this->load->model('products/mdl_products');
                        $this->load->model('stock/mdl_stock');
                        $this->mdl_products->by_product_id($item->item_product_id);
                        $products = $this->mdl_products->get()->result();
                        $stockSum = $this->mdl_stock->get_stock_qty($item->item_product_id);

                            $previous = $this->mdl_invoices->qty_get($item->invoice_id, $item->item_product_id);
                            $previous_qty=0;
                             if($previous==0){
            
                            }else{
                                $previous_qty = $previous['item_quantity'];
                                
                            }

                            $latest_qty = $previous_qty - $item->item_quantity;
                            $new_qty=0;
                            if(($stockSum[0]->QT)==null){
                                $new_qty = $latest_qty;
                            }else{

                                $new_qty = ($stockSum[0]->QT + $latest_qty);
                            }

                            
  
                        if ($new_qty < 0) {
                            $response = [
                                'success' => 0,
                                'validation_errors' => "Quantity More than the Stock."
                            ];

                            echo json_encode($response);
                            exit();
                        } else {


                           
                            $previous = $this->mdl_invoices->qty_get($item->invoice_id, $item->item_product_id);
                            $previous_qty=0;

                            if($previous==0){
            
                            }else{
                                $previous_qty = $previous['item_quantity'];
                                
                            }

                            $latest_qty = $item->item_quantity-$previous_qty;
                           

                            $stock = $this->mdl_stock->where('stock_product_id = "' . $item->item_product_id . '" AND stock_qty !=0 ')
                                ->order_by('stock_create_date')
                                ->get()
                                ->result();

                            $qty = $latest_qty;
                            $checkstep=0;
                            foreach ($stock as $itemStock) {
                                $checkstep++;
                                if ($itemStock->stock_qty >= $qty) {
                                    $updateQty = ($itemStock->stock_qty - $qty);
                                    $this->db->where('stock_id', $itemStock->stock_id);
                                    $this->db->set('stock_qty', $updateQty);
                                    $this->db->update('ip_products_stock');
                                    $qty = $item->item_quantity - $itemStock->stock_qty;
                                    break;
                                } else {
                                    $this->db->where('stock_id', $itemStock->stock_id);
                                    $this->db->set('stock_qty', 0);
                                    $this->db->update('ip_products_stock');
                                    $qty = $qty - $itemStock->stock_qty;
                                }
                            }

                            if($checkstep==0){


                                $stockk = $this->mdl_stock->where('stock_product_id = "' . $item->item_product_id . '" ')
                                ->order_by('stock_id','DESC')
                                ->limit(1)
                                ->get()
                                ->result();

                                foreach ($stockk as $itemStockk) {
                                   
                                        $this->db->where('stock_id', $itemStockk->stock_id);
                                        $this->db->set('stock_qty', ($itemStockk->stock_qty-$qty));
                                        $this->db->update('ip_products_stock');
                                       
                                    
                                }


                            }



                         }
                    }

                    unset($item->item_id);
                    // die($invoice_status);
                    if (! $item->item_task_id) {
                        unset($item->item_task_id);
                    } else {
                        $this->load->model('tasks/mdl_tasks');
                        $this->mdl_tasks->update_status(4, $item->item_task_id);
                    }
                    $item->item_date = date_to_mysql($this->input->post('invoice_date_created'));
                    $item->item_date_added = date_to_mysql($this->input->post('invoice_date_created'));
                    $this->mdl_items->save($item_id, $item);
                } elseif (empty($item->item_name) && (! empty($item->item_quantity) || ! empty($item->item_price))) {
                    // Throw an error message and use the form validation for that
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('item_name', trans('item'), 'required');
                    $this->form_validation->run();

                    $response = [
                        'success' => 0,
                        'validation_errors' => [
                            'item_name' => form_error('item_name', '', '')
                        ]
                    ];

                    echo json_encode($response);
                    exit();
                }
            }

            if ($this->input->post('invoice_discount_amount') === '') {
                $invoice_discount_amount = floatval(0);
            } else {
                $invoice_discount_amount = $this->input->post('invoice_discount_amount');
            }

            if ($this->input->post('invoice_discount_percent') === '') {
                $invoice_discount_percent = floatval(0);
            } else {
                $invoice_discount_percent = $this->input->post('invoice_discount_percent');
            }

            // Generate new invoice number if needed
            $invoice_number = $this->input->post('invoice_number');

            if (empty($invoice_number) && $invoice_status != 1) {
                $invoice_group_id = $this->mdl_invoices->get_invoice_group_id($invoice_id);
                $invoice_number = $this->mdl_invoices->get_invoice_number($invoice_group_id);
            }

            $db_array = [
                'invoice_number' => $invoice_number,
                'invoice_terms' => $this->input->post('invoice_terms'),
                
                'billing_name' => $this->input->post('billing_name'),
                'billing_st_1' => $this->input->post('billing_st_1'),
                'billing_st_2' => $this->input->post('billing_st_2'),
                'billing_city' => $this->input->post('billing_city'),
                'deliver_name' => $this->input->post('deliver_name'),
                'deliver_st_1' => $this->input->post('deliver_st_1'),
                'deliver_st_2' => $this->input->post('deliver_st_2'),
                'deliver_city' => $this->input->post('deliver_city'),
                
                'invoice_date_created' => date_to_mysql($this->input->post('invoice_date_created')),
                'invoice_date_due' => date_to_mysql($this->input->post('invoice_date_due')),
                'invoice_password' => $this->input->post('invoice_password'),
                'invoice_status_id' => $invoice_status,
                'payment_method' => $this->input->post('payment_method'),
                'invoice_discount_amount' => standardize_amount($invoice_discount_amount),
                'invoice_discount_percent' => standardize_amount($invoice_discount_percent)
            ];

            // check if status changed to sent, the feature is enabled and settings is set to sent
            if ($this->config->item('disable_read_only') === false) {
                if ($invoice_status == get_setting('read_only_toggle')) {
                    $db_array['is_read_only'] = 1;
                } else if ($invoice_status == 2 || get_setting('read_only_toggle') == 2) {
                    // $db_array['is_read_only'] = 1;
                    // $response = [
                    // 'success' => 0,
                    // 'validation_errors' => "once you change status as sent, it cannot update again.",
                    // ];

                    // echo json_encode($response);
                    // exit;
                }
            }

            $this->mdl_invoices->save($invoice_id, $db_array);
            $sumexInvoice = $this->mdl_invoices->where('sumex_invoice', $invoice_id)
                ->get()
                ->num_rows();

            if ($sumexInvoice >= 1) {
                $sumex_array = [
                    'sumex_invoice' => $invoice_id,
                    'sumex_reason' => $this->input->post('invoice_sumex_reason'),
                    'sumex_diagnosis' => $this->input->post('invoice_sumex_diagnosis'),
                    'sumex_treatmentstart' => date_to_mysql($this->input->post('invoice_sumex_treatmentstart')),
                    'sumex_treatmentend' => date_to_mysql($this->input->post('invoice_sumex_treatmentend')),
                    'sumex_casedate' => date_to_mysql($this->input->post('invoice_sumex_casedate')),
                    'sumex_casenumber' => $this->input->post('invoice_sumex_casenumber'),
                    'sumex_observations' => $this->input->post('invoice_sumex_observations')
                ];
                $this->mdl_invoice_sumex->save($invoice_id, $sumex_array);
            }

            // Recalculate for discounts
            $this->load->model('invoices/mdl_invoice_amounts');
            $this->mdl_invoice_amounts->calculate($invoice_id);

            $response = [
                'success' => 1
            ];
        } else {
            $this->load->helper('json_error');
            $response = [
                'success' => 0,
                'validation_errors' => json_errors()
            ];
        }

        // Save all custom fields
        if ($this->input->post('custom')) {
            $db_array = [];

            $values = [];
            foreach ($this->input->post('custom') as $custom) {
                if (preg_match("/^(.*)\[\]$/i", $custom['name'], $matches)) {
                    $values[$matches[1]][] = $custom['value'];
                } else {
                    $values[$custom['name']] = $custom['value'];
                }
            }

            foreach ($values as $key => $value) {
                preg_match("/^custom\[(.*?)\](?:\[\]|)$/", $key, $matches);
                if ($matches) {
                    $db_array[$matches[1]] = $value;
                }
            }

            $this->load->model('custom_fields/mdl_invoice_custom');
            $result = $this->mdl_invoice_custom->save_custom($invoice_id, $db_array);
            if ($result !== true) {
                $response = [
                    'success' => 0,
                    'validation_errors' => $result
                ];

                echo json_encode($response);
                exit();
            }
        }

        echo json_encode($response);
    }

    public function check()
    {
        $this->load->model('mdl_invoices');
        $invoice_no = $this->input->post('invoice_number');
        $res = $this->mdl_invoices->qty_check($invoice_no);
        $data = null;
        foreach ($res as $row) {
            $data = $row->invoice_status_id;
        }
        echo json_encode((int) $data);
    }

    public function check_quantity($invoice_no, $items, $invoice_status)
    {
        $status = $this->mdl_invoices->qty_check($invoice_no);
        $invst = 0;
        $invst = $status['invoice_status_id'];
        if ($invst == 2) {
            foreach ($items as $item) {
                
               
                $previous = $this->mdl_invoices->qty_get($item->invoice_id, $item->item_product_id);
                $previous_qty=0;
                 if($previous==0){

                }else{
                    $previous_qty = $previous['item_quantity'];
                    
                }
              
                // $this->mdl_invoices->updateprice($item->item_price, $item->invoice_id, $item->item_id);
                // $this->mdl_invoices->updatepm($pay_m, $invoice_no);

                $stoab = $this->mdl_invoices->stock_qty_get($item->item_product_id);
                $stockab_qty = $stoab['st_qty'];

                // $stock = $this->mdl_stock_new->where('stock_product_id = "' . $item->item_product_id . '" AND stock_qty !=0 ')
                // ->order_by('stock_updated_date')
                // ->get()
                // ->result();

                $latest_qty = $previous_qty - $item->item_quantity;
                $updateQty = ($stockab_qty + $latest_qty);
                if (0 > $updateQty) {
                    $response = [
                        'success' => 0,
                        'validation_errors' => "Quantity More than the Stock."
                    ];

                    echo json_encode($response);
                    exit();
                }else{


                    
                }
            }
        } else if ($invst != 2 && $invoice_status == 2) {
            $this->load->model('products/mdl_products');
            $this->load->model('stock/mdl_stock');
            foreach ($items as $item) {
                $this->mdl_products->by_product_id($item->item_product_id);
                $products = $this->mdl_products->get()->result();
                $stockSum = $this->mdl_stock->get_stock_qty($item->item_product_id);

                $new_qty = $stockSum[0]->QT - $item->item_quantity;
                if ($new_qty < 0) {
                    $response = [
                        'success' => 0,
                        'validation_errors' => "Quantity More than the Stock."
                    ];

                    echo json_encode($response);
                    exit();
                }
            }
        }
    }

    public function setsessiondate()
    {
        $this->session->set_userdata('cdate', $this->input->post('cdate'));
        echo json_encode(date_to_mysql($this->session->userdata('cdate')));
    }

    public function save_invoice_tax_rate()
    {
        $this->load->model('invoices/mdl_invoice_tax_rates');

        if ($this->mdl_invoice_tax_rates->run_validation()) {
            $this->mdl_invoice_tax_rates->save();

            $response = [
                'success' => 1
            ];
        } else {
            $response = [
                'success' => 0,
                'validation_errors' => $this->mdl_invoice_tax_rates->validation_errors
            ];
        }

        echo json_encode($response);
    }

    public function create()
    {
        $this->load->model('invoices/mdl_invoices');

        if ($this->mdl_invoices->run_validation()) {
            $invoice_id = $this->mdl_invoices->create();

            $response = [
                'success' => 1,
                'invoice_id' => $invoice_id
            ];
        } else {
            $this->load->helper('json_error');
            $response = [
                'success' => 0,
                'validation_errors' => json_errors()
            ];
        }

        echo json_encode($response);
    }

    public function create_recurring()
    {
        $this->load->model('invoices/mdl_invoices_recurring');

        if ($this->mdl_invoices_recurring->run_validation()) {
            $this->mdl_invoices_recurring->save();

            $response = [
                'success' => 1
            ];
        } else {
            $this->load->helper('json_error');
            $response = [
                'success' => 0,
                'validation_errors' => json_errors()
            ];
        }

        echo json_encode($response);
    }

    public function get_item()
    {
        $this->load->model('invoices/mdl_items');

        $item = $this->mdl_items->get_by_id($this->input->post('item_id'));

        echo json_encode($item);
    }

    public function modal_create_invoice()
    {
        $this->load->module('layout');
        $this->load->model('invoice_groups/mdl_invoice_groups');
        $this->load->model('tax_rates/mdl_tax_rates');
        $this->load->model('clients/mdl_clients');
        $this->load->model('clients/mdl_client_product');

        $data = [
            'invoice_groups' => $this->mdl_invoice_groups->get()->result(),
            'tax_rates' => $this->mdl_tax_rates->get()->result(),
            // 'client' => $this->mdl_clients->get_by_id($this->input->post('client_id')),
            // 'client' => $this->mdl_client_product->resjoin($this->input->post('create_invoice_client_id')),
            'clients' => $this->mdl_clients->all_clients()
        ];
        $this->layout->load_view('invoices/modal_create_invoice', $data);
    }

    public function modal_create_recurring()
    {
        $this->load->module('layout');

        $this->load->model('mdl_invoices_recurring');

        $data = [
            'invoice_id' => $this->input->post('invoice_id'),
            'recur_frequencies' => $this->mdl_invoices_recurring->recur_frequencies
        ];

        $this->layout->load_view('invoices/modal_create_recurring', $data);
    }

    public function get_recur_start_date()
    {
        $invoice_date = $this->input->post('invoice_date');
        $recur_frequency = $this->input->post('recur_frequency');

        echo increment_user_date($invoice_date, $recur_frequency);
    }

    public function modal_change_client()
    {
        $this->load->module('layout');
        $this->load->model('clients/mdl_clients');

        $data = [
            'client_id' => $this->input->post('client_id'),
            'invoice_id' => $this->input->post('invoice_id'),
            'clients' => $this->mdl_clients->get_latest()
        ];

        $this->layout->load_view('invoices/modal_change_client', $data);
    }

    public function change_client()
    {
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('clients/mdl_clients');

        // Get the client ID
        $client_id = $this->input->post('client_id');
        $client = $this->mdl_clients->where('ip_clients.client_id', $client_id)
            ->get()
            ->row();

        if (! empty($client)) {
            $invoice_id = $this->input->post('invoice_id');

            $db_array = [
                'client_id' => $client_id
            ];
            $this->db->where('invoice_id', $invoice_id);
            $this->db->update('ip_invoices', $db_array);

            $response = [
                'success' => 1,
                'invoice_id' => $invoice_id
            ];
        } else {
            $this->load->helper('json_error');
            $response = [
                'success' => 0,
                'validation_errors' => json_errors()
            ];
        }

        echo json_encode($response);
    }

    public function modal_copy_invoice()
    {
        $this->load->module('layout');

        $this->load->model('invoices/mdl_invoices');
        $this->load->model('invoice_groups/mdl_invoice_groups');
        $this->load->model('tax_rates/mdl_tax_rates');

        $data = [
            'invoice_groups' => $this->mdl_invoice_groups->get()->result(),
            'tax_rates' => $this->mdl_tax_rates->get()->result(),
            'invoice_id' => $this->input->post('invoice_id'),
            'invoice' => $this->mdl_invoices->where('ip_invoices.invoice_id', $this->input->post('invoice_id'))
                ->get()
                ->row()
        ];

        $this->layout->load_view('invoices/modal_copy_invoice', $data);
    }

    public function copy_invoice()
    {
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('invoices/mdl_items');
        $this->load->model('invoices/mdl_invoice_tax_rates');

        if ($this->mdl_invoices->run_validation()) {
            $target_id = $this->mdl_invoices->save();
            $source_id = $this->input->post('invoice_id');

            $this->mdl_invoices->copy_invoice($source_id, $target_id);

            $response = [
                'success' => 1,
                'invoice_id' => $target_id
            ];
        } else {
            $this->load->helper('json_error');
            $response = [
                'success' => 0,
                'validation_errors' => json_errors()
            ];
        }

        echo json_encode($response);
    }

    public function modal_create_credit()
    {
        $this->load->module('layout');

        $this->load->model('invoices/mdl_invoices');
        $this->load->model('invoice_groups/mdl_invoice_groups');
        $this->load->model('tax_rates/mdl_tax_rates');

        $data = [
            'invoice_groups' => $this->mdl_invoice_groups->get()->result(),
            'tax_rates' => $this->mdl_tax_rates->get()->result(),
            'invoice_id' => $this->input->post('invoice_id'),
            'invoice' => $this->mdl_invoices->where('ip_invoices.invoice_id', $this->input->post('invoice_id'))
                ->get()
                ->row()
        ];

        $this->layout->load_view('invoices/modal_create_credit', $data);
    }

    public function create_credit()
    {
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('invoices/mdl_items');
        $this->load->model('invoices/mdl_invoice_tax_rates');

        if ($this->mdl_invoices->run_validation()) {
            $target_id = $this->mdl_invoices->save();
            $source_id = $this->input->post('invoice_id');
            $invoice_status = $this->input->post('invoice_status_id');

            $this->mdl_invoices->copy_credit_invoice($source_id, $target_id);

            // Set source invoice to read-only
            if ($this->config->item('disable_read_only') == false) {
                $this->mdl_invoices->where('invoice_id', $source_id);
                $this->mdl_invoices->update('ip_invoices', [
                    'is_read_only' => '1'
                ]);
            }

            // update qty on product table
            $results = $this->mdl_invoices->product_qty($target_id);

            foreach ($results as $pro) {
                $id = $pro->productid;
                $qt = $pro->qty;

                $str = $qt;
                $str1 = explode("-", $str);
                $qt = (int) $str1[1];

                $this->load->model('products/mdl_products');
                $this->load->model('stock/mdl_stock');
                $this->mdl_products->by_product_id($id);
                $products = $this->mdl_products->get()->result();
//                $stockSum = $this->mdl_stock->select('SUM(stock_qty) AS QT')
//                    ->where('stock_product_id = "' . $id . '" AND stock_qty !=0 ')
//                    ->get()
//                    ->result();
                $stockSum = $this->mdl_stock->get_stock_qty($id);

                if ($invoice_status == 2) {
                    $new_qty = $stockSum[0]->QT + $qt;
                    if ($new_qty < 0) {
                        $response = [
                            'success' => 0,
                            'validation_errors' => "Quantity More than the Stock."
                        ];

                        echo json_encode($response);
                        exit();
                    } else {
                        $stock = $this->mdl_stock->where('stock_product_id = "' . $id . '" AND stock_qty !=0 ')
                            ->order_by('stock_create_date')
                            ->get()
                            ->result();
                        $qty = $qt;
                        foreach ($stock as $itemStock) {
                            if ($itemStock->stock_qty >= $qty) {
                                $updateQty = ($itemStock->stock_qty + $qty);
                                $this->db->where('stock_id', $itemStock->stock_id);
                                $this->db->set('stock_qty', $updateQty);
                                $this->db->update('ip_products_stock');
                                $qty = $qt + $itemStock->stock_qty;
                                break;
                            }
                        }
                    }
                } else if ($invoice_status == 7) {

                    $this->load->model('products/mdl_products');
                    $this->load->model('stock/mdl_stock');
                    $this->mdl_products->by_product_id($item->item_product_id);
                    $products = $this->mdl_products->get()->result();
//                    $stockSum = $this->mdl_stock->select('SUM(stock_qty) AS QT')
//                        ->where('stock_product_id = "' . $item->item_product_id . '" AND stock_qty !=0 ')
//                        ->get()
//                        ->result();

                    $stockSum = $this->mdl_stock->get_stock_qty($item->item_product_id);

                    $new_qty = $stockSum[0]->QT - $item->item_quantity;
                    if ($new_qty < 0) {
                        $response = [
                            'success' => 0,
                            'validation_errors' => "Quantity More than the Stock."
                        ];

                        echo json_encode($response);
                        exit();
                    } else {

                        $stock = $this->mdl_stock->where('stock_product_id = "' . $item->item_product_id . '" AND stock_qty !=0 ')
                            ->order_by('stock_create_date')
                            ->get()
                            ->result();
                        $qty = $item->item_quantity;
                        foreach ($stock as $itemStock) {
                            if ($itemStock->stock_qty >= $qty) {
                                $updateQty = ($itemStock->stock_qty - $qty);
                                $this->db->where('stock_id', $itemStock->stock_id);
                                $this->db->set('stock_qty', $updateQty);
                                $this->db->update('ip_products_stock');
                                $qty = $item->item_quantity - $itemStock->stock_qty;
                                break;
                            }
                        }
                    }
                }
            }

            $this->mdl_invoices->where('invoice_id', $source_id);
            $this->mdl_invoices->update('ip_invoices', [
                'is_read_only' => '1'
            ]);

            // Set target invoice to credit invoice
            $this->mdl_invoices->where('invoice_id', $target_id);
            $this->mdl_invoices->update('ip_invoices', [
                'creditinvoice_parent_id' => $source_id
            ]);

            $this->mdl_invoices->where('invoice_id', $target_id);
            $this->mdl_invoices->update('ip_invoice_amounts', [
                'invoice_sign' => '-1'
            ]);

            $response = [
                'success' => 1,
                'invoice_id' => $target_id
            ];
        } else {
            $this->load->helper('json_error');
            $response = [
                'success' => 0,
                'validation_errors' => json_errors()
            ];
        }

        echo json_encode($response);
    }

    /**
     *
     * @param
     *            $invoice_id
     */
    public function delete_item($invoice_id)
    {
        $success = 0;
        $item_id = $this->input->post('item_id');
        $this->load->model('mdl_invoices');
        // Add Products to Stock
        $this->load->model('stock/mdl_stock');
        $inn = $this->mdl_invoices->checkqty($item_id);
        $invoice_ids = $inn['invoice_id'];
        $status = $this->mdl_invoices->checkstatus($invoice_ids);
        $invst = $status['invoice_status_id'];
        if ($invst == 2) {
            $statu = $this->mdl_invoices->getitemqty($item_id);
            $item_pid = $statu['item_product_id'];
            $stock = $this->mdl_stock->where('stock_product_id = "' . $item_pid . '" ')
                ->order_by('stock_create_date')
                ->get()
                ->result();
            $qty = $statu['item_quantity'];
            foreach ($stock as $itemStock) {
                $updateQty = ($itemStock->stock_qty + $qty);
                $this->db->where('stock_id', $itemStock->stock_id);
                $this->db->set('stock_qty', $updateQty);
                $this->db->update('ip_products_stock');
                $qty = $qty + $itemStock->stock_qty;
                break;
            }
            $success = 1;
        }
        // Only continue if the invoice exists or no item id was provided
        if ($this->mdl_invoices->get_by_id($invoice_id) || empty($item_id)) {
            // Delete invoice item
            $this->load->model('mdl_items');
            $item = $this->mdl_items->delete($item_id);
            // Check if deletion was successful
            if ($item) {
                $success = 1;
                // Mark task as complete from invoiced
                if ($item->item_task_id) {
                    $this->load->model('tasks/mdl_tasks');
                    $this->mdl_tasks->update_status(3, $item->item_task_id);
                }
            }
        }
        // Return the response
        echo json_encode([
            'success' => $success
        ]);
    }

    public function filter_invoices_by_client(){

        $client_id = $this->input->post('client_id');
        $this->load->model('mdl_invoices');

        if($client_id === '0' ){
            $invoices =  $this->mdl_invoices->limit(15)->get()->result();
        }else{
            $invoices =  $this->mdl_invoices->by_client($client_id)->get()->result();
        }


        $data = array(
            'invoices' => $invoices,
            'invoice_statuses' => $this->mdl_invoices->statuses()
        );

        $this->layout->load_view('invoices/partial_invoice_table', $data);

    }

    public function filter_invoices_by_date(){

        $to_date = new DateTime($this->input->post('to_date'));
        $from_date = new DateTime($this->input->post('from_date'));


        $to_date = $to_date->format('Y-m-d');
        $from_date = $from_date->format('Y-m-d');

        $this->load->model('mdl_invoices');

        if(empty($this->input->post('from_date')) && empty($this->input->post('to_date'))) {
            $invoices =  $this->mdl_invoices->limit(15)->get()->result();
        }else{
            $invoices = $this->mdl_invoices->by_date($to_date, $from_date)->get()->result();

        }

        $data = array(
            'invoices' => $invoices,
            'invoice_statuses' => $this->mdl_invoices->statuses()
        );

        $this->layout->load_view('invoices/partial_invoice_table', $data);

    }
}
