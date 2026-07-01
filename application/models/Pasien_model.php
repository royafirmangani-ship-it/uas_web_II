<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasien_model extends CI_Model
{
    public function getAll($limit, $start, $search = '')
    {
        if ($search) {
            $this->db->group_start();
            $this->db->like('nama', $search);
            $this->db->or_like('no_rm', $search);
            $this->db->or_like('telepon', $search);
            $this->db->group_end();
        }
        $this->db->order_by('id_pasien', 'DESC');
        return $this->db->get('pasien', $limit, $start)->result_array();
    }

    public function getById($id)
    {
        return $this->db->get_where('pasien', ['id_pasien' => $id])->row_array();
    }

    public function countAll($search = '')
    {
        if ($search) {
            $this->db->group_start();
            $this->db->like('nama', $search);
            $this->db->or_like('no_rm', $search);
            $this->db->or_like('telepon', $search);
            $this->db->group_end();
        }
        return $this->db->count_all_results('pasien');
    }

    public function insert($data)
    {
        $this->db->insert('pasien', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id_pasien', $id);
        return $this->db->update('pasien', $data);
    }

    public function delete($id)
    {
        $this->db->where('id_pasien', $id);
        return $this->db->delete('pasien');
    }

    public function getAllDropdown()
    {
        $this->db->select('id_pasien, no_rm, nama');
        $this->db->order_by('nama', 'ASC');
        $result = $this->db->get('pasien')->result_array();
        $dropdown = [];
        foreach ($result as $row) {
            $dropdown[$row['id_pasien']] = $row['no_rm'] . ' - ' . $row['nama'];
        }
        return $dropdown;
    }

    public function getLastRM($year)
    {
        $this->db->like('no_rm', 'RM-' . $year, 'after');
        $this->db->order_by('id_pasien', 'DESC');
        return $this->db->get('pasien', 1)->row_array();
    }
}
