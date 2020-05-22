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
 * Class Tasks
 */
class Tasks extends Admin_Controller
{
    /**
     * Tasks constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_tasks');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {
        $this->mdl_tasks->paginate(site_url('tasks/index'), $page);
        $tasks = $this->mdl_tasks->result();

        $this->layout->set('tasks', $tasks);
        $this->layout->set('task_statuses', $this->mdl_tasks->statuses());
        $this->layout->buffer('content', 'tasks/index');
        $this->layout->render();
    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('tasks');
        }
        $task_name = $this->input->post('task_name');
        $task_description = $this->input->post('task_description');
        $task_price = $this->input->post('task_price');
        $tax_rate_id = $this->input->post('tax_rate_id');
        $project_id = $this->input->post('project_id');
        $task_finish_date = new DateTime($this->input->post('task_finish_date'));
        $tfd = $task_finish_date->format('Y-m-d');

        $imageName="";
        if (!empty($_FILES['imagefile']['name'])){
            $data=explode('.',$_FILES['imagefile']['name']);
            $extension=$data[1];
            $allowed_extension=array("jpg","png","jpg","jpeg");
            if(in_array($extension,$allowed_extension)){
                $new_file_name=rand().'.'.$extension;
                $path='uploads/'.$new_file_name;
                if(move_uploaded_file($_FILES['imagefile']['tmp_name'],$path)){
                    //echo json_encode($_FILES['imagefile']['tmp_name']);
                    $imageName = $path;
                }
            }
        }
        if ($this->mdl_tasks->run_validation()) {
            $db_array = array(
                'task_name' => $task_name,
                'task_finish_date'=>$tfd,
                'task_description' => $task_description,
                'task_price' => $task_price,
                'tax_rate_id' => $tax_rate_id,
                'project_id' => $project_id,
                'photo' => $imageName
            );
            $id = $this->mdl_tasks->save_task($db_array);

            redirect('tasks');
        }

        if (!$this->input->post('btn_submit')) {
            $prep_form = $this->mdl_tasks->prep_form($id);
            if ($id and !$prep_form) {
                show_404();
            }
        }

        $this->load->model('projects/mdl_projects');
        $this->load->model('tax_rates/mdl_tax_rates');

        $this->layout->set(
            array(
                'projects' => $this->mdl_projects->get()->result(),
                'task_statuses' => $this->mdl_tasks->statuses(),
                'tax_rates' => $this->mdl_tax_rates->get()->result(),
            )
        );
        $this->layout->buffer('content', 'tasks/form');
        $this->layout->render();
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->mdl_tasks->delete($id);
        redirect('tasks');
    }
}
