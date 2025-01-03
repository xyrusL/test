<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$this->load->model('fetchAnimeModel');
		$data['animeSeries'] = $this->fetchAnimeModel->getAllAnime();
		$this->load->view('/home/homepage', $data);
	}

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

    public function loadMore()
    {
        $offSet = $this->input->post('offSet');
        $type = $this->input->post('currentType'); 
        $itemsPerLoad = 6;
        
        $this->load->model('fetchAnimeModel');
        
        switch($type) {
            case 'dub':
                $result = $this->fetchAnimeModel->getDubAnime($offSet, $itemsPerLoad);
                break;
            case 'sub':
                $result = $this->fetchAnimeModel->getSubAnime($offSet, $itemsPerLoad);
                break;
            case 'movie':
                $result = $this->fetchAnimeModel->getMovieAnime($offSet, $itemsPerLoad);
                break;
            default:
                $result = $this->fetchAnimeModel->getAllAnime($offSet, $itemsPerLoad);
        }
        
        echo json_encode($result);
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

    public function watch($title = '')
    {
        if (empty($title)) {
            redirect('/');
        }

        $this->load->model('fetchAnimeModel');
        $data['anime'] = $this->fetchAnimeModel->getAnimeByTitle($title);
        
        if (!$data['anime']) {
            redirect('/');
        }
        
        $data['title'] = $data['anime']->title;
   
        if (isset($data['anime']->genres)) {
            $genres = json_decode($data['anime']->genres);
            $data['genres'] = implode(', ', $genres);
        } else {
            $data['genres'] = '';
        }
        
        $data['status'] = isset($data['anime']->status) ? $data['anime']->status : 'Unknown';
        $data['total_episodes'] = isset($data['anime']->total_episodes) ? $data['anime']->total_episodes : 1;

        if (isset($data['anime']->urls)) {
            $urls = json_decode($data['anime']->urls);
            $data['episode_count'] = count($urls);
        } else {
            $data['episode_count'] = 1;
        }
        
        $this->load->view('home/animeseries', $data);
    }

    public function random() {
        $this->load->model('fetchAnimeModel');
        $anime = $this->fetchAnimeModel->getRandomAnime();
        if ($anime) {
            redirect(base_url('watch/' . url_title($anime->title, 'dash', TRUE)));
        } else {
            redirect(base_url());
        }
    }

    public function list() {
        $this->load->model('fetchAnimeModel');
        $data['animeSeries'] = $this->fetchAnimeModel->getAllAnime();
        $this->load->view('home/list', $data);
    }

}