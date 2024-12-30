<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function upload() {
        $data['title'] = 'Upload Anime';
        $this->load->view('admin/template/head', $data);
        $this->load->view('admin/uploadView');
        $this->load->view('admin/template/footer');
    }

    public function login() {
        $data['title'] = 'Admin Login';
        $this->load->view('admin/template/head', $data);
        $this->load->view('admin/loginView');
        $this->load->view('admin/template/footer');
    }

    public function uploadAnimeData() {
        // Get JSON data from POST request
        $jsonData = $this->input->post('animeData');
        if ($jsonData) {
            // Decode JSON data to PHP array
            $data = json_decode($jsonData, true);
        } else {
            $data = null;
        }

        if ($data) {
            // Prepare data for insertion
            $insertData = array(
                'title' => $data['Title'],
                'poster' => $data['Poster'],
                'total_episodes' => $data['Total Episodes'],
                'category' => $data['Category'],
                'genres' => $data['Genres'],
                'mal_score' => $data['MAL Score'],
                'status' => $data['Status'],
                'language' => $data['Language'],
                'season' => $data['Season'],
                'year' => $data['Year'],
                'urls' => $data['urls'],
                'date' => date('Y-m-d', strtotime($data['date']))
            );

            // Load model and insert data into database
            $this->load->model('admin/UploadModel');
            $result = $this->UploadModel->insertAnimeData($insertData);
            
            // Prepare response based on insertion result
            $response = $result ? 
                array('status' => 'success', 'message' => 'Data inserted successfully') : 
                array('status' => 'error', 'message' => 'Failed to insert data');
        } else {
            // Handle invalid JSON data
            $response = array('status' => 'error', 'message' => 'Invalid JSON data');
        }

        // Return response as JSON
        echo json_encode($response);
    }
}