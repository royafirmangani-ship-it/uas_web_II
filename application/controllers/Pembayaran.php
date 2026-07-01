<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->check_login();
        $this->load->model('Pembayaran_model');
    }

    public function index()
    {
        $data['title'] = 'Data Pembayaran';
        $data['breadcrumb'] = [
            ['label' => 'Pembayaran', 'url' => 'pembayaran']
        ];

        $search = $this->input->get('search');
        $status = $this->input->get('status');
        $page = $this->uri->segment(3) ? (int)$this->uri->segment(3) : 0;
        $limit = 5;

        $config['base_url'] = site_url('pembayaran/index');
        $config['total_rows'] = $this->Pembayaran_model->countAll($search, $status);
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

        $data['pembayaran'] = $this->Pembayaran_model->getAll($limit, $page, $search, $status);
        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $search;
        $data['status_filter'] = $status;

        $this->view('pembayaran/list', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Pembayaran';
        $data['breadcrumb'] = [
            ['label' => 'Pembayaran', 'url' => 'pembayaran'],
            ['label' => 'Tambah', 'url' => 'pembayaran/create']
        ];

        $this->form_validation->set_rules('id_periksa', 'Pemeriksaan', 'required');
        $this->form_validation->set_rules('biaya', 'Biaya', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $data['pemeriksaan'] = $this->Pembayaran_model->getAvailablePemeriksaan();
            $data['pembayaran'] = null;
            $this->view('pembayaran/form', $data);
        } else {
            $insert = [
                'id_periksa' => $this->input->post('id_periksa'),
                'biaya' => $this->input->post('biaya'),
                'status' => $this->input->post('status') ?: 'belum',
                'tanggal' => $this->input->post('tanggal') ?: date('Y-m-d H:i:s'),
            ];
            $this->Pembayaran_model->insert($insert);
            $this->session->set_flashdata('success', 'Pembayaran berhasil ditambahkan.');
            redirect('pembayaran');
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Pembayaran';
        $data['breadcrumb'] = [
            ['label' => 'Pembayaran', 'url' => 'pembayaran'],
            ['label' => 'Edit', 'url' => 'pembayaran/edit/' . $id]
        ];

        $data['pembayaran'] = $this->Pembayaran_model->getById($id);
        if (!$data['pembayaran']) {
            $this->session->set_flashdata('error', 'Pembayaran tidak ditemukan.');
            redirect('pembayaran');
        }

        $this->form_validation->set_rules('biaya', 'Biaya', 'required|numeric');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[lunas,belum,batal]');

        if ($this->form_validation->run() == FALSE) {
            $data['pemeriksaan'] = $this->Pembayaran_model->getAvailablePemeriksaan();
            $this->view('pembayaran/form', $data);
        } else {
            $update = [
                'biaya' => $this->input->post('biaya'),
                'status' => $this->input->post('status'),
                'tanggal' => $this->input->post('tanggal'),
            ];
            $this->Pembayaran_model->update($id, $update);
            $this->session->set_flashdata('success', 'Pembayaran berhasil diperbarui.');
            redirect('pembayaran');
        }
    }

    public function delete($id)
    {
        $pembayaran = $this->Pembayaran_model->getById($id);
        if (!$pembayaran) {
            $this->session->set_flashdata('error', 'Pembayaran tidak ditemukan.');
            redirect('pembayaran');
        }
        $this->Pembayaran_model->delete($id);
        $this->session->set_flashdata('success', 'Pembayaran berhasil dihapus.');
        redirect('pembayaran');
    }

    public function detail($id)
    {
        $data['title'] = 'Detail Pembayaran';
        $data['breadcrumb'] = [
            ['label' => 'Pembayaran', 'url' => 'pembayaran'],
            ['label' => 'Detail', 'url' => 'pembayaran/detail/' . $id]
        ];

        $data['pembayaran'] = $this->Pembayaran_model->getById($id);
        if (!$data['pembayaran']) {
            $this->session->set_flashdata('error', 'Pembayaran tidak ditemukan.');
            redirect('pembayaran');
        }

        $this->view('pembayaran/detail', $data);
    }

    public function nota($id)
    {
        $data['pembayaran'] = $this->Pembayaran_model->getById($id);
        if (!$data['pembayaran']) {
            $this->session->set_flashdata('error', 'Pembayaran tidak ditemukan.');
            redirect('pembayaran');
        }

        $this->load->view('pembayaran/nota', $data);
    }

    public function lunas($id)
    {
        $pembayaran = $this->Pembayaran_model->getById($id);
        if (!$pembayaran) {
            $this->session->set_flashdata('error', 'Pembayaran tidak ditemukan.');
            redirect('pembayaran');
        }
        $this->Pembayaran_model->update($id, ['status' => 'lunas']);
        $this->session->set_flashdata('success', 'Status pembayaran diubah menjadi LUNAS.');
        redirect('pembayaran');
    }

    public function batal($id)
    {
        $pembayaran = $this->Pembayaran_model->getById($id);
        if (!$pembayaran) {
            $this->session->set_flashdata('error', 'Pembayaran tidak ditemukan.');
            redirect('pembayaran');
        }
        $this->Pembayaran_model->update($id, ['status' => 'batal']);
        $this->session->set_flashdata('success', 'Status pembayaran diubah menjadi BATAL.');
        redirect('pembayaran');
    }
}
