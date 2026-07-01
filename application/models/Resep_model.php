<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resep_model extends CI_Model
{
    public function getAll($limit, $start, $search = '')
    {
        $this->db->select('
            resep.*,
            pemeriksaan.id_daftar,
            pendaftaran.tanggal as tgl_periksa,
            pasien.no_rm,
            pasien.nama as nama_pasien,
            dokter.nama as nama_dokter,
            poli.nama_poli,
            (SELECT COUNT(*) FROM detail_resep WHERE detail_resep.id_resep = resep.id_resep) as jumlah_obat
        ');
        $this->db->from('resep');
        $this->db->join('pemeriksaan', 'pemeriksaan.id_periksa = resep.id_periksa');
        $this->db->join('pendaftaran', 'pendaftaran.id_daftar = pemeriksaan.id_daftar');
        $this->db->join('pasien', 'pasien.id_pasien = pendaftaran.id_pasien');
        $this->db->join('dokter', 'dokter.id_dokter = pendaftaran.id_dokter');
        $this->db->join('poli', 'poli.id_poli = pendaftaran.id_poli');

        if ($search) {
            $this->db->like('pasien.nama', $search);
            $this->db->or_like('pasien.no_rm', $search);
        }

        $this->db->order_by('resep.id_resep', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get()->result_array();
    }

    public function getById($id)
    {
        return $this->db->select('
            resep.*,
            pemeriksaan.id_daftar,
            pemeriksaan.diagnosa,
            pemeriksaan.tindakan,
            pendaftaran.tanggal as tgl_periksa,
            pasien.no_rm,
            pasien.nama as nama_pasien,
            pasien.id_pasien,
            dokter.nama as nama_dokter,
            dokter.id_dokter,
            poli.nama_poli,
            poli.id_poli
        ')
        ->from('resep')
        ->join('pemeriksaan', 'pemeriksaan.id_periksa = resep.id_periksa')
        ->join('pendaftaran', 'pendaftaran.id_daftar = pemeriksaan.id_daftar')
        ->join('pasien', 'pasien.id_pasien = pendaftaran.id_pasien')
        ->join('dokter', 'dokter.id_dokter = pendaftaran.id_dokter')
        ->join('poli', 'poli.id_poli = pendaftaran.id_poli')
        ->where('resep.id_resep', $id)
        ->get()
        ->row_array();
    }

    public function countAll($search = '')
    {
        $this->db->from('resep');
        $this->db->join('pemeriksaan', 'pemeriksaan.id_periksa = resep.id_periksa');
        $this->db->join('pendaftaran', 'pendaftaran.id_daftar = pemeriksaan.id_daftar');
        $this->db->join('pasien', 'pasien.id_pasien = pendaftaran.id_pasien');

        if ($search) {
            $this->db->group_start();
            $this->db->like('pasien.nama', $search);
            $this->db->or_like('pasien.no_rm', $search);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }

    public function insert($data)
    {
        $this->db->insert('resep', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id_resep', $id);
        $this->db->update('resep', $data);
        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        $this->db->where('id_resep', $id);
        $this->db->delete('resep');
        return $this->db->affected_rows();
    }

    public function getDetails($id_resep)
    {
        return $this->db->select('
            detail_resep.*,
            obat.nama_obat,
            obat.harga,
            obat.satuan,
            obat.stok
        ')
        ->from('detail_resep')
        ->join('obat', 'obat.id_obat = detail_resep.id_obat')
        ->where('detail_resep.id_resep', $id_resep)
        ->get()
        ->result_array();
    }

    public function insertDetail($data)
    {
        $this->db->insert('detail_resep', $data);
        return $this->db->insert_id();
    }

    public function deleteDetails($id_resep)
    {
        $this->db->where('id_resep', $id_resep);
        $this->db->delete('detail_resep');
        return $this->db->affected_rows();
    }

    public function getAvailablePemeriksaan()
    {
        return $this->db->select('
            pemeriksaan.id_periksa,
            pemeriksaan.id_daftar,
            pemeriksaan.diagnosa,
            pendaftaran.tanggal,
            pasien.no_rm,
            pasien.nama as nama_pasien,
            dokter.nama as nama_dokter,
            poli.nama_poli
        ')
        ->from('pemeriksaan')
        ->join('pendaftaran', 'pendaftaran.id_daftar = pemeriksaan.id_daftar')
        ->join('pasien', 'pasien.id_pasien = pendaftaran.id_pasien')
        ->join('dokter', 'dokter.id_dokter = pendaftaran.id_dokter')
        ->join('poli', 'poli.id_poli = pendaftaran.id_poli')
        ->where_in('pendaftaran.status', ['selesai', 'diperiksa'])
        ->where('pemeriksaan.id_periksa NOT IN (SELECT COALESCE(id_periksa, 0) FROM resep)', NULL, FALSE)
        ->order_by('pendaftaran.tanggal', 'DESC')
        ->get()
        ->result_array();
    }

    public function reduceStock($id_obat, $jumlah)
    {
        $this->db->set('stok', 'stok - ' . (int)$jumlah, FALSE);
        $this->db->where('id_obat', $id_obat);
        $this->db->update('obat');
    }
}
