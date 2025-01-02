<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function login() {
        $this->load->view('admin/template/head');
        $this->load->view('admin/loginView');
        $this->load->view('admin/template/footer');
    }

    public function dashboard() {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
            return;
        }
        
        $this->load->view('admin/template/head');
        $this->load->view('admin/dashboardView');
        $this->load->view('admin/template/footer');
    }

    public function process_login() {
        // Set validation rules
        $this->form_validation->set_rules(
            'username_email', 'Username/Email',
            'required|trim|min_length[3]|max_length[100]|xss_clean',
            array('required' => 'Please enter your username or email')
        );
        $this->form_validation->set_rules(
            'password', 'Password',
            'required|trim|min_length[3]|max_length[255]',
            array('required' => 'Please enter your password')
        );

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth/login');
            return;
        }

        // Sanitize inputs
        $username_email = $this->security->xss_clean($this->input->post('username_email', TRUE));
        $password = $this->input->post('password', TRUE);

        // Verify CSRF token
        if ($this->input->post('csrf_token') !== $this->security->get_csrf_hash()) {
            $this->session->set_flashdata('error', 'Security validation failed');
            redirect('auth/login');
            return;
        }

        if (empty($username_email) || empty($password)) {
            $this->session->set_flashdata('error', 'Invalid input data');
            redirect('auth/login');
            return;
        }

        $this->load->model('admin/authModel');
        $admin = $this->authModel->verify_login($username_email);

        if ($admin) {
            if (password_verify($password, $admin->password) || $password === $admin->password) {
                // Regenerate session ID for security
                $this->session->sess_regenerate(TRUE);
                
                $this->session->set_userdata([
                    'admin_id' => $admin->id,
                    'admin_name' => $admin->name,
                    'logged_in' => TRUE
                ]);
                redirect('admin/dashboard');
                return;
            }
        }

        $this->session->set_flashdata('error', 'Invalid credentials');
        redirect('auth/login');
    }
}