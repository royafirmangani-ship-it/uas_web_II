<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemeriksaan_model extends CI_Model
{
    public function getAll($limit, $start, $search = '')
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
        $this->db->order_by('pemeriksaan.id_periksa', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get()->result_array();
    }

    public function getById($id)
    {
        return $this->db->select('pemeriksaan.*, pendaftaran.tanggal as tgl_daftar, pendaftaran.keluhan, pendaftaran.status as status_daftar, pasien.id_pasien, pasien.no_rm, pasien.nama as nama_pasien, pasien.jenis_kelamin, pasien.tanggal_lahir, dokter.nama as nama_dokter, dokter.spesialis, poli.nama_poli')
            ->from('pemeriksaan')
            ->join('pendaftaran', 'pendaftaran.id_daftar = pemeriksaan.id_daftar')
            ->join('pasien', 'pasien.id_pasien = pendaftaran.id_pasien')
            ->join('dokter', 'dokter.id_dokter = pendaftaran.id_dokter')
            ->join('poli', 'poli.id_poli = pendaftaran.id_poli')
            ->where('pemeriksaan.id_periksa', $id)
            ->get()
            ->row_array();
    }

    public function countAll($search = '')
    {
        $this->db->from('pemeriksaan');
        $this->db->join('pendaftaran', 'pendaftaran.id_daftar = pemeriksaan.id_daftar');
        $this->db->join('pasien', 'pasien.id_pasien = pendaftaran.id_pasien');
        if ($search) {
            $this->db->like('pasien.nama', $search);
        }
        return $this->db->count_all_results();
    }

    public function insert($data)
    {
        $this->db->insert('pemeriksaan', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id_periksa', $id);
        $this->db->update('pemeriksaan', $data);
        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        $this->db->where('id_periksa', $id);
        $this->db->delete('pemeriksaan');
        return $this->db->affected_rows();
    }

    public function getAvailablePendaftaran()
    {
        $sub_query = '(SELECT id_daftar FROM pemeriksaan)';

        return $this->db->select('pendaftaran.*, pasien.no_rm, pasien.nama as nama_pasien, dokter.nama as nama_dokter, poli.nama_poli')
            ->from('pendaftaran')
            ->join('pasien', 'pasien.id_pasien = pendaftaran.id_pasien')
            ->join('dokter', 'dokter.id_dokter = pendaftaran.id_dokter')
            ->join('poli', 'poli.id_poli = pendaftaran.id_poli')
            ->where_in('pendaftaran.status', ['menunggu', 'diperiksa'])
            ->where("pendaftaran.id_daftar NOT IN $sub_query", NULL, FALSE)
            ->order_by('pendaftaran.id_daftar', 'DESC')
            ->get()
            ->result_array();
    }

    public function getMonthlyStats($year)
    {
        return $this->db->select('MONTH(pemeriksaan.tgl_periksa) as bulan, COUNT(*) as total')
            ->from('pemeriksaan')
            ->where('YEAR(pemeriksaan.tgl_periksa)', $year)
            ->group_by('MONTH(pemeriksaan.tgl_periksa)')
            ->order_by('MONTH(pemeriksaan.tgl_periksa)')
            ->get()
            ->result_array();
    }
}
