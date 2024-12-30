<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    const ITEMS_PER_LOAD = 6;

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

    public function loadMore()
    {
        $offset = $this->input->post('offset');
        $type = $this->input->post('type');
        
        $this->load->model('fetchAnimeModel');
        
        switch($type) {
            case 'dub':
                $data = $this->fetchAnimeModel->getDubAnime($offset);
                break;
            case 'sub':
                $data = $this->fetchAnimeModel->getSubAnime($offset);
                break;
            default:
                $data = $this->fetchAnimeModel->getAllAnime($offset);
        }
        
        echo json_encode(array_slice($data, 0, self::ITEMS_PER_LOAD));
    }
}