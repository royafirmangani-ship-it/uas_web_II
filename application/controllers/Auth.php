<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->helper('url');
	}

	public function index()
	{
		if ($this->session->userdata('id_user')) {
			redirect('dashboard');
		} else {
			$this->load->view('auth/login');
		}
	}

	public function login()
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect('auth');
		}

		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$user = $this->db->get_where('users', ['username' => $username])->row_array();

		if ($user && password_verify($password, $user['password'])) {
			$session_data = [
				'id_user' => $user['id_user'],
				'nama'    => $user['nama'],
				'username' => $user['username'],
				'role'    => $user['role'],
			];
			$this->session->set_userdata($session_data);
			redirect('dashboard');
		} else {
			$this->session->set_flashdata('error', 'Username atau password salah.');
			redirect('auth');
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth');
	}
}
