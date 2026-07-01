<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokter extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->check_login();
        $this->load->model('Dokter_model');
    }

    public function index()
    {
        $search = $this->input->get('search');
        $page = $this->input->get('per_page') ? (int)$this->input->get('per_page') : 0;
        $limit = 5;

        $config['base_url'] = site_url('dokter?search=' . urlencode($search ?? ''));
        $config['total_rows'] = $this->Dokter_model->countAll($search);
        $config['per_page'] = $limit;
        $config['page_query_string'] = TRUE;
        $config['reuse_query_string'] = TRUE;
        $config['full_tag_open'] = '<nav><ul class="pagination pagination-sm m-0 float-right">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['attributes'] = ['class' => 'page-link'];
        $config['first_link'] = '&laquo;';
        $config['last_link'] = '&raquo;';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = '&rsaquo;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&lsaquo;';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $data['dokter'] = $this->Dokter_model->getAll($limit, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $search;

        $this->view('dokter/list', $data);
    }

    public function create()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['dokter'] = null;
            $this->view('dokter/form', $data);
        } else {
            $data = [
                'nama'      => $this->input->post('nama'),
                'spesialis' => $this->input->post('spesialis'),
                'telepon'   => $this->input->post('telepon'),
                'alamat'    => $this->input->post('alamat'),
            ];

            $this->Dokter_model->insert($data);
            $this->session->set_flashdata('success', 'Data dokter berhasil ditambahkan.');
            redirect('dokter');
        }
    }

    public function edit($id)
    {
        $dokter = $this->Dokter_model->getById($id);
        if (!$dokter) {
            $this->session->set_flashdata('error', 'Data dokter tidak ditemukan.');
            redirect('dokter');
        }

        $this->form_validation->set_rules('nama', 'Nama', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['dokter'] = $dokter;
            $this->view('dokter/form', $data);
        } else {
            $data = [
                'nama'      => $this->input->post('nama'),
                'spesialis' => $this->input->post('spesialis'),
                'telepon'   => $this->input->post('telepon'),
                'alamat'    => $this->input->post('alamat'),
            ];

            $this->Dokter_model->update($id, $data);
            $this->session->set_flashdata('success', 'Data dokter berhasil diperbarui.');
            redirect('dokter');
        }
    }

    public function delete($id)
    {
        $dokter = $this->Dokter_model->getById($id);
        if (!$dokter) {
            $this->session->set_flashdata('error', 'Data dokter tidak ditemukan.');
            redirect('dokter');
        }

        $this->Dokter_model->delete($id);
        $this->session->set_flashdata('success', 'Data dokter berhasil dihapus.');
        redirect('dokter');
    }
}
