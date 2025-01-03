<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$this->load->model('fetchAnimeModel');
		$data['animeSeries'] = $this->fetchAnimeModel->getAllAnime();
		$this->load->view('/home/homepage', $data);
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
}