<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UploadModel extends CI_Model {
    public function insertAnimeData($data) {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = json_encode($value);
            }
        }
        return $this->db->insert('animeseries', $data);
    }
}