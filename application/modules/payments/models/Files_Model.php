<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 8/2/18
 * Time: 3:41 PM
 */

class Files_Model extends CI_Model {

    public function insert_file($filename, $title)
    {
        $data = array(
            'filename'      => $filename,
            'title'         => $title
        );
        $this->db->insert('files', $data);
        return $this->db->insert_id();
    }

}