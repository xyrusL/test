<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    // Array of valid pages and their view paths
    private $pages = [
        'anime_post' => 'admin/menus/anime_post',
        'featured_post' => 'admin/menus/featured_post'
        // Add new pages here easily:
        // 'page_name' => 'view/path'
    ];

    public function dashboard() {
        $this->load->view('admin/admin_panel');
    }

    // Generic method to load any page content
    public function load_page($page = null) {
        if($this->input->is_ajax_request()) {
            if($page && isset($this->pages[$page])) {
                $content = $this->load->view($this->pages[$page], [], TRUE);
                echo $content;
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }
}
?>