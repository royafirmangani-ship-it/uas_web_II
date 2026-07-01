<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran_model extends CI_Model
{
    public function getAll($limit, $start, $search = '', $status = '')
    {
        $this->db->select('
            pembayaran.*,
            pemeriksaan.id_daftar,
            pasien.no_rm,
            pasien.nama as nama_pasien,
            dokter.nama as nama_dokter,
            poli.nama_poli
        ');
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

        $this->db->order_by('pembayaran.id_bayar', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get()->result_array();
    }

    public function getById($id)
    {
        return $this->db->select('
            pembayaran.*,
            pemeriksaan.id_daftar,
            pemeriksaan.diagnosa,
            pemeriksaan.tindakan,
            pendaftaran.tanggal as tgl_periksa,
            pasien.no_rm,
            pasien.nama as nama_pasien,
            pasien.alamat,
            pasien.telepon,
            dokter.nama as nama_dokter,
            poli.nama_poli,
            pendaftaran.keluhan
        ')
        ->from('pembayaran')
        ->join('pemeriksaan', 'pemeriksaan.id_periksa = pembayaran.id_periksa')
        ->join('pendaftaran', 'pendaftaran.id_daftar = pemeriksaan.id_daftar')
        ->join('pasien', 'pasien.id_pasien = pendaftaran.id_pasien')
        ->join('dokter', 'dokter.id_dokter = pendaftaran.id_dokter')
        ->join('poli', 'poli.id_poli = pendaftaran.id_poli')
        ->where('pembayaran.id_bayar', $id)
        ->get()
        ->row_array();
    }

    public function countAll($search = '', $status = '')
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

        return $this->db->count_all_results();
    }

    public function insert($data)
    {
        $this->db->insert('pembayaran', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id_bayar', $id);
        $this->db->update('pembayaran', $data);
        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        $this->db->where('id_bayar', $id);
        $this->db->delete('pembayaran');
        return $this->db->affected_rows();
    }

    public function getAvailablePemeriksaan()
    {
        return $this->db->select('
            pemeriksaan.id_periksa,
            pasien.no_rm,
            pasien.nama as nama_pasien,
            dokter.nama as nama_dokter,
            poli.nama_poli,
            pendaftaran.tanggal
        ')
        ->from('pemeriksaan')
        ->join('pendaftaran', 'pendaftaran.id_daftar = pemeriksaan.id_daftar')
        ->join('pasien', 'pasien.id_pasien = pendaftaran.id_pasien')
        ->join('dokter', 'dokter.id_dokter = pendaftaran.id_dokter')
        ->join('poli', 'poli.id_poli = pendaftaran.id_poli')
        ->where('pemeriksaan.id_periksa NOT IN (SELECT COALESCE(id_periksa, 0) FROM pembayaran)', NULL, FALSE)
        ->order_by('pendaftaran.tanggal', 'DESC')
        ->get()
        ->result_array();
    }

    public function getMonthlyStats($year)
    {
        return $this->db->select('MONTH(tanggal) as bulan, SUM(biaya) as total')
            ->from('pembayaran')
            ->where('status', 'lunas')
            ->where('YEAR(tanggal)', $year)
            ->group_by('MONTH(tanggal)')
            ->order_by('MONTH(tanggal)')
            ->get()
            ->result_array();
    }

    public function getTotalByStatus($status)
    {
        $this->db->select('COALESCE(SUM(biaya), 0) as total');
        $this->db->from('pembayaran');
        if ($status !== '') {
            $this->db->where('status', $status);
        }
        return $this->db->get()->row_array();
    }
}
