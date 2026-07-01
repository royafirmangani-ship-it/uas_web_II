<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendaftaran extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->check_login();
        $this->load->model('Pendaftaran_model');
        $this->load->model('Pasien_model');
        $this->load->model('Dokter_model');
        $this->load->model('Poli_model');
    }

    public function index()
    {
        $data['title'] = 'Data Pendaftaran';
        $data['breadcrumb'] = [
            ['label' => 'Pendaftaran', 'url' => 'pendaftaran']
        ];

        $search = $this->input->get('search');
        $status = $this->input->get('status');
        $page = $this->uri->segment(3) ? (int)$this->uri->segment(3) : 0;
        $limit = 5;

        $config['base_url'] = site_url('pendaftaran/index');
        $config['total_rows'] = $this->Pendaftaran_model->countAll($search, $status);
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

        $data['pendaftaran'] = $this->Pendaftaran_model->getAll($limit, $page, $search, $status);
        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $search;
        $data['status'] = $status;

        $this->view('pendaftaran/list', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Pendaftaran';
        $data['breadcrumb'] = [
            ['label' => 'Pendaftaran', 'url' => 'pendaftaran'],
            ['label' => 'Tambah', 'url' => 'pendaftaran/create']
        ];

        $this->form_validation->set_rules('id_pasien', 'Pasien', 'required');
        $this->form_validation->set_rules('id_dokter', 'Dokter', 'required');
        $this->form_validation->set_rules('id_poli', 'Poli', 'required');
        $this->form_validation->set_rules('keluhan', 'Keluhan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['pendaftaran'] = null;
            $data['pasien'] = $this->Pasien_model->getAllDropdown();
            $data['dokter'] = $this->Dokter_model->getAllDropdown();
            $data['poli'] = $this->Poli_model->getAllDropdown();
            $this->view('pendaftaran/form', $data);
        } else {
            $insert = [
                'id_pasien' => $this->input->post('id_pasien'),
                'id_dokter' => $this->input->post('id_dokter'),
                'id_poli' => $this->input->post('id_poli'),
                'keluhan' => $this->input->post('keluhan'),
                'tanggal' => date('Y-m-d H:i:s'),
                'status' => 'menunggu',
            ];
            $this->Pendaftaran_model->insert($insert);
            $this->session->set_flashdata('success', 'Pendaftaran berhasil ditambahkan.');
            redirect('pendaftaran');
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Pendaftaran';
        $data['breadcrumb'] = [
            ['label' => 'Pendaftaran', 'url' => 'pendaftaran'],
            ['label' => 'Edit', 'url' => 'pendaftaran/edit/' . $id]
        ];

        $data['pendaftaran'] = $this->Pendaftaran_model->getById($id);
        if (!$data['pendaftaran']) {
            $this->session->set_flashdata('error', 'Pendaftaran tidak ditemukan.');
            redirect('pendaftaran');
        }

        $this->form_validation->set_rules('id_pasien', 'Pasien', 'required');
        $this->form_validation->set_rules('id_dokter', 'Dokter', 'required');
        $this->form_validation->set_rules('id_poli', 'Poli', 'required');
        $this->form_validation->set_rules('keluhan', 'Keluhan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['pasien'] = $this->Pasien_model->getAllDropdown();
            $data['dokter'] = $this->Dokter_model->getAllDropdown();
            $data['poli'] = $this->Poli_model->getAllDropdown();
            $this->view('pendaftaran/form', $data);
        } else {
            $update = [
                'id_pasien' => $this->input->post('id_pasien'),
                'id_dokter' => $this->input->post('id_dokter'),
                'id_poli' => $this->input->post('id_poli'),
                'keluhan' => $this->input->post('keluhan'),
                'status' => $this->input->post('status'),
            ];
            $this->Pendaftaran_model->update($id, $update);
            $this->session->set_flashdata('success', 'Pendaftaran berhasil diperbarui.');
            redirect('pendaftaran');
        }
    }

    public function delete($id)
    {
        $pendaftaran = $this->Pendaftaran_model->getById($id);
        if (!$pendaftaran) {
            $this->session->set_flashdata('error', 'Pendaftaran tidak ditemukan.');
            redirect('pendaftaran');
        }
        $this->Pendaftaran_model->delete($id);
        $this->session->set_flashdata('success', 'Pendaftaran berhasil dihapus.');
        redirect('pendaftaran');
    }

    public function detail($id)
    {
        $data['title'] = 'Detail Pendaftaran';
        $data['breadcrumb'] = [
            ['label' => 'Pendaftaran', 'url' => 'pendaftaran'],
            ['label' => 'Detail', 'url' => 'pendaftaran/detail/' . $id]
        ];

        $data['p'] = $this->Pendaftaran_model->getById($id);
        if (!$data['p']) {
            $this->session->set_flashdata('error', 'Pendaftaran tidak ditemukan.');
            redirect('pendaftaran');
        }

        $this->view('pendaftaran/detail', $data);
    }

    public function update_status($id, $status)
    {
        $pendaftaran = $this->Pendaftaran_model->getById($id);
        if (!$pendaftaran) {
            $this->session->set_flashdata('error', 'Pendaftaran tidak ditemukan.');
            redirect('pendaftaran');
        }

        $allowed = ['menunggu', 'diperiksa', 'selesai'];
        if (!in_array($status, $allowed)) {
            $this->session->set_flashdata('error', 'Status tidak valid.');
            redirect('pendaftaran');
        }

        $this->Pendaftaran_model->update($id, ['status' => $status]);
        $this->session->set_flashdata('success', 'Status berhasil diperbarui.');
        redirect('pendaftaran');
    }
}
