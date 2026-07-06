<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_model extends CI_Model {
    
    protected $table = 'blogs';
    
    public function __construct() {
        parent::__construct();
    }
    
    // Get all blogs (admin - all statuses)
    public function get_all_blogs() {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get($this->table)->result();
    }
    
    // Get only active blogs (frontend)
    public function get_active_blogs($limit = null, $offset = null) {
        $this->db->where('status', 1);
        $this->db->order_by('created_at', 'DESC');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get($this->table)->result();
    }
    
    // Get single blog by ID
    public function get_blog_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }
    
    // Get single active blog by slug (frontend)
    public function get_active_blog_by_slug($slug) {
        $this->db->where('slug', $slug);
        $this->db->where('status', 1);
        return $this->db->get($this->table)->row();
    }
    
    // Insert new blog
    public function insert_blog($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    // Update blog
    public function update_blog($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    // Delete blog
    public function delete_blog($id) {
        $blog = $this->get_blog_by_id($id);
        if ($blog && $blog->image && file_exists($blog->image)) {
            unlink($blog->image);
        }
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
    
    // Toggle status
    public function toggle_status($id, $status) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, ['status' => $status]);
    }
    
    // Count active blogs
    public function count_active_blogs() {
        $this->db->where('status', 1);
        return $this->db->count_all_results($this->table);
    }
}
