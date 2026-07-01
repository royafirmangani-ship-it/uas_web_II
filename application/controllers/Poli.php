<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poli extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->check_login();
        $this->load->model('Poli_model');
    }

    public function index()
    {
        $data['title'] = 'Data Poli';
        $data['breadcrumb'] = [
            ['label' => 'Data Poli', 'url' => 'poli']
        ];

        $search = $this->input->get('search');
        $page = $this->input->get('per_page') ? (int)$this->input->get('per_page') : 0;
        $limit = 5;

        $config['base_url'] = site_url('poli/index');
        $config['total_rows'] = $this->Poli_model->countAll($search);
        $config['per_page'] = $limit;
        $config['reuse_query_string'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['enable_query_strings'] = TRUE;
        $config['full_tag_open'] = '<nav><ul class="pagination pagination-sm m-0 float-right">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['attributes'] = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        $data['poli'] = $this->Poli_model->getAll($limit, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $search;

        $this->view('poli/list', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Poli';
        $data['breadcrumb'] = [
            ['label' => 'Data Poli', 'url' => 'poli'],
            ['label' => 'Tambah', 'url' => '']
        ];

        $this->form_validation->set_rules('nama_poli', 'Nama Poli', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['poli'] = null;
            $this->view('poli/form', $data);
        } else {
            $this->Poli_model->insert([
                'nama_poli' => $this->input->post('nama_poli')
            ]);
            $this->session->set_flashdata('success', 'Data poli berhasil ditambahkan.');
            redirect('poli');
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Poli';
        $data['breadcrumb'] = [
            ['label' => 'Data Poli', 'url' => 'poli'],
            ['label' => 'Edit', 'url' => '']
        ];

        $data['poli'] = $this->Poli_model->getById($id);

        if (!$data['poli']) {
            $this->session->set_flashdata('error', 'Data poli tidak ditemukan.');
            redirect('poli');
        }

        $this->form_validation->set_rules('nama_poli', 'Nama Poli', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->view('poli/form', $data);
        } else {
            $this->Poli_model->update($id, [
                'nama_poli' => $this->input->post('nama_poli')
            ]);
            $this->session->set_flashdata('success', 'Data poli berhasil diubah.');
            redirect('poli');
        }
    }

    public function delete($id)
    {
        $poli = $this->Poli_model->getById($id);

        if (!$poli) {
            $this->session->set_flashdata('error', 'Data poli tidak ditemukan.');
            redirect('poli');
        }

        $this->Poli_model->delete($id);
        $this->session->set_flashdata('success', 'Data poli berhasil dihapus.');
        redirect('poli');
    }
}
