<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->check_login();
        $this->check_admin();
        $this->load->model('User_model');
    }

    public function index()
    {
        $data['title'] = 'Data User';
        $data['breadcrumb'] = [
            ['label' => 'User', 'url' => 'user']
        ];

        $search = $this->input->get('search');
        $page = $this->uri->segment(3) ? (int)$this->uri->segment(3) : 0;
        $limit = 5;

        $config['base_url'] = site_url('user/index');
        $config['total_rows'] = $this->User_model->countAll($search);
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = FALSE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['attributes'] = ['class' => 'page-link'];
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $data['users'] = $this->User_model->getAll($limit, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $search;

        $this->view('user/list', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah User';
        $data['breadcrumb'] = [
            ['label' => 'User', 'url' => 'user'],
            ['label' => 'Tambah', 'url' => 'user/create']
        ];

        $this->form_validation->set_rules('nama', 'Nama', 'required|max_length[100]');
        $this->form_validation->set_rules('username', 'Username', 'required|max_length[50]|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,petugas]');

        if ($this->form_validation->run() == FALSE) {
            $data['user'] = null;
            $this->view('user/form', $data);
        } else {
            $insert = [
                'nama' => $this->input->post('nama'),
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role' => $this->input->post('role'),
            ];
            $this->User_model->insert($insert);
            $this->session->set_flashdata('success', 'User berhasil ditambahkan.');
            redirect('user');
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Edit User';
        $data['breadcrumb'] = [
            ['label' => 'User', 'url' => 'user'],
            ['label' => 'Edit', 'url' => 'user/edit/' . $id]
        ];

        $data['user'] = $this->User_model->getById($id);
        if (!$data['user']) {
            $this->session->set_flashdata('error', 'User tidak ditemukan.');
            redirect('user');
        }

        $this->form_validation->set_rules('nama', 'Nama', 'required|max_length[100]');
        $this->form_validation->set_rules('username', 'Username', 'required|max_length[50]|callback_username_check[' . $id . ']');
        if ($this->input->post('password')) {
            $this->form_validation->set_rules('password', 'Password', 'min_length[4]');
        }
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,petugas]');

        if ($this->form_validation->run() == FALSE) {
            $this->view('user/form', $data);
        } else {
            $update = [
                'nama' => $this->input->post('nama'),
                'username' => $this->input->post('username'),
                'role' => $this->input->post('role'),
            ];
            $password = $this->input->post('password');
            if ($password) {
                $update['password'] = password_hash($password, PASSWORD_DEFAULT);
            }
            $this->User_model->update($id, $update);
            $this->session->set_flashdata('success', 'User berhasil diperbarui.');
            redirect('user');
        }
    }

    public function username_check($username, $id)
    {
        $this->db->where('username', $username);
        $this->db->where('id_user !=', $id);
        $exists = $this->db->get('users')->num_rows();
        if ($exists > 0) {
            $this->form_validation->set_message('username_check', 'Username ini sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }

    public function delete($id)
    {
        $user = $this->User_model->getById($id);
        if (!$user) {
            $this->session->set_flashdata('error', 'User tidak ditemukan.');
            redirect('user');
        }
        $this->User_model->delete($id);
        $this->session->set_flashdata('success', 'User berhasil dihapus.');
        redirect('user');
    }

    public function detail($id)
    {
        $data['title'] = 'Detail User';
        $data['breadcrumb'] = [
            ['label' => 'User', 'url' => 'user'],
            ['label' => 'Detail', 'url' => 'user/detail/' . $id]
        ];

        $data['user'] = $this->User_model->getById($id);
        if (!$data['user']) {
            $this->session->set_flashdata('error', 'User tidak ditemukan.');
            redirect('user');
        }

        $this->view('user/detail', $data);
    }
}
