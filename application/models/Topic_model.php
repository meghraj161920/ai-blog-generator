<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Topic_model extends CI_Model {
    
    protected $table = 'blog_topics';
    
    public function get_all_topics() {
        return $this->db->get($this->table)->result();
    }
    
    public function get_active_topics() {
        $this->db->where('is_active', 1);
        return $this->db->get($this->table)->result();
    }
    
    public function get_random_active_topics($limit = 1) {
        $this->db->where('is_active', 1);
        $this->db->order_by('RAND()');
        $this->db->limit($limit);
        return $this->db->get($this->table)->result();
    }
    
    public function insert_topic($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function update_topic($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    public function delete_topic($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
}
