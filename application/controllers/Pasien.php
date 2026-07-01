<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasien extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->check_login();
        $this->load->model('Pasien_model');
        $this->load->library('upload');
    }

    public function index()
    {
        $search = $this->input->get('search');
        $page = $this->input->get('per_page') ? (int)$this->input->get('per_page') : 0;
        $limit = 5;

        $config['base_url'] = site_url('pasien?search=' . urlencode($search ?? ''));
        $config['total_rows'] = $this->Pasien_model->countAll($search);
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

        $data['pasien'] = $this->Pasien_model->getAll($limit, $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $search;

        $this->view('pasien/list', $data);
    }

    public function create()
    {
        $this->form_validation->set_rules('no_rm', 'No RM', 'required|is_unique[pasien.no_rm]');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('telepon', 'Telepon', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['pasien'] = null;
            $this->view('pasien/form', $data);
        } else {
            $foto = '';
            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path'] = './uploads/pasien/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 2048;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);

                if ($this->upload->do_upload('foto')) {
                    $foto = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('pasien/create');
                }
            }

            $year = date('Y');
            $lastRM = $this->Pasien_model->getLastRM($year);
            if ($lastRM) {
                $lastNum = (int)substr($lastRM['no_rm'], -5);
                $newNum = str_pad($lastNum + 1, 5, '0', STR_PAD_LEFT);
            } else {
                $newNum = '00001';
            }
            $no_rm = 'RM-' . $year . $newNum;

            $data = [
                'no_rm'         => $no_rm,
                'nama'          => $this->input->post('nama'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'alamat'        => $this->input->post('alamat'),
                'telepon'       => $this->input->post('telepon'),
                'foto'          => $foto,
            ];

            $this->Pasien_model->insert($data);
            $this->session->set_flashdata('success', 'Data pasien berhasil ditambahkan.');
            redirect('pasien');
        }
    }

    public function edit($id)
    {
        $pasien = $this->Pasien_model->getById($id);
        if (!$pasien) {
            $this->session->set_flashdata('error', 'Data pasien tidak ditemukan.');
            redirect('pasien');
        }

        $this->form_validation->set_rules('no_rm', 'No RM', 'required|is_unique[pasien.no_rm.' . $id . ']');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('telepon', 'Telepon', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['pasien'] = $pasien;
            $this->view('pasien/form', $data);
        } else {
            $data = [
                'no_rm'         => $this->input->post('no_rm'),
                'nama'          => $this->input->post('nama'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'alamat'        => $this->input->post('alamat'),
                'telepon'       => $this->input->post('telepon'),
            ];

            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path'] = './uploads/pasien/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 2048;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);

                if ($this->upload->do_upload('foto')) {
                    if ($pasien['foto'] && file_exists('./uploads/pasien/' . $pasien['foto'])) {
                        unlink('./uploads/pasien/' . $pasien['foto']);
                    }
                    $data['foto'] = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('pasien/edit/' . $id);
                }
            }

            $this->Pasien_model->update($id, $data);
            $this->session->set_flashdata('success', 'Data pasien berhasil diperbarui.');
            redirect('pasien');
        }
    }

    public function delete($id)
    {
        $pasien = $this->Pasien_model->getById($id);
        if (!$pasien) {
            $this->session->set_flashdata('error', 'Data pasien tidak ditemukan.');
            redirect('pasien');
        }

        if ($pasien['foto'] && file_exists('./uploads/pasien/' . $pasien['foto'])) {
            unlink('./uploads/pasien/' . $pasien['foto']);
        }

        $this->Pasien_model->delete($id);
        $this->session->set_flashdata('success', 'Data pasien berhasil dihapus.');
        redirect('pasien');
    }

    public function detail($id)
    {
        $pasien = $this->Pasien_model->getById($id);
        if (!$pasien) {
            $this->session->set_flashdata('error', 'Data pasien tidak ditemukan.');
            redirect('pasien');
        }

        $data['pasien'] = $pasien;
        $this->view('pasien/detail', $data);
    }
}
