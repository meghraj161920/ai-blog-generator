<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auto_generate_log_model extends CI_Model {
    
    protected $table = 'auto_generate_logs';
    
    public function get_all_logs($limit = 50) {
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get($this->table)->result();
    }
    
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }
}
