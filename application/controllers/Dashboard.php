<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->check_login();
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['breadcrumb'] = [
            ['label' => 'Dashboard', 'url' => 'dashboard']
        ];

        $data['count_pasien'] = $this->db->count_all('pasien');
        $data['count_dokter'] = $this->db->count_all('dokter');
        $data['count_poli'] = $this->db->count_all('poli');
        $data['count_obat'] = $this->db->count_all('obat');
        $data['count_pemeriksaan'] = $this->db->count_all('pemeriksaan');
        $data['count_pembayaran'] = $this->db->count_all('pembayaran');

        $data['recent_pendaftaran'] = $this->db->select('
                pendaftaran.*,
                pasien.nama as nama_pasien,
                pasien.no_rm,
                dokter.nama as nama_dokter,
                poli.nama_poli
            ')
            ->from('pendaftaran')
            ->join('pasien', 'pasien.id_pasien = pendaftaran.id_pasien')
            ->join('dokter', 'dokter.id_dokter = pendaftaran.id_dokter')
            ->join('poli', 'poli.id_poli = pendaftaran.id_poli')
            ->order_by('pendaftaran.tanggal', 'DESC')
            ->limit(5)
            ->get()
            ->result_array();

        $monthly = $this->db->select('MONTH(tanggal) as bulan, COUNT(*) as total')
            ->from('pendaftaran')
            ->where('YEAR(tanggal)', date('Y'))
            ->group_by('MONTH(tanggal)')
            ->order_by('MONTH(tanggal)')
            ->get()
            ->result_array();

        $chart_labels = [];
        $chart_data = [];
        for ($i = 1; $i <= 12; $i++) {
            $chart_labels[] = date('F', mktime(0, 0, 0, $i, 1));
            $found = 0;
            foreach ($monthly as $m) {
                if ((int)$m['bulan'] === $i) {
                    $found = (int)$m['total'];
                    break;
                }
            }
            $chart_data[] = $found;
        }
        $data['chart_labels'] = json_encode($chart_labels);
        $data['chart_data'] = json_encode($chart_data);

        $this->view('dashboard/index', $data);
    }
}
