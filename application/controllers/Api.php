<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
    public function getAllAnime()
    {
        $this->load->model('fetchAnimeModel');
        $data = $this->fetchAnimeModel->getAllAnime();
        echo json_encode($data);
    }

    public function getDubAnime()
    {
        $this->load->model('fetchAnimeModel');
        $data = $this->fetchAnimeModel->getDubAnime();
        echo json_encode($data);
    }

    public function getSubAnime()
    {
        $this->load->model('fetchAnimeModel');
        $data = $this->fetchAnimeModel->getSubAnime();
        echo json_encode($data);
    }

    public function getMovieAnime()
    {
        $this->load->model('fetchAnimeModel');
        $data = $this->fetchAnimeModel->getMovieAnime();
        echo json_encode($data);
    }

    public function getEpisodeUrl()
    {
        $animeId = $this->input->post('anime_id');
        $episodeIndex = $this->input->post('episode_index');

        $this->load->model('fetchAnimeModel');
        $urls = $this->fetchAnimeModel->getAnimeUrls($animeId);

        $response = ['url' => null];
        if ($urls && isset($urls[$episodeIndex])) {
            $response['url'] = $urls[$episodeIndex];
        }

        echo json_encode($response);
    }

    public function searchAnime()
    {
        $query = $this->input->post('query');
        $this->load->model('fetchAnimeModel');
        $result = $this->fetchAnimeModel->searchAnime($query);
        echo json_encode($result);
    }

    public function getRandomAnime()
    {
        $this->load->model('fetchAnimeModel');
        $randomAnime = $this->fetchAnimeModel->getRandomAnime();
        echo json_encode($randomAnime);
    }

    public function getAnimeById()
    {
        $this->load->model('fetchAnimeModel');
        $id = $this->input->post('id');
        $result = $this->fetchAnimeModel->getAnimeById($id);
        echo json_encode($result);
    }

    public function random()
    {
        $this->load->model('fetchAnimeModel');
        $anime = $this->fetchAnimeModel->getRandomAnime();
        if ($anime) {
            redirect(base_url('watch/' . url_title($anime->title, 'dash', TRUE)));
        } else {
            redirect(base_url());
        }
    }
}
