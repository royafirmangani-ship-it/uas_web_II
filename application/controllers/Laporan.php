<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->check_login();
        $this->check_admin();
        $this->load->model('Pasien_model');
        $this->load->model('Pemeriksaan_model');
        $this->load->model('Pembayaran_model');
    }

    public function pasien()
    {
        $dari  = $this->input->post('dari_tanggal') ?: $this->input->get('dari_tanggal');
        $sampai = $this->input->post('sampai_tanggal') ?: $this->input->get('sampai_tanggal');
        $search = $this->input->post('search') ?: $this->input->get('search');

        if ($this->input->post('export_pdf')) {
            $this->_export_pdf_pasien($dari, $sampai, $search);
        }
        if ($this->input->post('export_excel')) {
            $this->_export_excel_pasien($dari, $sampai, $search);
        }
        if ($this->input->post('print')) {
            $this->_print_pasien($dari, $sampai, $search);
        }

        $page  = $this->input->get('per_page') ? (int)$this->input->get('per_page') : 0;
        $limit = 10;
        $total = $this->_count_pasien($dari, $sampai, $search);

        $config['base_url']          = site_url('laporan/pasien');
        $config['total_rows']        = $total;
        $config['per_page']          = $limit;
        $config['page_query_string'] = TRUE;
        $config['reuse_query_string'] = TRUE;
        $config['full_tag_open']     = '<nav><ul class="pagination pagination-sm m-0 float-right">';
        $config['full_tag_close']    = '</ul></nav>';
        $config['attributes']        = ['class' => 'page-link'];
        $config['first_link']        = '&laquo;';
        $config['last_link']         = '&raquo;';
        $config['first_tag_open']    = '<li class="page-item">';
        $config['first_tag_close']   = '</li>';
        $config['last_tag_open']     = '<li class="page-item">';
        $config['last_tag_close']    = '</li>';
        $config['next_link']         = '&rsaquo;';
        $config['next_tag_open']     = '<li class="page-item">';
        $config['next_tag_close']    = '</li>';
        $config['prev_link']         = '&lsaquo;';
        $config['prev_tag_open']     = '<li class="page-item">';
        $config['prev_tag_close']    = '</li>';
        $config['cur_tag_open']      = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close']     = '</a></li>';
        $config['num_tag_open']      = '<li class="page-item">';
        $config['num_tag_close']     = '</li>';

        $this->pagination->initialize($config);

        $data['pasien']        = $this->_get_pasien($limit, $page, $dari, $sampai, $search);
        $data['pagination']    = $this->pagination->create_links();
        $data['dari_tanggal']  = $dari;
        $data['sampai_tanggal'] = $sampai;
        $data['search']        = $search;

        $this->view('laporan/pasien', $data);
    }

    public function pemeriksaan()
    {
        $dari   = $this->input->post('dari_tanggal') ?: $this->input->get('dari_tanggal');
        $sampai = $this->input->post('sampai_tanggal') ?: $this->input->get('sampai_tanggal');
        $search = $this->input->post('search') ?: $this->input->get('search');

        if ($this->input->post('export_pdf')) {
            $this->_export_pdf_pemeriksaan($dari, $sampai, $search);
        }
        if ($this->input->post('export_excel')) {
            $this->_export_excel_pemeriksaan($dari, $sampai, $search);
        }
        if ($this->input->post('print')) {
            $this->_print_pemeriksaan($dari, $sampai, $search);
        }

        $page  = $this->input->get('per_page') ? (int)$this->input->get('per_page') : 0;
        $limit = 10;
        $total = $this->_count_pemeriksaan($dari, $sampai, $search);

        $config['base_url']          = site_url('laporan/pemeriksaan');
        $config['total_rows']        = $total;
        $config['per_page']          = $limit;
        $config['page_query_string'] = TRUE;
        $config['reuse_query_string'] = TRUE;
        $config['full_tag_open']     = '<nav><ul class="pagination pagination-sm m-0 float-right">';
        $config['full_tag_close']    = '</ul></nav>';
        $config['attributes']        = ['class' => 'page-link'];
        $config['first_link']        = '&laquo;';
        $config['last_link']         = '&raquo;';
        $config['first_tag_open']    = '<li class="page-item">';
        $config['first_tag_close']   = '</li>';
        $config['last_tag_open']     = '<li class="page-item">';
        $config['last_tag_close']    = '</li>';
        $config['next_link']         = '&rsaquo;';
        $config['next_tag_open']     = '<li class="page-item">';
        $config['next_tag_close']    = '</li>';
        $config['prev_link']         = '&lsaquo;';
        $config['prev_tag_open']     = '<li class="page-item">';
        $config['prev_tag_close']    = '</li>';
        $config['cur_tag_open']      = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close']     = '</a></li>';
        $config['num_tag_open']      = '<li class="page-item">';
        $config['num_tag_close']     = '</li>';

        $this->pagination->initialize($config);

        $data['pemeriksaan']   = $this->_get_pemeriksaan($limit, $page, $dari, $sampai, $search);
        $data['pagination']    = $this->pagination->create_links();
        $data['dari_tanggal']  = $dari;
        $data['sampai_tanggal'] = $sampai;
        $data['search']        = $search;

        $this->view('laporan/pemeriksaan', $data);
    }

    public function pembayaran()
    {
        $dari   = $this->input->post('dari_tanggal') ?: $this->input->get('dari_tanggal');
        $sampai = $this->input->post('sampai_tanggal') ?: $this->input->get('sampai_tanggal');
        $search = $this->input->post('search') ?: $this->input->get('search');
        $status = $this->input->post('status') ?: $this->input->get('status');

        if ($this->input->post('export_pdf')) {
            $this->_export_pdf_pembayaran($dari, $sampai, $search, $status);
        }
        if ($this->input->post('export_excel')) {
            $this->_export_excel_pembayaran($dari, $sampai, $search, $status);
        }
        if ($this->input->post('print')) {
            $this->_print_pembayaran($dari, $sampai, $search, $status);
        }

        $page  = $this->input->get('per_page') ? (int)$this->input->get('per_page') : 0;
        $limit = 10;
        $total = $this->_count_pembayaran($dari, $sampai, $search, $status);

        $config['base_url']          = site_url('laporan/pembayaran');
        $config['total_rows']        = $total;
        $config['per_page']          = $limit;
        $config['page_query_string'] = TRUE;
        $config['reuse_query_string'] = TRUE;
        $config['full_tag_open']     = '<nav><ul class="pagination pagination-sm m-0 float-right">';
        $config['full_tag_close']    = '</ul></nav>';
        $config['attributes']        = ['class' => 'page-link'];
        $config['first_link']        = '&laquo;';
        $config['last_link']         = '&raquo;';
        $config['first_tag_open']    = '<li class="page-item">';
        $config['first_tag_close']   = '</li>';
        $config['last_tag_open']     = '<li class="page-item">';
        $config['last_tag_close']    = '</li>';
        $config['next_link']         = '&rsaquo;';
        $config['next_tag_open']     = '<li class="page-item">';
        $config['next_tag_close']    = '</li>';
        $config['prev_link']         = '&lsaquo;';
        $config['prev_tag_open']     = '<li class="page-item">';
        $config['prev_tag_close']    = '</li>';
        $config['cur_tag_open']      = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close']     = '</a></li>';
        $config['num_tag_open']      = '<li class="page-item">';
        $config['num_tag_close']     = '</li>';

        $this->pagination->initialize($config);

        $data['pembayaran']    = $this->_get_pembayaran($limit, $page, $dari, $sampai, $search, $status);
        $data['pagination']    = $this->pagination->create_links();
        $data['dari_tanggal']  = $dari;
        $data['sampai_tanggal'] = $sampai;
        $data['search']        = $search;
        $data['status']        = $status;

        $this->view('laporan/pembayaran', $data);
    }

    // --------------------------------------------------------------------
    // DATA QUERIES
    // --------------------------------------------------------------------

    private function _get_pasien($limit, $page, $dari, $sampai, $search)
    {
        $this->db->from('pasien');
        if ($search) {
            $this->db->group_start();
            $this->db->like('nama', $search);
            $this->db->or_like('no_rm', $search);
            $this->db->or_like('telepon', $search);
            $this->db->group_end();
        }
        if ($dari && $sampai) {
            $this->db->where('tanggal_lahir >=', $dari);
            $this->db->where('tanggal_lahir <=', $sampai);
        }
        $this->db->order_by('id_pasien', 'DESC');
        if ($limit) {
            $this->db->limit($limit, $page);
        }
        return $this->db->get()->result_array();
    }

    private function _count_pasien($dari, $sampai, $search)
    {
        $this->db->from('pasien');
        if ($search) {
            $this->db->group_start();
            $this->db->like('nama', $search);
            $this->db->or_like('no_rm', $search);
            $this->db->or_like('telepon', $search);
            $this->db->group_end();
        }
        if ($dari && $sampai) {
            $this->db->where('tanggal_lahir >=', $dari);
            $this->db->where('tanggal_lahir <=', $sampai);
        }
        return $this->db->count_all_results();
    }

    private function _get_pemeriksaan($limit, $page, $dari, $sampai, $search)
    {
        $this->db->select('pemeriksaan.*, pendaftaran.tanggal as tgl_daftar, pasien.no_rm, pasien.nama as nama_pasien, dokter.nama as nama_dokter, poli.nama_poli');
        $this->db->from('pemeriksaan');
        $this->db->join('pendaftaran', 'pendaftaran.id_daftar = pemeriksaan.id_daftar');
        $this->db->join('pasien', 'pasien.id_pasien = pendaftaran.id_pasien');
        $this->db->join('dokter', 'dokter.id_dokter = pendaftaran.id_dokter');
        $this->db->join('poli', 'poli.id_poli = pendaftaran.id_poli');
        if ($search) {
            $this->db->like('pasien.nama', $search);
        }
        if ($dari && $sampai) {
            $this->db->where('pendaftaran.tanggal >=', $dari);
            $this->db->where('pendaftaran.tanggal <=', $sampai);
        }
        $this->db->order_by('pemeriksaan.id_periksa', 'DESC');
        if ($limit) {
            $this->db->limit($limit, $page);
        }
        return $this->db->get()->result_array();
    }

    private function _count_pemeriksaan($dari, $sampai, $search)
    {
        $this->db->from('pemeriksaan');
        $this->db->join('pendaftaran', 'pendaftaran.id_daftar = pemeriksaan.id_daftar');
        $this->db->join('pasien', 'pasien.id_pasien = pendaftaran.id_pasien');
        if ($search) {
            $this->db->like('pasien.nama', $search);
        }
        if ($dari && $sampai) {
            $this->db->where('pendaftaran.tanggal >=', $dari);
            $this->db->where('pendaftaran.tanggal <=', $sampai);
        }
        return $this->db->count_all_results();
    }

    private function _get_pembayaran($limit, $page, $dari, $sampai, $search, $status)
    {
        $this->db->select('pembayaran.*, pasien.no_rm, pasien.nama as nama_pasien, dokter.nama as nama_dokter, poli.nama_poli');
        $this->db->from('pembayaran');
        $this->db->join('pemeriksaan', 'pemeriksaan.id_periksa = pembayaran.id_periksa');
        $this->db->join('pendaftaran', 'pendaftaran.id_daftar = pemeriksaan.id_daftar');
        $this->db->join('pasien', 'pasien.id_pasien = pendaftaran.id_pasien');
        $this->db->join('dokter', 'dokter.id_dokter = pendaftaran.id_dokter');
        $this->db->join('poli', 'poli.id_poli = pendaftaran.id_poli');
        if ($search) {
            $this->db->group_start();
            $this->db->like('pasien.nama', $search);
            $this->db->or_like('pasien.no_rm', $search);
            $this->db->group_end();
        }
        if ($status !== '') {
            $this->db->where('pembayaran.status', $status);
        }
        if ($dari && $sampai) {
            $this->db->where('pembayaran.tanggal >=', $dari);
            $this->db->where('pembayaran.tanggal <=', $sampai);
        }
        $this->db->order_by('pembayaran.id_bayar', 'DESC');
        if ($limit) {
            $this->db->limit($limit, $page);
        }
        return $this->db->get()->result_array();
    }

    private function _count_pembayaran($dari, $sampai, $search, $status)
    {
        $this->db->from('pembayaran');
        $this->db->join('pemeriksaan', 'pemeriksaan.id_periksa = pembayaran.id_periksa');
        $this->db->join('pendaftaran', 'pendaftaran.id_daftar = pemeriksaan.id_daftar');
        $this->db->join('pasien', 'pasien.id_pasien = pendaftaran.id_pasien');
        if ($search) {
            $this->db->group_start();
            $this->db->like('pasien.nama', $search);
            $this->db->or_like('pasien.no_rm', $search);
            $this->db->group_end();
        }
        if ($status !== '') {
            $this->db->where('pembayaran.status', $status);
        }
        if ($dari && $sampai) {
            $this->db->where('pembayaran.tanggal >=', $dari);
            $this->db->where('pembayaran.tanggal <=', $sampai);
        }
        return $this->db->count_all_results();
    }

    // --------------------------------------------------------------------
    // EXPORT PDF
    // --------------------------------------------------------------------

    private function _export_pdf_pasien($dari, $sampai, $search)
    {
        $data['rows']   = $this->_get_pasien(null, null, $dari, $sampai, $search);
        $data['dari']   = $dari;
        $data['sampai'] = $sampai;
        $data['search'] = $search;
        $data['judul']  = 'LAPORAN DATA PASIEN';

        require_once FCPATH . 'vendor/autoload.php';
        $dompdf = new Dompdf\Dompdf();
        $html   = $this->load->view('laporan/pasien_pdf', $data, true);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan-pasien.pdf', ['Attachment' => false]);
        exit;
    }

    private function _export_pdf_pemeriksaan($dari, $sampai, $search)
    {
        $data['rows']   = $this->_get_pemeriksaan(null, null, $dari, $sampai, $search);
        $data['dari']   = $dari;
        $data['sampai'] = $sampai;
        $data['search'] = $search;
        $data['judul']  = 'LAPORAN DATA PEMERIKSAAN';

        require_once FCPATH . 'vendor/autoload.php';
        $dompdf = new Dompdf\Dompdf();
        $html   = $this->load->view('laporan/pemeriksaan_pdf', $data, true);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan-pemeriksaan.pdf', ['Attachment' => false]);
        exit;
    }

    private function _export_pdf_pembayaran($dari, $sampai, $search, $status)
    {
        $data['rows']   = $this->_get_pembayaran(null, null, $dari, $sampai, $search, $status);
        $data['dari']   = $dari;
        $data['sampai'] = $sampai;
        $data['search'] = $search;
        $data['status'] = $status;
        $data['judul']  = 'LAPORAN DATA PEMBAYARAN';

        $total = 0;
        foreach ($data['rows'] as $r) {
            $total += $r['biaya'];
        }
        $data['total'] = $total;

        require_once FCPATH . 'vendor/autoload.php';
        $dompdf = new Dompdf\Dompdf();
        $html   = $this->load->view('laporan/pembayaran_pdf', $data, true);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan-pembayaran.pdf', ['Attachment' => false]);
        exit;
    }

    // --------------------------------------------------------------------
    // EXPORT EXCEL
    // --------------------------------------------------------------------

    private function _export_excel_pasien($dari, $sampai, $search)
    {
        $rows = $this->_get_pasien(null, null, $dari, $sampai, $search);

        require_once FCPATH . 'vendor/autoload.php';
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Pasien');

        $headers = ['No', 'No RM', 'Nama', 'Jenis Kelamin', 'Tanggal Lahir', 'Telepon', 'Alamat'];
        $col     = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '1', $h);
            $col++;
        }

        $rowNum = 2;
        $no     = 1;
        foreach ($rows as $r) {
            $sheet->setCellValue('A' . $rowNum, $no++);
            $sheet->setCellValue('B' . $rowNum, $r['no_rm']);
            $sheet->setCellValue('C' . $rowNum, $r['nama']);
            $sheet->setCellValue('D' . $rowNum, $r['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan');
            $sheet->setCellValue('E' . $rowNum, $r['tanggal_lahir']);
            $sheet->setCellValue('F' . $rowNum, $r['telepon']);
            $sheet->setCellValue('G' . $rowNum, $r['alamat']);
            $rowNum++;
        }

        foreach (range('A', 'G') as $colID) {
            $sheet->getColumnDimension($colID)->setAutoSize(true);
        }

        $writer   = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'laporan-pasien.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $writer->save('php://output');
        exit;
    }

    private function _export_excel_pemeriksaan($dari, $sampai, $search)
    {
        $rows = $this->_get_pemeriksaan(null, null, $dari, $sampai, $search);

        require_once FCPATH . 'vendor/autoload.php';
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Pemeriksaan');

        $headers = ['No', 'No RM', 'Pasien', 'Dokter', 'Poli', 'Tanggal Daftar', 'Diagnosa', 'Tindakan'];
        $col     = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '1', $h);
            $col++;
        }

        $rowNum = 2;
        $no     = 1;
        foreach ($rows as $r) {
            $sheet->setCellValue('A' . $rowNum, $no++);
            $sheet->setCellValue('B' . $rowNum, $r['no_rm']);
            $sheet->setCellValue('C' . $rowNum, $r['nama_pasien']);
            $sheet->setCellValue('D' . $rowNum, $r['nama_dokter']);
            $sheet->setCellValue('E' . $rowNum, $r['nama_poli']);
            $sheet->setCellValue('F' . $rowNum, $r['tgl_daftar']);
            $sheet->setCellValue('G' . $rowNum, $r['diagnosa']);
            $sheet->setCellValue('H' . $rowNum, $r['tindakan']);
            $rowNum++;
        }

        foreach (range('A', 'H') as $colID) {
            $sheet->getColumnDimension($colID)->setAutoSize(true);
        }

        $writer   = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'laporan-pemeriksaan.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $writer->save('php://output');
        exit;
    }

    private function _export_excel_pembayaran($dari, $sampai, $search, $status)
    {
        $rows = $this->_get_pembayaran(null, null, $dari, $sampai, $search, $status);

        require_once FCPATH . 'vendor/autoload.php';
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Pembayaran');

        $headers = ['No', 'No RM', 'Pasien', 'Dokter', 'Biaya', 'Status', 'Tanggal Bayar'];
        $col     = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '1', $h);
            $col++;
        }

        $rowNum = 2;
        $no     = 1;
        foreach ($rows as $r) {
            $sheet->setCellValue('A' . $rowNum, $no++);
            $sheet->setCellValue('B' . $rowNum, $r['no_rm']);
            $sheet->setCellValue('C' . $rowNum, $r['nama_pasien']);
            $sheet->setCellValue('D' . $rowNum, $r['nama_dokter']);
            $sheet->setCellValue('E' . $rowNum, $r['biaya']);
            $sheet->setCellValue('F' . $rowNum, ucfirst($r['status']));
            $sheet->setCellValue('G' . $rowNum, $r['tanggal']);
            $rowNum++;
        }

        foreach (range('A', 'G') as $colID) {
            $sheet->getColumnDimension($colID)->setAutoSize(true);
        }

        $writer   = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'laporan-pembayaran.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $writer->save('php://output');
        exit;
    }

    // --------------------------------------------------------------------
    // PRINT
    // --------------------------------------------------------------------

    private function _print_pasien($dari, $sampai, $search)
    {
        $data['rows']   = $this->_get_pasien(null, null, $dari, $sampai, $search);
        $data['dari']   = $dari;
        $data['sampai'] = $sampai;
        $data['search'] = $search;
        $data['judul']  = 'LAPORAN DATA PASIEN';
        $this->load->view('laporan/print_css');
        $this->load->view('laporan/pasien_pdf', $data);
    }

    private function _print_pemeriksaan($dari, $sampai, $search)
    {
        $data['rows']   = $this->_get_pemeriksaan(null, null, $dari, $sampai, $search);
        $data['dari']   = $dari;
        $data['sampai'] = $sampai;
        $data['search'] = $search;
        $data['judul']  = 'LAPORAN DATA PEMERIKSAAN';
        $this->load->view('laporan/print_css');
        $this->load->view('laporan/pemeriksaan_pdf', $data);
    }

    private function _print_pembayaran($dari, $sampai, $search, $status)
    {
        $data['rows']   = $this->_get_pembayaran(null, null, $dari, $sampai, $search, $status);
        $data['dari']   = $dari;
        $data['sampai'] = $sampai;
        $data['search'] = $search;
        $data['status'] = $status;
        $data['judul']  = 'LAPORAN DATA PEMBAYARAN';

        $total = 0;
        foreach ($data['rows'] as $r) {
            $total += $r['biaya'];
        }
        $data['total'] = $total;

        $this->load->view('laporan/print_css');
        $this->load->view('laporan/pembayaran_pdf', $data);
    }
}
