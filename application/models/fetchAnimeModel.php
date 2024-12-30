<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class fetchAnimeModel extends CI_Model {
    public function getAllAnime($offset = 0) {
        $this->db->order_by('id', 'DESC');
        $this->db->limit(24, $offset);
        $query = $this->db->get('animeseries');
        return $query->result();
    }

    public function getDubAnime($offset = 0) {
        $this->db->where('language', 'dub');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(24, $offset);
        $query = $this->db->get('animeseries');
        return $query->result();
    }

    public function getSubAnime($offset = 0) {
        $this->db->where('language', 'sub');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(24, $offset);
        $query = $this->db->get('animeseries');
        return $query->result();
    }
}