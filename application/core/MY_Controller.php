<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['session', 'form_validation', 'pagination']);
        $this->load->helper(['url', 'form', 'file']);
    }

    protected function check_login()
    {
        if (!$this->session->userdata('id_user')) {
            redirect('auth');
        }
    }

    protected function check_admin()
    {
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak! Hanya untuk admin.');
            redirect('dashboard');
        }
    }

    protected function check_petugas()
    {
        if ($this->session->userdata('role') !== 'petugas') {
            $this->session->set_flashdata('error', 'Akses ditolak! Hanya untuk petugas.');
            redirect('dashboard');
        }
    }

    protected function view($view, $data = [])
    {
        $data['content'] = $this->load->view($view, $data, true);
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/content', $data);
        $this->load->view('template/footer', $data);
    }
}
