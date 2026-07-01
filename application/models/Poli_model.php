<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poli_model extends CI_Model
{
    public function getAll($limit, $start, $search = '')
    {
        if ($search) {
            $this->db->like('nama_poli', $search);
        }
        $this->db->order_by('id_poli', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get('poli')->result_array();
    }

    public function getById($id)
    {
        return $this->db->get_where('poli', ['id_poli' => $id])->row_array();
    }

    public function countAll($search = '')
    {
        if ($search) {
            $this->db->like('nama_poli', $search);
        }
        return $this->db->count_all_results('poli');
    }

    public function insert($data)
    {
        $this->db->insert('poli', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id_poli', $id);
        $this->db->update('poli', $data);
        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        $this->db->where('id_poli', $id);
        $this->db->delete('poli');
        return $this->db->affected_rows();
    }

    public function getAllDropdown()
    {
        $result = $this->db->order_by('nama_poli', 'ASC')->get('poli')->result_array();
        $dropdown = [];
        foreach ($result as $row) {
            $dropdown[$row['id_poli']] = $row['nama_poli'];
        }
        return $dropdown;
    }
}
