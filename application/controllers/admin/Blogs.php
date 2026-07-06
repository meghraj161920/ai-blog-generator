<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blogs extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('blog_model');
        $this->load->model('topic_model');
        $this->load->library('gemini_api');
        $this->load->helper(['url', 'form']);
        $this->load->library('upload');
        $this->load->library('session');
    }
    
    // Admin blog list
    public function index() {
        $data['blogs'] = $this->blog_model->get_all_blogs();
        $data['title'] = 'Manage Blogs';
        $this->load->view('admin/blogs/list', $data);
    }
    
    // Show AI generation form
    public function create() {
        $data['title'] = 'Generate New Blog';
        $data['blog'] = null;
        $this->load->view('admin/blogs/form', $data);
    }
    
    // AJAX: Generate blog with AI
    public function generate_ai() {
        $topic = $this->input->post('topic', true);
        
        if (empty($topic)) {
            echo json_encode(['success' => false, 'error' => 'Please enter a topic']);
            return;
        }
        
        $result = $this->gemini_api->generate_blog($topic);
        echo json_encode($result);
    }
    
    // Save blog (after generation + image upload)
    public function save() {
        $id = $this->input->post('id');
        
        $data = [
            'title'            => $this->input->post('title', true),
            'slug'             => $this->input->post('slug', true),
            'content'          => $this->input->post('content'),
            'meta_description' => $this->input->post('meta_description', true),
            'meta_keywords'    => $this->input->post('meta_keywords', true),
            'topic'            => $this->input->post('topic', true),
            'status'           => 0 // Always inactive by default
        ];
        
        // Handle image upload
        if (!empty($_FILES['blog_image']['name'])) {
            $config['upload_path']   = './uploads/blogs/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
            $config['max_size']      = 2048; // 2MB
            $config['file_name']     = 'blog_' . time();
            
            // Create directory if not exists
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('blog_image')) {
                $upload_data = $this->upload->data();
                $data['image'] = 'uploads/blogs/' . $upload_data['file_name'];
            } else {
                $error = $this->upload->display_errors('', '');
                $this->session->set_flashdata('error', 'Image upload failed: ' . $error);
                redirect('admin/blogs/create');
                return;
            }
        }
        
        if ($id) {
            // Update existing
            $this->blog_model->update_blog($id, $data);
            $this->session->set_flashdata('success', 'Blog updated successfully!');
        } else {
            // Insert new
            $this->blog_model->insert_blog($data);
            $this->session->set_flashdata('success', 'Blog saved as inactive!');
        }
        
        redirect('admin/blogs');
    }
    
    // Edit blog
    public function edit($id) {
        $data['title'] = 'Edit Blog';
        $data['blog'] = $this->blog_model->get_blog_by_id($id);
        
        if (!$data['blog']) {
            show_404();
        }
        
        $this->load->view('admin/blogs/form', $data);
    }
    
    // Toggle status (activate/deactivate)
    public function toggle_status($id) {
        $blog = $this->blog_model->get_blog_by_id($id);
        if ($blog) {
            $new_status = $blog->status == 1 ? 0 : 1;
            $this->blog_model->toggle_status($id, $new_status);
            
            $msg = $new_status == 1 ? 'Blog activated and is now live!' : 'Blog deactivated.';
            $this->session->set_flashdata('success', $msg);
        }
        redirect('admin/blogs');
    }
    
    // Delete blog
    public function delete($id) {
        $this->blog_model->delete_blog($id);
        $this->session->set_flashdata('success', 'Blog deleted successfully!');
        redirect('admin/blogs');
    }
}
