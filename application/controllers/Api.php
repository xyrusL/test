<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('fetchAnimeModel');
    }

    public function getAllAnime() {
        $query = $this->input->post('query');
        $data = $this->fetchAnimeModel->getAllAnime();
        
        if ($query) {
            $query = strtolower($query);
            $data = array_filter($data, function($anime) use ($query) {
                return str_contains(strtolower($anime->title), $query) || 
                       $anime->id == $query;
            });
        }
        
        echo json_encode(array_values($data));
    }

    public function getDubAnime() {
        $data = $this->fetchAnimeModel->getDubAnime();
        echo json_encode($data);
    }

    public function getSubAnime() {
        $data = $this->fetchAnimeModel->getSubAnime();
        echo json_encode($data);
    }

    public function getMovieAnime() {
        $data = $this->fetchAnimeModel->getMovieAnime();
        echo json_encode($data);
    }

    public function getEpisodeUrl() {
        $animeId = $this->input->post('anime_id');
        $episodeIndex = $this->input->post('episode_index');

        $urls = $this->fetchAnimeModel->getAnimeUrls($animeId);

        $response = ['url' => null];
        if ($urls && isset($urls[$episodeIndex])) {
            $response['url'] = $urls[$episodeIndex];
        }

        echo json_encode($response);
    }

    public function updateAnime() {
        $id = $this->input->post('id');
        $data = [
            'title' => $this->input->post('title'),
            'alternative_title' => $this->input->post('alternative_title'),
            'category' => $this->input->post('category'),
            'language' => $this->input->post('language'),
            'total_episodes' => $this->input->post('total_episodes'),
            'status' => $this->input->post('status'),
            'synopsis' => $this->input->post('synopsis'),
            'urls' => json_encode($this->input->post('urls'))
        ];

        $result = $this->fetchAnimeModel->updateAnime($id, $data);
        echo json_encode(['success' => $result]);
    }

    public function searchAnime() {
        $query = $this->input->post('query');
        $result = $this->fetchAnimeModel->searchAnime($query);
        echo json_encode($result);
    }

    public function getRandomAnime() {
        $randomAnime = $this->fetchAnimeModel->getRandomAnime();
        echo json_encode($randomAnime);
    }

    public function getAnimeById() {
        $id = $this->input->post('id');
        $result = $this->fetchAnimeModel->getAnimeById($id);
        echo json_encode($result);
    }

    public function random() {
        $anime = $this->fetchAnimeModel->getRandomAnime();
        if ($anime) {
            redirect(base_url('watch/' . url_title($anime->title, 'dash', TRUE)));
        } else {
            redirect(base_url());
        }
    }
}
