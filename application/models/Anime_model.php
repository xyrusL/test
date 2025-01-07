<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anime_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getFeaturedAnime() {
        // Replace this with your actual database query
        $query = $this->db->get('featured_anime'); // Adjust table name as needed
        return $query->result_array();
    }
}
