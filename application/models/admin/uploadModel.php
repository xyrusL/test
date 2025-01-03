<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UploadModel extends CI_Model {
    protected $table = 'animeseries';

    public function insertAnimeData($data) {
        if (!is_array($data)) {
            return false;
        }

        if (empty($data['title'])) {
            return false;
        }

        return $this->db->insert($this->table, $data);
    }
}