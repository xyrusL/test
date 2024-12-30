<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class fetchAnimeModel extends CI_Model {
    private function hasMoreAnime($offset, $limit, $conditions = array()) {
        foreach ($conditions as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->limit(1, $offset + $limit);
        return $this->db->get('animeseries')->num_rows() > 0;
    }
    
    public function getAllAnime($offset = 0, $limit = 24) {
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get('animeseries');
        return $query->result();
    }

    public function getDubAnime($offset = 0, $limit = 24) {
        $this->db->where('language', 'dub');
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get('animeseries');
        return $query->result();
    }

    public function getSubAnime($offset = 0, $limit = 24) {
        $this->db->where('language', 'sub');
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get('animeseries');
        return $query->result();
    }

    public function getMovieAnime($offset = 0, $limit = 24) {
        $this->db->where('category', 'movie');
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get('animeseries');
        return $query->result();
    }
}