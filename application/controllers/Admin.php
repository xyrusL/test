<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function dashboard() {
        $this->load->model('fetchAnimeModel');
        $data['featuredAnime'] = $this->fetchAnimeModel->getFeaturedAnime();
        $this->load->view('admin/admin_panel', $data);
    }
}