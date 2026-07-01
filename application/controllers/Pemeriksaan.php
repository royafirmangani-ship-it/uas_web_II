<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemeriksaan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->check_login();
        $this->load->model('Pemeriksaan_model');
        $this->load->model('Pendaftaran_model');
    }

    public function index()
    {
        $data['title'] = 'Data Pemeriksaan';
        $data['breadcrumb'] = [
            ['label' => 'Pemeriksaan', 'url' => 'pemeriksaan']
        ];

        $search = $this->input->get('search');
        $page = $this->uri->segment(3) ? (int)$this->uri->segment(3) : 0;
        $limit = 5;

        $config['base_url'] = site_url('pemeriksaan/index');
        $config['total_rows'] = $this->Pemeriksaan_model->countAll($search);
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

        $data['pemeriksaan'] = $this->Pemeriksaan_model->getAll($limit, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $search;

        $this->view('pemeriksaan/list', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Pemeriksaan';
        $data['breadcrumb'] = [
            ['label' => 'Pemeriksaan', 'url' => 'pemeriksaan'],
            ['label' => 'Tambah', 'url' => 'pemeriksaan/create']
        ];

        $this->form_validation->set_rules('id_daftar', 'Pendaftaran', 'required');
        $this->form_validation->set_rules('diagnosa', 'Diagnosa', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['pemeriksaan'] = null;
            $data['pendaftaran_list'] = $this->Pemeriksaan_model->getAvailablePendaftaran();
            $this->view('pemeriksaan/form', $data);
        } else {
            $insert = [
                'id_daftar' => $this->input->post('id_daftar'),
                'diagnosa' => $this->input->post('diagnosa'),
                'tindakan' => $this->input->post('tindakan'),
                'berat_badan' => $this->input->post('berat_badan'),
                'tinggi_badan' => $this->input->post('tinggi_badan'),
                'tekanan_darah' => $this->input->post('tekanan_darah'),
                'catatan' => $this->input->post('catatan'),
                'tgl_periksa' => date('Y-m-d H:i:s'),
            ];
            $this->Pemeriksaan_model->insert($insert);

            $this->Pendaftaran_model->update($this->input->post('id_daftar'), ['status' => 'diperiksa']);

            $this->session->set_flashdata('success', 'Pemeriksaan berhasil ditambahkan.');
            redirect('pemeriksaan');
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Pemeriksaan';
        $data['breadcrumb'] = [
            ['label' => 'Pemeriksaan', 'url' => 'pemeriksaan'],
            ['label' => 'Edit', 'url' => 'pemeriksaan/edit/' . $id]
        ];

        $data['pemeriksaan'] = $this->Pemeriksaan_model->getById($id);
        if (!$data['pemeriksaan']) {
            $this->session->set_flashdata('error', 'Pemeriksaan tidak ditemukan.');
            redirect('pemeriksaan');
        }

        $this->form_validation->set_rules('diagnosa', 'Diagnosa', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->view('pemeriksaan/form', $data);
        } else {
            $update = [
                'diagnosa' => $this->input->post('diagnosa'),
                'tindakan' => $this->input->post('tindakan'),
                'berat_badan' => $this->input->post('berat_badan'),
                'tinggi_badan' => $this->input->post('tinggi_badan'),
                'tekanan_darah' => $this->input->post('tekanan_darah'),
                'catatan' => $this->input->post('catatan'),
            ];
            $this->Pemeriksaan_model->update($id, $update);
            $this->session->set_flashdata('success', 'Pemeriksaan berhasil diperbarui.');
            redirect('pemeriksaan');
        }
    }

    public function detail($id)
    {
        $data['title'] = 'Detail Pemeriksaan';
        $data['breadcrumb'] = [
            ['label' => 'Pemeriksaan', 'url' => 'pemeriksaan'],
            ['label' => 'Detail', 'url' => 'pemeriksaan/detail/' . $id]
        ];

        $data['p'] = $this->Pemeriksaan_model->getById($id);
        if (!$data['p']) {
            $this->session->set_flashdata('error', 'Pemeriksaan tidak ditemukan.');
            redirect('pemeriksaan');
        }

        $this->view('pemeriksaan/detail', $data);
    }

    public function delete($id)
    {
        $pemeriksaan = $this->Pemeriksaan_model->getById($id);
        if (!$pemeriksaan) {
            $this->session->set_flashdata('error', 'Pemeriksaan tidak ditemukan.');
            redirect('pemeriksaan');
        }
        $this->Pemeriksaan_model->delete($id);
        $this->session->set_flashdata('success', 'Pemeriksaan berhasil dihapus.');
        redirect('pemeriksaan');
    }
}
