<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obat extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->check_login();
        $this->load->model('Obat_model');
    }

    public function index()
    {
        $data['title'] = 'Data Obat';
        $data['breadcrumb'] = [
            ['label' => 'Data Obat', 'url' => 'obat']
        ];

        $search = $this->input->get('search');
        $page = $this->input->get('per_page') ? (int)$this->input->get('per_page') : 0;
        $limit = 5;

        $config['base_url'] = site_url('obat/index');
        $config['total_rows'] = $this->Obat_model->countAll($search);
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

        $data['obat'] = $this->Obat_model->getAll($limit, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $search;

        $this->view('obat/list', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Obat';
        $data['breadcrumb'] = [
            ['label' => 'Data Obat', 'url' => 'obat'],
            ['label' => 'Tambah', 'url' => '']
        ];

        $this->form_validation->set_rules('nama_obat', 'Nama Obat', 'required');
        $this->form_validation->set_rules('stok', 'Stok', 'required|numeric');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['obat'] = null;
            $this->view('obat/form', $data);
        } else {
            $this->Obat_model->insert([
                'nama_obat' => $this->input->post('nama_obat'),
                'stok'      => $this->input->post('stok'),
                'harga'     => $this->input->post('harga'),
                'satuan'    => $this->input->post('satuan')
            ]);
            $this->session->set_flashdata('success', 'Data obat berhasil ditambahkan.');
            redirect('obat');
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Obat';
        $data['breadcrumb'] = [
            ['label' => 'Data Obat', 'url' => 'obat'],
            ['label' => 'Edit', 'url' => '']
        ];

        $data['obat'] = $this->Obat_model->getById($id);

        if (!$data['obat']) {
            $this->session->set_flashdata('error', 'Data obat tidak ditemukan.');
            redirect('obat');
        }

        $this->form_validation->set_rules('nama_obat', 'Nama Obat', 'required');
        $this->form_validation->set_rules('stok', 'Stok', 'required|numeric');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->view('obat/form', $data);
        } else {
            $this->Obat_model->update($id, [
                'nama_obat' => $this->input->post('nama_obat'),
                'stok'      => $this->input->post('stok'),
                'harga'     => $this->input->post('harga'),
                'satuan'    => $this->input->post('satuan')
            ]);
            $this->session->set_flashdata('success', 'Data obat berhasil diubah.');
            redirect('obat');
        }
    }

    public function delete($id)
    {
        $obat = $this->Obat_model->getById($id);

        if (!$obat) {
            $this->session->set_flashdata('error', 'Data obat tidak ditemukan.');
            redirect('obat');
        }

        $this->Obat_model->delete($id);
        $this->session->set_flashdata('success', 'Data obat berhasil dihapus.');
        redirect('obat');
    }
}
