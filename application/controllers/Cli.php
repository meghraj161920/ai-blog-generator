<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cli extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Security: only allow command-line access
        if (!$this->input->is_cli_request()) {
            echo "This script can only be run from the command line.\n";
            exit;
        }
        $this->load->model('blog_model');
        $this->load->model('topic_model');
        $this->load->model('auto_generate_log_model');
        $this->load->library('gemini_api');
    }
    
    /**
     * Auto-generate blog posts from command line
     * Usage: php index.php cli auto_generate 1
     */
    public function auto_generate($count = 1) {
        echo "========================================\n";
        echo "  Auto-Generating {$count} Blog Post(s)\n";
        echo "  " . date('Y-m-d H:i:s') . "\n";
        echo "========================================\n\n";
        
        $topics = $this->topic_model->get_random_active_topics($count);
        
        if (empty($topics)) {
            echo "❌ No active topics found in the pool. Add topics first!\n";
            exit;
        }
        
        foreach ($topics as $topic) {
            echo "📝 Topic: {$topic->topic}\n";
            echo "⏳ Generating... ";
            
            $result = $this->gemini_api->generate_blog($topic->topic);
            
            if ($result['success']) {
                $data = $result['data'];
                $data['status'] = 0;
                $data['is_auto_generated'] = 1;
                $blog_id = $this->blog_model->insert_blog($data);
                
                echo "✅ DONE (ID: {$blog_id})\n";
                echo "   Title: {$data['title']}\n\n";
                
                $this->auto_generate_log_model->insert([
                    'topic' => $topic->topic,
                    'blog_id' => $blog_id,
                    'status' => 'success'
                ]);
            } else {
                echo "❌ FAILED\n";
                echo "   Error: {$result['error']}\n\n";
                
                $this->auto_generate_log_model->insert([
                    'topic' => $topic->topic,
                    'status' => 'failed',
                    'error_message' => $result['error']
                ]);
            }
            sleep(2);
        }
        echo "========================================\n";
        echo "  Auto-Generation Complete!\n";
        echo "========================================\n";
    }
}
