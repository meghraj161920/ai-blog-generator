<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blogs extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('blog_model');
        $this->load->helper('url');
    }
    
    // Blog listing page (public - only active blogs)
    public function index() {
        $data['title'] = 'Our Blog';
        $data['blogs'] = $this->blog_model->get_active_blogs();
        $this->load->view('blogs/list', $data);
    }
    
    // Single blog page (public - only active)
    public function detail($slug) {
        $data['blog'] = $this->blog_model->get_active_blog_by_slug($slug);
        
        if (!$data['blog']) {
            show_404();
        }
        
        $data['title'] = $data['blog']->title;
        $this->load->view('blogs/detail', $data);
    }
}
