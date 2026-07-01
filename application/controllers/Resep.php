<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resep extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->check_login();
        $this->load->model('Resep_model');
    }

    public function index()
    {
        $data['title'] = 'Data Resep';
        $data['breadcrumb'] = [
            ['label' => 'Resep', 'url' => 'resep']
        ];

        $search = $this->input->get('search');
        $page = $this->uri->segment(3) ? (int)$this->uri->segment(3) : 0;
        $limit = 5;

        $config['base_url'] = site_url('resep/index');
        $config['total_rows'] = $this->Resep_model->countAll($search);
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

        $data['resep'] = $this->Resep_model->getAll($limit, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $search;

        $this->view('resep/list', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Resep';
        $data['breadcrumb'] = [
            ['label' => 'Resep', 'url' => 'resep'],
            ['label' => 'Tambah', 'url' => 'resep/create']
        ];

        $this->form_validation->set_rules('id_periksa', 'Pemeriksaan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['pemeriksaan'] = $this->Resep_model->getAvailablePemeriksaan();
            $data['obat'] = $this->db->get('obat')->result_array();
            $data['resep'] = null;
            $this->view('resep/form', $data);
        } else {
            $insert = [
                'id_periksa' => $this->input->post('id_periksa'),
                'tanggal' => date('Y-m-d H:i:s'),
            ];
            $id_resep = $this->Resep_model->insert($insert);

            $id_obat = $this->input->post('id_obat');
            $jumlah = $this->input->post('jumlah');
            $aturan_pakai = $this->input->post('aturan_pakai');

            if ($id_obat) {
                foreach ($id_obat as $i => $ob) {
                    if (!empty($ob) && isset($jumlah[$i]) && $jumlah[$i] > 0) {
                        $detail = [
                            'id_resep' => $id_resep,
                            'id_obat' => $ob,
                            'jumlah' => $jumlah[$i],
                            'aturan_pakai' => isset($aturan_pakai[$i]) ? $aturan_pakai[$i] : '',
                        ];
                        $this->Resep_model->insertDetail($detail);
                        $this->Resep_model->reduceStock($ob, $jumlah[$i]);
                    }
                }
            }

            $this->session->set_flashdata('success', 'Resep berhasil ditambahkan.');
            redirect('resep');
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Resep';
        $data['breadcrumb'] = [
            ['label' => 'Resep', 'url' => 'resep'],
            ['label' => 'Edit', 'url' => 'resep/edit/' . $id]
        ];

        $data['resep'] = $this->Resep_model->getById($id);
        if (!$data['resep']) {
            $this->session->set_flashdata('error', 'Resep tidak ditemukan.');
            redirect('resep');
        }

        $this->form_validation->set_rules('id_periksa', 'Pemeriksaan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['pemeriksaan'] = $this->Resep_model->getAvailablePemeriksaan();
            $data['obat'] = $this->db->get('obat')->result_array();
            $data['detail'] = $this->Resep_model->getDetails($id);
            $this->view('resep/form', $data);
        } else {
            $update = [
                'id_periksa' => $this->input->post('id_periksa'),
            ];
            $this->Resep_model->update($id, $update);

            $this->Resep_model->deleteDetails($id);

            $id_obat = $this->input->post('id_obat');
            $jumlah = $this->input->post('jumlah');
            $aturan_pakai = $this->input->post('aturan_pakai');

            if ($id_obat) {
                foreach ($id_obat as $i => $ob) {
                    if (!empty($ob) && isset($jumlah[$i]) && $jumlah[$i] > 0) {
                        $detail = [
                            'id_resep' => $id,
                            'id_obat' => $ob,
                            'jumlah' => $jumlah[$i],
                            'aturan_pakai' => isset($aturan_pakai[$i]) ? $aturan_pakai[$i] : '',
                        ];
                        $this->Resep_model->insertDetail($detail);
                        $this->Resep_model->reduceStock($ob, $jumlah[$i]);
                    }
                }
            }

            $this->session->set_flashdata('success', 'Resep berhasil diperbarui.');
            redirect('resep');
        }
    }

    public function detail($id)
    {
        $data['title'] = 'Detail Resep';
        $data['breadcrumb'] = [
            ['label' => 'Resep', 'url' => 'resep'],
            ['label' => 'Detail', 'url' => 'resep/detail/' . $id]
        ];

        $data['resep'] = $this->Resep_model->getById($id);
        if (!$data['resep']) {
            $this->session->set_flashdata('error', 'Resep tidak ditemukan.');
            redirect('resep');
        }

        $data['detail'] = $this->Resep_model->getDetails($id);
        $this->view('resep/detail', $data);
    }

    public function delete($id)
    {
        $resep = $this->Resep_model->getById($id);
        if (!$resep) {
            $this->session->set_flashdata('error', 'Resep tidak ditemukan.');
            redirect('resep');
        }

        $this->Resep_model->deleteDetails($id);
        $this->Resep_model->delete($id);
        $this->session->set_flashdata('success', 'Resep berhasil dihapus.');
        redirect('resep');
    }
}
