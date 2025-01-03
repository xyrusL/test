<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function index() {
        $this->load->view('admin/dashboard');
    }

    public function dashboard() {
        $this->load->view('admin/dashboard');
    }

    public function upload() {
        $data['title'] = 'Upload Anime';
        $this->load->view('admin/template/head', $data);
        $this->load->view('admin/uploadView');
        $this->load->view('admin/template/footer');
    }

    public function uploadAnimeData() {
        header('Content-Type: application/json');
        
        try {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid JSON data');
            }

            if (empty($data['Title'])) {
                throw new Exception('Title is required');
            }

            $insertData = [
                'title' => $data['Title'],
                'poster' => $data['Poster'],
                'total_episodes' => isset($data['Total Episodes']) ? intval($data['Total Episodes']) : null,
                'category' => $data['Category'],
                'genres' => is_array($data['Genres']) ? json_encode($data['Genres']) : null,
                'mal_score' => isset($data['MAL Score']) ? floatval($data['MAL Score']) : null,
                'status' => $data['Status'],
                'language' => $data['Language'],
                'season' => $data['Season'],
                'year' => $data['Year'],
                'urls' => is_array($data['urls']) ? json_encode($data['urls']) : null,
                'date' => date('Y-m-d')
            ];

            $this->load->model('admin/UploadModel');
            $result = $this->UploadModel->insertAnimeData($insertData);

            if (!$result) {
                throw new Exception('Failed to insert data');
            }

            echo json_encode(['status' => 'success']);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function load_content() {
        $content = $this->input->get('content');
        $valid_contents = ['dashboard', 'featured_post', 'anime_post', 'users', 'settings', 'reports'];
        
        if (in_array($content, $valid_contents)) {
            if ($content === 'dashboard') {
                $this->load->view('admin/content/monitoring');
            } else {
                $this->load->view('admin/content/' . $content);
            }
        } else {
            show_404();
        }
    }
}