<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Individual_model extends CI_Model {

    public function change_status($id, $status_value, $db_name) {
        $data = array(
            'status' => $status_value
        );

        $this->db->where('record_id', $id);
        $this->db->update($db_name, $data);
    }

}

?>