<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gemini_api {
    
    private $api_key;
    private $api_url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';
    
    public function __construct() {
        $CI =& get_instance();
        $CI->load->config('gemini', TRUE);
        $this->api_key = $CI->config->item('gemini_api_key', 'gemini');
    }
    
    /**
     * Generate blog content from a topic
     */
    public function generate_blog($topic) {
        $prompt = "Write a comprehensive, SEO-friendly blog post about: " . $topic . "\n\n";
        $prompt .= "Requirements:\n";
        $prompt .= "- Write 800-1200 words\n";
        $prompt .= "- Use proper HTML tags: <h2> for main headings, <h3> for subheadings, <p> for paragraphs, <ul><li> for bullet points\n";
        $prompt .= "- Make it engaging and informative for beginners\n";
        $prompt .= "- Include an introduction and conclusion\n\n";
        $prompt .= "Return ONLY a valid JSON object in this exact format (no markdown code blocks, no extra text):\n";
        $prompt .= '{"title": "Blog Title Here", "meta_description": "SEO meta description under 160 characters", "meta_keywords": "keyword1, keyword2, keyword3", "content": "Full HTML content here"}';
        
        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 4096
            ]
        ];
        
        $url = $this->api_url . '?key=' . $this->api_key;
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            return ['success' => false, 'error' => 'CURL Error: ' . $error];
        }
        
        if ($http_code !== 200) {
            return ['success' => false, 'error' => 'API Error (HTTP ' . $http_code . '): ' . $response];
        }
        
        $result = json_decode($response, true);
        
        if (!isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            return ['success' => false, 'error' => 'Invalid API response structure'];
        }
        
        $text = $result['candidates'][0]['content']['parts'][0]['text'];
        
        // Clean up markdown code blocks if Gemini wrapped JSON in them
        $text = preg_replace('/^```json\s*/', '', $text);
        $text = preg_replace('/^```\s*/', '', $text);
        $text = preg_replace('/\s*```$/', '', $text);
        $text = trim($text);
        
        $blog_data = json_decode($text, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['success' => false, 'error' => 'Failed to parse JSON: ' . json_last_error_msg(), 'raw' => $text];
        }
        
        // Validate required fields
        if (empty($blog_data['title']) || empty($blog_data['content'])) {
            return ['success' => false, 'error' => 'Generated content missing required fields', 'raw' => $text];
        }
        
        // Generate slug from title
        $blog_data['slug'] = $this->create_slug($blog_data['title']);
        $blog_data['topic'] = $topic;
        
        return ['success' => true, 'data' => $blog_data];
    }
    
    /**
     * Create URL-friendly slug
     */
    private function create_slug($string) {
        $slug = strtolower(trim($string));
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);  // remove special chars except spaces and hyphens
        $slug = preg_replace('/[\s]+/', '-', $slug);       // replace ALL spaces with hyphens
        $slug = preg_replace('/-+/', '-', $slug);            // remove multiple hyphens
        $slug = trim($slug, '-');                            // trim hyphens from ends
        $slug = substr($slug, 0, 100);                      // limit length
        return $slug . '-' . time();                         // add timestamp to ensure uniqueness
    }
}