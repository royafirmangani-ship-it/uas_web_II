<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendaftaran_model extends CI_Model
{
    public function getAll($limit, $start, $search = '', $status = '')
    {
        $this->db->select('pendaftaran.*, pasien.no_rm, pasien.nama as nama_pasien, dokter.nama as nama_dokter, poli.nama_poli');
        $this->db->from('pendaftaran');
        $this->db->join('pasien', 'pasien.id_pasien = pendaftaran.id_pasien');
        $this->db->join('dokter', 'dokter.id_dokter = pendaftaran.id_dokter');
        $this->db->join('poli', 'poli.id_poli = pendaftaran.id_poli');
        if ($search) {
            $this->db->group_start();
            $this->db->like('pasien.nama', $search);
            $this->db->or_like('dokter.nama', $search);
            $this->db->group_end();
        }
        if ($status) {
            $this->db->where('pendaftaran.status', $status);
        }
        $this->db->order_by('pendaftaran.id_daftar', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get()->result_array();
    }

    public function getById($id)
    {
        return $this->db            ->select('pendaftaran.*, pasien.no_rm, pasien.nama as nama_pasien, pasien.jenis_kelamin, pasien.tanggal_lahir, pasien.alamat as alamat_pasien, pasien.telepon as telepon_pasien, dokter.nama as nama_dokter, dokter.spesialis, poli.nama_poli')
            ->from('pendaftaran')
            ->join('pasien', 'pasien.id_pasien = pendaftaran.id_pasien')
            ->join('dokter', 'dokter.id_dokter = pendaftaran.id_dokter')
            ->join('poli', 'poli.id_poli = pendaftaran.id_poli')
            ->where('pendaftaran.id_daftar', $id)
            ->get()
            ->row_array();
    }

    public function countAll($search = '', $status = '')
    {
        $this->db->from('pendaftaran');
        $this->db->join('pasien', 'pasien.id_pasien = pendaftaran.id_pasien');
        $this->db->join('dokter', 'dokter.id_dokter = pendaftaran.id_dokter');
        $this->db->join('poli', 'poli.id_poli = pendaftaran.id_poli');
        if ($search) {
            $this->db->group_start();
            $this->db->like('pasien.nama', $search);
            $this->db->or_like('dokter.nama', $search);
            $this->db->group_end();
        }
        if ($status) {
            $this->db->where('pendaftaran.status', $status);
        }
        return $this->db->count_all_results();
    }

    public function insert($data)
    {
        $this->db->insert('pendaftaran', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id_daftar', $id);
        $this->db->update('pendaftaran', $data);
        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        $this->db->where('id_daftar', $id);
        $this->db->delete('pendaftaran');
        return $this->db->affected_rows();
    }

    public function getMonthlyStats($year)
    {
        return $this->db->select('MONTH(tanggal) as bulan, COUNT(*) as total')
            ->from('pendaftaran')
            ->where('YEAR(tanggal)', $year)
            ->group_by('MONTH(tanggal)')
            ->order_by('MONTH(tanggal)')
            ->get()
            ->result_array();
    }
}
