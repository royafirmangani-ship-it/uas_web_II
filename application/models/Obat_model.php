<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obat_model extends CI_Model
{
    public function getAll($limit, $start, $search = '')
    {
        if ($search) {
            $this->db->like('nama_obat', $search);
        }
        $this->db->order_by('id_obat', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get('obat')->result_array();
    }

    public function getById($id)
    {
        return $this->db->get_where('obat', ['id_obat' => $id])->row_array();
    }

    public function countAll($search = '')
    {
        if ($search) {
            $this->db->like('nama_obat', $search);
        }
        return $this->db->count_all_results('obat');
    }

    public function insert($data)
    {
        $this->db->insert('obat', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id_obat', $id);
        $this->db->update('obat', $data);
        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        $this->db->where('id_obat', $id);
        $this->db->delete('obat');
        return $this->db->affected_rows();
    }

    public function getAllDropdown()
    {
        $result = $this->db->order_by('nama_obat', 'ASC')->get('obat')->result_array();
        $dropdown = [];
        foreach ($result as $row) {
            $dropdown[$row['id_obat']] = $row['nama_obat'] . ' (' . $row['stok'] . ')';
        }
        return $dropdown;
    }
}
