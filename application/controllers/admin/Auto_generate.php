<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auto_generate extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('blog_model');
        $this->load->model('topic_model');
        $this->load->model('auto_generate_log_model');
        $this->load->library('gemini_api');
        $this->load->helper(['url', 'form']);
        $this->load->library('session'); 
    }
    
    // Dashboard: show topics, logs, and generate button
    public function index() {
        $data['title'] = 'Auto Generate Settings';
        $data['topics'] = $this->topic_model->get_all_topics();
        $data['logs'] = $this->auto_generate_log_model->get_all_logs(20);
        $data['active_count'] = $this->blog_model->count_active_blogs();
        $this->load->view('admin/auto_generate/dashboard', $data);
    }
    
    // AJAX: Generate multiple posts now
    public function generate_now() {
        $count = (int) $this->input->post('count', true);
        if ($count < 1 || $count > 10) $count = 4;
        
        $topics = $this->topic_model->get_random_active_topics($count);
        $results = [];
        
        foreach ($topics as $topic) {
            $result = $this->gemini_api->generate_blog($topic->topic);
            
            if ($result['success']) {
                $data = $result['data'];
                $data['status'] = 0;
                $data['is_auto_generated'] = 1;
                $blog_id = $this->blog_model->insert_blog($data);
                $results[] = ['success' => true, 'title' => $data['title'], 'id' => $blog_id];
                
                $this->auto_generate_log_model->insert([
                    'topic' => $topic->topic,
                    'blog_id' => $blog_id,
                    'status' => 'success'
                ]);
            } else {
                $results[] = ['success' => false, 'error' => $result['error'], 'topic' => $topic->topic];
                $this->auto_generate_log_model->insert([
                    'topic' => $topic->topic,
                    'status' => 'failed',
                    'error_message' => $result['error']
                ]);
            }
            sleep(2); // Small delay between API calls
        }
        
        echo json_encode(['results' => $results]);
    }
    
    // Add topic to pool
    public function add_topic() {
        $topic = $this->input->post('topic', true);
        $category = $this->input->post('category', true);
        if (!empty($topic)) {
            $this->topic_model->insert_topic(['topic' => $topic, 'category' => $category]);
            $this->session->set_flashdata('success', 'Topic added to pool!');
        }
        redirect('admin/auto_generate');
    }
    
    // Delete topic from pool
    public function delete_topic($id) {
        $this->topic_model->delete_topic($id);
        $this->session->set_flashdata('success', 'Topic removed!');
        redirect('admin/auto_generate');
    }
}
