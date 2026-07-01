<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokter_model extends CI_Model
{
    public function getAll($limit, $start, $search = '')
    {
        if ($search) {
            $this->db->group_start();
            $this->db->like('nama', $search);
            $this->db->or_like('spesialis', $search);
            $this->db->or_like('telepon', $search);
            $this->db->group_end();
        }
        $this->db->order_by('id_dokter', 'DESC');
        return $this->db->get('dokter', $limit, $start)->result_array();
    }

    public function getById($id)
    {
        return $this->db->get_where('dokter', ['id_dokter' => $id])->row_array();
    }

    public function countAll($search = '')
    {
        if ($search) {
            $this->db->group_start();
            $this->db->like('nama', $search);
            $this->db->or_like('spesialis', $search);
            $this->db->or_like('telepon', $search);
            $this->db->group_end();
        }
        return $this->db->count_all_results('dokter');
    }

    public function insert($data)
    {
        $this->db->insert('dokter', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id_dokter', $id);
        return $this->db->update('dokter', $data);
    }

    public function delete($id)
    {
        $this->db->where('id_dokter', $id);
        return $this->db->delete('dokter');
    }

    public function getAllDropdown()
    {
        $this->db->order_by('nama', 'ASC');
        $result = $this->db->get('dokter')->result_array();
        $dropdown = [];
        foreach ($result as $row) {
            $dropdown[$row['id_dokter']] = $row['nama'];
        }
        return $dropdown;
    }
}
