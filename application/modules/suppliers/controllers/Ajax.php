<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{

    public $ajax_controller = true;

    public function name_query()
    {
        // Load the model & helper
        $this->load->model('suppliers/mdl_suppliers');

        $response = [];

        // Get the post input
        $query = $this->input->get('query');
        $permissiveSearchClients = $this->input->get('permissive_search_clients');

        if (empty($query)) {
            echo json_encode($response);
            exit;
        }

        // Search for chars "in the middle" of clients names
        $permissiveSearchClients ? $moreClientsQuery = '%' : $moreClientsQuery = '';

        // Search for clients
        $escapedQuery = $this->db->escape_str($query);
        $escapedQuery = str_replace("%", "", $escapedQuery);
        $suppliers = $this->mdl_suppliers
            ->where('supplier_active', 1)
            ->having('supplier_name LIKE \'' . $moreClientsQuery . $escapedQuery . '%\'')
            ->or_having('supplier_contact_name LIKE \'' . $moreClientsQuery . $escapedQuery . '%\'')
            ->order_by('supplier_name')
            ->get()
            ->result();

        foreach ($suppliers as $supplier) {
            $response[] = [
                'id' => $supplier->supplier_id,
                'text' => $supplier->supplier_name,
            ];
        }

        // Return the results
        echo json_encode($response);
    }

    /**
     * Get the latest clients
     */
    public function get_latest()
    {
        // Load the model & helper
        $this->load->model('suppliers/mdl_suppliers');

        $response = [];

        $supplier = $this->mdl_suppliers
            ->where('supplier_active', 1)
            ->limit(5)
            ->order_by('supplier_date_created')
            ->get()
            ->result();

        foreach ($supplier as $sp) {
            $response[] = [
                'id' => $sp->supplier_id,
                'text' => htmlsc($sp->supplier_name),
            ];
        }

        // Return the results
        echo json_encode($response);
    }





}
