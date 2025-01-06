<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FetchAnimeModel extends CI_Model {
    public function getAnimeDAta() {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('animeseries');
        return $query->result();
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

    private function cleanTitle($title) {
        $title = str_replace([':', '+'], '', $title);
        $title = preg_replace('/[^\p{L}\p{N}\s\-]/u', '', $title);
        $title = strtolower($title);
        $title = preg_replace('/[\s-]+/', '-', $title);
        $title = trim($title, '-');
        return $title;
    }

    public function getAnimeByTitle($url_title) {
        $this->db->select('*');
        $this->db->from('animeseries');
        
        $query = $this->db->get();
        $all_anime = $query->result();
        
        $cleaned_url = $this->cleanTitle($url_title);
        
        foreach($all_anime as $anime) {
            if($this->cleanTitle($anime->title) === $cleaned_url) {
                return $anime;
            }
        }
        
        return null;
    }

    public function getAnimeById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('animeseries');
        return $query->row();
    }

    public function getAnimeUrls($animeId) {
        $this->db->select('urls');
        $this->db->where('id', $animeId);
        $query = $this->db->get('animeseries');
        
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return json_decode($result->urls, true);
        }
        return null;
    }

    public function searchAnime($query) {
        $query = trim($query);
        
        $this->db->select('*, 
            CASE 
                WHEN LOWER(title) = LOWER("'.$query.'") THEN 1
                WHEN LOWER(title) LIKE LOWER("'.$query.'%") THEN 2
                ELSE 3 
            END as match_priority'
        );
        
        $this->db->group_start()
            ->like('title', $query, 'both')
            ->or_like('category', $query, 'both')
            ->group_end();
            
        $this->db->order_by('match_priority', 'ASC')
            ->order_by('title', 'ASC')
            ->limit(6);
            
        $query = $this->db->get('animeseries');
        return $query->result();
    }

    public function getRandomAnime() {
        $this->db->order_by('RAND()');
        $this->db->limit(1);
        $query = $this->db->get('animeseries');
        return $query->row();
    }

    public function updateAnime($id, $data) {
        try {
            $this->db->where('id', $id);
            return $this->db->update('animeseries', $data);
        } catch (Exception $e) {
            log_message('error', 'Error updating anime: ' . $e->getMessage());
            return false;
        }
    }

    public function insertAnime($data) {
        try {
            return $this->db->insert('animeseries', $data);
        } catch (Exception $e) {
            log_message('error', 'Error inserting anime: ' . $e->getMessage());
            return false;
        }
    }
}