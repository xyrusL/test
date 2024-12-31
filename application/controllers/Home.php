<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$this->load->model('fetchAnimeModel');
		$data['animeSeries'] = $this->fetchAnimeModel->getAllAnime();
		$this->load->view('homepage', $data);
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

    public function watch($title = '')
    {
        if (empty($title)) {
            redirect('/');
        }

        // Get anime details from your model based on the title
        // $data['anime'] = $this->anime_model->getAnimeByTitle($title);
        
        // For now, just pass the title
        $data['title'] = $title;
        
        // Load your anime series view
        $this->load->view('animeseries', $data);
    }
}